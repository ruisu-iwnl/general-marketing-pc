@php
    $currentManager = \App\Models\Manager::find(session('manager_id'));
@endphp
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '매니저') | 매일영 챌린지</title>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable-dynamic-subset.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
    tailwind.config = {
        theme: { extend: { fontFamily: { sans: ['Pretendard','ui-sans-serif','system-ui','sans-serif'] } } }
    }
    </script>
</head>
<body class="font-sans bg-gray-50 min-h-screen">
    {{-- Nav --}}
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-30">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 flex items-center justify-between h-14">
            <div class="flex items-center gap-6">
                <a href="/manager" class="font-bold text-gray-800 text-sm">매일영 챌린지 <span class="text-blue-500 font-normal">Manager</span></a>
                <div class="hidden sm:flex items-center gap-1">
                    <a href="/manager" class="px-3 py-1.5 rounded-lg text-sm {{ request()->is('manager') && !request()->is('manager/*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-800' }} transition">대시보드</a>
                    <a href="/manager/leads" class="px-3 py-1.5 rounded-lg text-sm {{ request()->is('manager/leads*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-800' }} transition">담당 리드</a>
                    <a href="/manager/login-history" class="px-3 py-1.5 rounded-lg text-sm {{ request()->is('manager/login-history*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-800' }} transition">로그인 이력</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                @if($currentManager)
                <span class="text-xs text-gray-500">{{ $currentManager->name }}</span>
                @endif
                <a href="/manager/logout" class="text-xs text-red-400 hover:text-red-600 transition">로그아웃</a>
            </div>
        </div>
    </nav>

    {{-- Mobile Nav --}}
    <div class="sm:hidden bg-white border-b border-gray-100 px-4 py-2 flex gap-1 overflow-x-auto">
        <a href="/manager" class="shrink-0 text-center px-3 py-1.5 rounded-lg text-sm {{ request()->is('manager') && !request()->is('manager/*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500' }}">대시보드</a>
        <a href="/manager/leads" class="shrink-0 text-center px-3 py-1.5 rounded-lg text-sm {{ request()->is('manager/leads*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500' }}">담당 리드</a>
        <a href="/manager/login-history" class="shrink-0 text-center px-3 py-1.5 rounded-lg text-sm {{ request()->is('manager/login-history*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500' }}">로그인 이력</a>
    </div>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
        {{-- Flash --}}
        @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
