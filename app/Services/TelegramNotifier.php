<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\PostRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TelegramNotifier
{
    private array $settings;

    public function __construct()
    {
        $this->settings = $this->loadSettings();
    }

    private function loadSettings(): array
    {
        return [
            'enabled' => Setting::getValue('telegram_enabled', '0'),
            'bot_token' => Setting::getValue('telegram_bot_token'),
            'chat_id' => Setting::getValue('telegram_chat_id'),
            'message_format' => Setting::getValue('telegram_message_format', 'simple'),
            'notify_new_request' => Setting::getValue('telegram_notify_new_request', '1'),
            'notify_new_comment' => Setting::getValue('telegram_notify_new_comment', '1'),
            'notify_billing_generated' => Setting::getValue('telegram_notify_billing_generated', '1'),
            'notify_daily_summary' => Setting::getValue('telegram_notify_daily_summary', '1'),
            'daily_times' => Setting::getValue('telegram_daily_times', ''),
            'last_daily_sent' => Setting::getValue('telegram_last_daily_sent', ''),
        ];
    }

    /**
     * 텔레그램 활성화 여부
     */
    public function isEnabled(): bool
    {
        return $this->settings['enabled'] === '1'
            && !empty($this->settings['bot_token'])
            && !empty($this->settings['chat_id']);
    }

    /**
     * 메시지 전송
     */
    public function send(string $message, ?array $inlineKeyboard = null): bool
    {
        if (empty($this->settings['bot_token']) || empty($this->settings['chat_id'])) {
            return false;
        }

        $params = [
            'chat_id' => $this->settings['chat_id'],
            'text' => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ];

        if ($inlineKeyboard) {
            $params['reply_markup'] = json_encode(['inline_keyboard' => $inlineKeyboard]);
        }

        return $this->callApi($this->settings['bot_token'], $params);
    }

    /**
     * 텔레그램 API 호출
     */
    private function callApi(string $botToken, array $params): bool
    {
        $url = "https://api.telegram.org/bot{$botToken}/sendMessage";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            Log::error('TelegramNotifier send failed', ['error' => $error]);
            return false;
        }

        $data = json_decode($response, true);
        if (empty($data['ok'])) {
            Log::warning('TelegramNotifier API error', ['response' => $data]);
            return false;
        }

        return true;
    }

    // ========================================
    // 알림 메서드
    // ========================================

    /**
     * 새 의뢰 등록 알림
     */
    public function notifyNewRequest(PostRequest $request): bool
    {
        if (!$this->isEnabled() || $this->settings['notify_new_request'] !== '1') {
            return false;
        }

        if ($this->settings['message_format'] === 'simple') {
            $message = "새 의뢰: [{$request->customer_name}] {$request->keyword}";
        } else {
            $message = "📋 <b>새 의뢰가 등록되었습니다</b>\n\n"
                . "👤 고객사: {$request->customer_name}\n"
                . "🔑 키워드: {$request->keyword}\n"
                . "📅 등록일: " . $request->created_at->format('Y-m-d H:i');
        }

        return $this->send($message);
    }

    /**
     * 새 댓글 등록 알림
     */
    public function notifyNewComment(PostRequest $request, string $comment): bool
    {
        if (!$this->isEnabled() || $this->settings['notify_new_comment'] !== '1') {
            return false;
        }

        $shortComment = mb_substr($comment, 0, 100);

        if ($this->settings['message_format'] === 'simple') {
            $message = "새 댓글: [{$request->customer_name}] {$shortComment}";
        } else {
            $message = "💬 <b>새 댓글이 등록되었습니다</b>\n\n"
                . "👤 고객사: {$request->customer_name}\n"
                . "🔑 키워드: {$request->keyword}\n"
                . "📝 내용: {$shortComment}";
        }

        return $this->send($message);
    }

    /**
     * 의뢰 수정 알림
     */
    public function notifyRequestUpdated(PostRequest $request, array $changes): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        $changeLines = [];
        foreach ($changes as $field => $values) {
            $changeLines[] = "  {$field}: {$values['old']} → {$values['new']}";
        }
        $changeText = implode("\n", $changeLines);

        if ($this->settings['message_format'] === 'simple') {
            $message = "의뢰 수정: [{$request->customer_name}] {$request->keyword}";
        } else {
            $message = "✏️ <b>의뢰가 수정되었습니다</b>\n\n"
                . "👤 고객사: {$request->customer_name}\n"
                . "🔑 키워드: {$request->keyword}\n"
                . "📝 변경 내용:\n{$changeText}";
        }

        return $this->send($message);
    }

    /**
     * 의뢰 삭제 알림
     */
    public function notifyRequestDeleted(PostRequest $request): bool
    {
        if (!$this->isEnabled()) {
            return false;
        }

        if ($this->settings['message_format'] === 'simple') {
            $message = "의뢰 삭제: [{$request->customer_name}] {$request->keyword}";
        } else {
            $message = "🗑 <b>의뢰가 삭제되었습니다</b>\n\n"
                . "👤 고객사: {$request->customer_name}\n"
                . "🔑 키워드: {$request->keyword}";
        }

        return $this->send($message);
    }

    /**
     * 자동 청구서 생성 알림
     */
    public function notifyBillingGenerated(int $count, int $totalAmount): bool
    {
        if (!$this->isEnabled() || $this->settings['notify_billing_generated'] !== '1') {
            return false;
        }

        $formattedAmount = number_format($totalAmount);

        if ($this->settings['message_format'] === 'simple') {
            $message = "청구서 생성: {$count}건, {$formattedAmount}원";
        } else {
            $message = "💰 <b>자동 청구서가 생성되었습니다</b>\n\n"
                . "📊 생성 건수: {$count}건\n"
                . "💵 총 금액: {$formattedAmount}원";
        }

        return $this->send($message);
    }

    /**
     * 진행 중 의뢰 현황 정기 알림
     */
    public function notifyDailySummary(): bool
    {
        if (!$this->isEnabled() || $this->settings['notify_daily_summary'] !== '1') {
            return false;
        }

        $stats = DB::table('post_requests')
            ->selectRaw("SUM(CASE WHEN status = 'requested' THEN 1 ELSE 0 END) as requested")
            ->selectRaw("SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress")
            ->selectRaw("SUM(CASE WHEN status = 'as' THEN 1 ELSE 0 END) as as_count")
            ->first();

        $requested = (int) ($stats->requested ?? 0);
        $inProgress = (int) ($stats->in_progress ?? 0);
        $asCount = (int) ($stats->as_count ?? 0);
        $total = $requested + $inProgress + $asCount;

        if ($this->settings['message_format'] === 'simple') {
            $message = "일일 현황: 의뢰 {$requested}건, 진행 {$inProgress}건, AS {$asCount}건 (총 {$total}건)";
        } else {
            $message = "📊 <b>의뢰 현황 알림</b>\n\n"
                . "📋 의뢰 대기: {$requested}건\n"
                . "🔄 진행 중: {$inProgress}건\n"
                . "🔧 AS: {$asCount}건\n"
                . "━━━━━━━━━━━━\n"
                . "📌 총 진행: {$total}건\n\n"
                . "⏰ " . now()->format('Y-m-d H:i');
        }

        return $this->send($message);
    }

    /**
     * 테스트 메시지 (enabled 체크 우회)
     */
    public function sendTest(?string $botToken = null, ?string $chatId = null): bool
    {
        $token = $botToken ?? $this->settings['bot_token'];
        $chat = $chatId ?? $this->settings['chat_id'];

        if (empty($token) || empty($chat)) {
            return false;
        }

        $message = "✅ <b>텔레그램 연동 테스트</b>\n\n"
            . "텔레그램 알림이 정상적으로 연결되었습니다.\n"
            . "테스트 시간: " . now()->format('Y-m-d H:i:s');

        $params = [
            'chat_id' => $chat,
            'text' => $message,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ];

        return $this->callApi($token, $params);
    }

    // ========================================
    // 정기 알림 조건 체크
    // ========================================

    /**
     * 현재 시간이 설정된 알림 시간인지 확인
     */
    public function shouldSendDailySummary(): bool
    {
        $dailyTimes = $this->settings['daily_times'];
        if (empty($dailyTimes)) {
            return false;
        }

        $currentTime = now()->format('H:i');
        $times = array_map('trim', explode(',', $dailyTimes));

        return in_array($currentTime, $times);
    }

    /**
     * 같은 분에 이미 발송했는지 확인 (중복 방지)
     */
    public function canSendDailySummary(): bool
    {
        $lastSent = $this->settings['last_daily_sent'];
        $currentMinute = now()->format('Y-m-d H:i');

        return $lastSent !== $currentMinute;
    }

    /**
     * 발송 완료 기록
     */
    public function markDailySummarySent(): void
    {
        Setting::setValue('telegram_last_daily_sent', now()->format('Y-m-d H:i'));
    }
}
