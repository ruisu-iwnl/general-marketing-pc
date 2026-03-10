<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\RankRecord;
use App\Models\PostRequest;
use Illuminate\Support\Facades\Log;

class RankChecker
{
    private const DEFAULT_USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36';

    /**
     * 큐 기반 순위 체크 처리
     */
    public function process(): bool
    {
        // 최소 간격 확인
        $minInterval = (int) Setting::getValue('crawl_min_interval', '10');
        $lastCrawlTime = (int) Setting::getValue('last_crawl_time', '0');

        if ((time() - $lastCrawlTime) < $minInterval) {
            return false;
        }

        // 대기 건 조회
        $record = RankRecord::getPendingRecord();
        if (!$record) {
            return false;
        }

        $postRequest = PostRequest::find($record->post_request_id);
        if (!$postRequest || empty($postRequest->keyword) || empty($postRequest->published_url)) {
            $record->update(['status' => 'failed']);
            return false;
        }

        // 크롤링 실행
        $rank = $this->crawlNaverBlog($postRequest->keyword, $postRequest->published_url);

        if ($rank !== false) {
            $record->update([
                'rank' => $rank,
                'status' => 'completed',
                'checked_at' => now(),
            ]);
        } else {
            $maxRetry = (int) Setting::getValue('crawl_max_retry', '5');
            $retryCount = $record->retry_count + 1;

            $record->update([
                'retry_count' => $retryCount,
                'status' => $retryCount >= $maxRetry ? 'failed' : 'pending',
            ]);
        }

        // 마지막 크롤링 시각 갱신
        Setting::setValue('last_crawl_time', (string) time());

        return true;
    }

    /**
     * 실시간 즉시 순위 조회
     */
    public function checkRankNow(string $keyword, string $targetUrl): ?int
    {
        $rank = $this->crawlNaverBlog($keyword, $targetUrl);

        return $rank !== false ? $rank : null;
    }

    /**
     * 네이버 블로그 검색 크롤링
     */
    protected function crawlNaverBlog(string $keyword, string $targetUrl): int|false
    {
        $userAgent = $this->getChromeUserAgent();
        $majorVersion = $this->extractMajorVersion($userAgent);

        $searchUrl = 'https://search.naver.com/search.naver?ssc=tab.blog.all&sm=tab_jum&query=' . urlencode($keyword);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $searchUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
                'Accept-Language: ko-KR,ko;q=0.9,en-US;q=0.8,en;q=0.7',
                'Cache-Control: max-age=0',
                'DNT: 1',
                'Priority: u=0, i',
                "Sec-CH-UA: \"Chromium\";v=\"{$majorVersion}\", \"Google Chrome\";v=\"{$majorVersion}\", \"Not?A_Brand\";v=\"99\"",
                'Sec-CH-UA-Mobile: ?0',
                'Sec-CH-UA-Platform: "Windows"',
                'Sec-Fetch-Dest: document',
                'Sec-Fetch-Mode: navigate',
                'Sec-Fetch-Site: same-origin',
                'Sec-Fetch-User: ?1',
                'Upgrade-Insecure-Requests: 1',
                "User-Agent: {$userAgent}",
                'Referer: https://search.naver.com/',
            ],
        ]);

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($html === false || $httpCode !== 200) {
            Log::warning('RankChecker crawl failed', ['keyword' => $keyword, 'http_code' => $httpCode, 'error' => $error]);
            return false;
        }

        return $this->parseRank($html, $targetUrl);
    }

    /**
     * HTML에서 순위 파싱 (3단계 fallback)
     */
    private function parseRank(string $html, string $targetUrl): int|false
    {
        // 타겟 URL에서 blogId 추출
        $targetBlogId = $this->extractBlogId($targetUrl);
        if (!$targetBlogId) {
            return false;
        }

        $blogIds = [];

        // 1단계: data-heatmap-target=".nblg" + href
        if (preg_match_all('/data-heatmap-target=["\']\.nblg["\'][^>]*href=["\']([^"\']+)["\']|href=["\']([^"\']+)["\'][^>]*data-heatmap-target=["\']\.nblg["\']/i', $html, $matches)) {
            foreach ($matches[0] as $i => $match) {
                $url = !empty($matches[1][$i]) ? $matches[1][$i] : $matches[2][$i];
                $blogId = $this->extractBlogId($url);
                if ($blogId) {
                    $blogIds[] = $blogId;
                }
            }
        }

        // 2단계: href에서 직접 blog.naver.com 패턴
        if (empty($blogIds)) {
            if (preg_match_all('/href=["\']([^"\']*blog\.naver\.com\/[^"\']+)["\']/i', $html, $matches)) {
                foreach ($matches[1] as $url) {
                    $blogId = $this->extractBlogId($url);
                    if ($blogId) {
                        $blogIds[] = $blogId;
                    }
                }
            }
        }

        // 3단계: 모든 URL에서 blog.naver.com 패턴
        if (empty($blogIds)) {
            if (preg_match_all('/blog\.naver\.com\/([a-zA-Z0-9_]+)\/(\d+)/', $html, $matches)) {
                foreach ($matches[1] as $blogId) {
                    $blogIds[] = $blogId;
                }
            }
        }

        if (empty($blogIds)) {
            return false;
        }

        // 중복 제거 (seen 배열), 순위 카운트
        $seen = [];
        $rank = 0;

        foreach ($blogIds as $blogId) {
            if (isset($seen[$blogId])) continue;
            $seen[$blogId] = true;
            $rank++;

            if ($rank > 30) break;

            if ($blogId === $targetBlogId) {
                return $rank;
            }
        }

        return false; // 30위 내 미발견
    }

    /**
     * URL에서 blogId 추출
     */
    private function extractBlogId(string $url): ?string
    {
        if (preg_match('/blog\.naver\.com\/([a-zA-Z0-9_]+)/', $url, $m)) {
            return $m[1];
        }
        return null;
    }

    /**
     * Chrome User-Agent 관리 (매일 1회 외부 API에서 갱신)
     */
    private function getChromeUserAgent(): string
    {
        $today = date('Y-m-d');
        $lastUpdated = Setting::getValue('chrome_agent_updated_date', '');

        if ($lastUpdated === $today) {
            $cached = Setting::getValue('chrome_user_agent');
            if ($cached) return $cached;
        }

        // 외부 API에서 최신 UA 가져오기
        $apiUrl = Setting::getValue('chrome_agent_api_url', 'http://blogsolution.net/api/chrome_agent/get_agent.php');

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_SSL_VERIFYPEER => false,
            ]);
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                $data = json_decode($response, true);
                if (!empty($data['success']) && !empty($data['user_agent'])) {
                    Setting::setValue('chrome_user_agent', $data['user_agent']);
                    Setting::setValue('chrome_agent_updated_date', $today);
                    return $data['user_agent'];
                }
            }
        } catch (\Exception $e) {
            Log::warning('RankChecker UA fetch failed', ['error' => $e->getMessage()]);
        }

        // fallback: 캐시된 값 또는 기본값
        return Setting::getValue('chrome_user_agent', self::DEFAULT_USER_AGENT);
    }

    /**
     * User-Agent에서 Chrome major version 추출
     */
    private function extractMajorVersion(string $userAgent): string
    {
        if (preg_match('/Chrome\/(\d+)/', $userAgent, $m)) {
            return $m[1];
        }
        return '144';
    }
}
