<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractMonthlyToken extends Model
{
    protected $fillable = ['token', 'contract_id', 'year_month'];

    /**
     * 토큰으로 조회
     */
    public static function getByToken(string $token): ?self
    {
        return static::where('token', $token)->first();
    }
}
