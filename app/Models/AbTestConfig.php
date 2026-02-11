<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbTestConfig extends Model
{
    protected $table = 'ab_test_config';

    protected $fillable = ['key', 'value'];

    /**
     * 설정 값 가져오기
     */
    public static function get(string $key, $default = null)
    {
        $config = self::where('key', $key)->first();
        return $config ? $config->value : $default;
    }

    /**
     * 설정 값 저장하기
     */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
