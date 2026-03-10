<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractPeriod extends Model
{
    protected $fillable = [
        'token', 'customer_name', 'title', 'start_date', 'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function postRequests()
    {
        return $this->hasMany(PostRequest::class);
    }

    /**
     * 토큰으로 조회
     */
    public static function getByToken(string $token): ?self
    {
        return static::where('token', $token)->first();
    }
}
