@extends('admin.layout')
@section('title', '마이그레이션 관리')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-gray-900">마이그레이션 관리</h1>
    <p class="text-sm text-gray-500 mt-1">데이터베이스 스키마 변경을 관리합니다.</p>
</div>

{{-- 상태 요약 --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-sm text-gray-500 mb-1">전체 마이그레이션</p>
        <p class="text-2xl font-bold text-gray-900">{{ count($migrations) }}개</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4">
        <p class="text-sm text-gray-500 mb-1">실행 완료</p>
        <p class="text-2xl font-bold text-green-600">{{ count(array_filter($migrations, fn($m) => $m['ran'])) }}개</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-4 {{ $pendingCount > 0 ? 'border-red-200 bg-red-50' : '' }}">
        <p class="text-sm {{ $pendingCount > 0 ? 'text-red-600' : 'text-gray-500' }} mb-1">미실행 (대기중)</p>
        <p class="text-2xl font-bold {{ $pendingCount > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $pendingCount }}개</p>
    </div>
</div>

{{-- 액션 버튼 --}}
@if($pendingCount > 0)
<div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="font-semibold text-yellow-800">미실행 마이그레이션이 있습니다</p>
            <p class="text-sm text-yellow-700">아래 버튼을 클릭하여 데이터베이스를 최신 상태로 업데이트하세요.</p>
        </div>
        <form action="/admin/settings/migrations/run" method="POST" onsubmit="return confirm('마이그레이션을 실행하시겠습니까?');">
            @csrf
            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                마이그레이션 실행
            </button>
        </form>
    </div>
</div>
@endif

{{-- 결과 메시지 --}}
@if(session('migration_result'))
@php $result = session('migration_result'); @endphp
<div class="mb-6 rounded-xl p-4 {{ $result['success'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
    <p class="font-semibold {{ $result['success'] ? 'text-green-800' : 'text-red-800' }}">{{ $result['message'] }}</p>
    @if(!empty($result['output']))
    <details class="mt-2">
        <summary class="text-sm {{ $result['success'] ? 'text-green-700' : 'text-red-700' }} cursor-pointer">상세 로그 보기</summary>
        <pre class="mt-2 p-3 bg-gray-900 text-gray-100 text-xs rounded-lg overflow-x-auto">{{ $result['output'] }}</pre>
    </details>
    @endif
</div>
@endif

{{-- 마이그레이션 목록 --}}
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
        <h2 class="font-semibold text-gray-800 text-sm">마이그레이션 목록</h2>
    </div>
    <div class="divide-y divide-gray-100">
        @forelse($migrations as $migration)
        <div class="px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition">
            <div class="flex items-center gap-3 min-w-0">
                @if($migration['ran'])
                <span class="shrink-0 w-6 h-6 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </span>
                @else
                <span class="shrink-0 w-6 h-6 rounded-full bg-yellow-100 flex items-center justify-center">
                    <svg class="w-3.5 h-3.5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                @endif
                <span class="text-sm text-gray-800 font-mono truncate">{{ $migration['name'] }}</span>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                @if($migration['ran'])
                <span class="text-xs text-gray-400">Batch {{ $migration['batch'] }}</span>
                <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">실행됨</span>
                @else
                <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">대기중</span>
                @endif
            </div>
        </div>
        @empty
        <div class="px-4 py-8 text-center text-gray-400 text-sm">
            마이그레이션 파일이 없습니다.
        </div>
        @endforelse
    </div>
</div>

{{-- 롤백 버튼 --}}
@if(count(array_filter($migrations, fn($m) => $m['ran'])) > 0)
<div class="mt-6 pt-6 border-t border-gray-200">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-700">마지막 배치 롤백</p>
            <p class="text-xs text-gray-400">가장 최근 실행된 마이그레이션 배치를 되돌립니다.</p>
        </div>
        <form action="/admin/settings/migrations/rollback" method="POST" onsubmit="return confirm('정말 롤백하시겠습니까? 데이터가 손실될 수 있습니다.');">
            @csrf
            <button type="submit" class="px-4 py-2 bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-600 text-sm font-medium rounded-lg transition border border-gray-200 hover:border-red-200">
                롤백
            </button>
        </form>
    </div>
</div>
@endif

@endsection
