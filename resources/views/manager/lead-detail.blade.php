@extends('manager.layout')

@section('title', '리드 상세')

@section('content')
<div class="mb-6">
    <a href="/manager/leads" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 transition">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        목록으로
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- 리드 정보 --}}
    <div class="lg:col-span-2 space-y-6">
        {{-- 기본 정보 --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">{{ $lead->name }}</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">연락처</span>
                    <p class="font-medium text-gray-900 mt-1">{{ $lead->phone }}</p>
                </div>
                <div>
                    <span class="text-gray-500">등록일</span>
                    <p class="font-medium text-gray-900 mt-1">{{ $lead->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
                @if($lead->utm_source)
                <div>
                    <span class="text-gray-500">UTM Source</span>
                    <p class="font-medium text-gray-900 mt-1">{{ $lead->utm_source }}</p>
                </div>
                @endif
                @if($lead->utm_medium)
                <div>
                    <span class="text-gray-500">UTM Medium</span>
                    <p class="font-medium text-gray-900 mt-1">{{ $lead->utm_medium }}</p>
                </div>
                @endif
                @if($lead->utm_campaign)
                <div>
                    <span class="text-gray-500">UTM Campaign</span>
                    <p class="font-medium text-gray-900 mt-1">{{ $lead->utm_campaign }}</p>
                </div>
                @endif
                @if($lead->referrer)
                <div class="sm:col-span-2">
                    <span class="text-gray-500">유입 경로</span>
                    <p class="font-medium text-gray-900 mt-1 break-all">{{ $lead->referrer }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- 상태 변경 --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-medium text-gray-900 mb-4">상태 변경</h3>
            <form method="POST" action="/manager/leads/{{ $lead->id }}/status">
                @csrf
                <div class="flex gap-2 flex-wrap">
                    @php
                        $statusColors = [
                            'new' => 'bg-blue-500 hover:bg-blue-600',
                            'contacted' => 'bg-yellow-500 hover:bg-yellow-600',
                            'qualified' => 'bg-purple-500 hover:bg-purple-600',
                            'converted' => 'bg-green-500 hover:bg-green-600',
                            'lost' => 'bg-gray-500 hover:bg-gray-600',
                        ];
                    @endphp
                    @foreach(\App\Models\Lead::STATUSES as $key => $label)
                    <button
                        type="submit"
                        name="status"
                        value="{{ $key }}"
                        class="px-4 py-2 text-sm rounded-lg transition {{ $lead->status === $key ? $statusColors[$key] . ' text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                    >
                        {{ $label }}
                    </button>
                    @endforeach
                </div>
            </form>
        </div>

        {{-- 댓글/메모 --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-medium text-gray-900 mb-4">메모</h3>

            {{-- 댓글 목록 --}}
            <div class="space-y-3 mb-6">
                @forelse($lead->comments as $comment)
                <div class="flex gap-3 p-3 rounded-lg {{ $comment->author_type === 'system' ? 'bg-gray-50' : 'bg-blue-50' }}">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            @if($comment->author_type === 'system')
                            <span class="text-xs font-medium text-gray-500">시스템</span>
                            @elseif($comment->author_type === 'admin')
                            <span class="text-xs font-medium text-purple-600">관리자</span>
                            @elseif($comment->author_type === 'manager')
                            <span class="text-xs font-medium text-blue-600">{{ $comment->manager?->name ?? '매니저' }}</span>
                            @endif
                            <span class="text-xs text-gray-400">{{ $comment->created_at->format('Y-m-d H:i') }}</span>
                        </div>
                        <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-400 text-center py-4">메모가 없습니다.</p>
                @endforelse
            </div>

            {{-- 댓글 추가 --}}
            <form method="POST" action="/manager/leads/{{ $lead->id }}/comment">
                @csrf
                <textarea
                    name="content"
                    rows="3"
                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                    placeholder="메모를 입력하세요..."
                    required
                ></textarea>
                <div class="mt-2 flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition">
                        메모 추가
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 사이드바 --}}
    <div class="space-y-6">
        {{-- 현재 상태 --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-medium text-gray-900 mb-4">현재 상태</h3>
            @php
                $statusColors = [
                    'new' => 'bg-blue-100 text-blue-700',
                    'contacted' => 'bg-yellow-100 text-yellow-700',
                    'qualified' => 'bg-purple-100 text-purple-700',
                    'converted' => 'bg-green-100 text-green-700',
                    'lost' => 'bg-gray-100 text-gray-500',
                ];
            @endphp
            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium {{ $statusColors[$lead->status] ?? 'bg-gray-100 text-gray-500' }}">
                {{ \App\Models\Lead::STATUSES[$lead->status] ?? $lead->status }}
            </span>
        </div>

        {{-- 타임라인 --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="font-medium text-gray-900 mb-4">타임라인</h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    <span class="text-gray-500">등록:</span>
                    <span class="text-gray-900">{{ $lead->created_at->format('Y-m-d H:i') }}</span>
                </div>
                @if($lead->contacted_at)
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                    <span class="text-gray-500">연락:</span>
                    <span class="text-gray-900">{{ $lead->contacted_at->format('Y-m-d H:i') }}</span>
                </div>
                @endif
                @if($lead->converted_at)
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-green-500"></div>
                    <span class="text-gray-500">전환:</span>
                    <span class="text-gray-900">{{ $lead->converted_at->format('Y-m-d H:i') }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
