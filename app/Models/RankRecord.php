<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RankRecord extends Model
{
    protected $fillable = [
        'post_request_id', 'check_type', 'scheduled_at', 'checked_at',
        'rank', 'retry_count', 'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'checked_at' => 'datetime',
    ];

    public function postRequest()
    {
        return $this->belongsTo(PostRequest::class);
    }

    /**
     * 대기 중인 레코드 1건 조회
     */
    public static function getPendingRecord(): ?self
    {
        return static::where('status', 'pending')
            ->where('scheduled_at', '<=', now())
            ->orderBy('scheduled_at', 'asc')
            ->first();
    }

    /**
     * 의뢰별 순위 기록 조회
     */
    public static function getByPostRequestId(int $postRequestId)
    {
        return static::where('post_request_id', $postRequestId)
            ->orderBy('scheduled_at', 'asc')
            ->get();
    }

    /**
     * 순위 체크 스케줄 생성
     */
    public static function createSchedules(int $postRequestId, string $completedAt): int
    {
        $scheduleStr = Setting::getValue('rank_check_schedule', '2h:2시간후,12h:12시간후,1d:1일후,3d:3일후,7d:7일후');
        $baseTime = \Carbon\Carbon::parse($completedAt);
        $created = 0;

        foreach (explode(',', $scheduleStr) as $item) {
            $parts = explode(':', trim($item), 2);
            if (count($parts) < 2) continue;

            $timeCode = $parts[0];
            $label = $parts[1];

            // 시간 코드 파싱
            $scheduledAt = self::parseTimeCode($baseTime->copy(), $timeCode);
            if (!$scheduledAt) continue;

            // 이미 존재하는 check_type 건너뜀
            $exists = static::where('post_request_id', $postRequestId)
                ->where('check_type', $label)
                ->exists();

            if ($exists) continue;

            static::create([
                'post_request_id' => $postRequestId,
                'check_type' => $label,
                'scheduled_at' => $scheduledAt,
                'status' => 'pending',
            ]);
            $created++;
        }

        return $created;
    }

    /**
     * 시간 코드를 Carbon으로 변환
     */
    private static function parseTimeCode(\Carbon\Carbon $base, string $code): ?\Carbon\Carbon
    {
        if (preg_match('/^(\d+)h$/i', $code, $m)) {
            return $base->addHours((int) $m[1]);
        }
        if (preg_match('/^(\d+)d$/i', $code, $m)) {
            return $base->addDays((int) $m[1]);
        }
        if (preg_match('/^(\d+)w$/i', $code, $m)) {
            return $base->addWeeks((int) $m[1]);
        }
        return null;
    }

    /**
     * 수동 순위 등록
     */
    public static function createManualRecord(int $postRequestId, ?int $rank): self
    {
        return static::create([
            'post_request_id' => $postRequestId,
            'check_type' => '수동',
            'scheduled_at' => now(),
            'checked_at' => now(),
            'rank' => $rank,
            'status' => 'completed',
        ]);
    }

    /**
     * 여러 의뢰의 최고순위/최종순위 조회
     */
    public static function getRankStats(array $requestIds): array
    {
        if (empty($requestIds)) return [];

        $stats = static::select('post_request_id')
            ->selectRaw('MIN(CASE WHEN status = "completed" AND rank IS NOT NULL THEN rank END) as best_rank')
            ->selectRaw('(SELECT rr2.rank FROM rank_records rr2 WHERE rr2.post_request_id = rank_records.post_request_id AND rr2.status = "completed" AND rr2.rank IS NOT NULL ORDER BY rr2.checked_at DESC LIMIT 1) as latest_rank')
            ->whereIn('post_request_id', $requestIds)
            ->groupBy('post_request_id')
            ->get();

        $result = [];
        foreach ($stats as $stat) {
            $result[$stat->post_request_id] = [
                'best_rank' => $stat->best_rank,
                'latest_rank' => $stat->latest_rank,
            ];
        }

        return $result;
    }
}
