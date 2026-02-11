<?php

namespace App\Http\Controllers;

use App\Models\CtaClick;
use App\Models\FakeLeadSchedule;
use App\Models\Setting;
use App\Models\Visitor;
use App\Services\FakeLeadGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * 헬스체크
     * GET /api/status
     */
    public function status()
    {
        return response()->json([
            'success' => true,
            'status' => 'ok',
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * 가짜 리드 생성
     * GET /api/fake-leads
     */
    public function fakeLeads()
    {
        try {
            $generator = new FakeLeadGenerator;
            $date = request()->query('date');

            if ($date) {
                $leads = $generator->generateForDate($date);
            } else {
                $leads = $generator->generate();
            }

            $activeSchedules = FakeLeadSchedule::where('is_active', true)->count();

            return response()->json([
                'success' => true,
                'count' => count($leads),
                'active_schedules' => $activeSchedules,
                'leads' => $leads,
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ]);
        } catch (\Exception $e) {
            Log::error('fakeLeads error', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ]);
        }
    }

    /**
     * CTA 클릭 트래킹
     * POST /api/cta-click
     */
    public function ctaClick(Request $request)
    {
        $visitorHash = $request->cookie('hp_visitor');
        if (! $visitorHash) {
            return response()->json(['success' => false, 'message' => 'no visitor'], 400);
        }

        $variant = $request->input('variant');
        if (! $variant || ! in_array($variant, ['a', 'b', 'c'])) {
            return response()->json(['success' => false, 'message' => 'invalid variant'], 400);
        }

        $visitor = Visitor::where('visitor_hash', $visitorHash)->first();
        if (! $visitor) {
            return response()->json(['success' => false, 'message' => 'visitor not found'], 404);
        }

        $click = CtaClick::firstOrCreate(
            ['visitor_id' => $visitor->id, 'variant' => $variant],
            ['button_type' => $request->input('button_type')]
        );

        return response()->json([
            'success' => true,
            'new' => $click->wasRecentlyCreated,
        ]);
    }

    /**
     * 통합 API - 모든 예약 작업을 주기별 선별 실행
     * GET /api/all
     */
    public function all()
    {
        $now = time();
        $results = [];

        // ── 가짜 리드 생성 ──
        $fakeLeadInterval = (int) Setting::getValue('api_interval_fake_leads', '3600');
        $lastFakeLeadTime = (int) Setting::getValue('last_api_fake_leads_time', '0');

        if (($now - $lastFakeLeadTime) >= $fakeLeadInterval) {
            try {
                $generator = new FakeLeadGenerator;
                $leads = $generator->generate();
                $activeSchedules = FakeLeadSchedule::where('is_active', true)->count();

                Setting::setValue('last_api_fake_leads_time', (string) $now);

                $results['fake_leads'] = [
                    'executed' => true,
                    'count' => count($leads),
                    'active_schedules' => $activeSchedules,
                    'message' => count($leads) > 0
                        ? '가짜 리드 '.count($leads).'건 생성됨'
                        : '생성 대상 없음 (스케줄 비활성 또는 시간대 외)',
                ];
            } catch (\Exception $e) {
                $results['fake_leads'] = [
                    'executed' => true,
                    'count' => 0,
                    'message' => '에러: '.$e->getMessage(),
                ];
            }
        } else {
            $results['fake_leads'] = [
                'executed' => false,
                'next_run_in' => ($fakeLeadInterval - ($now - $lastFakeLeadTime)).'초',
                'message' => '주기 미도달',
            ];
        }

        // ── 임시 업로드 파일 정리 (매번 실행) ──
        $tempDeletedCount = 0;
        $tempDir = storage_path('app/uploads/temp');

        if (is_dir($tempDir)) {
            $items = scandir($tempDir);
            foreach ($items as $item) {
                if ($item === '.' || $item === '..') {
                    continue;
                }

                $path = $tempDir.DIRECTORY_SEPARATOR.$item;
                $mtime = filemtime($path);

                if ($mtime && ($now - $mtime) > 3600) {
                    if (is_dir($path)) {
                        $this->deleteDirectory($path);
                    } else {
                        @unlink($path);
                    }
                    $tempDeletedCount++;
                }
            }
        }

        $results['cleanup_temp'] = [
            'executed' => true,
            'deleted_count' => $tempDeletedCount,
        ];

        return response()->json([
            'success' => true,
            'results' => $results,
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }

    /**
     * 디렉토리 재귀 삭제
     */
    private function deleteDirectory(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        $items = scandir($dir);
        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $dir.DIRECTORY_SEPARATOR.$item;
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                @unlink($path);
            }
        }
        @rmdir($dir);
    }
}
