@extends('admin.layout')
@section('title', '텔레그램 알림 설정')

@section('content')
<div class="mb-6">
    <a href="/admin" class="text-sm text-gray-400 hover:text-gray-600 transition">&larr; 대시보드로</a>
</div>

<h1 class="text-2xl font-bold text-gray-900 mb-6">텔레그램 알림 설정</h1>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- 왼쪽: 설정 폼 --}}
    <div class="lg:col-span-2 space-y-6">
        <form action="/admin/settings/telegram" method="POST">
            @csrf

            {{-- 기본 설정 카드 --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
                <div class="px-6 py-4 bg-blue-600 text-white flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.01-.03.01-.14-.07-.2-.08-.06-.19-.04-.27-.02-.12.03-1.99 1.27-5.62 3.72-.53.36-1.01.54-1.44.53-.47-.01-1.38-.27-2.06-.49-.83-.27-1.49-.42-1.43-.88.03-.24.37-.49 1.02-.74 3.99-1.74 6.65-2.89 7.99-3.45 3.8-1.6 4.59-1.88 5.1-1.89.11 0 .37.03.54.17.14.12.18.28.2.45-.01.06.01.24 0 .38z"/></svg>
                    <span class="font-semibold">텔레그램 알림</span>
                </div>

                <div class="p-6 space-y-6">
                    {{-- 활성화 토글 --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-medium text-gray-900">텔레그램 알림 활성화</h3>
                            <p class="text-sm text-gray-500">알림 기능을 켜거나 끕니다</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="enabled" value="1" {{ $settings['enabled'] ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <hr class="border-gray-100">

                    {{-- 봇 토큰 --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            봇 토큰 (Bot Token) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="bot_token" value="{{ $settings['bot_token'] }}"
                            placeholder="1234567890:ABCDefGhIjKlmNoPQRsTUVwxyZ"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                        <p class="mt-1 text-xs text-gray-400">@BotFather에서 발급받은 토큰</p>
                    </div>

                    {{-- 관리자 채팅 ID --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            관리자 채팅 ID (Chat ID) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="admin_chat_id" value="{{ $settings['admin_chat_id'] }}"
                            placeholder="-1001234567890"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                        <p class="mt-1 text-xs text-gray-400">그룹 채팅 ID (보통 -로 시작)</p>
                    </div>

                    {{-- 메시지 형식 --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">메시지 형식</label>
                        <select name="message_format" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="simple" {{ $settings['message_format'] === 'simple' ? 'selected' : '' }}>간단 - 이름, 연락처만</option>
                            <option value="detailed" {{ $settings['message_format'] === 'detailed' ? 'selected' : '' }}>상세 - 전체 정보 표시</option>
                        </select>
                    </div>

                    {{-- 테스트 버튼 --}}
                    <div>
                        <button type="button" onclick="sendTestMessage()" class="inline-flex items-center gap-2 px-4 py-2 border border-blue-600 text-blue-600 hover:bg-blue-50 text-sm font-medium rounded-lg transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            테스트 메시지 전송
                        </button>
                        <p id="test-result" class="mt-2 text-sm hidden"></p>
                    </div>
                </div>
            </div>

            {{-- 즉시 알림 설정 --}}
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/></svg>
                        즉시 알림 설정
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">아래 이벤트 발생 시 즉시 텔레그램으로 알림이 발송됩니다.</p>
                </div>
                <div class="p-6 space-y-4">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="notify_new_lead" value="1" {{ $settings['notify_new_lead'] ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-0.5">
                        <div>
                            <span class="font-medium text-gray-900">새 상담신청 등록</span>
                            <span class="text-gray-500"> - 고객이 상담을 신청했을 때</span>
                        </div>
                    </label>

                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="notify_lead_assigned" value="1" {{ $settings['notify_lead_assigned'] ? 'checked' : '' }}
                            class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 mt-0.5">
                        <div>
                            <span class="font-medium text-gray-900">매니저 배정</span>
                            <span class="text-gray-500"> - 상담이 매니저에게 배정되었을 때 (해당 매니저에게 알림)</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- 저장 버튼 --}}
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition cursor-pointer">
                    설정 저장
                </button>
            </div>
        </form>
    </div>

    {{-- 오른쪽: 안내 --}}
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden sticky top-20">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    텔레그램 봇 설정 안내
                </h2>
            </div>
            <div class="p-6 text-sm text-gray-600 space-y-4">
                <ol class="list-decimal list-inside space-y-3">
                    <li>텔레그램에서 <strong class="text-blue-600">@BotFather</strong>를 검색하여 대화를 시작합니다.</li>
                    <li><code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs">/newbot</code> 명령으로 새 봇을 생성합니다.</li>
                    <li>봇 이름과 사용자명을 입력하면 <strong>봇 토큰</strong>이 발급됩니다.</li>
                    <li>알림을 받을 그룹에 봇을 추가합니다.</li>
                    <li>그룹에서 아무 메시지나 보낸 후 아래 URL로 <strong>채팅 ID</strong>를 확인합니다:</li>
                </ol>

                <div class="bg-gray-50 rounded-lg p-3 mt-4">
                    <code class="text-xs text-blue-600 break-all">https://api.telegram.org/bot{토큰}/getUpdates</code>
                </div>

                <p class="text-xs text-gray-500 mt-4">
                    응답에서 <code class="bg-gray-100 px-1 py-0.5 rounded">"chat":{"id":-100xxx}</code> 형태의 ID를 복사합니다.
                </p>

                <hr class="border-gray-100 my-4">

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                    <p class="text-xs text-yellow-800">
                        <strong>매니저별 알림:</strong> 매니저 관리 페이지에서 각 매니저의 텔레그램 채팅 ID를 입력하면 배정 알림이 개별 발송됩니다.
                    </p>
                </div>
            </div>
        </div>

        {{-- 메시지 미리보기 --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mt-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    메시지 형식 미리보기
                </h2>
            </div>
            <div class="p-6 text-sm space-y-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-2">간단:</p>
                    <div class="bg-gray-900 text-white rounded-lg p-3 text-xs font-mono">
                        📋 <b>새 상담신청</b><br><br>
                        이름: 홍길동<br>
                        연락처: 010-1234-5678
                    </div>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 mb-2">상세:</p>
                    <div class="bg-gray-900 text-white rounded-lg p-3 text-xs font-mono">
                        📋 <b>새 상담신청이 접수되었습니다</b><br><br>
                        👤 이름: 홍길동<br>
                        📱 연락처: 010-1234-5678<br>
                        📅 접수일시: 2026-02-07 16:30<br>
                        🔗 유입: naver / cpc<br><br>
                        <span class="text-blue-400 underline">상세 보기</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
async function sendTestMessage() {
    const botToken = document.querySelector('input[name="bot_token"]').value;
    const chatId = document.querySelector('input[name="admin_chat_id"]').value;
    const resultEl = document.getElementById('test-result');

    if (!botToken || !chatId) {
        resultEl.className = 'mt-2 text-sm text-red-600';
        resultEl.textContent = '봇 토큰과 채팅 ID를 모두 입력해주세요.';
        resultEl.classList.remove('hidden');
        return;
    }

    resultEl.className = 'mt-2 text-sm text-gray-500';
    resultEl.textContent = '전송 중...';
    resultEl.classList.remove('hidden');

    try {
        const response = await fetch('/admin/settings/telegram/test', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ bot_token: botToken, chat_id: chatId })
        });

        const data = await response.json();

        if (data.success) {
            resultEl.className = 'mt-2 text-sm text-green-600';
            resultEl.textContent = '✓ ' + data.message;
        } else {
            resultEl.className = 'mt-2 text-sm text-red-600';
            resultEl.textContent = '✗ ' + data.message;
        }
    } catch (e) {
        resultEl.className = 'mt-2 text-sm text-red-600';
        resultEl.textContent = '요청 실패: ' + e.message;
    }
}
</script>
@endsection
