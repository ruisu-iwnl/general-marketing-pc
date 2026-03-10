<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadComment extends Model
{
    protected $fillable = [
        'lead_id',
        'manager_id',
        'author_type',
        'content',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    /**
     * 작성자 이름 반환
     */
    public function getAuthorNameAttribute(): string
    {
        if ($this->author_type === 'admin') {
            return '관리자';
        }
        if ($this->author_type === 'system') {
            return '시스템';
        }
        return $this->manager?->name ?? '알 수 없음';
    }
}
