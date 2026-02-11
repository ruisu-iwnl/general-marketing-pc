<?php

namespace App\Http\Middleware;

use App\Services\AbTestService;
use App\Services\AnalyticsService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 관리자 페이지, API, 정적 파일은 제외
        if ($this->shouldSkip($request)) {
            return $next($request);
        }

        // A/B 테스트 variant 가져오기
        $variant = null;
        if ($request->is('/')) {
            $variant = AbTestService::getVariant();
        }

        // 페이지뷰 기록
        AnalyticsService::trackPageView($request, null, $variant);

        return $next($request);
    }

    /**
     * 트래킹 제외 여부 확인
     */
    private function shouldSkip(Request $request): bool
    {
        // 관리자 페이지
        if ($request->is('admin/*') || $request->is('admin')) {
            return true;
        }

        // API 요청
        if ($request->is('api/*')) {
            return true;
        }

        // 봇/크롤러
        $userAgent = strtolower($request->userAgent() ?? '');
        $bots = ['bot', 'crawler', 'spider', 'scraper', 'curl', 'wget', 'python', 'java'];
        foreach ($bots as $bot) {
            if (str_contains($userAgent, $bot)) {
                return true;
            }
        }

        // AJAX 요청 (일부)
        if ($request->ajax() && !$request->is('/')) {
            return true;
        }

        return false;
    }
}
