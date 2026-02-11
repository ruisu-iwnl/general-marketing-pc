<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'variant',
        'referrer',
        'manager_id',
        'status',
        'contacted_at',
        'converted_at',
        'note',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
        'converted_at' => 'datetime',
    ];

    /**
     * 상태 목록
     */
    public const STATUSES = [
        'new' => '신규',
        'contacted' => '연락완료',
        'consulting' => '상담중',
        'converted' => '결제완료',
        'lost' => '이탈',
    ];

    /**
     * 상태별 색상
     */
    public const STATUS_COLORS = [
        'new' => 'bg-blue-100 text-blue-700',
        'contacted' => 'bg-yellow-100 text-yellow-700',
        'consulting' => 'bg-purple-100 text-purple-700',
        'converted' => 'bg-green-100 text-green-700',
        'lost' => 'bg-gray-100 text-gray-500',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(LeadComment::class)->orderBy('created_at', 'desc');
    }

    /**
     * 상태 라벨 반환
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    /**
     * 상태 색상 클래스 반환
     */
    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'bg-gray-100 text-gray-500';
    }
}
