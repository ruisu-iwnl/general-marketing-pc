<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manager extends Model
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'telegram_chat_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function leads(): HasMany
    {
        return $this->hasMany(Lead::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(LeadComment::class);
    }

    public function loginHistories(): HasMany
    {
        return $this->hasMany(LoginHistory::class, 'user_id')
            ->where('user_type', 'manager');
    }

    /**
     * 마지막 로그인 정보
     */
    public function lastLogin(): ?LoginHistory
    {
        return $this->loginHistories()
            ->where('is_successful', true)
            ->latest('logged_in_at')
            ->first();
    }
}
