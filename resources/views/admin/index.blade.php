@extends('admin.layout')
@section('title', '대시보드')

@section('content')
<h1 class="text-2xl font-bold text-gray-900 mb-6">대시보드</h1>

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-500 mb-1">전체 상담신청</p>
        <p class="text-3xl font-bold text-gray-900">{{ number_format($totalLeads) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-500 mb-1">오늘</p>
        <p class="text-3xl font-bold text-blue-600">{{ number_format($todayLeads) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-500 mb-1">이번 주</p>
        <p class="text-3xl font-bold text-gray-700">{{ number_format($weekLeads) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-xs text-gray-500 mb-1">이번 달</p>
        <p class="text-3xl font-bold text-gray-700">{{ number_format($monthLeads) }}</p>
    </div>
</div>

{{-- Recent --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-5 py-3.5 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
        <h2 class="font-semibold text-gray-800 text-sm">최근 상담신청</h2>
        <a href="/admin/leads" class="text-xs text-blue-600 hover:text-blue-800 transition">전체 보기 &rarr;</a>
    </div>

    @if($recentLeads->isEmpty())
        <div class="px-6 py-12 text-center">
            <p class="text-gray-400 text-sm">아직 상담신청이 없습니다.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left px-4 py-3 font-medium text-gray-500">이름</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-500">연락처</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-500 hidden sm:table-cell">유입</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-500">등록일</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($recentLeads as $lead)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3">
                            <a href="/admin/leads/{{ $lead->id }}" class="font-medium text-gray-900 hover:text-blue-600 transition">{{ $lead->name }}</a>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $lead->phone }}</td>
                        <td class="px-4 py-3 text-gray-400 hidden sm:table-cell">{{ $lead->utm_source ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-400">{{ $lead->created_at?->format('m/d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

{{-- Quick Actions --}}
<div class="mt-6 flex flex-wrap gap-3">
    <a href="/admin/leads" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
        전체 목록
    </a>
    <a href="/admin/leads/csv" class="px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition">
        CSV 내보내기
    </a>
</div>
@endsection
