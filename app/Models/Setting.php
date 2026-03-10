<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = ['setting_key', 'setting_value', 'description', 'updated_at'];

    /**
     * 설정값 조회
     */
    public static function getValue(string $key, $default = null): ?string
    {
        $setting = static::where('setting_key', $key)->first();

        return $setting?->setting_value ?? $default;
    }

    /**
     * 설정값 저장 (upsert)
     */
    public static function setValue(string $key, string $value): bool
    {
        return (bool) static::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value, 'updated_at' => now()]
        );
    }

    /**
     * 전체 설정 조회
     */
    public static function getAllSettings(): array
    {
        return static::pluck('setting_value', 'setting_key')->toArray();
    }
}
