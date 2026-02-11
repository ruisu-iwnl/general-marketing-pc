<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    protected $fillable = [
        'visitor_hash',
        'ip_address',
        'country',
        'city',
        'first_visit_at',
        'last_visit_at',
        'total_visits',
        'total_pageviews',
        'is_converted',
        'lead_id',
    ];

    protected $casts = [
        'first_visit_at' => 'datetime',
        'last_visit_at' => 'datetime',
        'is_converted' => 'boolean',
    ];

    public function pageViews(): HasMany
    {
        return $this->hasMany(PageView::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    /**
     * 방문자 해시로 찾기 또는 생성
     */
    public static function findOrCreateByHash(string $hash, array $attributes = []): self
    {
        $visitor = self::where('visitor_hash', $hash)->first();

        if ($visitor) {
            $visitor->increment('total_visits');
            $visitor->update(['last_visit_at' => now()]);
            return $visitor;
        }

        return self::create(array_merge([
            'visitor_hash' => $hash,
            'first_visit_at' => now(),
            'last_visit_at' => now(),
        ], $attributes));
    }
}
