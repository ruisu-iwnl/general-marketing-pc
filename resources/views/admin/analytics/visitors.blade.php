@extends('admin.layout')
@section('title', '실시간 방문 로그')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <a href="/admin/analytics" class="text-sm text-gray-400 hover:text-gray-600 transition">&larr; 통계 대시보드</a>
        <h1 class="text-2xl font-bold text-gray-900 mt-2">실시간 방문 로그</h1>
    </div>
    <button onclick="location.reload()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
        새로고침
    </button>
</div>

{{-- 탭 --}}
<div class="flex gap-1 mb-4 border-b border-gray-200">
    <button onclick="showTab('pageviews')" id="tab-pageviews" class="px-4 py-2 text-sm font-medium border-b-2 border-blue-500 text-blue-600">페이지뷰</button>
    <button onclick="showTab('visitors')" id="tab-visitors" class="px-4 py-2 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">방문자</button>
</div>

{{-- 봇 필터 --}}
<div id="bot-filter" class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
    <form method="GET" class="flex flex-wrap items-center gap-4">
        <span class="text-sm text-gray-600 font-medium">봇 필터:</span>
        <div class="flex gap-2">
            <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg cursor-pointer {{ $botFilter === 'exclude' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                <input type="radio" name="bot" value="exclude" class="hidden" onchange="this.form.submit()" {{ $botFilter === 'exclude' ? 'checked' : '' }}>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                봇 제외
            </label>
            <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg cursor-pointer {{ $botFilter === 'all' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                <input type="radio" name="bot" value="all" class="hidden" onchange="this.form.submit()" {{ $botFilter === 'all' ? 'checked' : '' }}>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                전체
            </label>
            <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg cursor-pointer {{ $botFilter === 'only' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }} transition">
                <input type="radio" name="bot" value="only" class="hidden" onchange="this.form.submit()" {{ $botFilter === 'only' ? 'checked' : '' }}>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                봇만
            </label>
        </div>
        <span class="text-xs text-gray-400">
            @if($botFilter === 'exclude')
                실제 사용자 방문만 표시
            @elseif($botFilter === 'only')
                검색엔진 크롤러, 봇만 표시
            @else
                모든 방문 표시
            @endif
        </span>
    </form>
</div>

{{-- 페이지뷰 테이블 --}}
<div id="content-pageviews" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left px-4 py-3 font-medium text-gray-600">시간</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">유형</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">IP</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">디바이스</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">브라우저</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">OS</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">레퍼러</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">UTM</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pageViews as $pv)
                <tr class="hover:bg-gray-50 transition-colors {{ $pv->is_bot ? 'bg-orange-50/50' : '' }}">
                    <td class="px-4 py-3 text-gray-500 whitespace-nowrap">{{ $pv->created_at->format('m-d H:i:s') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($pv->is_bot)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            봇
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            사용자
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $pv->visitor?->ip_address ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($pv->device_type === 'mobile')
                        <span class="inline-flex items-center gap-1 text-green-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            모바일
                        </span>
                        @elseif($pv->device_type === 'tablet')
                        <span class="inline-flex items-center gap-1 text-yellow-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            태블릿
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 text-blue-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            데스크톱
                        </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ $pv->browser ?? '-' }}
                        @if($pv->browser_version)
                        <span class="text-gray-400 text-xs">{{ Str::limit($pv->browser_version, 8) }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-600">
                        {{ $pv->os ?? '-' }}
                        @if($pv->os_version)
                        <span class="text-gray-400 text-xs">{{ Str::limit($pv->os_version, 8) }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-gray-500 truncate max-w-[200px]" title="{{ $pv->referrer }}">
                        {{ $pv->referrer_domain ?: '직접 유입' }}
                    </td>
                    <td class="px-4 py-3">
                        @if($pv->utm_source)
                        <span class="text-xs bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded">{{ $pv->utm_source }}</span>
                        @endif
                        @if($pv->utm_medium)
                        <span class="text-xs bg-green-100 text-green-700 px-1.5 py-0.5 rounded">{{ $pv->utm_medium }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-400">방문 기록이 없습니다.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- 방문자 테이블 --}}
<div id="content-visitors" class="bg-white rounded-xl border border-gray-200 overflow-hidden hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="text-left px-4 py-3 font-medium text-gray-600">ID</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">IP</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">첫 방문</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">마지막 방문</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">방문 횟수</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">페이지뷰</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-600">전환</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($visitors as $visitor)
                <tr class="hover:bg-gray-50 transition-colors {{ $visitor->is_converted ? 'bg-green-50' : '' }}">
                    <td class="px-4 py-3 text-gray-400 font-mono text-xs">{{ $visitor->id }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $visitor->ip_address ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $visitor->first_visit_at?->format('m-d H:i') }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $visitor->last_visit_at?->format('m-d H:i') }}</td>
                    <td class="px-4 py-3 font-medium">{{ $visitor->total_visits }}</td>
                    <td class="px-4 py-3">{{ $visitor->total_pageviews }}</td>
                    <td class="px-4 py-3">
                        @if($visitor->is_converted)
                        <span class="inline-flex items-center gap-1 text-green-600 font-medium">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            전환됨
                            @if($visitor->lead)
                            <a href="/admin/leads/{{ $visitor->lead_id }}" class="text-blue-600 hover:underline text-xs">#{{ $visitor->lead_id }}</a>
                            @endif
                        </span>
                        @else
                        <span class="text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">방문자가 없습니다.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function showTab(tab) {
    document.getElementById('content-pageviews').classList.add('hidden');
    document.getElementById('content-visitors').classList.add('hidden');
    document.getElementById('tab-pageviews').classList.remove('border-blue-500', 'text-blue-600');
    document.getElementById('tab-pageviews').classList.add('border-transparent', 'text-gray-500');
    document.getElementById('tab-visitors').classList.remove('border-blue-500', 'text-blue-600');
    document.getElementById('tab-visitors').classList.add('border-transparent', 'text-gray-500');

    document.getElementById('content-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-500');
    document.getElementById('tab-' + tab).classList.add('border-blue-500', 'text-blue-600');

    // 봇 필터는 페이지뷰 탭에서만 표시
    document.getElementById('bot-filter').style.display = tab === 'pageviews' ? 'block' : 'none';
}
</script>
@endsection
