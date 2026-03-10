@extends('admin.layout')
@section('title', '상담신청 목록')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">상담신청 목록</h1>
    <a href="/admin/leads/csv" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        CSV 다운로드
    </a>
</div>

{{-- Filters --}}
<form action="/admin/leads" method="GET" class="mb-4 flex flex-wrap gap-2">
    <input
        type="text"
        name="q"
        value="{{ $search }}"
        placeholder="이름 또는 연락처 검색"
        class="flex-1 min-w-[200px] px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
    <select name="status" class="px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">전체 상태</option>
        @foreach($statuses as $key => $label)
        <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <select name="manager_id" class="px-4 py-2.5 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">전체 담당자</option>
        <option value="unassigned" {{ $managerId === 'unassigned' ? 'selected' : '' }}>미배정</option>
        @foreach($managers as $manager)
        <option value="{{ $manager->id }}" {{ $managerId == $manager->id ? 'selected' : '' }}>{{ $manager->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition cursor-pointer">검색</button>
    @if($search || $status || $managerId)
    <a href="/admin/leads" class="px-4 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">초기화</a>
    @endif
</form>

{{-- Table --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    @if($leads->isEmpty())
        <div class="px-6 py-12 text-center">
            <p class="text-gray-400 text-sm">
                @if($search || $status || $managerId)
                    검색 결과가 없습니다.
                @else
                    등록된 상담신청이 없습니다.
                @endif
            </p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left px-4 py-3 font-medium text-gray-600 w-12">ID</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">상태</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">이름</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">연락처</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">담당자</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600 hidden md:table-cell">UTM Source</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">등록일</th>
                        <th class="w-10"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($leads as $lead)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-gray-400">{{ $lead->id }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex px-2 py-0.5 text-xs font-medium {{ $lead->status_color }} rounded-full">
                                {{ $lead->status_label }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="/admin/leads/{{ $lead->id }}" class="font-medium text-gray-900 hover:text-blue-600 transition">{{ $lead->name }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $lead->phone }}</td>
                        <td class="px-4 py-3">
                            @if($lead->manager)
                                <span class="text-gray-700">{{ $lead->manager->name }}</span>
                            @else
                                <span class="text-gray-400">미배정</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-400 hidden md:table-cell">{{ $lead->utm_source ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $lead->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-3">
                            <a href="/admin/leads/{{ $lead->id }}" class="text-gray-400 hover:text-blue-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($leads->hasPages())
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $leads->links() }}
        </div>
        @endif
    @endif
</div>
@endsection
