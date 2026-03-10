<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>매니저 로그인 | 매일영 챌린지</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-dynamic-subset.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
    tailwind.config = {
        theme: { extend: { fontFamily: { sans: ['Pretendard','ui-sans-serif','system-ui','sans-serif'] } } }
    }
    </script>
</head>
<body class="font-sans bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">매일영 챌린지</h1>
            <p class="text-blue-500 text-sm mt-1">Manager Login</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            @if($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="/manager/login">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">이메일</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="이메일을 입력하세요"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">비밀번호</label>
                    <input
                        type="password"
                        name="password"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="비밀번호를 입력하세요"
                        required
                    >
                </div>

                <button
                    type="submit"
                    class="w-full py-3 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition"
                >
                    로그인
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            매니저 계정은 관리자에게 문의하세요.
        </p>
    </div>
</body>
</html>
