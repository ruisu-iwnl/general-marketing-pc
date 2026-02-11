<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\LeadComment;
use App\Models\LoginHistory;
use App\Models\Manager;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * 로그인 페이지
     */
    public function login()
    {
        if (session('manager_auth')) {
            return redirect('/manager');
        }

        return view('manager.login');
    }

    /**
     * 로그인 처리
     */
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $manager = Manager::where('email', $email)->first();

        if (!$manager) {
            LoginHistory::record('manager', null, $request, false, '존재하지 않는 계정');
            return back()->withErrors(['email' => '존재하지 않는 계정입니다.'])->withInput();
        }

        if (!$manager->is_active) {
            LoginHistory::record('manager', $manager->id, $request, false, '비활성화된 계정');
            return back()->withErrors(['email' => '비활성화된 계정입니다. 관리자에게 문의하세요.'])->withInput();
        }

        if (!password_verify($password, $manager->password)) {
            LoginHistory::record('manager', $manager->id, $request, false, '비밀번호 불일치');
            return back()->withErrors(['password' => '비밀번호가 올바르지 않습니다.'])->withInput();
        }

        // 로그인 성공
        $request->session()->put('manager_auth', true);
        $request->session()->put('manager_id', $manager->id);

        LoginHistory::record('manager', $manager->id, $request, true);

        return redirect('/manager');
    }

    /**
     * 로그아웃
     */
    public function logout(Request $request)
    {
        $request->session()->forget('manager_auth');
        $request->session()->forget('manager_id');

        return redirect('/manager/login');
    }

    /**
     * 대시보드
     */
    public function index()
    {
        $manager = $this->getManager();

        $today = now()->startOfDay();
        $weekStart = now()->startOfWeek();

        return view('manager.index', [
            'manager' => $manager,
            'totalLeads' => Lead::where('manager_id', $manager->id)->count(),
            'newLeads' => Lead::where('manager_id', $manager->id)->where('status', 'new')->count(),
            'todayLeads' => Lead::where('manager_id', $manager->id)->where('created_at', '>=', $today)->count(),
            'weekLeads' => Lead::where('manager_id', $manager->id)->where('created_at', '>=', $weekStart)->count(),
            'recentLeads' => Lead::where('manager_id', $manager->id)->latest()->take(5)->get(),
        ]);
    }

    /**
     * 담당 리드 목록
     */
    public function leads(Request $request)
    {
        $manager = $this->getManager();

        $query = Lead::where('manager_id', $manager->id);

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

        return view('manager.leads', [
            'manager' => $manager,
            'leads' => $query->latest()->paginate(20)->withQueryString(),
            'search' => $search,
            'status' => $status,
            'statuses' => Lead::STATUSES,
        ]);
    }

    /**
     * 리드 상세
     */
    public function leadDetail($id)
    {
        $manager = $this->getManager();

        $lead = Lead::with(['manager', 'comments.manager'])
            ->where('manager_id', $manager->id)
            ->findOrFail($id);

        return view('manager.lead-detail', [
            'manager' => $manager,
            'lead' => $lead,
        ]);
    }

    /**
     * 리드 상태 변경
     */
    public function leadUpdateStatus(Request $request, $id)
    {
        $manager = $this->getManager();

        $lead = Lead::where('manager_id', $manager->id)->findOrFail($id);
        $oldStatus = $lead->status;
        $newStatus = $request->input('status');

        $lead->status = $newStatus;

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
            'manager_id' => $manager->id,
            'author_type' => 'system',
            'content' => "상태 변경: {$oldLabel} → {$newLabel}",
        ]);

        return redirect("/manager/leads/{$id}")->with('success', '상태가 변경되었습니다.');
    }

    /**
     * 리드 댓글 추가
     */
    public function leadAddComment(Request $request, $id)
    {
        $manager = $this->getManager();

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Lead::where('manager_id', $manager->id)->findOrFail($id);

        LeadComment::create([
            'lead_id' => $id,
            'manager_id' => $manager->id,
            'author_type' => 'manager',
            'content' => $request->input('content'),
        ]);

        return redirect("/manager/leads/{$id}")->with('success', '메모가 추가되었습니다.');
    }

    /**
     * 내 로그인 이력
     */
    public function myLoginHistory()
    {
        $manager = $this->getManager();

        $histories = LoginHistory::where('user_type', 'manager')
            ->where('user_id', $manager->id)
            ->latest('logged_in_at')
            ->paginate(20);

        return view('manager.login-history', [
            'manager' => $manager,
            'histories' => $histories,
        ]);
    }

    /**
     * 현재 로그인한 매니저 가져오기
     */
    private function getManager(): Manager
    {
        return Manager::findOrFail(session('manager_id'));
    }
}
