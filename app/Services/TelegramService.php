<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService
{
    private static string $settingsFile = 'telegram_settings.json';

    /**
     * 설정 파일 경로
     */
    private static function getSettingsPath(): string
    {
        return storage_path(self::$settingsFile);
    }

    /**
     * 전체 설정 조회
     */
    public static function getSettings(): array
    {
        $path = self::getSettingsPath();

        if (!file_exists($path)) {
            return self::getDefaultSettings();
        }

        $data = json_decode(file_get_contents($path), true);
        return array_merge(self::getDefaultSettings(), $data ?? []);
    }

    /**
     * 기본 설정
     */
    private static function getDefaultSettings(): array
    {
        return [
            'enabled' => false,
            'bot_token' => '',
            'admin_chat_id' => '',
            'notify_new_lead' => true,
            'notify_lead_assigned' => true,
            'message_format' => 'detailed', // simple, detailed
        ];
    }

    /**
     * 설정 저장
     */
    public static function saveSettings(array $settings): bool
    {
        $path = self::getSettingsPath();
        $current = self::getSettings();
        $merged = array_merge($current, $settings);

        return file_put_contents($path, json_encode($merged, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) !== false;
    }

    /**
     * 텔레그램 메시지 발송
     */
    public static function sendMessage(string $chatId, string $message, ?string $botToken = null): array
    {
        $settings = self::getSettings();
        $token = $botToken ?? $settings['bot_token'];

        if (empty($token) || empty($chatId)) {
            return ['success' => false, 'message' => '봇 토큰 또는 채팅 ID가 설정되지 않았습니다.'];
        }

        try {
            $url = "https://api.telegram.org/bot{$token}/sendMessage";

            $response = Http::timeout(10)->post($url, [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
            ]);

            if ($response->successful() && $response->json('ok')) {
                return ['success' => true, 'message' => '메시지 발송 성공'];
            }

            $error = $response->json('description') ?? '알 수 없는 오류';
            Log::warning('Telegram send failed', ['error' => $error, 'chat_id' => $chatId]);

            return ['success' => false, 'message' => $error];
        } catch (\Exception $e) {
            Log::error('Telegram send exception', ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * 관리자에게 메시지 발송
     */
    public static function sendToAdmin(string $message): array
    {
        $settings = self::getSettings();

        if (!$settings['enabled']) {
            return ['success' => false, 'message' => '텔레그램 알림이 비활성화되어 있습니다.'];
        }

        if (empty($settings['admin_chat_id'])) {
            return ['success' => false, 'message' => '관리자 채팅 ID가 설정되지 않았습니다.'];
        }

        return self::sendMessage($settings['admin_chat_id'], $message);
    }

    /**
     * 새 상담신청 알림
     */
    public static function notifyNewLead(\App\Models\Lead $lead): array
    {
        $settings = self::getSettings();

        if (!$settings['enabled'] || !$settings['notify_new_lead']) {
            return ['success' => false, 'message' => '새 상담신청 알림이 비활성화되어 있습니다.'];
        }

        if ($settings['message_format'] === 'simple') {
            $message = "📋 <b>새 상담신청</b>\n\n"
                . "이름: {$lead->name}\n"
                . "연락처: {$lead->phone}";
        } else {
            $message = "📋 <b>새 상담신청이 접수되었습니다</b>\n\n"
                . "👤 이름: {$lead->name}\n"
                . "📱 연락처: {$lead->phone}\n"
                . "📅 접수일시: " . $lead->created_at->format('Y-m-d H:i') . "\n";

            if ($lead->utm_source) {
                $message .= "🔗 유입: {$lead->utm_source}";
                if ($lead->utm_medium) {
                    $message .= " / {$lead->utm_medium}";
                }
                $message .= "\n";
            }

            $message .= "\n<a href=\"" . url("/admin/leads/{$lead->id}") . "\">상세 보기</a>";
        }

        return self::sendToAdmin($message);
    }

    /**
     * 매니저 배정 알림
     */
    public static function notifyManagerAssigned(\App\Models\Lead $lead, \App\Models\Manager $manager): array
    {
        $settings = self::getSettings();

        if (!$settings['enabled'] || !$settings['notify_lead_assigned']) {
            return ['success' => false, 'message' => '배정 알림이 비활성화되어 있습니다.'];
        }

        if (empty($manager->telegram_chat_id)) {
            return ['success' => false, 'message' => '매니저의 텔레그램 채팅 ID가 설정되지 않았습니다.'];
        }

        if ($settings['message_format'] === 'simple') {
            $message = "📌 <b>새 상담 배정</b>\n\n"
                . "이름: {$lead->name}\n"
                . "연락처: {$lead->phone}";
        } else {
            $message = "📌 <b>새 상담이 배정되었습니다</b>\n\n"
                . "👤 고객명: {$lead->name}\n"
                . "📱 연락처: {$lead->phone}\n"
                . "📊 상태: " . ($lead->status_label ?? '신규') . "\n"
                . "📅 접수일: " . $lead->created_at->format('Y-m-d H:i') . "\n";

            $message .= "\n<a href=\"" . url("/admin/leads/{$lead->id}") . "\">상세 보기</a>";
        }

        return self::sendMessage($manager->telegram_chat_id, $message);
    }

    /**
     * 테스트 메시지 발송
     */
    public static function sendTestMessage(string $botToken, string $chatId): array
    {
        $message = "✅ <b>매일영 챌린지 텔레그램 연동 테스트</b>\n\n"
            . "텔레그램 알림이 정상적으로 연결되었습니다.\n"
            . "테스트 시간: " . now()->format('Y-m-d H:i:s');

        return self::sendMessage($chatId, $message, $botToken);
    }
}
