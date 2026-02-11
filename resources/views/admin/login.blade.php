<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>관리자 로그인 | 매일영 챌린지</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-dynamic-subset.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: { extend: { fontFamily: { sans: ['Pretendard','ui-sans-serif','system-ui','sans-serif'] } } }
    }
    </script>
</head>
<body class="font-sans bg-gray-900 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl bg-blue-600 flex items-center justify-center">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h1 class="text-2xl font-bold text-white mb-1">관리자</h1>
            <p class="text-gray-400 text-sm">
                {{ $isFirstSetup ? '비밀번호를 설정해주세요' : '비밀번호를 입력해주세요' }}
            </p>
        </div>

        @error('password')
        <div class="bg-red-500/20 border border-red-500/30 rounded-lg p-3 mb-4 text-center">
            <p class="text-red-400 text-sm">{{ $message }}</p>
        </div>
        @enderror

        <form action="/admin/login" method="POST" class="space-y-4">
            @csrf
            <input
                type="password"
                name="password"
                placeholder="{{ $isFirstSetup ? '새 비밀번호 설정 (4자 이상)' : '비밀번호' }}"
                required
                autofocus
                class="w-full px-4 py-3 bg-gray-800 border border-gray-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
            >
            <button type="submit" class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition text-sm cursor-pointer">
                {{ $isFirstSetup ? '비밀번호 설정' : '로그인' }}
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/" class="text-gray-500 hover:text-gray-300 text-xs transition">&larr; 사이트로 돌아가기</a>
        </div>
    </div>
</body>
</html>
