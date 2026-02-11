<?php

namespace App\Services;

use App\Models\AbTestSetting;
use App\Models\AbTestConfig;
use Illuminate\Support\Facades\Cookie;

class AbTestService
{
    const MODE_MANUAL = 'manual';      // URL 파라미터로만 분기
    const MODE_AUTO = 'auto';          // 자동 랜덤 분배
    const MODE_WEIGHTED = 'weighted';  // 비율 기반 분배

    private static ?string $cachedVariant = null;

    /**
     * 현재 요청에 대한 variant 결정 (같은 요청 내 캐시)
     */
    public static function getVariant(): string
    {
        if (self::$cachedVariant !== null) {
            return self::$cachedVariant;
        }

        $mode = self::getMode();
        $defaultVariant = self::getDefaultVariant();

        // URL 파라미터가 있으면 무조건 그걸 사용
        $urlVariant = request('v');
        if ($urlVariant && self::isValidVariant($urlVariant)) {
            Cookie::queue('ab_variant', $urlVariant, 60 * 24 * 30); // 30일
            return self::$cachedVariant = $urlVariant;
        }

        // 수동 모드면 기본값 반환
        if ($mode === self::MODE_MANUAL) {
            return self::$cachedVariant = $defaultVariant;
        }

        // 이미 쿠키에 variant가 있으면 그걸 사용 (일관성)
        $cookieVariant = request()->cookie('ab_variant');
        if ($cookieVariant && self::isValidVariant($cookieVariant)) {
            return self::$cachedVariant = $cookieVariant;
        }

        // 자동/비율 모드
        $variant = self::selectVariant($mode);
        Cookie::queue('ab_variant', $variant, 60 * 24 * 30);
        return self::$cachedVariant = $variant;
    }

    /**
     * 모드에 따라 variant 선택
     */
    private static function selectVariant(string $mode): string
    {
        $activeVariants = self::getActiveVariants();

        if (empty($activeVariants)) {
            return self::getDefaultVariant();
        }

        if ($mode === self::MODE_AUTO) {
            // 균등 분배
            return $activeVariants[array_rand($activeVariants)];
        }

        if ($mode === self::MODE_WEIGHTED) {
            // 비율 기반 분배
            return self::selectByWeight();
        }

        return self::getDefaultVariant();
    }

    /**
     * 비율 기반으로 variant 선택
     */
    private static function selectByWeight(): string
    {
        $settings = AbTestSetting::where('is_active', true)
            ->where('traffic_percentage', '>', 0)
            ->get();

        if ($settings->isEmpty()) {
            return self::getDefaultVariant();
        }

        $totalWeight = $settings->sum('traffic_percentage');
        $random = mt_rand(1, $totalWeight);
        $cumulative = 0;

        foreach ($settings as $setting) {
            $cumulative += $setting->traffic_percentage;
            if ($random <= $cumulative) {
                return $setting->variant;
            }
        }

        return self::getDefaultVariant();
    }

    /**
     * 유효한 variant인지 확인
     */
    public static function isValidVariant(string $variant): bool
    {
        return in_array($variant, ['a', 'b', 'c']);
    }

    /**
     * 활성화된 variant 목록
     */
    public static function getActiveVariants(): array
    {
        try {
            return AbTestSetting::where('is_active', true)
                ->pluck('variant')
                ->toArray();
        } catch (\Exception $e) {
            return ['a']; // 테이블 없으면 기본값
        }
    }

    /**
     * 현재 모드 가져오기
     */
    public static function getMode(): string
    {
        try {
            return AbTestConfig::get('mode', self::MODE_MANUAL);
        } catch (\Exception $e) {
            return self::MODE_MANUAL;
        }
    }

    /**
     * 기본 variant 가져오기
     */
    public static function getDefaultVariant(): string
    {
        try {
            return AbTestConfig::get('default_variant', 'a');
        } catch (\Exception $e) {
            return 'a';
        }
    }

    /**
     * 모든 variant 설정 가져오기 (초기화 포함)
     */
    public static function getAllSettings(): array
    {
        try {
            $settings = AbTestSetting::all()->keyBy('variant')->toArray();
        } catch (\Exception $e) {
            $settings = [];
        }

        // 기본값 병합
        $defaults = [
            'a' => [
                'variant' => 'a',
                'name' => 'A안: 직접 질문형',
                'description' => '"매달 40만 원, 그냥 쓰고 계세요?"',
                'is_active' => true,
                'traffic_percentage' => 34,
            ],
            'b' => [
                'variant' => 'b',
                'name' => 'B안: 절약 강조형',
                'description' => '"생활비 40만 원, 매달 아끼는 엄마들의 비밀"',
                'is_active' => false,
                'traffic_percentage' => 33,
            ],
            'c' => [
                'variant' => 'c',
                'name' => 'C안: 감정 공감형',
                'description' => '"장 볼 때마다 한숨부터 나오시죠?"',
                'is_active' => false,
                'traffic_percentage' => 33,
            ],
        ];

        foreach ($defaults as $key => $default) {
            if (!isset($settings[$key])) {
                $settings[$key] = $default;
            }
        }

        return $settings;
    }

    /**
     * 각 variant별 뷰 파일 존재 여부 (admin용)
     */
    public static function getVariantViewStatus(): array
    {
        $status = [];
        foreach (['a', 'b', 'c'] as $variant) {
            $path = resource_path("views/variants/{$variant}/landing.blade.php");
            $status[$variant] = file_exists($path);
        }
        return $status;
    }

    /**
     * 설정 저장
     */
    public static function saveSettings(array $data): void
    {
        // 모드 저장
        if (isset($data['mode'])) {
            AbTestConfig::set('mode', $data['mode']);
        }

        // 기본 variant 저장
        if (isset($data['default_variant'])) {
            AbTestConfig::set('default_variant', $data['default_variant']);
        }

        // Variant별 설정 저장
        if (isset($data['variants']) && is_array($data['variants'])) {
            foreach ($data['variants'] as $variant => $settings) {
                AbTestSetting::updateOrCreate(
                    ['variant' => $variant],
                    [
                        'name' => $settings['name'] ?? "Variant " . strtoupper($variant),
                        'description' => $settings['description'] ?? '',
                        'is_active' => $settings['is_active'] ?? false,
                        'traffic_percentage' => $settings['traffic_percentage'] ?? 0,
                    ]
                );
            }
        }
    }

    /**
     * 초기 데이터 시드
     */
    public static function seedInitialData(): void
    {
        $defaults = self::getAllSettings();

        foreach ($defaults as $variant => $data) {
            AbTestSetting::firstOrCreate(
                ['variant' => $variant],
                $data
            );
        }

        // 기본 설정
        AbTestConfig::set('mode', self::MODE_MANUAL);
        AbTestConfig::set('default_variant', 'a');
    }
}
