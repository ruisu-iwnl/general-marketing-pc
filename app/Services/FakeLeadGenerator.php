<?php

namespace App\Services;

use App\Models\FakeLeadSchedule;
use Carbon\Carbon;

class FakeLeadGenerator
{
    private const SURNAMES = [
        '김', '이', '박', '최', '정', '강', '조', '윤', '장', '임',
        '한', '오', '서', '신', '권', '황', '안', '송', '류', '전',
        '홍', '고', '문', '양', '손', '배', '백', '허', '유', '남',
        '심', '노', '하', '곽', '성', '차', '주', '우', '구', '민',
        '진', '나', '지', '엄', '변', '채', '원', '천', '방', '공',
    ];

    private const REGIONS = [
        '서울', '부산', '인천', '대구', '대전', '광주', '수원', '성남',
        '고양', '용인', '창원', '청주', '전주', '천안', '안산', '안양',
        '김포', '파주', '화성', '제주',
    ];

    /**
     * 최근 60분 이내의 가짜 리드를 생성하여 반환합니다.
     * DB에 저장하지 않고 on-the-fly로 생성합니다.
     */
    public function generate(): array
    {
        $schedules = FakeLeadSchedule::where('is_active', true)->get();

        if ($schedules->isEmpty()) {
            return [];
        }

        $now = Carbon::now();
        $sixtyMinutesAgo = $now->copy()->subMinutes(60);
        $today = $now->format('Y-m-d');
        $results = [];

        foreach ($schedules as $schedule) {
            // 요일 체크
            if (!$this->isActiveDay($schedule, $now)) {
                continue;
            }

            if ($schedule->isCountMode()) {
                $dayLeads = $this->generateByCount($schedule, $today);
                // 60분 이내 필터링
                foreach ($dayLeads as $lead) {
                    if ($lead['timestamp'] >= $sixtyMinutesAgo->timestamp && $lead['timestamp'] <= $now->timestamp) {
                        $results[] = $lead;
                    }
                }
            } else {
                $intervalLeads = $this->generateByInterval($schedule, $today, $now, $sixtyMinutesAgo);
                $results = array_merge($results, $intervalLeads);
            }
        }

        // mt_srand 리셋
        mt_srand();

        return $results;
    }

    /**
     * 특정 날짜의 전체 가짜 리드를 생성하여 반환합니다. (관리 화면용)
     */
    public function generateForDate(string $date, ?int $scheduleId = null): array
    {
        $query = FakeLeadSchedule::where('is_active', true);
        if ($scheduleId) {
            $query->where('id', $scheduleId);
        }
        $schedules = $query->get();

        if ($schedules->isEmpty()) {
            return [];
        }

        $dateCarbon = Carbon::parse($date);
        $results = [];

        foreach ($schedules as $schedule) {
            // 요일 체크
            if (!$this->isActiveDay($schedule, $dateCarbon)) {
                continue;
            }

            if ($schedule->isCountMode()) {
                $leads = $this->generateByCount($schedule, $date);
            } else {
                $leads = $this->generateByIntervalFullDay($schedule, $date);
            }

            foreach ($leads as &$lead) {
                $lead['schedule_id'] = $schedule->id;
                $lead['schedule_name'] = $schedule->name ?? '스케줄 #' . $schedule->id;
            }

            $results = array_merge($results, $leads);
        }

        // mt_srand 리셋
        mt_srand();

        // 시간순 정렬
        usort($results, fn($a, $b) => $a['timestamp'] - $b['timestamp']);

        return $results;
    }

    /**
     * 건수 기반 생성 - 하루 전체 리드 생성
     */
    private function generateByCount(FakeLeadSchedule $schedule, string $date): array
    {
        $dailyCount = $this->getDailyCount($schedule, $date);
        $timeStart = Carbon::parse($date . ' ' . $schedule->time_start);
        $timeEnd = Carbon::parse($date . ' ' . $schedule->time_end);

        // 시간대별 분배
        $distribution = $this->distributeLeads($schedule, $dailyCount, $timeStart, $timeEnd);

        $results = [];
        $globalIndex = 0;

        foreach ($distribution as $band) {
            $bandLeads = $this->spreadLeadsInBand(
                $schedule,
                $date,
                $band['start'],
                $band['end'],
                $band['count'],
                $globalIndex
            );
            $results = array_merge($results, $bandLeads);
            $globalIndex += $band['count'];
        }

        return $results;
    }

    /**
     * 기존 간격 기반 생성 - 60분 이내 필터링
     */
    private function generateByInterval(FakeLeadSchedule $schedule, string $today, Carbon $now, Carbon $sixtyMinutesAgo): array
    {
        $timeStart = Carbon::parse($today . ' ' . $schedule->time_start);
        $timeEnd = Carbon::parse($today . ' ' . $schedule->time_end);
        $results = [];

        // 현재 시각이 스케줄 범위 밖이면 스킵
        if ($now->lt($timeStart) || $now->gt($timeEnd)) {
            return [];
        }

        $cursor = $timeStart->copy();
        $index = 0;

        while ($cursor->lte($now)) {
            $seed = crc32($today . '_' . $schedule->id . '_' . $index);
            mt_srand($seed);

            $interval = mt_rand($schedule->min_interval_seconds, $schedule->max_interval_seconds);
            $leadTime = $cursor->copy();
            $cursor->addSeconds($interval);
            $index++;

            if ($leadTime->lt($sixtyMinutesAgo)) {
                continue;
            }

            if ($leadTime->gt($now)) {
                break;
            }

            $surname = self::SURNAMES[mt_rand(0, count(self::SURNAMES) - 1)];
            $region = self::REGIONS[mt_rand(0, count(self::REGIONS) - 1)];

            $results[] = [
                'name' => $surname . '○○',
                'region' => $region,
                'time' => $leadTime->format('H:i'),
                'timestamp' => $leadTime->timestamp,
                'is_fake' => true,
            ];
        }

        return $results;
    }

    /**
     * 기존 간격 기반 생성 - 하루 전체 (관리 화면용)
     */
    private function generateByIntervalFullDay(FakeLeadSchedule $schedule, string $date): array
    {
        $timeStart = Carbon::parse($date . ' ' . $schedule->time_start);
        $timeEnd = Carbon::parse($date . ' ' . $schedule->time_end);
        $results = [];

        $cursor = $timeStart->copy();
        $index = 0;

        while ($cursor->lt($timeEnd)) {
            $seed = crc32($date . '_' . $schedule->id . '_' . $index);
            mt_srand($seed);

            $interval = mt_rand($schedule->min_interval_seconds, $schedule->max_interval_seconds);
            $leadTime = $cursor->copy();
            $cursor->addSeconds($interval);
            $index++;

            if ($leadTime->gte($timeEnd)) {
                break;
            }

            $surname = self::SURNAMES[mt_rand(0, count(self::SURNAMES) - 1)];
            $region = self::REGIONS[mt_rand(0, count(self::REGIONS) - 1)];

            $results[] = [
                'name' => $surname . '○○',
                'region' => $region,
                'time' => $leadTime->format('H:i'),
                'timestamp' => $leadTime->timestamp,
                'is_fake' => true,
            ];
        }

        return $results;
    }

    /**
     * 요일 체크
     */
    private function isActiveDay(FakeLeadSchedule $schedule, Carbon $date): bool
    {
        if ($schedule->days_of_week === null) {
            return true;
        }

        return in_array($date->dayOfWeek, $schedule->days_of_week);
    }

    /**
     * 시드 기반 결정적 일일 건수 계산
     */
    private function getDailyCount(FakeLeadSchedule $schedule, string $date): int
    {
        $seed = crc32($date . '_count_' . $schedule->id);
        mt_srand($seed);

        $count = mt_rand($schedule->daily_min_count, $schedule->daily_max_count);

        return $count;
    }

    /**
     * 시간대별 건수 분배
     */
    private function distributeLeads(FakeLeadSchedule $schedule, int $totalCount, Carbon $timeStart, Carbon $timeEnd): array
    {
        $distribution = $schedule->time_distribution;

        // time_distribution이 없으면 전체 시간대에 균등 분배
        if (empty($distribution)) {
            return [[
                'start' => $timeStart,
                'end' => $timeEnd,
                'count' => $totalCount,
            ]];
        }

        $date = $timeStart->format('Y-m-d');
        $totalWeight = array_sum(array_column($distribution, 'weight'));

        if ($totalWeight <= 0) {
            return [[
                'start' => $timeStart,
                'end' => $timeEnd,
                'count' => $totalCount,
            ]];
        }

        $bands = [];
        $assigned = 0;

        foreach ($distribution as $i => $band) {
            $bandStart = Carbon::parse($date . ' ' . $band['start']);
            $bandEnd = Carbon::parse($date . ' ' . $band['end']);

            // 마지막 밴드는 나머지 전부 할당 (반올림 누적 오차 방지)
            if ($i === count($distribution) - 1) {
                $count = $totalCount - $assigned;
            } else {
                $count = (int) round($totalCount * $band['weight'] / $totalWeight);
            }

            $assigned += $count;

            $bands[] = [
                'start' => $bandStart,
                'end' => $bandEnd,
                'count' => max(0, $count),
            ];
        }

        return $bands;
    }

    /**
     * 시간대 내 리드 시간 분산
     */
    private function spreadLeadsInBand(FakeLeadSchedule $schedule, string $date, Carbon $bandStart, Carbon $bandEnd, int $count, int $globalIndex): array
    {
        if ($count <= 0) {
            return [];
        }

        $bandSeconds = $bandEnd->diffInSeconds($bandStart);
        if ($bandSeconds <= 0) {
            return [];
        }

        $interval = $bandSeconds / $count;
        $results = [];

        for ($i = 0; $i < $count; $i++) {
            $seed = crc32($date . '_' . $schedule->id . '_lead_' . ($globalIndex + $i));
            mt_srand($seed);

            // 균등 간격의 중심점
            $centerOffset = ($i + 0.5) * $interval;

            // jitter: ±(간격의 30%)
            $jitterRange = (int) ($interval * 0.3);
            $jitter = $jitterRange > 0 ? mt_rand(-$jitterRange, $jitterRange) : 0;

            $offsetSeconds = (int) $centerOffset + $jitter;

            // 경계 초과 방지
            $offsetSeconds = max(0, min($bandSeconds - 1, $offsetSeconds));

            $leadTime = $bandStart->copy()->addSeconds($offsetSeconds);

            $surname = self::SURNAMES[mt_rand(0, count(self::SURNAMES) - 1)];
            $region = self::REGIONS[mt_rand(0, count(self::REGIONS) - 1)];

            $results[] = [
                'name' => $surname . '○○',
                'region' => $region,
                'time' => $leadTime->format('H:i'),
                'timestamp' => $leadTime->timestamp,
                'is_fake' => true,
            ];
        }

        return $results;
    }
}
