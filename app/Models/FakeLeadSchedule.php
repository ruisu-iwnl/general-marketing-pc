<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FakeLeadSchedule extends Model
{
    protected $fillable = [
        'name',
        'time_start',
        'time_end',
        'min_interval_seconds',
        'max_interval_seconds',
        'daily_min_count',
        'daily_max_count',
        'time_distribution',
        'days_of_week',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'time_distribution' => 'array',
        'days_of_week' => 'array',
    ];

    /**
     * 건수 기반 모드인지 확인
     */
    public function isCountMode(): bool
    {
        return $this->daily_min_count !== null;
    }
}
