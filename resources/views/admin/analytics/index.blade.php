@extends('admin.layout')
@section('title', '방문자 통계')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">방문자 통계</h1>

    <div class="flex items-center gap-3">
        <a href="/admin/analytics/visitors" class="text-sm text-gray-500 hover:text-gray-700 transition">실시간 로그</a>
        <form action="/admin/analytics" method="GET" class="flex items-center gap-2">
            <select name="period" onchange="this.form.submit()" class="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="today" {{ $period === 'today' ? 'selected' : '' }}>오늘</option>
                <option value="yesterday" {{ $period === 'yesterday' ? 'selected' : '' }}>어제</option>
                <option value="week" {{ $period === 'week' ? 'selected' : '' }}>최근 7일</option>
                <option value="month" {{ $period === 'month' ? 'selected' : '' }}>최근 30일</option>
                <option value="quarter" {{ $period === 'quarter' ? 'selected' : '' }}>최근 90일</option>
            </select>
        </form>
    </div>
</div>

{{-- 핵심 지표 카드 --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-sm text-gray-500 mb-1">방문자</p>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['visitors']) }}</p>
        <p class="text-xs text-gray-400 mt-1">신규 {{ number_format($stats['new_visitors']) }} / 재방문 {{ number_format($stats['returning_visitors']) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-sm text-gray-500 mb-1">페이지뷰</p>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['pageviews']) }}</p>
        <p class="text-xs text-gray-400 mt-1">평균 {{ $stats['avg_pageviews'] }}회/방문자</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-sm text-gray-500 mb-1">전환 (상담신청)</p>
        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['conversions']) }}</p>
        <p class="text-xs text-gray-400 mt-1">전환율 {{ $stats['conversion_rate'] }}%</p>
    </div>
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-5 text-white">
        <p class="text-sm text-blue-100 mb-1">전환율</p>
        <p class="text-2xl font-bold">{{ $stats['conversion_rate'] }}%</p>
        <p class="text-xs text-blue-200 mt-1">{{ $stats['visitors'] }}명 중 {{ $stats['conversions'] }}명</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    {{-- 일별 트렌드 차트 --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-bold text-gray-900 mb-4">일별 추이 (30일)</h2>
        <div class="h-64">
            <canvas id="dailyChart"></canvas>
        </div>
    </div>

    {{-- 전환 퍼널 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-bold text-gray-900 mb-4">전환 퍼널</h2>
        <div class="space-y-3">
            @foreach($funnel as $step)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">{{ $step['name'] }}</span>
                    <span class="font-medium">{{ number_format($step['count']) }} <span class="text-gray-400">({{ $step['rate'] }}%)</span></span>
                </div>
                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-blue-500 rounded-full transition-all" style="width: {{ $step['rate'] }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    {{-- 디바이스 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            디바이스
        </h2>
        @php
            $deviceTotal = array_sum($deviceStats);
            $deviceColors = ['desktop' => 'bg-blue-500', 'mobile' => 'bg-green-500', 'tablet' => 'bg-yellow-500'];
            $deviceLabels = ['desktop' => '데스크톱', 'mobile' => '모바일', 'tablet' => '태블릿'];
        @endphp
        @if($deviceTotal > 0)
        <div class="space-y-3">
            @foreach($deviceStats as $device => $count)
            <div class="flex items-center gap-3">
                <div class="w-3 h-3 rounded-full {{ $deviceColors[$device] ?? 'bg-gray-400' }}"></div>
                <span class="flex-1 text-sm text-gray-600">{{ $deviceLabels[$device] ?? $device }}</span>
                <span class="text-sm font-medium">{{ number_format($count) }}</span>
                <span class="text-xs text-gray-400 w-12 text-right">{{ round(($count / $deviceTotal) * 100) }}%</span>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-400">데이터가 없습니다.</p>
        @endif
    </div>

    {{-- 브라우저 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
            브라우저
        </h2>
        @php $browserTotal = array_sum($browserStats); @endphp
        @if($browserTotal > 0)
        <div class="space-y-2">
            @foreach(array_slice($browserStats, 0, 6) as $browser => $count)
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">{{ $browser }}</span>
                <div class="flex items-center gap-2">
                    <div class="w-20 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-400 rounded-full" style="width: {{ ($count / $browserTotal) * 100 }}%"></div>
                    </div>
                    <span class="text-xs text-gray-400 w-8 text-right">{{ round(($count / $browserTotal) * 100) }}%</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-400">데이터가 없습니다.</p>
        @endif
    </div>

    {{-- 운영체제 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            운영체제
        </h2>
        @php $osTotal = array_sum($osStats); @endphp
        @if($osTotal > 0)
        <div class="space-y-2">
            @foreach(array_slice($osStats, 0, 6) as $os => $count)
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">{{ $os }}</span>
                <div class="flex items-center gap-2">
                    <div class="w-20 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-purple-400 rounded-full" style="width: {{ ($count / $osTotal) * 100 }}%"></div>
                    </div>
                    <span class="text-xs text-gray-400 w-8 text-right">{{ round(($count / $osTotal) * 100) }}%</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-sm text-gray-400">데이터가 없습니다.</p>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- 유입 경로 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            유입 경로 (레퍼러)
        </h2>
        @if(count($referrerStats) > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-2 font-medium text-gray-500">소스</th>
                        <th class="text-right py-2 font-medium text-gray-500">방문자</th>
                        <th class="text-right py-2 font-medium text-gray-500">PV</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach(array_slice($referrerStats, 0, 10) as $ref)
                    <tr>
                        <td class="py-2 text-gray-700 truncate max-w-[200px]" title="{{ $ref['source'] }}">{{ $ref['source'] }}</td>
                        <td class="py-2 text-right font-medium">{{ number_format($ref['visitors']) }}</td>
                        <td class="py-2 text-right text-gray-400">{{ number_format($ref['pageviews']) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-sm text-gray-400">데이터가 없습니다.</p>
        @endif
    </div>

    {{-- 시간대별 분포 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            시간대별 방문 분포
        </h2>
        @php $maxHourly = max($hourlyStats) ?: 1; @endphp
        <div class="flex items-end justify-between h-32 gap-0.5">
            @foreach($hourlyStats as $hour => $count)
            <div class="flex-1 flex flex-col items-center">
                <div class="w-full bg-blue-400 rounded-t transition-all hover:bg-blue-500" style="height: {{ ($count / $maxHourly) * 100 }}%" title="{{ $hour }}시: {{ $count }}"></div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-between mt-2 text-xs text-gray-400">
            <span>0시</span>
            <span>6시</span>
            <span>12시</span>
            <span>18시</span>
            <span>24시</span>
        </div>
    </div>
</div>

{{-- UTM 캠페인 --}}
<div class="bg-white rounded-xl border border-gray-200 p-6">
    <h2 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
        UTM 캠페인 성과
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Source --}}
        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-3">utm_source</h3>
            @if(count($utmStats['sources']) > 0)
            <div class="space-y-2">
                @foreach($utmStats['sources'] as $source => $count)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-700">{{ $source }}</span>
                    <span class="text-sm font-medium text-blue-600">{{ number_format($count) }}</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-400">데이터 없음</p>
            @endif
        </div>

        {{-- Medium --}}
        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-3">utm_medium</h3>
            @if(count($utmStats['mediums']) > 0)
            <div class="space-y-2">
                @foreach($utmStats['mediums'] as $medium => $count)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-700">{{ $medium }}</span>
                    <span class="text-sm font-medium text-green-600">{{ number_format($count) }}</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-400">데이터 없음</p>
            @endif
        </div>

        {{-- Campaign --}}
        <div>
            <h3 class="text-sm font-medium text-gray-500 mb-3">utm_campaign</h3>
            @if(count($utmStats['campaigns']) > 0)
            <div class="space-y-2">
                @foreach($utmStats['campaigns'] as $campaign => $count)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-700 truncate" title="{{ $campaign }}">{{ Str::limit($campaign, 20) }}</span>
                    <span class="text-sm font-medium text-purple-600">{{ number_format($count) }}</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-400">데이터 없음</p>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const dailyData = @json($dailyTrend);

new Chart(document.getElementById('dailyChart'), {
    type: 'line',
    data: {
        labels: dailyData.map(d => d.date.slice(5)),
        datasets: [
            {
                label: '방문자',
                data: dailyData.map(d => d.visitors),
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.3,
            },
            {
                label: '페이지뷰',
                data: dailyData.map(d => d.pageviews),
                borderColor: '#10B981',
                backgroundColor: 'transparent',
                borderDash: [5, 5],
                tension: 0.3,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endsection
