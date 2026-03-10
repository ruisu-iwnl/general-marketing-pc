<?php

namespace App\Http\Controllers;

use App\Models\CtaClick;
use App\Models\FakeLeadSchedule;
use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\LoginHistory;
use App\Models\Manager;
use App\Models\PageView;
use App\Models\Setting;
use App\Services\AbTestService;
use App\Services\AnalyticsService;
use App\Services\FakeLeadGenerator;
use App\Services\MigrationService;
use App\Services\TelegramService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * 로그인 페이지
     */
    public function login()
    {
        if (session('admin_auth')) {
            return redirect('/admin');
        }

        $keyFile = storage_path('admin.key');

        return view('admin.login', [
            'isFirstSetup' => ! file_exists($keyFile),
        ]);
    }

    /**
     * 로그인 / 최초 비밀번호 설정 처리
     */
    public function loginSubmit(Request $request)
    {
        $password = $request->input('password', '');
        $keyFile  = storage_path('admin.key');

        // 최초 설정
        if (! file_exists($keyFile)) {
            if (strlen($password) < 4) {
                return back()->withErrors(['password' => '비밀번호는 4자 이상이어야 합니다.']);
            }

            file_put_contents($keyFile, password_hash($password, PASSWORD_DEFAULT));
            $request->session()->put('admin_auth', true);

            // 로그인 이력 기록
            LoginHistory::record('admin', null, $request, true);

            return redirect('/admin');
        }

        // 비밀번호 검증
        $hash = file_get_contents($keyFile);
        if (password_verify($password, $hash)) {
            $request->session()->put('admin_auth', true);

            // 로그인 이력 기록
            LoginHistory::record('admin', null, $request, true);

            return redirect('/admin');
        }

        // 실패 이력 기록
        LoginHistory::record('admin', null, $request, false, '비밀번호 불일치');

        return back()->withErrors(['password' => '비밀번호가 올바르지 않습니다.']);
    }

    /**
     * 로그아웃
     */
    public function logout(Request $request)
    {
        $request->session()->forget('admin_auth');

        return redirect('/admin/login');
    }

    /**
     * 대시보드
     */
    public function index()
    {
        $today     = now()->startOfDay();
        $weekStart = now()->startOfWeek();
        $monthStart = now()->startOfMonth();

        return view('admin.index', [
            'totalLeads' => Lead::count(),
            'todayLeads' => Lead::where('created_at', '>=', $today)->count(),
            'weekLeads'  => Lead::where('created_at', '>=', $weekStart)->count(),
            'monthLeads' => Lead::where('created_at', '>=', $monthStart)->count(),
            'recentLeads' => Lead::latest()->take(5)->get(),
        ]);
    }

    /**
     * 상담신청 목록
     */
    public function leads(Request $request)
    {
        $query = Lead::with('manager');

        // 검색
        $search = $request->input('q');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // 상태 필터
        $status = $request->input('status');
        if ($status) {
            $query->where('status', $status);
        }

        // 매니저 필터
        $managerId = $request->input('manager_id');
        if ($managerId === 'unassigned') {
            $query->whereNull('manager_id');
        } elseif ($managerId) {
            $query->where('manager_id', $managerId);
        }

        return view('admin.leads', [
            'leads'    => $query->latest()->paginate(20)->withQueryString(),
            'search'   => $search,
            'status'   => $status,
            'managerId' => $managerId,
            'managers' => Manager::where('is_active', true)->get(),
            'statuses' => Lead::STATUSES,
        ]);
    }

    /**
     * 상담신청 상세
     */
    public function leadDetail($id)
    {
        $lead = Lead::with(['manager', 'comments.manager'])->findOrFail($id);
        $managers = Manager::where('is_active', true)->get();

        return view('admin.lead-detail', compact('lead', 'managers'));
    }

    /**
     * 상담신청 상태 변경
     */
    public function leadUpdateStatus(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $oldStatus = $lead->status;
        $newStatus = $request->input('status');

        $lead->status = $newStatus;

        // 상태에 따른 타임스탬프 자동 설정
        if ($newStatus === 'contacted' && !$lead->contacted_at) {
            $lead->contacted_at = now();
        }
        if ($newStatus === 'converted' && !$lead->converted_at) {
            $lead->converted_at = now();
        }

        $lead->save();

        // 시스템 댓글 추가
        $oldLabel = Lead::STATUSES[$oldStatus] ?? $oldStatus;
        $newLabel = Lead::STATUSES[$newStatus] ?? $newStatus;
        LeadComment::create([
            'lead_id' => $lead->id,
            'author_type' => 'system',
            'content' => "상태 변경: {$oldLabel} → {$newLabel}",
        ]);

        return redirect("/admin/leads/{$id}")->with('success', '상태가 변경되었습니다.');
    }

    /**
     * 상담신청 매니저 배정
     */
    public function leadAssign(Request $request, $id)
    {
        $lead = Lead::findOrFail($id);
        $managerId = $request->input('manager_id') ?: null;

        $oldManager = $lead->manager;
        $lead->manager_id = $managerId;
        $lead->save();

        // 시스템 댓글 추가
        $newManager = $managerId ? Manager::find($managerId) : null;
        $oldName = $oldManager?->name ?? '미배정';
        $newName = $newManager?->name ?? '미배정';

        LeadComment::create([
            'lead_id' => $lead->id,
            'author_type' => 'system',
            'content' => "담당자 변경: {$oldName} → {$newName}",
        ]);

        // 텔레그램 알림 발송 (새 매니저에게)
        if ($newManager) {
            TelegramService::notifyManagerAssigned($lead, $newManager);
        }

        return redirect("/admin/leads/{$id}")->with('success', '담당자가 변경되었습니다.');
    }

    /**
     * 상담신청 댓글 추가
     */
    public function leadAddComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        LeadComment::create([
            'lead_id' => $id,
            'author_type' => 'admin',
            'content' => $request->input('content'),
        ]);

        return redirect("/admin/leads/{$id}")->with('success', '메모가 추가되었습니다.');
    }

    /**
     * 상담신청 댓글 삭제
     */
    public function leadDeleteComment($leadId, $commentId)
    {
        $comment = LeadComment::where('lead_id', $leadId)->findOrFail($commentId);
        $comment->delete();

        return redirect("/admin/leads/{$leadId}")->with('success', '메모가 삭제되었습니다.');
    }

    /**
     * 상담신청 삭제
     */
    public function leadDelete($id)
    {
        Lead::findOrFail($id)->delete();

        return redirect('/admin/leads')->with('success', '삭제되었습니다.');
    }

    /**
     * CSV 내보내기
     */
    public function exportCsv()
    {
        $leads = Lead::latest()->get();

        $filename = 'leads_' . date('Y-m-d_His') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($leads) {
            $out = fopen('php://output', 'w');
            // UTF-8 BOM
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['ID', '이름', '연락처', 'UTM Source', 'UTM Medium', 'UTM Campaign', '유입경로', '등록일']);

            foreach ($leads as $lead) {
                fputcsv($out, [
                    $lead->id,
                    $lead->name,
                    $lead->phone,
                    $lead->utm_source ?? '',
                    $lead->utm_medium ?? '',
                    $lead->utm_campaign ?? '',
                    $lead->referrer ?? '',
                    $lead->created_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * 생성 데이터 시간대 설정 페이지
     */
    public function fakeSettings(FakeLeadGenerator $generator)
    {
        $schedules = FakeLeadSchedule::latest()->get();
        $today = now()->format('Y-m-d');

        // 오늘의 생성 현황
        $todaySummary = [];
        foreach ($schedules as $schedule) {
            if (!$schedule->is_active) {
                continue;
            }

            $allLeads = $generator->generateForDate($today, $schedule->id);
            $now = now();
            $pastLeads = array_filter($allLeads, fn($l) => $l['timestamp'] <= $now->timestamp);

            $todaySummary[] = [
                'schedule_id' => $schedule->id,
                'schedule_name' => $schedule->name ?? '스케줄 #' . $schedule->id,
                'total' => count($allLeads),
                'generated' => count($pastLeads),
                'is_count_mode' => $schedule->isCountMode(),
            ];
        }

        return view('admin.fake-settings', compact('schedules', 'todaySummary'));
    }

    /**
     * 생성 데이터 시간대 추가
     */
    public function fakeSettingsStore(Request $request)
    {
        $mode = $request->input('mode', 'interval');

        $rules = [
            'time_start' => 'required|date_format:H:i',
            'time_end'   => 'required|date_format:H:i|after:time_start',
            'name'       => 'nullable|string|max:100',
        ];

        $messages = [
            'time_end.after' => '종료 시간은 시작 시간보다 늦어야 합니다.',
        ];

        if ($mode === 'count') {
            $rules['daily_min_count'] = 'required|integer|min:1|max:500';
            $rules['daily_max_count'] = 'required|integer|min:1|max:500|gte:daily_min_count';
            $messages['daily_max_count.gte'] = '최대 건수는 최소 건수 이상이어야 합니다.';
        } else {
            $rules['min_interval_seconds'] = 'required|integer|min:10|max:3600';
            $rules['max_interval_seconds'] = 'required|integer|min:10|max:3600|gte:min_interval_seconds';
            $messages['max_interval_seconds.gte'] = '최대 간격은 최소 간격 이상이어야 합니다.';
        }

        $request->validate($rules, $messages);

        $data = [
            'name'       => $request->input('name'),
            'time_start' => $request->input('time_start'),
            'time_end'   => $request->input('time_end'),
            'is_active'  => $request->boolean('is_active', true),
        ];

        if ($mode === 'count') {
            $data['daily_min_count'] = $request->input('daily_min_count');
            $data['daily_max_count'] = $request->input('daily_max_count');

            // 시간대별 분배
            $timeDistribution = $request->input('time_distribution');
            if ($timeDistribution && is_array($timeDistribution)) {
                $filtered = array_filter($timeDistribution, fn($td) => !empty($td['start']) && !empty($td['end']) && isset($td['weight']));
                $data['time_distribution'] = !empty($filtered) ? array_values($filtered) : null;
            }
        } else {
            $data['min_interval_seconds'] = $request->input('min_interval_seconds');
            $data['max_interval_seconds'] = $request->input('max_interval_seconds');
        }

        // 요일 설정
        $daysOfWeek = $request->input('days_of_week');
        if ($daysOfWeek && is_array($daysOfWeek)) {
            $data['days_of_week'] = array_map('intval', $daysOfWeek);
        }

        FakeLeadSchedule::create($data);

        return redirect('/admin/fake-settings')->with('success', '스케줄이 추가되었습니다.');
    }

    /**
     * 생성 데이터 스케줄 수정
     */
    public function fakeSettingsUpdate(Request $request, $id)
    {
        $schedule = FakeLeadSchedule::findOrFail($id);

        $mode = $request->input('mode', $schedule->isCountMode() ? 'count' : 'interval');

        $rules = [
            'time_start' => 'required|date_format:H:i',
            'time_end'   => 'required|date_format:H:i|after:time_start',
            'name'       => 'nullable|string|max:100',
        ];

        $messages = [
            'time_end.after' => '종료 시간은 시작 시간보다 늦어야 합니다.',
        ];

        if ($mode === 'count') {
            $rules['daily_min_count'] = 'required|integer|min:1|max:500';
            $rules['daily_max_count'] = 'required|integer|min:1|max:500|gte:daily_min_count';
            $messages['daily_max_count.gte'] = '최대 건수는 최소 건수 이상이어야 합니다.';
        } else {
            $rules['min_interval_seconds'] = 'required|integer|min:10|max:3600';
            $rules['max_interval_seconds'] = 'required|integer|min:10|max:3600|gte:min_interval_seconds';
            $messages['max_interval_seconds.gte'] = '최대 간격은 최소 간격 이상이어야 합니다.';
        }

        $request->validate($rules, $messages);

        $data = [
            'name'       => $request->input('name'),
            'time_start' => $request->input('time_start'),
            'time_end'   => $request->input('time_end'),
        ];

        if ($mode === 'count') {
            $data['daily_min_count'] = $request->input('daily_min_count');
            $data['daily_max_count'] = $request->input('daily_max_count');
            $data['min_interval_seconds'] = 120;
            $data['max_interval_seconds'] = 300;

            $timeDistribution = $request->input('time_distribution');
            if ($timeDistribution && is_array($timeDistribution)) {
                $filtered = array_filter($timeDistribution, fn($td) => !empty($td['start']) && !empty($td['end']) && isset($td['weight']));
                $data['time_distribution'] = !empty($filtered) ? array_values($filtered) : null;
            } else {
                $data['time_distribution'] = null;
            }
        } else {
            $data['min_interval_seconds'] = $request->input('min_interval_seconds');
            $data['max_interval_seconds'] = $request->input('max_interval_seconds');
            $data['daily_min_count'] = null;
            $data['daily_max_count'] = null;
            $data['time_distribution'] = null;
        }

        // 요일 설정
        $daysOfWeek = $request->input('days_of_week');
        if ($daysOfWeek && is_array($daysOfWeek)) {
            $data['days_of_week'] = array_map('intval', $daysOfWeek);
        } else {
            $data['days_of_week'] = null;
        }

        $schedule->update($data);

        return redirect('/admin/fake-settings')->with('success', '스케줄이 수정되었습니다.');
    }

    /**
     * 생성 데이터 스케줄 토글
     */
    public function fakeSettingsToggle($id)
    {
        $schedule = FakeLeadSchedule::findOrFail($id);
        $schedule->is_active = !$schedule->is_active;
        $schedule->save();

        $status = $schedule->is_active ? '활성화' : '비활성화';

        return redirect('/admin/fake-settings')->with('success', "스케줄이 {$status}되었습니다.");
    }

    /**
     * 생성 데이터 시간대 삭제
     */
    public function fakeSettingsDelete($id)
    {
        FakeLeadSchedule::findOrFail($id)->delete();

        return redirect('/admin/fake-settings')->with('success', '삭제되었습니다.');
    }

    /**
     * 생성 데이터 목록 조회
     */
    public function fakeLeads(Request $request, FakeLeadGenerator $generator)
    {
        $date = $request->input('date', now()->format('Y-m-d'));
        $scheduleId = $request->input('schedule_id');

        $schedules = FakeLeadSchedule::latest()->get();
        $leads = $generator->generateForDate($date, $scheduleId ? (int) $scheduleId : null);

        // 현재까지 생성된 건수
        $now = now();
        $pastLeads = array_filter($leads, fn($l) => $l['timestamp'] <= $now->timestamp);

        // 시간대별 분포 (24시간)
        $hourlyDistribution = array_fill(0, 24, 0);
        foreach ($leads as $lead) {
            $hour = (int) Carbon::createFromTimestamp($lead['timestamp'])->format('G');
            $hourlyDistribution[$hour]++;
        }

        return view('admin.fake-leads', [
            'leads' => $leads,
            'date' => $date,
            'scheduleId' => $scheduleId,
            'schedules' => $schedules,
            'totalCount' => count($leads),
            'generatedCount' => count($pastLeads),
            'hourlyDistribution' => $hourlyDistribution,
        ]);
    }

    /**
     * 마이그레이션 관리 페이지
     */
    public function migrations()
    {
        return view('admin.settings.migrations', [
            'migrations' => MigrationService::getMigrationStatus(),
            'pendingCount' => MigrationService::getPendingCount(),
        ]);
    }

    /**
     * 마이그레이션 실행
     */
    public function runMigrations()
    {
        $result = MigrationService::runMigrations();

        return redirect('/admin/settings/migrations')
            ->with('migration_result', $result);
    }

    /**
     * 마이그레이션 롤백
     */
    public function rollbackMigration()
    {
        $result = MigrationService::rollbackMigration();

        return redirect('/admin/settings/migrations')
            ->with('migration_result', $result);
    }

    /**
     * A/B 테스트 설정 페이지
     */
    public function abTestSettings()
    {
        // variant별 리드 전환 통계
        $stats = Lead::selectRaw('variant, COUNT(*) as count')
            ->whereNotNull('variant')
            ->groupBy('variant')
            ->pluck('count', 'variant')
            ->toArray();

        $totalLeads = Lead::whereNotNull('variant')->count();

        // variant별 CTA 클릭 통계
        $clickStats = CtaClick::selectRaw('variant, COUNT(*) as count')
            ->groupBy('variant')
            ->pluck('count', 'variant')
            ->toArray();

        $totalClicks = array_sum($clickStats);

        // variant별 고유 방문자 수 (page_views의 variant 기준)
        $visitorStats = PageView::selectRaw('variant, COUNT(DISTINCT visitor_id) as count')
            ->whereNotNull('variant')
            ->where('variant', '!=', '')
            ->groupBy('variant')
            ->pluck('count', 'variant')
            ->toArray();

        // A/B 테스트 설정
        $settings = AbTestService::getAllSettings();
        $mode = AbTestService::getMode();
        $defaultVariant = AbTestService::getDefaultVariant();

        $viewStatus = AbTestService::getVariantViewStatus();

        return view('admin.settings.ab-test', [
            'stats' => $stats,
            'totalLeads' => $totalLeads,
            'clickStats' => $clickStats,
            'totalClicks' => $totalClicks,
            'visitorStats' => $visitorStats,
            'settings' => $settings,
            'mode' => $mode,
            'defaultVariant' => $defaultVariant,
            'viewStatus' => $viewStatus,
        ]);
    }

    /**
     * A/B 테스트 설정 저장
     */
    public function abTestSettingsStore(Request $request)
    {
        $data = [
            'mode' => $request->input('mode', 'manual'),
            'default_variant' => $request->input('default_variant', 'a'),
            'variants' => [],
        ];

        foreach (['a', 'b', 'c'] as $variant) {
            $data['variants'][$variant] = [
                'name' => $request->input("variant_{$variant}_name"),
                'description' => $request->input("variant_{$variant}_description"),
                'is_active' => $request->boolean("variant_{$variant}_active"),
                'traffic_percentage' => (int) $request->input("variant_{$variant}_percentage", 0),
            ];
        }

        AbTestService::saveSettings($data);

        return redirect('/admin/settings/ab-test')->with('success', 'A/B 테스트 설정이 저장되었습니다.');
    }

    // ========================================
    // 매니저 관리
    // ========================================

    /**
     * 매니저 목록
     */
    public function managers()
    {
        $managers = Manager::withCount('leads')->latest()->get();

        return view('admin.managers.index', compact('managers'));
    }

    /**
     * 매니저 생성 폼
     */
    public function managerCreate()
    {
        return view('admin.managers.create');
    }

    /**
     * 매니저 저장
     */
    public function managerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:managers,email',
            'password' => 'required|string|min:4',
        ], [
            'email.unique' => '이미 사용중인 이메일입니다.',
        ]);

        Manager::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'is_active' => $request->boolean('is_active', true),
            'telegram_chat_id' => $request->input('telegram_chat_id'),
        ]);

        return redirect('/admin/managers')->with('success', '매니저가 추가되었습니다.');
    }

    /**
     * 매니저 수정 폼
     */
    public function managerEdit($id)
    {
        $manager = Manager::withCount('leads')->findOrFail($id);

        return view('admin.managers.edit', compact('manager'));
    }

    /**
     * 매니저 업데이트
     */
    public function managerUpdate(Request $request, $id)
    {
        $manager = Manager::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:managers,email,' . $id,
        ], [
            'email.unique' => '이미 사용중인 이메일입니다.',
        ]);

        $manager->name = $request->input('name');
        $manager->email = $request->input('email');
        $manager->is_active = $request->boolean('is_active', true);
        $manager->telegram_chat_id = $request->input('telegram_chat_id');

        // 비밀번호는 입력된 경우에만 변경
        if ($request->filled('password')) {
            $manager->password = bcrypt($request->input('password'));
        }

        $manager->save();

        return redirect('/admin/managers')->with('success', '매니저 정보가 수정되었습니다.');
    }

    /**
     * 매니저 삭제
     */
    public function managerDelete($id)
    {
        $manager = Manager::findOrFail($id);

        // 배정된 리드가 있으면 미배정으로 변경
        Lead::where('manager_id', $id)->update(['manager_id' => null]);

        $manager->delete();

        return redirect('/admin/managers')->with('success', '매니저가 삭제되었습니다.');
    }

    // ========================================
    // API 엔드포인트 관리
    // ========================================

    /**
     * API 엔드포인트 관리 페이지
     */
    public function apiSettings()
    {
        $now = time();

        // API 주기 설정
        $intervals = [
            'fake_leads' => [
                'label' => '가짜 리드 생성',
                'interval' => (int) Setting::getValue('api_interval_fake_leads', '3600'),
                'last_run' => (int) Setting::getValue('last_api_fake_leads_time', '0'),
                'setting_key' => 'api_interval_fake_leads',
            ],
        ];

        // 각 항목에 next_run_in, last_run_formatted 추가
        foreach ($intervals as &$item) {
            $elapsed = $now - $item['last_run'];
            $item['next_run_in'] = max(0, $item['interval'] - $elapsed);
            $item['last_run_formatted'] = $item['last_run'] > 0
                ? Carbon::createFromTimestamp($item['last_run'])->format('Y-m-d H:i:s')
                : '없음';
        }

        // 가짜 리드 스케줄 활성 개수
        $fakeLeadActiveCount = FakeLeadSchedule::where('is_active', true)->count();

        return view('admin.settings.api', compact('intervals', 'fakeLeadActiveCount'));
    }

    /**
     * API 설정 저장
     */
    public function apiSettingsStore(Request $request)
    {
        Setting::setValue('api_interval_fake_leads', $request->input('api_interval_fake_leads', '3600'));

        return redirect('/admin/settings/api')->with('success', 'API 호출 주기 설정이 저장되었습니다.');
    }

    /**
     * API 수동 실행
     */
    public function apiTrigger(string $action)
    {
        try {
            switch ($action) {
                case 'fake-leads':
                    $generator = new FakeLeadGenerator();
                    $leads = $generator->generate();
                    $activeSchedules = FakeLeadSchedule::where('is_active', true)->count();
                    return response()->json([
                        'success' => true,
                        'message' => count($leads) > 0
                            ? '가짜 리드 ' . count($leads) . '건 생성됨 (활성 스케줄: ' . $activeSchedules . '개)'
                            : '생성 대상 없음 (활성 스케줄: ' . $activeSchedules . '개)',
                    ]);

                default:
                    return response()->json(['success' => false, 'message' => '알 수 없는 작업입니다.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ========================================
    // 텔레그램 알림 설정
    // ========================================

    /**
     * 텔레그램 설정 페이지
     */
    public function telegramSettings()
    {
        $settings = TelegramService::getSettings();

        return view('admin.settings.telegram', compact('settings'));
    }

    /**
     * 텔레그램 설정 저장
     */
    public function telegramSettingsStore(Request $request)
    {
        $settings = [
            'enabled' => $request->boolean('enabled'),
            'bot_token' => $request->input('bot_token', ''),
            'admin_chat_id' => $request->input('admin_chat_id', ''),
            'notify_new_lead' => $request->boolean('notify_new_lead'),
            'notify_lead_assigned' => $request->boolean('notify_lead_assigned'),
            'message_format' => $request->input('message_format', 'detailed'),
        ];

        TelegramService::saveSettings($settings);

        return redirect('/admin/settings/telegram')->with('success', '텔레그램 설정이 저장되었습니다.');
    }

    /**
     * 텔레그램 테스트 메시지 발송
     */
    public function telegramTest(Request $request)
    {
        $botToken = $request->input('bot_token');
        $chatId = $request->input('chat_id');

        if (empty($botToken) || empty($chatId)) {
            return response()->json(['success' => false, 'message' => '봇 토큰과 채팅 ID를 모두 입력해주세요.']);
        }

        $result = TelegramService::sendTestMessage($botToken, $chatId);

        return response()->json($result);
    }

    // ========================================
    // 방문자 통계
    // ========================================

    /**
     * 방문자 통계 대시보드
     */
    public function analytics(Request $request)
    {
        $period = $request->input('period', 'month');

        return view('admin.analytics.index', [
            'period' => $period,
            'stats' => AnalyticsService::getVisitorStats($period),
            'deviceStats' => AnalyticsService::getDeviceStats($period),
            'browserStats' => AnalyticsService::getBrowserStats($period),
            'osStats' => AnalyticsService::getOsStats($period),
            'referrerStats' => AnalyticsService::getReferrerStats($period),
            'utmStats' => AnalyticsService::getUtmStats($period),
            'hourlyStats' => AnalyticsService::getHourlyStats($period),
            'funnel' => AnalyticsService::getConversionFunnel($period),
            'dailyTrend' => AnalyticsService::getDailyTrend(30),
        ]);
    }

    /**
     * 로그인 이력 조회
     */
    public function loginHistory(Request $request)
    {
        $query = LoginHistory::query();

        // 사용자 유형 필터
        $userType = $request->input('user_type');
        if ($userType === 'admin') {
            $query->admin();
        } elseif ($userType === 'manager') {
            $query->manager();
        }

        // 성공/실패 필터
        $status = $request->input('status');
        if ($status === 'success') {
            $query->successful();
        } elseif ($status === 'failed') {
            $query->failed();
        }

        $histories = $query->with('manager')
            ->latest('logged_in_at')
            ->paginate(30)
            ->withQueryString();

        return view('admin.login-history', [
            'histories' => $histories,
            'userType' => $userType,
            'status' => $status,
        ]);
    }

    /**
     * 방문자 목록
     */
    public function analyticsVisitors(Request $request)
    {
        $botFilter = $request->input('bot', 'exclude'); // 기본값: 봇 제외

        $recentVisitors = AnalyticsService::getRecentVisitors(100);
        $recentPageViews = AnalyticsService::getRecentPageViews(200, $botFilter);

        return view('admin.analytics.visitors', [
            'visitors' => $recentVisitors,
            'pageViews' => $recentPageViews,
            'botFilter' => $botFilter,
        ]);
    }

    /**
     * 차트 데이터 API
     */
    public function analyticsChartData(Request $request)
    {
        $days = (int) $request->input('days', 30);

        return response()->json([
            'dailyTrend' => AnalyticsService::getDailyTrend($days),
        ]);
    }
}
