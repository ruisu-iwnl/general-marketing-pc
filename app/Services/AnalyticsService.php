<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\PageView;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AnalyticsService
{
    private const VISITOR_COOKIE = 'hp_visitor';
    private const SESSION_COOKIE = 'hp_session';
    private const COOKIE_LIFETIME = 60 * 24 * 365 * 2; // 2년

    /**
     * 페이지뷰 기록
     */
    public static function trackPageView(Request $request, ?string $pageTitle = null, ?string $variant = null): ?PageView
    {
        try {
            $visitorHash = self::getOrCreateVisitorHash($request);
            $sessionId = self::getOrCreateSessionId($request);
            $userAgent = $request->userAgent() ?? '';

            // 방문자 찾기 또는 생성
            $visitor = Visitor::findOrCreateByHash($visitorHash, [
                'ip_address' => self::getClientIp($request),
            ]);

            // User Agent 파싱
            $deviceInfo = self::parseUserAgent($userAgent);
            $isBot = self::isBot($userAgent);

            // 레퍼러 도메인 추출
            $referrer = $request->header('referer');
            $referrerDomain = $referrer ? parse_url($referrer, PHP_URL_HOST) : null;

            // 페이지뷰 생성
            $pageView = PageView::create([
                'visitor_id' => $visitor->id,
                'session_id' => $sessionId,
                'url' => $request->fullUrl(),
                'page_title' => $pageTitle,
                'referrer' => $referrer,
                'referrer_domain' => $referrerDomain,
                'utm_source' => $request->input('utm_source'),
                'utm_medium' => $request->input('utm_medium'),
                'utm_campaign' => $request->input('utm_campaign'),
                'utm_term' => $request->input('utm_term'),
                'utm_content' => $request->input('utm_content'),
                'device_type' => $deviceInfo['device_type'],
                'os' => $deviceInfo['os'],
                'os_version' => $deviceInfo['os_version'],
                'browser' => $deviceInfo['browser'],
                'browser_version' => $deviceInfo['browser_version'],
                'variant' => $variant,
                'is_bot' => $isBot,
                'created_at' => now(),
            ]);

            // 방문자 페이지뷰 카운트 증가
            $visitor->increment('total_pageviews');

            return $pageView;
        } catch (\Exception $e) {
            \Log::error('Analytics tracking error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * 리드 전환 연결
     */
    public static function linkLeadToVisitor(Lead $lead, Request $request): void
    {
        try {
            $visitorHash = $request->cookie(self::VISITOR_COOKIE);

            if ($visitorHash) {
                $visitor = Visitor::where('visitor_hash', $visitorHash)->first();

                if ($visitor) {
                    $visitor->update([
                        'is_converted' => true,
                        'lead_id' => $lead->id,
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Lead-Visitor link error: ' . $e->getMessage());
        }
    }

    /**
     * 방문자 해시 가져오기 또는 생성
     */
    private static function getOrCreateVisitorHash(Request $request): string
    {
        $hash = $request->cookie(self::VISITOR_COOKIE);

        if (!$hash) {
            $hash = Str::random(32);
            Cookie::queue(self::VISITOR_COOKIE, $hash, self::COOKIE_LIFETIME);
        }

        return $hash;
    }

    /**
     * 세션 ID 가져오기 또는 생성
     */
    private static function getOrCreateSessionId(Request $request): string
    {
        $sessionId = $request->cookie(self::SESSION_COOKIE);

        if (!$sessionId) {
            $sessionId = Str::random(32);
            Cookie::queue(self::SESSION_COOKIE, $sessionId, 30); // 30분 세션
        }

        return $sessionId;
    }

    /**
     * 클라이언트 IP 가져오기
     */
    private static function getClientIp(Request $request): string
    {
        $headers = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'];

        foreach ($headers as $header) {
            if ($ip = $request->server($header)) {
                $ip = explode(',', $ip)[0];
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }

        return $request->ip() ?? '0.0.0.0';
    }

    /**
     * 봇 여부 확인
     */
    public static function isBot(string $userAgent): bool
    {
        if (empty($userAgent)) {
            return true;
        }

        $botPatterns = [
            // 검색엔진 크롤러
            'googlebot',
            'bingbot',
            'slurp',           // Yahoo
            'duckduckbot',
            'baiduspider',
            'yandexbot',
            'sogou',
            'exabot',
            'facebot',         // Facebook
            'ia_archiver',     // Alexa

            // SEO/마케팅 도구
            'semrushbot',
            'ahrefsbot',
            'mj12bot',         // Majestic
            'dotbot',
            'rogerbot',
            'seznambot',
            'petalbot',

            // 모니터링/크롤러
            'uptimerobot',
            'pingdom',
            'statuscake',
            'jetmon',
            'site24x7',

            // 일반 봇 패턴
            'bot',
            'spider',
            'crawler',
            'scraper',
            'fetcher',
            'headless',
            'phantom',
            'selenium',
            'puppeteer',
            'playwright',

            // 기타
            'curl',
            'wget',
            'python-requests',
            'python-urllib',
            'java/',
            'apache-httpclient',
            'go-http-client',
            'node-fetch',
            'axios',
            'okhttp',
            'libwww',
            'httpunit',
            'nutch',
            'biglotron',
            'teoma',
            'convera',
            'gigablast',
            'ia_archiver',
            'webmon',
            'httrack',
            'grub.org',
            'netresearchserver',
            'speedy',
            'fluffy',
            'findlink',
            'panscient',
            'zyborg',
            'datacha',
            'archive.org_bot',
            'applebot',
            'twitterbot',
            'linkedinbot',
            'slackbot',
            'telegrambot',
            'whatsapp',
            'discordbot',
            'bytespider',
            'gptbot',
            'chatgpt',
            'claudebot',
            'anthropic',
            'ccbot',
            'cohere-ai',
        ];

        $ua = strtolower($userAgent);

        foreach ($botPatterns as $pattern) {
            if (str_contains($ua, $pattern)) {
                return true;
            }
        }

        // 브라우저 식별자가 없는 경우
        if (!preg_match('/(mozilla|chrome|safari|firefox|edge|opera|msie|trident)/i', $userAgent)) {
            return true;
        }

        return false;
    }

    /**
     * User Agent 파싱
     */
    private static function parseUserAgent(string $userAgent): array
    {
        $result = [
            'device_type' => 'desktop',
            'os' => null,
            'os_version' => null,
            'browser' => null,
            'browser_version' => null,
        ];

        $ua = strtolower($userAgent);

        // 디바이스 타입
        if (preg_match('/(iphone|ipod|android.*mobile|windows phone|blackberry)/i', $ua)) {
            $result['device_type'] = 'mobile';
        } elseif (preg_match('/(ipad|android(?!.*mobile)|tablet)/i', $ua)) {
            $result['device_type'] = 'tablet';
        }

        // 운영체제
        $osPatterns = [
            'Windows 11' => '/windows nt 10.*build.*(22[0-9]{3}|2[3-9][0-9]{3})/i',
            'Windows 10' => '/windows nt 10/i',
            'Windows 8.1' => '/windows nt 6\.3/i',
            'Windows 8' => '/windows nt 6\.2/i',
            'Windows 7' => '/windows nt 6\.1/i',
            'macOS' => '/macintosh|mac os x/i',
            'iOS' => '/(iphone|ipad|ipod)/i',
            'Android' => '/android/i',
            'Linux' => '/linux/i',
            'Chrome OS' => '/cros/i',
        ];

        foreach ($osPatterns as $os => $pattern) {
            if (preg_match($pattern, $userAgent)) {
                $result['os'] = $os;

                // 버전 추출
                if ($os === 'Android' && preg_match('/android\s*([\d.]+)/i', $userAgent, $m)) {
                    $result['os_version'] = $m[1];
                } elseif ($os === 'iOS' && preg_match('/os\s*([\d_]+)/i', $userAgent, $m)) {
                    $result['os_version'] = str_replace('_', '.', $m[1]);
                } elseif (str_contains($os, 'Windows') && preg_match('/windows nt ([\d.]+)/i', $userAgent, $m)) {
                    $result['os_version'] = $m[1];
                } elseif ($os === 'macOS' && preg_match('/mac os x ([\d_]+)/i', $userAgent, $m)) {
                    $result['os_version'] = str_replace('_', '.', $m[1]);
                }
                break;
            }
        }

        // 브라우저
        $browserPatterns = [
            'Edge' => '/edg(?:e|a|ios)?\/([\d.]+)/i',
            'Samsung Browser' => '/samsungbrowser\/([\d.]+)/i',
            'Opera' => '/(?:opera|opr)\/([\d.]+)/i',
            'Whale' => '/whale\/([\d.]+)/i',
            'Chrome' => '/(?:chrome|crios)\/([\d.]+)/i',
            'Safari' => '/version\/([\d.]+).*safari/i',
            'Firefox' => '/(?:firefox|fxios)\/([\d.]+)/i',
            'IE' => '/(?:msie |trident.*rv:)([\d.]+)/i',
        ];

        foreach ($browserPatterns as $browser => $pattern) {
            if (preg_match($pattern, $userAgent, $matches)) {
                $result['browser'] = $browser;
                $result['browser_version'] = $matches[1] ?? null;
                break;
            }
        }

        return $result;
    }

    // ==========================================
    // 통계 조회 메소드
    // ==========================================

    /**
     * 기간별 방문자 통계
     */
    public static function getVisitorStats(string $period = 'today'): array
    {
        $ranges = self::getDateRange($period);

        $visitors = Visitor::whereBetween('first_visit_at', [$ranges['start'], $ranges['end']])->count();
        $returningVisitors = Visitor::where('total_visits', '>', 1)
            ->whereBetween('last_visit_at', [$ranges['start'], $ranges['end']])->count();
        $pageviews = PageView::whereBetween('created_at', [$ranges['start'], $ranges['end']])->count();
        $conversions = Visitor::where('is_converted', true)
            ->whereBetween('updated_at', [$ranges['start'], $ranges['end']])->count();

        $conversionRate = $visitors > 0 ? round(($conversions / $visitors) * 100, 2) : 0;

        return [
            'visitors' => $visitors,
            'returning_visitors' => $returningVisitors,
            'new_visitors' => $visitors - $returningVisitors,
            'pageviews' => $pageviews,
            'conversions' => $conversions,
            'conversion_rate' => $conversionRate,
            'avg_pageviews' => $visitors > 0 ? round($pageviews / $visitors, 1) : 0,
        ];
    }

    /**
     * 일별 트렌드 데이터
     */
    public static function getDailyTrend(int $days = 30): array
    {
        $data = PageView::selectRaw('DATE(created_at) as date, COUNT(*) as pageviews, COUNT(DISTINCT visitor_id) as visitors')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date')
            ->toArray();

        // 빈 날짜 채우기
        $result = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $result[] = [
                'date' => $date,
                'visitors' => $data[$date]['visitors'] ?? 0,
                'pageviews' => $data[$date]['pageviews'] ?? 0,
            ];
        }

        return $result;
    }

    /**
     * 디바이스 통계
     */
    public static function getDeviceStats(string $period = 'month'): array
    {
        $ranges = self::getDateRange($period);

        return PageView::selectRaw('device_type, COUNT(DISTINCT visitor_id) as count')
            ->whereBetween('created_at', [$ranges['start'], $ranges['end']])
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->pluck('count', 'device_type')
            ->toArray();
    }

    /**
     * 브라우저 통계
     */
    public static function getBrowserStats(string $period = 'month'): array
    {
        $ranges = self::getDateRange($period);

        return PageView::selectRaw('browser, COUNT(DISTINCT visitor_id) as count')
            ->whereBetween('created_at', [$ranges['start'], $ranges['end']])
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'browser')
            ->toArray();
    }

    /**
     * 운영체제 통계
     */
    public static function getOsStats(string $period = 'month'): array
    {
        $ranges = self::getDateRange($period);

        return PageView::selectRaw('os, COUNT(DISTINCT visitor_id) as count')
            ->whereBetween('created_at', [$ranges['start'], $ranges['end']])
            ->whereNotNull('os')
            ->groupBy('os')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'os')
            ->toArray();
    }

    /**
     * 레퍼러 통계
     */
    public static function getReferrerStats(string $period = 'month'): array
    {
        $ranges = self::getDateRange($period);

        return PageView::selectRaw("
                CASE
                    WHEN referrer_domain IS NULL OR referrer_domain = '' THEN '직접 유입'
                    ELSE referrer_domain
                END as source,
                COUNT(DISTINCT visitor_id) as visitors,
                COUNT(*) as pageviews
            ")
            ->whereBetween('created_at', [$ranges['start'], $ranges['end']])
            ->groupBy('source')
            ->orderByDesc('visitors')
            ->limit(15)
            ->get()
            ->toArray();
    }

    /**
     * UTM 캠페인 통계
     */
    public static function getUtmStats(string $period = 'month'): array
    {
        $ranges = self::getDateRange($period);

        // UTM Source 통계
        $sources = PageView::selectRaw('utm_source, COUNT(DISTINCT visitor_id) as visitors')
            ->whereBetween('created_at', [$ranges['start'], $ranges['end']])
            ->whereNotNull('utm_source')
            ->groupBy('utm_source')
            ->orderByDesc('visitors')
            ->limit(10)
            ->pluck('visitors', 'utm_source')
            ->toArray();

        // UTM Medium 통계
        $mediums = PageView::selectRaw('utm_medium, COUNT(DISTINCT visitor_id) as visitors')
            ->whereBetween('created_at', [$ranges['start'], $ranges['end']])
            ->whereNotNull('utm_medium')
            ->groupBy('utm_medium')
            ->orderByDesc('visitors')
            ->limit(10)
            ->pluck('visitors', 'utm_medium')
            ->toArray();

        // UTM Campaign 통계
        $campaigns = PageView::selectRaw('utm_campaign, COUNT(DISTINCT visitor_id) as visitors')
            ->whereBetween('created_at', [$ranges['start'], $ranges['end']])
            ->whereNotNull('utm_campaign')
            ->groupBy('utm_campaign')
            ->orderByDesc('visitors')
            ->limit(10)
            ->pluck('visitors', 'utm_campaign')
            ->toArray();

        return [
            'sources' => $sources,
            'mediums' => $mediums,
            'campaigns' => $campaigns,
        ];
    }

    /**
     * 시간대별 통계
     */
    public static function getHourlyStats(string $period = 'week'): array
    {
        $ranges = self::getDateRange($period);

        $data = PageView::selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->whereBetween('created_at', [$ranges['start'], $ranges['end']])
            ->groupBy('hour')
            ->pluck('count', 'hour')
            ->toArray();

        $result = [];
        for ($i = 0; $i < 24; $i++) {
            $result[$i] = $data[$i] ?? 0;
        }

        return $result;
    }

    /**
     * 최근 방문자 목록
     */
    public static function getRecentVisitors(int $limit = 50): \Illuminate\Database\Eloquent\Collection
    {
        return Visitor::with(['lead'])
            ->latest('last_visit_at')
            ->limit($limit)
            ->get();
    }

    /**
     * 최근 페이지뷰 목록
     *
     * @param int $limit
     * @param string $botFilter 'all' | 'exclude' | 'only'
     */
    public static function getRecentPageViews(int $limit = 100, string $botFilter = 'all'): \Illuminate\Database\Eloquent\Collection
    {
        $query = PageView::with('visitor');

        if ($botFilter === 'exclude') {
            $query->excludeBots();
        } elseif ($botFilter === 'only') {
            $query->onlyBots();
        }

        return $query->latest('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * 전환 퍼널 통계
     */
    public static function getConversionFunnel(string $period = 'month'): array
    {
        $ranges = self::getDateRange($period);

        $totalVisitors = Visitor::whereBetween('first_visit_at', [$ranges['start'], $ranges['end']])->count();
        $multiPageVisitors = Visitor::whereBetween('first_visit_at', [$ranges['start'], $ranges['end']])
            ->where('total_pageviews', '>', 1)->count();
        $conversions = Visitor::whereBetween('first_visit_at', [$ranges['start'], $ranges['end']])
            ->where('is_converted', true)->count();

        return [
            ['name' => '전체 방문자', 'count' => $totalVisitors, 'rate' => 100],
            ['name' => '2페이지 이상', 'count' => $multiPageVisitors, 'rate' => $totalVisitors > 0 ? round(($multiPageVisitors / $totalVisitors) * 100, 1) : 0],
            ['name' => '전환 (상담신청)', 'count' => $conversions, 'rate' => $totalVisitors > 0 ? round(($conversions / $totalVisitors) * 100, 1) : 0],
        ];
    }

    /**
     * 날짜 범위 계산
     */
    private static function getDateRange(string $period): array
    {
        return match ($period) {
            'today' => ['start' => now()->startOfDay(), 'end' => now()->endOfDay()],
            'yesterday' => ['start' => now()->subDay()->startOfDay(), 'end' => now()->subDay()->endOfDay()],
            'week' => ['start' => now()->subDays(7)->startOfDay(), 'end' => now()->endOfDay()],
            'month' => ['start' => now()->subDays(30)->startOfDay(), 'end' => now()->endOfDay()],
            'quarter' => ['start' => now()->subDays(90)->startOfDay(), 'end' => now()->endOfDay()],
            'year' => ['start' => now()->subYear()->startOfDay(), 'end' => now()->endOfDay()],
            default => ['start' => now()->subDays(30)->startOfDay(), 'end' => now()->endOfDay()],
        };
    }
}
