@extends('admin.layout')

@section('title', '로그인 이력')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-gray-900">로그인 이력</h1>
</div>

{{-- 필터 --}}
<div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <div>
            <label class="block text-xs text-gray-500 mb-1">사용자 유형</label>
            <select name="user_type" class="px-3 py-2 border border-gray-200 rounded-lg text-sm" onchange="this.form.submit()">
                <option value="">전체</option>
                <option value="admin" {{ $userType === 'admin' ? 'selected' : '' }}>관리자</option>
                <option value="manager" {{ $userType === 'manager' ? 'selected' : '' }}>매니저</option>
            </select>
        </div>
        <div>
            <label class="block text-xs text-gray-500 mb-1">상태</label>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm" onchange="this.form.submit()">
                <option value="">전체</option>
                <option value="success" {{ $status === 'success' ? 'selected' : '' }}>성공</option>
                <option value="failed" {{ $status === 'failed' ? 'selected' : '' }}>실패</option>
            </select>
        </div>
    </form>
</div>

{{-- 목록 --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">시간</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">유형</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">사용자</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">결과</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">IP</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">디바이스</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">브라우저</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">OS</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($histories as $history)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">
                        {{ $history->logged_in_at->format('Y-m-d H:i:s') }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($history->user_type === 'admin')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-700">관리자</span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">매니저</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($history->user_type === 'manager' && $history->manager)
                            {{ $history->manager->name }}
                        @elseif($history->user_type === 'admin')
                            -
                        @else
                            <span class="text-gray-400">알 수 없음</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        @if($history->is_successful)
                            <span class="inline-flex items-center gap-1 text-green-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                성공
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-red-600" title="{{ $history->failure_reason }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                실패
                                @if($history->failure_reason)
                                    <span class="text-gray-400 text-xs">({{ $history->failure_reason }})</span>
                                @endif
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap font-mono text-xs text-gray-500">
                        {{ $history->ip_address }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap">
                        <span title="{{ $history->device_type }}">{{ $history->device_icon }}</span>
                        <span class="text-gray-500">{{ $history->device_type ?? '-' }}</span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">
                        {{ $history->browser ?? '-' }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">
                        {{ $history->os ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-12 text-center text-gray-400">
                        로그인 이력이 없습니다.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($histories->hasPages())
    <div class="px-4 py-3 border-t border-gray-200">
        {{ $histories->links() }}
    </div>
    @endif
</div>
@endsection
