@extends('manager.layout')

@section('title', '담당 리드')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-bold text-gray-900">담당 리드</h1>
</div>

{{-- 필터 --}}
<div class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="q" value="{{ $search }}" placeholder="이름, 연락처 검색..."
                class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <div>
            <select name="status" class="px-3 py-2 border border-gray-200 rounded-lg text-sm" onchange="this.form.submit()">
                <option value="">전체 상태</option>
                @foreach($statuses as $key => $label)
                <option value="{{ $key }}" {{ $status === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition">검색</button>
    </form>
</div>

{{-- 목록 --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">이름</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">연락처</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">상태</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-600">등록일</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($leads as $lead)
                <tr class="hover:bg-gray-50 cursor-pointer" onclick="location.href='/manager/leads/{{ $lead->id }}'">
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $lead->name }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $lead->phone }}</td>
                    <td class="px-4 py-3">
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
                            {{ $statuses[$lead->status] ?? $lead->status }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $lead->created_at->format('Y-m-d H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-12 text-center text-gray-400">
                        담당 리드가 없습니다.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($leads->hasPages())
    <div class="px-4 py-3 border-t border-gray-200">
        {{ $leads->links() }}
    </div>
    @endif
</div>
@endsection
