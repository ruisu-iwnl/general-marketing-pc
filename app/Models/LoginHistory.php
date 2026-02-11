<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LoginHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_type',
        'user_id',
        'ip_address',
        'user_agent',
        'device_type',
        'browser',
        'os',
        'is_successful',
        'failure_reason',
        'logged_in_at',
    ];

    protected $casts = [
        'is_successful' => 'boolean',
        'logged_in_at' => 'datetime',
    ];

    /**
     * 로그인 이력 기록
     */
    public static function record(
        string $userType,
        ?int $userId,
        Request $request,
        bool $isSuccessful = true,
        ?string $failureReason = null
    ): self {
        $userAgent = $request->userAgent() ?? '';
        $parsed = self::parseUserAgent($userAgent);

        return self::create([
            'user_type' => $userType,
            'user_id' => $userId,
            'ip_address' => $request->ip(),
            'user_agent' => substr($userAgent, 0, 500),
            'device_type' => $parsed['device_type'],
            'browser' => $parsed['browser'],
            'os' => $parsed['os'],
            'is_successful' => $isSuccessful,
            'failure_reason' => $failureReason,
            'logged_in_at' => now(),
        ]);
    }

    /**
     * User-Agent 파싱
     */
    public static function parseUserAgent(string $userAgent): array
    {
        $result = [
            'device_type' => 'desktop',
            'browser' => null,
            'os' => null,
        ];

        if (empty($userAgent)) {
            return $result;
        }

        // 디바이스 타입 감지
        if (preg_match('/Mobile|Android.*Mobile|iPhone|iPod/i', $userAgent)) {
            $result['device_type'] = 'mobile';
        } elseif (preg_match('/iPad|Android(?!.*Mobile)|Tablet/i', $userAgent)) {
            $result['device_type'] = 'tablet';
        }

        // 브라우저 감지
        if (preg_match('/Edge|Edg\//i', $userAgent)) {
            $result['browser'] = 'Edge';
        } elseif (preg_match('/Chrome/i', $userAgent) && !preg_match('/Chromium|Edge|Edg/i', $userAgent)) {
            $result['browser'] = 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $result['browser'] = 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome|Chromium/i', $userAgent)) {
            $result['browser'] = 'Safari';
        } elseif (preg_match('/MSIE|Trident/i', $userAgent)) {
            $result['browser'] = 'Internet Explorer';
        } elseif (preg_match('/Opera|OPR/i', $userAgent)) {
            $result['browser'] = 'Opera';
        } elseif (preg_match('/SamsungBrowser/i', $userAgent)) {
            $result['browser'] = 'Samsung Browser';
        } elseif (preg_match('/Whale/i', $userAgent)) {
            $result['browser'] = 'Whale';
        }

        // OS 감지
        if (preg_match('/Windows NT 10/i', $userAgent)) {
            $result['os'] = 'Windows 10/11';
        } elseif (preg_match('/Windows NT 6\.3/i', $userAgent)) {
            $result['os'] = 'Windows 8.1';
        } elseif (preg_match('/Windows NT 6\.2/i', $userAgent)) {
            $result['os'] = 'Windows 8';
        } elseif (preg_match('/Windows NT 6\.1/i', $userAgent)) {
            $result['os'] = 'Windows 7';
        } elseif (preg_match('/Windows/i', $userAgent)) {
            $result['os'] = 'Windows';
        } elseif (preg_match('/Mac OS X/i', $userAgent)) {
            $result['os'] = 'macOS';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $result['os'] = 'iOS';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $result['os'] = 'Android';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $result['os'] = 'Linux';
        }

        return $result;
    }

    /**
     * 관리자 이력 스코프
     */
    public function scopeAdmin($query)
    {
        return $query->where('user_type', 'admin');
    }

    /**
     * 매니저 이력 스코프
     */
    public function scopeManager($query)
    {
        return $query->where('user_type', 'manager');
    }

    /**
     * 성공한 로그인만
     */
    public function scopeSuccessful($query)
    {
        return $query->where('is_successful', true);
    }

    /**
     * 실패한 로그인만
     */
    public function scopeFailed($query)
    {
        return $query->where('is_successful', false);
    }

    /**
     * 매니저 관계
     */
    public function manager()
    {
        return $this->belongsTo(Manager::class, 'user_id');
    }

    /**
     * 디바이스 타입 아이콘
     */
    public function getDeviceIconAttribute(): string
    {
        return match ($this->device_type) {
            'mobile' => '📱',
            'tablet' => '📲',
            default => '💻',
        };
    }
}
