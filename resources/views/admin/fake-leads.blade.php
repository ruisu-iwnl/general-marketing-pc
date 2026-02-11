@extends('admin.layout')
@section('title', '생성 데이터 목록')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">생성 데이터 목록</h1>
        <p class="text-sm text-gray-500 mt-1">날짜별 가짜 리드 생성 현황을 확인합니다.</p>
    </div>
</div>

{{-- 탭 네비게이션 --}}
<div class="flex gap-1 mb-6 border-b border-gray-200">
    <a href="/admin/fake-settings" class="px-4 py-2.5 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 -mb-px">스케줄 설정</a>
    <a href="/admin/fake-leads" class="px-4 py-2.5 text-sm font-medium border-b-2 border-blue-500 text-blue-600 -mb-px">생성 목록</a>
</div>

{{-- 필터 --}}
<div class="bg-white border border-gray-200 rounded-xl p-4 mb-6">
    <form action="/admin/fake-leads" method="GET" class="flex flex-wrap items-end gap-4">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">날짜</label>
            <input type="date" name="date" value="{{ $date }}" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">스케줄</label>
            <select name="schedule_id" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">전체</option>
                @foreach($schedules as $schedule)
                <option value="{{ $schedule->id }}" {{ $scheduleId == $schedule->id ? 'selected' : '' }}>
                    {{ $schedule->name ?? '스케줄 #' . $schedule->id }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition cursor-pointer">조회</button>
    </form>
</div>

{{-- 요약 카드 --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="text-xs font-medium text-gray-500 mb-1">총 생성 예정</div>
        <div class="text-3xl font-bold text-gray-900">{{ $totalCount }}<span class="text-base font-normal text-gray-400 ml-1">건</span></div>
    </div>
    <div class="bg-white border border-gray-200 rounded-xl p-5">
        <div class="text-xs font-medium text-gray-500 mb-1">현재까지 생성</div>
        <div class="text-3xl font-bold text-blue-600">{{ $generatedCount }}<span class="text-base font-normal text-gray-400 ml-1">건</span></div>
        @if($totalCount > 0)
        <div class="mt-2 w-full bg-gray-200 rounded-full h-1.5">
            <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ round($generatedCount / $totalCount * 100) }}%"></div>
        </div>
        @endif
    </div>
</div>

{{-- 시간대별 분포 차트 --}}
@if($totalCount > 0)
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-6">
    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
        <h2 class="text-sm font-semibold text-gray-700">시간대별 분포</h2>
    </div>
    <div class="p-4">
        @php
            $maxHourly = max($hourlyDistribution) ?: 1;
            $nowHour = (int) now()->format('G');
            $isToday = $date === now()->format('Y-m-d');
        @endphp
        <div class="flex items-end gap-[3px] h-32">
            @for($h = 0; $h < 24; $h++)
            @php
                $count = $hourlyDistribution[$h];
                $height = $maxHourly > 0 ? round($count / $maxHourly * 100) : 0;
                $isPast = $isToday ? $h <= $nowHour : true;
                $isFuture = $isToday && $h > $nowHour;
            @endphp
            <div class="flex-1 flex flex-col items-center gap-1 group relative">
                <div class="w-full rounded-t transition-all {{ $isFuture ? 'bg-gray-200' : 'bg-blue-400' }}" style="height: {{ max(2, $height) }}%"></div>
                @if($h % 3 === 0)
                <span class="text-[10px] text-gray-400">{{ $h }}시</span>
                @endif
                {{-- 호버 툴팁 --}}
                @if($count > 0)
                <div class="absolute bottom-full mb-1 hidden group-hover:block bg-gray-800 text-white text-[10px] px-2 py-1 rounded whitespace-nowrap z-10">
                    {{ $h }}시: {{ $count }}건
                </div>
                @endif
            </div>
            @endfor
        </div>
        <div class="flex items-center gap-4 mt-3 text-xs text-gray-400">
            <div class="flex items-center gap-1"><span class="w-3 h-2 rounded bg-blue-400 inline-block"></span> 생성 완료</div>
            @if($isToday)
            <div class="flex items-center gap-1"><span class="w-3 h-2 rounded bg-gray-200 inline-block"></span> 예정</div>
            @endif
        </div>
    </div>
</div>
@endif

{{-- 생성 목록 테이블 --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-700">생성 목록</h2>
        <span class="text-xs text-gray-400">총 {{ count($leads) }}건</span>
    </div>
    @if(empty($leads))
    <div class="px-4 py-8 text-center text-gray-400 text-sm">해당 날짜에 생성된 데이터가 없습니다.</div>
    @else
    <div class="overflow-x-auto max-h-[600px] overflow-y-auto">
        <table class="w-full text-sm">
            <thead class="sticky top-0">
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <th class="px-4 py-3 text-left w-12">#</th>
                    <th class="px-4 py-3 text-left">시간</th>
                    <th class="px-4 py-3 text-left">이름</th>
                    <th class="px-4 py-3 text-left">지역</th>
                    @if(!$scheduleId)
                    <th class="px-4 py-3 text-left">스케줄</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @php
                    $now = now();
                    $isToday = $date === $now->format('Y-m-d');
                @endphp
                @foreach($leads as $index => $lead)
                @php
                    $isFuture = $isToday && $lead['timestamp'] > $now->timestamp;
                @endphp
                <tr class="hover:bg-gray-50 {{ $isFuture ? 'opacity-40' : '' }}">
                    <td class="px-4 py-2.5 text-gray-400 text-xs">{{ $index + 1 }}</td>
                    <td class="px-4 py-2.5 text-gray-800 font-mono text-xs">
                        {{ $lead['time'] }}
                        @if($isFuture)
                        <span class="ml-1 text-[10px] text-gray-400">(예정)</span>
                        @endif
                    </td>
                    <td class="px-4 py-2.5 text-gray-800">{{ $lead['name'] }}</td>
                    <td class="px-4 py-2.5 text-gray-600">{{ $lead['region'] }}</td>
                    @if(!$scheduleId)
                    <td class="px-4 py-2.5 text-gray-400 text-xs">{{ $lead['schedule_name'] ?? '-' }}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection
