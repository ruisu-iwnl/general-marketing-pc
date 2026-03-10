@extends('admin.layout')
@section('title', $lead->name . ' 상세')

@section('content')
<div class="mb-6">
    <a href="/admin/leads" class="text-sm text-gray-400 hover:text-gray-600 transition">&larr; 목록으로</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- 왼쪽: 고객 정보 + 상태 관리 --}}
    <div class="lg:col-span-1 space-y-6">
        {{-- 고객 정보 카드 --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <h2 class="font-bold text-gray-900">고객 정보</h2>
                <span class="inline-flex px-2.5 py-1 text-xs font-medium {{ $lead->status_color }} rounded-full">
                    {{ $lead->status_label }}
                </span>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="flex items-center px-6 py-3">
                    <span class="w-24 text-sm text-gray-500 shrink-0">이름</span>
                    <span class="text-sm font-medium text-gray-900">{{ $lead->name }}</span>
                </div>
                <div class="flex items-center px-6 py-3">
                    <span class="w-24 text-sm text-gray-500 shrink-0">연락처</span>
                    <span class="text-sm text-gray-900">{{ $lead->phone }}</span>
                </div>
                <div class="flex items-center px-6 py-3">
                    <span class="w-24 text-sm text-gray-500 shrink-0">등록일</span>
                    <span class="text-sm text-gray-600">{{ $lead->created_at?->format('Y-m-d H:i') }}</span>
                </div>
                @if($lead->contacted_at)
                <div class="flex items-center px-6 py-3">
                    <span class="w-24 text-sm text-gray-500 shrink-0">연락완료</span>
                    <span class="text-sm text-gray-600">{{ $lead->contacted_at->format('Y-m-d H:i') }}</span>
                </div>
                @endif
                @if($lead->converted_at)
                <div class="flex items-center px-6 py-3">
                    <span class="w-24 text-sm text-gray-500 shrink-0">결제완료</span>
                    <span class="text-sm text-green-600 font-medium">{{ $lead->converted_at->format('Y-m-d H:i') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- 상태 변경 --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-gray-900">상태 변경</h2>
            </div>
            <form action="/admin/leads/{{ $lead->id }}/status" method="POST" class="p-6">
                @csrf
                <div class="flex gap-2">
                    <select name="status" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(\App\Models\Lead::STATUSES as $key => $label)
                        <option value="{{ $key }}" {{ $lead->status === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition cursor-pointer">변경</button>
                </div>
            </form>
        </div>

        {{-- 담당자 배정 --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-gray-900">담당자</h2>
            </div>
            <form action="/admin/leads/{{ $lead->id }}/assign" method="POST" class="p-6">
                @csrf
                <div class="flex gap-2">
                    <select name="manager_id" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">미배정</option>
                        @foreach($managers as $manager)
                        <option value="{{ $manager->id }}" {{ $lead->manager_id == $manager->id ? 'selected' : '' }}>{{ $manager->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition cursor-pointer">배정</button>
                </div>
            </form>
        </div>

        {{-- UTM 정보 --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-gray-900">유입 정보</h2>
            </div>
            <div class="divide-y divide-gray-100">
                <div class="flex items-center px-6 py-3">
                    <span class="w-24 text-sm text-gray-500 shrink-0">Source</span>
                    <span class="text-sm text-gray-600">{{ $lead->utm_source ?? '-' }}</span>
                </div>
                <div class="flex items-center px-6 py-3">
                    <span class="w-24 text-sm text-gray-500 shrink-0">Medium</span>
                    <span class="text-sm text-gray-600">{{ $lead->utm_medium ?? '-' }}</span>
                </div>
                <div class="flex items-center px-6 py-3">
                    <span class="w-24 text-sm text-gray-500 shrink-0">Campaign</span>
                    <span class="text-sm text-gray-600">{{ $lead->utm_campaign ?? '-' }}</span>
                </div>
                <div class="flex items-start px-6 py-3">
                    <span class="w-24 text-sm text-gray-500 shrink-0">Referrer</span>
                    <span class="text-sm text-gray-600 break-all">{{ $lead->referrer ?? '-' }}</span>
                </div>
                <div class="flex items-center px-6 py-3">
                    <span class="w-24 text-sm text-gray-500 shrink-0">Variant</span>
                    <span class="text-sm text-gray-600">{{ $lead->variant ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- 삭제 --}}
        <div class="flex justify-end">
            <form action="/admin/leads/{{ $lead->id }}" method="POST" onsubmit="return confirm('정말 삭제하시겠습니까?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded-lg transition cursor-pointer">
                    삭제
                </button>
            </form>
        </div>
    </div>

    {{-- 오른쪽: 타임라인 (댓글/상담내역) --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="font-bold text-gray-900">상담 기록</h2>
            </div>

            {{-- 댓글 입력 --}}
            <form action="/admin/leads/{{ $lead->id }}/comment" method="POST" class="p-6 border-b border-gray-100">
                @csrf
                <div class="flex gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div class="flex-1">
                        <textarea name="content" rows="3" required placeholder="상담 내용을 입력하세요..."
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                        <div class="mt-2 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition cursor-pointer">
                                메모 추가
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            {{-- 타임라인 --}}
            <div class="divide-y divide-gray-100">
                @forelse($lead->comments as $comment)
                <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                    <div class="flex gap-3">
                        @if($comment->author_type === 'system')
                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        @elseif($comment->author_type === 'admin')
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        @else
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-900">{{ $comment->author_name }}</span>
                                    @if($comment->author_type === 'system')
                                    <span class="text-xs text-gray-400 bg-gray-100 px-1.5 py-0.5 rounded">시스템</span>
                                    @elseif($comment->author_type === 'admin')
                                    <span class="text-xs text-purple-600 bg-purple-100 px-1.5 py-0.5 rounded">관리자</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-400">{{ $comment->created_at->format('Y-m-d H:i') }}</span>
                                    @if($comment->author_type !== 'system')
                                    <form action="/admin/leads/{{ $lead->id }}/comment/{{ $comment->id }}" method="POST" class="inline" onsubmit="return confirm('삭제하시겠습니까?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-300 hover:text-red-500 transition cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 whitespace-pre-wrap">{{ $comment->content }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center">
                    <p class="text-gray-400 text-sm">아직 기록이 없습니다.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
