<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'visitor_id',
        'session_id',
        'url',
        'page_title',
        'referrer',
        'referrer_domain',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'device_type',
        'os',
        'os_version',
        'browser',
        'browser_version',
        'screen_width',
        'screen_height',
        'variant',
        'is_bot',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'is_bot' => 'boolean',
    ];

    /**
     * 봇 제외 스코프
     */
    public function scopeExcludeBots($query)
    {
        return $query->where('is_bot', false);
    }

    /**
     * 봇만 스코프
     */
    public function scopeOnlyBots($query)
    {
        return $query->where('is_bot', true);
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }
}
