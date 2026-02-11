<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>신청 완료 - 매일영 챌린지</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-dynamic-subset.min.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
{{-- A-8: Thank You 페이지 최적화 - 따뜻한 배경 + 다음 단계 안내 --}}
<body class="font-sans bg-gradient-to-br from-[#FFF8F5] via-white to-[#FFF0E8] min-h-screen flex items-center justify-center px-4">
    <div class="text-center max-w-lg">
        {{-- 체크 아이콘 --}}
        <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-green-100 flex items-center justify-center">
            <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            신청이 완료되었습니다!
        </h1>

        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
            <strong class="text-[var(--color-primary)]">24시간 내</strong>에 전담 매니저가 연락드릴게요.<br>
            영어 실력 향상까지, 함께할게요.
        </p>

        {{-- 다음 단계 안내 --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8 text-left">
            <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[var(--color-accent)]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                다음 단계 안내
            </h2>
            <div class="space-y-4">
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-[var(--color-primary)]/10 flex items-center justify-center shrink-0">
                        <span class="text-[var(--color-primary)] font-bold text-sm">1</span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">전담 매니저 배정</p>
                        <p class="text-sm text-gray-500">24시간 내 카카오톡 또는 전화로 연락드려요</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-[var(--color-primary)]/10 flex items-center justify-center shrink-0">
                        <span class="text-[var(--color-primary)] font-bold text-sm">2</span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">무료 상담 진행</p>
                        <p class="text-sm text-gray-500">현재 상황 파악 + 맞춤 전략 안내</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-[var(--color-accent)]/10 flex items-center justify-center shrink-0">
                        <span class="text-[var(--color-accent)] font-bold text-sm">3</span>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">수업 시작!</p>
                        <p class="text-sm text-gray-500">맞춤 수업으로 영어 말하기 시작</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 추가 액션 유도 --}}
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
            <p class="text-sm text-yellow-800 font-medium mb-2">💡 더 빠른 상담을 원하시면</p>
            <p class="text-xs text-yellow-700">카카오톡 채널 <strong>@매일영챌린지</strong>를 추가해주세요!</p>
        </div>

        <div class="space-y-3">
            <a href="/" class="inline-block px-8 py-3 bg-[var(--color-primary)] hover:bg-[var(--color-primary-dark)] text-white font-semibold rounded-xl transition">
                홈으로 돌아가기
            </a>
        </div>

        {{-- 신뢰 배지 --}}
        <div class="mt-10 flex flex-wrap justify-center gap-6 text-gray-400 text-sm">
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span>개인정보 암호화</span>
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>7일 환불 보장</span>
            </div>
            <div class="flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>24시간 내 상담</span>
            </div>
        </div>
    </div>
</body>
</html>
