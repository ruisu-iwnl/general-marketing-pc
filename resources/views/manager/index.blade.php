@extends('manager.layout')

@section('title', '대시보드')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-900">안녕하세요, {{ $manager->name }}님</h1>
    <p class="text-gray-500 text-sm mt-1">오늘도 좋은 하루 되세요!</p>
</div>

{{-- 통계 카드 --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div class="text-2xl font-bold text-gray-900">{{ number_format($totalLeads) }}</div>
        <div class="text-sm text-gray-500 mt-1">전체 리드</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div class="text-2xl font-bold text-blue-600">{{ number_format($newLeads) }}</div>
        <div class="text-sm text-gray-500 mt-1">신규 리드</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div class="text-2xl font-bold text-gray-900">{{ number_format($todayLeads) }}</div>
        <div class="text-sm text-gray-500 mt-1">오늘 배정</div>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <div class="text-2xl font-bold text-gray-900">{{ number_format($weekLeads) }}</div>
        <div class="text-sm text-gray-500 mt-1">이번 주</div>
    </div>
</div>

{{-- 최근 리드 --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between">
        <h2 class="font-medium text-gray-900">최근 배정된 리드</h2>
        <a href="/manager/leads" class="text-sm text-blue-500 hover:text-blue-600">전체보기</a>
    </div>

    @if($recentLeads->count() > 0)
    <div class="divide-y divide-gray-100">
        @foreach($recentLeads as $lead)
        <a href="/manager/leads/{{ $lead->id }}" class="block px-4 py-3 hover:bg-gray-50 transition">
            <div class="flex items-center justify-between">
                <div>
                    <span class="font-medium text-gray-900">{{ $lead->name }}</span>
                    <span class="text-gray-400 text-sm ml-2">{{ $lead->phone }}</span>
                </div>
                <div class="flex items-center gap-2">
                    @php
                        $statusColors = [
                            'new' => 'bg-blue-100 text-blue-700',
                            'contacted' => 'bg-yellow-100 text-yellow-700',
                            'qualified' => 'bg-purple-100 text-purple-700',
                            'converted' => 'bg-green-100 text-green-700',
                            'lost' => 'bg-gray-100 text-gray-500',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$lead->status] ?? 'bg-gray-100 text-gray-500' }}">
                        {{ \App\Models\Lead::STATUSES[$lead->status] ?? $lead->status }}
                    </span>
                    <span class="text-xs text-gray-400">{{ $lead->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @else
    <div class="px-4 py-12 text-center text-gray-400">
        배정된 리드가 없습니다.
    </div>
    @endif
</div>
@endsection
