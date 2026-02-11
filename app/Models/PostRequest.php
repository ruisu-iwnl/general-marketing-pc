<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostRequest extends Model
{
    protected $fillable = [
        'token', 'customer_name', 'keyword', 'blog_url', 'published_url',
        'status', 'contract_period_id', 'contract_month', 'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function rankRecords()
    {
        return $this->hasMany(RankRecord::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function contractPeriod()
    {
        return $this->belongsTo(ContractPeriod::class);
    }

    /**
     * 토큰으로 조회
     */
    public static function getByToken(string $token): ?self
    {
        return static::where('token', $token)->first();
    }

    /**
     * 계약 기간별 의뢰 조회
     */
    public static function getByContractPeriod(int $contractPeriodId)
    {
        return static::where('contract_period_id', $contractPeriodId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * 계약 월별 의뢰 조회
     */
    public static function getByContractMonth(int $contractId, string $yearMonth)
    {
        return static::where('contract_period_id', $contractId)
            ->where('contract_month', $yearMonth)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
