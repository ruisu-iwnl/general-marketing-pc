@extends('admin.layout')
@section('title', '생성 데이터 설정')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">생성 데이터 설정</h1>
        <p class="text-sm text-gray-500 mt-1">가짜 리드의 생성 스케줄을 관리합니다.</p>
    </div>
</div>

{{-- 탭 네비게이션 --}}
<div class="flex gap-1 mb-6 border-b border-gray-200">
    <a href="/admin/fake-settings" class="px-4 py-2.5 text-sm font-medium border-b-2 border-blue-500 text-blue-600 -mb-px">스케줄 설정</a>
    <a href="/admin/fake-leads" class="px-4 py-2.5 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 -mb-px">생성 목록</a>
</div>

{{-- 유효성 에러 --}}
@if($errors->any())
<div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
    <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- 오늘의 생성 현황 --}}
@if(!empty($todaySummary))
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-6">
    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
        <h2 class="text-sm font-semibold text-gray-700">오늘의 생성 현황</h2>
    </div>
    <div class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($todaySummary as $summary)
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">{{ $summary['schedule_name'] }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $summary['is_count_mode'] ? 'bg-blue-50 text-blue-600' : 'bg-gray-100 text-gray-500' }}">
                    {{ $summary['is_count_mode'] ? '건수 모드' : '간격 모드' }}
                </span>
            </div>
            <div class="flex items-end gap-2 mb-2">
                <span class="text-2xl font-bold text-gray-900">{{ $summary['generated'] }}</span>
                <span class="text-sm text-gray-400 mb-0.5">/ {{ $summary['total'] }}건</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-blue-500 h-2 rounded-full transition-all" style="width: {{ $summary['total'] > 0 ? round($summary['generated'] / $summary['total'] * 100) : 0 }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- 등록된 스케줄 목록 --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-8">
    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
        <h2 class="text-sm font-semibold text-gray-700">등록된 스케줄</h2>
    </div>
    @if($schedules->isEmpty())
    <div class="px-4 py-8 text-center text-gray-400 text-sm">등록된 스케줄이 없습니다.</div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-xs uppercase">
                    <th class="px-4 py-3 text-left">이름</th>
                    <th class="px-4 py-3 text-left">시간대</th>
                    <th class="px-4 py-3 text-left">모드</th>
                    <th class="px-4 py-3 text-left">설정값</th>
                    <th class="px-4 py-3 text-left">요일</th>
                    <th class="px-4 py-3 text-left">상태</th>
                    <th class="px-4 py-3 text-left">작업</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($schedules as $schedule)
                <tr class="hover:bg-gray-50" x-data="{ editing: false }">
                    {{-- 보기 모드 --}}
                    <template x-if="!editing">
                        <td class="px-4 py-3 text-gray-800 font-medium">{{ $schedule->name ?? '스케줄 #' . $schedule->id }}</td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }} ~ {{ \Carbon\Carbon::parse($schedule->time_end)->format('H:i') }}</td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-4 py-3">
                            @if($schedule->isCountMode())
                            <span class="inline-flex px-2 py-0.5 bg-blue-50 text-blue-600 text-xs font-medium rounded-full">건수</span>
                            @else
                            <span class="inline-flex px-2 py-0.5 bg-gray-100 text-gray-500 text-xs font-medium rounded-full">간격</span>
                            @endif
                        </td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-4 py-3 text-gray-600 text-xs">
                            @if($schedule->isCountMode())
                                일 {{ $schedule->daily_min_count }}~{{ $schedule->daily_max_count }}건
                                @if($schedule->time_distribution)
                                    <br>
                                    @foreach($schedule->time_distribution as $td)
                                        <span class="text-gray-400">{{ $td['start'] }}~{{ $td['end'] }}: {{ $td['weight'] }}%</span>{{ !$loop->last ? ', ' : '' }}
                                    @endforeach
                                @endif
                            @else
                                {{ $schedule->min_interval_seconds }}~{{ $schedule->max_interval_seconds }}초 간격
                            @endif
                        </td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-4 py-3 text-gray-600 text-xs">
                            @if($schedule->days_of_week)
                                @php
                                    $dayNames = ['일', '월', '화', '수', '목', '금', '토'];
                                    $days = array_map(fn($d) => $dayNames[$d], $schedule->days_of_week);
                                @endphp
                                {{ implode(', ', $days) }}
                            @else
                                매일
                            @endif
                        </td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-4 py-3">
                            <form action="/admin/fake-settings/{{ $schedule->id }}/toggle" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="cursor-pointer">
                                    @if($schedule->is_active)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-50 text-green-700 text-xs font-medium rounded-full hover:bg-green-100 transition">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> 활성
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-100 text-gray-500 text-xs font-medium rounded-full hover:bg-gray-200 transition">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> 비활성
                                    </span>
                                    @endif
                                </button>
                            </form>
                        </td>
                    </template>
                    <template x-if="!editing">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <button @click="editing = true" class="text-blue-500 hover:text-blue-700 text-xs font-medium transition cursor-pointer">수정</button>
                                <form action="/admin/fake-settings/{{ $schedule->id }}" method="POST" onsubmit="return confirm('삭제하시겠습니까?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-medium transition cursor-pointer">삭제</button>
                                </form>
                            </div>
                        </td>
                    </template>

                    {{-- 수정 모드 --}}
                    <template x-if="editing">
                        <td colspan="7" class="px-4 py-4">
                            <form action="/admin/fake-settings/{{ $schedule->id }}" method="POST" x-data="{
                                mode: '{{ $schedule->isCountMode() ? 'count' : 'interval' }}',
                                bands: {{ json_encode($schedule->time_distribution ?? []) }},
                                selectedDays: {{ json_encode($schedule->days_of_week ?? []) }},
                                dailyMin: {{ $schedule->daily_min_count ?? 20 }},
                                dailyMax: {{ $schedule->daily_max_count ?? 30 }},
                                addBand() { this.bands.push({start: '', end: '', weight: 10}); },
                                removeBand(i) { this.bands.splice(i, 1); },
                                totalWeight() { return this.bands.reduce((s, b) => s + Number(b.weight || 0), 0); },
                                toggleDay(d) {
                                    const idx = this.selectedDays.indexOf(d);
                                    if (idx > -1) this.selectedDays.splice(idx, 1);
                                    else this.selectedDays.push(d);
                                }
                            }">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="mode" :value="mode">

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">이름</label>
                                        <input type="text" name="name" value="{{ $schedule->name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="스케줄 이름">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">시작 시간</label>
                                        <input type="time" name="time_start" value="{{ \Carbon\Carbon::parse($schedule->time_start)->format('H:i') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">종료 시간</label>
                                        <input type="time" name="time_end" value="{{ \Carbon\Carbon::parse($schedule->time_end)->format('H:i') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">모드</label>
                                        <select x-model="mode" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="interval">간격 기반</option>
                                            <option value="count">건수 기반</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- 간격 모드 --}}
                                <div x-show="mode === 'interval'" class="grid grid-cols-2 gap-3 mb-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">최소 간격(초)</label>
                                        <input type="number" name="min_interval_seconds" value="{{ $schedule->min_interval_seconds }}" min="10" max="3600" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-600 mb-1">최대 간격(초)</label>
                                        <input type="number" name="max_interval_seconds" value="{{ $schedule->max_interval_seconds }}" min="10" max="3600" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>

                                {{-- 건수 모드 --}}
                                <div x-show="mode === 'count'" class="mb-3">
                                    <div class="grid grid-cols-2 gap-3 mb-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">일일 최소 건수</label>
                                            <input type="number" name="daily_min_count" x-model="dailyMin" min="1" max="500" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">일일 최대 건수</label>
                                            <input type="number" name="daily_max_count" x-model="dailyMax" min="1" max="500" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>

                                    {{-- 시간대별 분배 --}}
                                    <div class="mb-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <label class="text-xs font-medium text-gray-600">시간대별 분배 (비워두면 균등 분배)</label>
                                            <button type="button" @click="addBand()" class="text-xs text-blue-600 hover:text-blue-700 cursor-pointer">+ 시간대 추가</button>
                                        </div>
                                        <template x-for="(band, idx) in bands" :key="idx">
                                            <div class="flex items-center gap-2 mb-2">
                                                <input type="time" :name="'time_distribution['+idx+'][start]'" x-model="band.start" class="px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <span class="text-gray-400 text-xs">~</span>
                                                <input type="time" :name="'time_distribution['+idx+'][end]'" x-model="band.end" class="px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <input type="number" :name="'time_distribution['+idx+'][weight]'" x-model="band.weight" min="1" max="100" class="w-20 px-2 py-1.5 border border-gray-300 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="가중치">
                                                <span class="text-xs text-gray-400" x-text="totalWeight() > 0 ? Math.round(band.weight / totalWeight() * 100) + '%' : '0%'"></span>
                                                <button type="button" @click="removeBand(idx)" class="text-red-400 hover:text-red-600 text-xs cursor-pointer">삭제</button>
                                            </div>
                                        </template>
                                    </div>
                                </div>

                                {{-- 요일 설정 --}}
                                <div class="mb-3">
                                    <label class="block text-xs font-medium text-gray-600 mb-2">활성 요일 (미선택시 매일)</label>
                                    <div class="flex gap-2">
                                        @foreach(['일', '월', '화', '수', '목', '금', '토'] as $idx => $day)
                                        <button type="button"
                                            @click="toggleDay({{ $idx }})"
                                            :class="selectedDays.includes({{ $idx }}) ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                                            class="w-9 h-9 rounded-lg text-xs font-medium transition cursor-pointer">{{ $day }}</button>
                                        @endforeach
                                    </div>
                                    <template x-for="d in selectedDays" :key="'day_'+d">
                                        <input type="hidden" name="days_of_week[]" :value="d">
                                    </template>
                                </div>

                                <div class="flex items-center gap-2">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition cursor-pointer">저장</button>
                                    <button type="button" @click="editing = false" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-lg transition cursor-pointer">취소</button>
                                </div>
                            </form>
                        </td>
                    </template>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- 새 스케줄 추가 폼 --}}
<div class="bg-white border border-gray-200 rounded-xl overflow-hidden" x-data="{
    mode: 'count',
    bands: [],
    selectedDays: [],
    dailyMin: 20,
    dailyMax: 30,
    addBand() { this.bands.push({start: '', end: '', weight: 10}); },
    removeBand(i) { this.bands.splice(i, 1); },
    totalWeight() { return this.bands.reduce((s, b) => s + Number(b.weight || 0), 0); },
    toggleDay(d) {
        const idx = this.selectedDays.indexOf(d);
        if (idx > -1) this.selectedDays.splice(idx, 1);
        else this.selectedDays.push(d);
    },
    avgCount() { return Math.round((Number(this.dailyMin) + Number(this.dailyMax)) / 2); }
}">
    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
        <h2 class="text-sm font-semibold text-gray-700">새 스케줄 추가</h2>
    </div>
    <form action="/admin/fake-settings" method="POST" class="p-4 sm:p-6">
        @csrf
        <input type="hidden" name="mode" :value="mode">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">스케줄 이름</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="예: 주간 스케줄">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">시작 시간</label>
                <input type="time" name="time_start" value="{{ old('time_start', '09:00') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">종료 시간</label>
                <input type="time" name="time_end" value="{{ old('time_end', '23:00') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">생성 모드</label>
                <select x-model="mode" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="count">건수 기반 (일일 목표)</option>
                    <option value="interval">간격 기반 (초 단위)</option>
                </select>
            </div>
        </div>

        {{-- 간격 기반 모드 --}}
        <div x-show="mode === 'interval'" class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">최소 생성 간격 (초)</label>
                <input type="number" name="min_interval_seconds" value="{{ old('min_interval_seconds', 120) }}" min="10" max="3600" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">최대 생성 간격 (초)</label>
                <input type="number" name="max_interval_seconds" value="{{ old('max_interval_seconds', 300) }}" min="10" max="3600" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        {{-- 건수 기반 모드 --}}
        <div x-show="mode === 'count'">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">일일 최소 건수</label>
                    <input type="number" name="daily_min_count" x-model="dailyMin" value="{{ old('daily_min_count', 20) }}" min="1" max="500" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">일일 최대 건수</label>
                    <input type="number" name="daily_max_count" x-model="dailyMax" value="{{ old('daily_max_count', 30) }}" min="1" max="500" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            {{-- 시간대별 분배 비율 --}}
            <div class="mb-4">
                <div class="flex items-center justify-between mb-2">
                    <label class="text-xs font-medium text-gray-600">시간대별 분배 비율 <span class="text-gray-400">(비워두면 균등 분배)</span></label>
                    <button type="button" @click="addBand()" class="text-xs text-blue-600 hover:text-blue-700 font-medium cursor-pointer">+ 시간대 추가</button>
                </div>

                <template x-for="(band, idx) in bands" :key="idx">
                    <div class="flex items-center gap-2 mb-2">
                        <input type="time" :name="'time_distribution['+idx+'][start]'" x-model="band.start" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="시작">
                        <span class="text-gray-400 text-sm">~</span>
                        <input type="time" :name="'time_distribution['+idx+'][end]'" x-model="band.end" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="종료">
                        <div class="flex items-center gap-1">
                            <input type="number" :name="'time_distribution['+idx+'][weight]'" x-model="band.weight" min="1" max="100" class="w-20 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="가중치">
                        </div>
                        <span class="text-xs text-gray-400 w-10 text-right" x-text="totalWeight() > 0 ? Math.round(band.weight / totalWeight() * 100) + '%' : '0%'"></span>
                        <button type="button" @click="removeBand(idx)" class="text-red-400 hover:text-red-600 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </template>

                {{-- 분배 미리보기 --}}
                <div x-show="bands.length > 0" class="mt-3 p-3 bg-gray-50 rounded-lg">
                    <div class="text-xs font-medium text-gray-500 mb-2">분배 미리보기 (평균 <span x-text="avgCount()"></span>건 기준)</div>
                    <div class="flex gap-1 items-end h-16">
                        <template x-for="(band, idx) in bands" :key="'preview_'+idx">
                            <div class="flex-1 flex flex-col items-center gap-1">
                                <span class="text-[10px] text-gray-500" x-text="totalWeight() > 0 ? Math.round(avgCount() * band.weight / totalWeight()) + '건' : '0건'"></span>
                                <div class="w-full bg-blue-200 rounded-t" :style="'height: ' + (totalWeight() > 0 ? Math.max(4, band.weight / totalWeight() * 48) : 4) + 'px'"></div>
                                <span class="text-[10px] text-gray-400" x-text="band.start ? band.start.substring(0,5) : ''"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        {{-- 요일 설정 --}}
        <div class="mb-4">
            <label class="block text-xs font-medium text-gray-600 mb-2">활성 요일 <span class="text-gray-400">(미선택시 매일)</span></label>
            <div class="flex gap-2">
                @foreach(['일', '월', '화', '수', '목', '금', '토'] as $idx => $day)
                <button type="button"
                    @click="toggleDay({{ $idx }})"
                    :class="selectedDays.includes({{ $idx }}) ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="w-10 h-10 rounded-lg text-sm font-medium transition cursor-pointer">{{ $day }}</button>
                @endforeach
            </div>
            <template x-for="d in selectedDays" :key="'new_day_'+d">
                <input type="hidden" name="days_of_week[]" :value="d">
            </template>
        </div>

        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                <label for="is_active" class="text-sm text-gray-700">활성화</label>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition cursor-pointer">
                스케줄 추가
            </button>
        </div>
    </form>
</div>
@endsection
