<?php

namespace App\Http\Controllers;

use App\Models\ContractMonthlyToken;
use App\Models\ContractPeriod;
use App\Models\PostRequest;
use App\Models\RankRecord;
use App\Services\RankChecker;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PublicController extends Controller
{
    /**
     * 의뢰 상세 공개 보기
     * GET /public/view/{token}
     */
    public function view(string $token)
    {
        $postRequest = PostRequest::getByToken($token);

        if (!$postRequest) {
            abort(404);
        }

        $rankRecords = RankRecord::getByPostRequestId($postRequest->id);

        return view('public.view', [
            'postRequest' => $postRequest,
            'rankRecords' => $rankRecords,
        ]);
    }

    /**
     * 계약 기간별 공개 보기
     * GET /public/period/{token}
     */
    public function period(string $token)
    {
        $contractPeriod = ContractPeriod::getByToken($token);

        if (!$contractPeriod) {
            abort(404);
        }

        $postRequests = PostRequest::getByContractPeriod($contractPeriod->id);

        // 순위 통계 병합
        $requestIds = $postRequests->pluck('id')->toArray();
        $rankStats = RankRecord::getRankStats($requestIds);

        foreach ($postRequests as $request) {
            $stats = $rankStats[$request->id] ?? ['best_rank' => null, 'latest_rank' => null];
            $request->best_rank = $stats['best_rank'];
            $request->latest_rank = $stats['latest_rank'];
        }

        return view('public.period', [
            'contractPeriod' => $contractPeriod,
            'postRequests' => $postRequests,
        ]);
    }

    /**
     * 건별 계약 월별 공개 보기
     * GET /public/per-post/{token}
     */
    public function perPostMonth(string $token)
    {
        $monthlyToken = ContractMonthlyToken::getByToken($token);

        if (!$monthlyToken) {
            abort(404);
        }

        $postRequests = PostRequest::getByContractMonth(
            $monthlyToken->contract_id,
            $monthlyToken->year_month
        );

        // 순위 통계 병합
        $requestIds = $postRequests->pluck('id')->toArray();
        $rankStats = RankRecord::getRankStats($requestIds);

        foreach ($postRequests as $request) {
            $stats = $rankStats[$request->id] ?? ['best_rank' => null, 'latest_rank' => null];
            $request->best_rank = $stats['best_rank'];
            $request->latest_rank = $stats['latest_rank'];
        }

        return view('public.per_post_month', [
            'monthlyToken' => $monthlyToken,
            'postRequests' => $postRequests,
        ]);
    }

    /**
     * 실시간 순위 조회 (AJAX)
     * GET /public/check-rank/{token}
     */
    public function checkRank(string $token)
    {
        $postRequest = PostRequest::getByToken($token);

        if (!$postRequest) {
            return response()->json([
                'success' => false,
                'message' => '의뢰를 찾을 수 없습니다.',
            ], 404);
        }

        if (empty($postRequest->published_url)) {
            return response()->json([
                'success' => true,
                'rank' => null,
                'keyword' => $postRequest->keyword,
                'checked_at' => now()->format('Y-m-d H:i:s'),
                'message' => '발행 URL이 등록되지 않았습니다.',
            ]);
        }

        $rankChecker = new RankChecker();
        $rank = $rankChecker->checkRankNow($postRequest->keyword, $postRequest->published_url);

        return response()->json([
            'success' => true,
            'rank' => $rank,
            'keyword' => $postRequest->keyword,
            'checked_at' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
