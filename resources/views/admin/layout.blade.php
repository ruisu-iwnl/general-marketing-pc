@php
    // 미실행 마이그레이션 개수 계산
    $pendingMigrations = \App\Services\MigrationService::getPendingCount();
@endphp
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '관리자') | 매일영 챌린지</title>
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
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex items-center justify-between h-14">
            <div class="flex items-center gap-6">
                <a href="/admin" class="font-bold text-gray-800 text-sm">매일영 챌린지 <span class="text-gray-400 font-normal">Admin</span></a>

                {{-- Desktop Nav --}}
                <div class="hidden sm:flex items-center gap-1">
                    {{-- 대시보드 --}}
                    <a href="/admin" class="px-3 py-1.5 rounded-lg text-sm {{ request()->is('admin') && !request()->is('admin/*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-800' }} transition">대시보드</a>

                    {{-- 상담신청 --}}
                    <a href="/admin/leads" class="px-3 py-1.5 rounded-lg text-sm {{ request()->is('admin/leads*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-800' }} transition">상담신청</a>

                    {{-- 매니저 --}}
                    <a href="/admin/managers" class="px-3 py-1.5 rounded-lg text-sm {{ request()->is('admin/managers*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-800' }} transition">매니저</a>

                    {{-- 분석 드롭다운 --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="px-3 py-1.5 rounded-lg text-sm {{ request()->is('admin/analytics*') || request()->is('admin/login-history*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-800' }} transition inline-flex items-center gap-1">
                            분석
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-1 w-40 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-40">
                            <a href="/admin/analytics" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition {{ request()->is('admin/analytics') ? 'bg-gray-50 font-medium' : '' }}">
                                통계
                            </a>
                            <a href="/admin/analytics/visitors" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition {{ request()->is('admin/analytics/visitors') ? 'bg-gray-50 font-medium' : '' }}">
                                방문자
                            </a>
                            <a href="/admin/login-history" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition {{ request()->is('admin/login-history*') ? 'bg-gray-50 font-medium' : '' }}">
                                로그인 이력
                            </a>
                        </div>
                    </div>

                    {{-- 설정 드롭다운 --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="px-3 py-1.5 rounded-lg text-sm {{ request()->is('admin/settings*') || request()->is('admin/fake-settings*') || request()->is('admin/fake-leads*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-500 hover:text-gray-800' }} transition inline-flex items-center gap-1 cursor-pointer">
                            설정
                            @if($pendingMigrations > 0)
                            <span class="bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">{{ $pendingMigrations }}</span>
                            @endif
                            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-1 w-44 bg-white border border-gray-200 rounded-lg shadow-lg py-1 z-40">
                            <a href="/admin/settings/ab-test" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition {{ request()->is('admin/settings/ab-test') ? 'bg-gray-50 font-medium' : '' }}">
                                A/B 테스트
                            </a>
                            <a href="/admin/settings/telegram" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition {{ request()->is('admin/settings/telegram') ? 'bg-gray-50 font-medium' : '' }}">
                                텔레그램 알림
                            </a>
                            <a href="/admin/fake-settings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition {{ request()->is('admin/fake-settings*') ? 'bg-gray-50 font-medium' : '' }}">
                                생성 데이터
                            </a>
                            <a href="/admin/fake-leads" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition {{ request()->is('admin/fake-leads*') ? 'bg-gray-50 font-medium' : '' }}">
                                생성 목록
                            </a>
                            <a href="/admin/settings/api" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition {{ request()->is('admin/settings/api*') ? 'bg-gray-50 font-medium' : '' }}">
                                API 관리
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="/admin/settings/migrations" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition flex items-center justify-between {{ request()->is('admin/settings/migrations') ? 'bg-gray-50 font-medium' : '' }}">
                                마이그레이션
                                @if($pendingMigrations > 0)
                                <span class="bg-red-500 text-white text-[10px] font-bold rounded-full px-1.5 py-0.5">{{ $pendingMigrations }}개</span>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <a href="/" class="text-xs text-gray-400 hover:text-gray-600 transition" target="_blank">사이트 보기</a>
                <a href="/admin/logout" class="hidden sm:block text-xs text-red-400 hover:text-red-600 transition">로그아웃</a>

                {{-- Mobile Menu Button --}}
                <button class="sm:hidden p-1.5 text-gray-500 hover:text-gray-800" x-data @click="$dispatch('toggle-mobile-menu')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
            </div>
        </div>
    </nav>

    {{-- Mobile Nav Slide Panel --}}
    <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" class="sm:hidden">
        {{-- Backdrop --}}
        <div x-show="open" x-transition:enter="transition-opacity ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false" class="fixed inset-0 bg-black/20 z-40"></div>

        {{-- Panel --}}
        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" class="fixed right-0 top-0 bottom-0 w-64 bg-white shadow-xl z-50 overflow-y-auto">
            <div class="p-4 border-b border-gray-100 flex items-center justify-between">
                <span class="font-bold text-gray-800">메뉴</span>
                <button @click="open = false" class="p-1.5 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="py-2">
                {{-- 대시보드 --}}
                <a href="/admin" class="block px-4 py-2.5 text-sm {{ request()->is('admin') && !request()->is('admin/*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                    대시보드
                </a>

                {{-- 상담신청 --}}
                <a href="/admin/leads" class="block px-4 py-2.5 text-sm {{ request()->is('admin/leads*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                    상담신청
                </a>

                {{-- 매니저 --}}
                <a href="/admin/managers" class="block px-4 py-2.5 text-sm {{ request()->is('admin/managers*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                    매니저
                </a>

                {{-- 분석 섹션 --}}
                <div class="border-t border-gray-100 mt-2 pt-2">
                    <div class="px-4 py-1.5 text-xs font-medium text-gray-400 uppercase tracking-wide">분석</div>
                    <a href="/admin/analytics" class="block px-4 py-2.5 text-sm {{ request()->is('admin/analytics') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                        통계
                    </a>
                    <a href="/admin/analytics/visitors" class="block px-4 py-2.5 text-sm {{ request()->is('admin/analytics/visitors') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                        방문자
                    </a>
                    <a href="/admin/login-history" class="block px-4 py-2.5 text-sm {{ request()->is('admin/login-history*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                        로그인 이력
                    </a>
                </div>

                {{-- 설정 섹션 --}}
                <div class="border-t border-gray-100 mt-2 pt-2">
                    <div class="px-4 py-1.5 text-xs font-medium text-gray-400 uppercase tracking-wide flex items-center gap-2">
                        설정
                        @if($pendingMigrations > 0)
                        <span class="bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">{{ $pendingMigrations }}</span>
                        @endif
                    </div>
                    <a href="/admin/settings/ab-test" class="block px-4 py-2.5 text-sm {{ request()->is('admin/settings/ab-test') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                        A/B 테스트
                    </a>
                    <a href="/admin/settings/telegram" class="block px-4 py-2.5 text-sm {{ request()->is('admin/settings/telegram') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                        텔레그램 알림
                    </a>
                    <a href="/admin/fake-settings" class="block px-4 py-2.5 text-sm {{ request()->is('admin/fake-settings*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                        생성 데이터
                    </a>
                    <a href="/admin/fake-leads" class="block px-4 py-2.5 text-sm {{ request()->is('admin/fake-leads*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                        생성 목록
                    </a>
                    <a href="/admin/settings/api" class="block px-4 py-2.5 text-sm {{ request()->is('admin/settings/api*') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }}">
                        API 관리
                    </a>
                    <a href="/admin/settings/migrations" class="block px-4 py-2.5 text-sm {{ request()->is('admin/settings/migrations') ? 'bg-gray-100 text-gray-900 font-medium' : 'text-gray-600' }} flex items-center justify-between">
                        마이그레이션
                        @if($pendingMigrations > 0)
                        <span class="bg-red-500 text-white text-[10px] font-bold rounded-full px-1.5 py-0.5">{{ $pendingMigrations }}개</span>
                        @endif
                    </a>
                </div>

                {{-- 로그아웃 --}}
                <div class="border-t border-gray-100 mt-2 pt-2">
                    <a href="/admin/logout" class="block px-4 py-2.5 text-sm text-red-500">
                        로그아웃
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
        {{-- Flash --}}
        @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
