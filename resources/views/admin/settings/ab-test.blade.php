@extends('admin.layout')
@section('title', 'A/B 테스트 설정')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-900">A/B 테스트 설정</h1>
    <p class="text-sm text-gray-500 mt-1">랜딩 페이지 전체를 variant별로 교체하여 A/B 테스트합니다.</p>
</div>

<form action="/admin/settings/ab-test" method="POST">
    @csrf

    {{-- 운영 모드 --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
        <h2 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            운영 모드
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            {{-- 수동 모드 --}}
            <label class="relative cursor-pointer">
                <input type="radio" name="mode" value="manual" class="peer sr-only" {{ $mode === 'manual' ? 'checked' : '' }}>
                <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-8 h-8 rounded-full bg-gray-100 peer-checked:bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </span>
                        <span class="font-semibold text-gray-800">URL 파라미터</span>
                    </div>
                    <p class="text-xs text-gray-500">광고별로 URL에 <code class="bg-gray-100 px-1 rounded">?v=a</code> 파라미터를 붙여 수동으로 분기</p>
                </div>
            </label>

            {{-- 자동 균등 --}}
            <label class="relative cursor-pointer">
                <input type="radio" name="mode" value="auto" class="peer sr-only" {{ $mode === 'auto' ? 'checked' : '' }}>
                <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-8 h-8 rounded-full bg-gray-100 peer-checked:bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </span>
                        <span class="font-semibold text-gray-800">자동 균등 분배</span>
                    </div>
                    <p class="text-xs text-gray-500">활성화된 variant에 자동으로 균등하게 트래픽 분배</p>
                </div>
            </label>

            {{-- 비율 지정 --}}
            <label class="relative cursor-pointer">
                <input type="radio" name="mode" value="weighted" class="peer sr-only" {{ $mode === 'weighted' ? 'checked' : '' }}>
                <div class="p-4 rounded-xl border-2 border-gray-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-8 h-8 rounded-full bg-gray-100 peer-checked:bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                        </span>
                        <span class="font-semibold text-gray-800">비율 지정 분배</span>
                    </div>
                    <p class="text-xs text-gray-500">각 variant별로 트래픽 비율을 직접 지정</p>
                </div>
            </label>
        </div>

        {{-- 기본 variant (수동 모드용) --}}
        <div class="mt-4 pt-4 border-t border-gray-100">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                기본 Variant <span class="text-gray-400 font-normal">(URL 파라미터 없을 때)</span>
            </label>
            <select name="default_variant" class="w-full sm:w-48 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="a" {{ $defaultVariant === 'a' ? 'selected' : '' }}>A안</option>
                <option value="b" {{ $defaultVariant === 'b' ? 'selected' : '' }}>B안</option>
                <option value="c" {{ $defaultVariant === 'c' ? 'selected' : '' }}>C안</option>
            </select>
        </div>
    </div>

    {{-- Variant 페이지 설정 --}}
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-6">
        <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
            <h2 class="font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                랜딩 페이지 Variant
            </h2>
            <p class="text-xs text-gray-400 mt-1">각 variant는 독립된 랜딩 페이지 파일입니다. 디자인, 카피, 레이아웃을 자유롭게 변경할 수 있습니다.</p>
        </div>

        <div class="divide-y divide-gray-100">
            @php
                $variantColors = [
                    'a' => ['bg' => 'blue', 'label' => 'A'],
                    'b' => ['bg' => 'orange', 'label' => 'B'],
                    'c' => ['bg' => 'pink', 'label' => 'C'],
                ];
            @endphp

            @foreach(['a', 'b', 'c'] as $variant)
            @php
                $setting = $settings[$variant] ?? [];
                $color = $variantColors[$variant];
                $isActive = $setting['is_active'] ?? false;
                $percentage = $setting['traffic_percentage'] ?? 0;
                $conversionCount = $stats[$variant] ?? 0;
                $clickCount = $clickStats[$variant] ?? 0;
                $hasView = $viewStatus[$variant] ?? false;
            @endphp
            <div class="p-5 {{ !$hasView ? 'bg-gray-50/50' : '' }}">
                {{-- 상단: 토글 + 배지 + 이름 + 파일 상태 --}}
                <div class="flex items-center gap-3 mb-3">
                    {{-- 활성화 토글 --}}
                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                        <input type="checkbox" name="variant_{{ $variant }}_active" value="1" class="sr-only peer" {{ $isActive ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-500"></div>
                    </label>

                    {{-- 배지 --}}
                    <span class="w-7 h-7 rounded-full bg-{{ $color['bg'] }}-500 text-white text-xs font-bold flex items-center justify-center shrink-0">{{ $color['label'] }}</span>

                    {{-- 이름 입력 --}}
                    <input
                        type="text"
                        name="variant_{{ $variant }}_name"
                        value="{{ $setting['name'] ?? '' }}"
                        class="flex-1 px-3 py-1.5 border border-gray-200 rounded-lg text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Variant 이름 (예: 직접 질문형 페이지)"
                    >

                    {{-- 파일 상태 뱃지 --}}
                    @if($hasView)
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            페이지 있음
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-600 shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            페이지 없음
                        </span>
                    @endif
                </div>

                {{-- 중단: 파일 경로 + 설명 --}}
                <div class="ml-[4.75rem] space-y-2">
                    {{-- 파일 경로 --}}
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                        <code class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded">variants/{{ $variant }}/landing.blade.php</code>
                    </div>

                    {{-- 메모 입력 --}}
                    <input
                        type="text"
                        name="variant_{{ $variant }}_description"
                        value="{{ $setting['description'] ?? '' }}"
                        class="w-full px-3 py-1.5 border border-gray-200 rounded-lg text-sm text-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="메모 (예: 절약 강조 디자인, 감정 공감형 카피 등)"
                    >

                    {{-- 하단: 트래픽 + 전환 + 미리보기 --}}
                    <div class="flex items-center gap-5 pt-1">
                        {{-- 트래픽 비율 --}}
                        <div class="flex items-center gap-1.5">
                            <label class="text-xs text-gray-400">트래픽</label>
                            <input
                                type="number"
                                name="variant_{{ $variant }}_percentage"
                                value="{{ $percentage }}"
                                min="0"
                                max="100"
                                class="w-16 px-2 py-1 border border-gray-200 rounded-lg text-sm text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            >
                            <span class="text-sm text-gray-400">%</span>
                        </div>

                        {{-- 구분선 --}}
                        <div class="w-px h-5 bg-gray-200"></div>

                        {{-- 리드 전환 수 --}}
                        <div class="flex items-center gap-1.5">
                            <label class="text-xs text-gray-400">리드</label>
                            <span class="text-sm font-bold text-{{ $color['bg'] }}-600">{{ number_format($conversionCount) }}건</span>
                        </div>

                        {{-- 구분선 --}}
                        <div class="w-px h-5 bg-gray-200"></div>

                        {{-- CTA 클릭 수 --}}
                        <div class="flex items-center gap-1.5">
                            <label class="text-xs text-gray-400">클릭</label>
                            <span class="text-sm font-bold text-{{ $color['bg'] }}-600">{{ number_format($clickCount) }}건</span>
                        </div>

                        {{-- 구분선 --}}
                        <div class="w-px h-5 bg-gray-200"></div>

                        {{-- 미리보기 --}}
                        <a
                            href="/?v={{ $variant }}"
                            target="_blank"
                            class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-blue-600 transition {{ !$hasView ? 'opacity-50 pointer-events-none' : '' }}"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            미리보기
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- 저장 버튼 --}}
    <div class="flex items-center justify-between">
        <p class="text-sm text-gray-400">변경사항은 저장 후 즉시 적용됩니다.</p>
        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            설정 저장
        </button>
    </div>
</form>

{{-- 클릭 전환 통계 --}}
@if($totalClicks > 0)
<div class="mt-8 bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
        <h2 class="font-semibold text-gray-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
            CTA 클릭 전환 통계
            <span class="text-sm font-normal text-gray-400">(총 {{ number_format($totalClicks) }}건)</span>
        </h2>
    </div>
    <div class="p-5">
        <div class="space-y-4">
            @php
                $maxClickCount = max($clickStats ?: [1]);
            @endphp
            @foreach(['a' => 'blue', 'b' => 'orange', 'c' => 'pink'] as $variant => $color)
            @php
                $clickCount = $clickStats[$variant] ?? 0;
                $visitors = $visitorStats[$variant] ?? 0;
                $clickRate = $visitors > 0 ? round(($clickCount / $visitors) * 100, 1) : 0;
                $clickBarWidth = $maxClickCount > 0 ? ($clickCount / $maxClickCount) * 100 : 0;
            @endphp
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">{{ strtoupper($variant) }}안</span>
                    <span class="text-sm">
                        <span class="font-bold text-gray-900">{{ number_format($clickCount) }}클릭</span>
                        <span class="text-gray-400">/ {{ number_format($visitors) }}명</span>
                        <span class="text-{{ $color }}-600 font-semibold ml-1">({{ $clickRate }}%)</span>
                    </span>
                </div>
                <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-{{ $color }}-500 rounded-full transition-all duration-500" style="width: {{ $clickBarWidth }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        @if(count($clickStats) > 1)
        @php
            $clickWinner = array_keys($clickStats, max($clickStats))[0] ?? null;
            $clickWinnerCount = $clickStats[$clickWinner] ?? 0;
        @endphp
        @if($clickWinner && $clickWinnerCount >= 10)
        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg text-center">
            <p class="text-sm text-green-700">
                클릭 리더: <strong class="text-green-800">{{ strtoupper($clickWinner) }}안</strong>
                @if($clickWinnerCount < 100)
                <span class="text-green-600 text-xs block mt-1">* 신뢰할 수 있는 결과를 위해 최소 100건 이상 필요합니다</span>
                @endif
            </p>
        </div>
        @endif
        @endif
    </div>
</div>
@endif

{{-- 리드 전환 통계 --}}
@if($totalLeads > 0)
<div class="mt-6 bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50">
        <h2 class="font-semibold text-gray-800 flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            리드 전환 통계
            <span class="text-sm font-normal text-gray-400">(총 {{ number_format($totalLeads) }}건)</span>
        </h2>
    </div>
    <div class="p-5">
        <div class="space-y-4">
            @php
                $maxCount = max($stats ?: [1]);
            @endphp
            @foreach(['a' => 'blue', 'b' => 'orange', 'c' => 'pink'] as $variant => $color)
            @php
                $count = $stats[$variant] ?? 0;
                $percentage = $totalLeads > 0 ? round(($count / $totalLeads) * 100, 1) : 0;
                $barWidth = $maxCount > 0 ? ($count / $maxCount) * 100 : 0;
            @endphp
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">{{ strtoupper($variant) }}안</span>
                    <span class="text-sm">
                        <span class="font-bold text-gray-900">{{ number_format($count) }}건</span>
                        <span class="text-gray-400">({{ $percentage }}%)</span>
                    </span>
                </div>
                <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-{{ $color }}-500 rounded-full transition-all duration-500" style="width: {{ $barWidth }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        @if(count($stats) > 1)
        @php
            $winner = array_keys($stats, max($stats))[0] ?? null;
            $winnerCount = $stats[$winner] ?? 0;
        @endphp
        @if($winner && $winnerCount >= 30)
        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg text-center">
            <p class="text-sm text-green-700">
                현재 리더: <strong class="text-green-800">{{ strtoupper($winner) }}안</strong>
                @if($winnerCount < 200)
                <span class="text-green-600 text-xs block mt-1">* 신뢰할 수 있는 결과를 위해 최소 200건 이상 필요합니다</span>
                @endif
            </p>
        </div>
        @endif
        @endif
    </div>
</div>
@endif

{{-- 페이지 구조 안내 --}}
<div class="mt-6 bg-gray-50 rounded-xl border border-gray-200 p-5">
    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
        Variant 페이지 파일 구조
    </h3>
    <div class="bg-white rounded-lg border border-gray-200 p-4 font-mono text-sm text-gray-700">
        <div class="text-gray-400 mb-1">resources/views/variants/</div>
        <div class="ml-4 space-y-0.5">
            <div class="flex items-center gap-2">
                <span class="text-blue-600">a/</span>landing.blade.php
                @if($viewStatus['a'] ?? false)
                    <span class="text-green-500 text-xs font-sans">&#10003;</span>
                @else
                    <span class="text-red-400 text-xs font-sans">&#10007;</span>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <span class="text-orange-500">b/</span>landing.blade.php
                @if($viewStatus['b'] ?? false)
                    <span class="text-green-500 text-xs font-sans">&#10003;</span>
                @else
                    <span class="text-red-400 text-xs font-sans">&#10007;</span>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <span class="text-pink-500">c/</span>landing.blade.php
                @if($viewStatus['c'] ?? false)
                    <span class="text-green-500 text-xs font-sans">&#10003;</span>
                @else
                    <span class="text-red-400 text-xs font-sans">&#10007;</span>
                @endif
            </div>
        </div>
    </div>
    <p class="mt-3 text-xs text-gray-500">각 variant 폴더에 완전히 다른 랜딩 페이지 HTML을 배치합니다. variant별 뷰 파일이 없으면 기본 variant → A안 → 원본 landing 순서로 fallback됩니다.</p>
</div>

{{-- 사용 가이드 --}}
<div class="mt-4 bg-blue-50 rounded-xl border border-blue-200 p-5">
    <h3 class="font-semibold text-blue-800 mb-3 flex items-center gap-2">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        사용 가이드
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-700">
        <div>
            <p class="font-medium mb-1">전체 페이지 교체 방식</p>
            <ul class="text-xs space-y-1 text-blue-600">
                <li>• variant별로 완전히 다른 랜딩 페이지를 사용</li>
                <li>• 각 variant 폴더의 <code class="bg-white px-1 rounded">landing.blade.php</code>를 직접 편집</li>
                <li>• 디자인, 카피, 레이아웃 등 자유롭게 변경 가능</li>
                <li>• 폼의 variant hidden input은 자동 설정됨</li>
            </ul>
        </div>
        <div>
            <p class="font-medium mb-1">트래픽 분배</p>
            <ul class="text-xs space-y-1 text-blue-600">
                <li>• <strong>URL 파라미터</strong>: <code class="bg-white px-1 rounded">/?v=a</code>로 수동 분기</li>
                <li>• <strong>자동 균등</strong>: 활성 variant에 균등 분배</li>
                <li>• <strong>비율 지정</strong>: variant별 트래픽 비율 설정</li>
                <li>• 쿠키로 30일간 동일 variant 유지</li>
            </ul>
        </div>
    </div>
    <div class="mt-4 pt-4 border-t border-blue-200">
        <p class="text-xs text-blue-600">
            <strong>권장:</strong> 처음에는 URL 파라미터 모드로 시작하여 광고 소재별 성과를 측정하고,
            승자가 나오면 자동 분배 모드로 전환하여 전체 트래픽에 적용하세요.
        </p>
    </div>
</div>
@endsection
