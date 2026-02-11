@extends('admin.layout')
@section('title', '매니저 관리')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <h1 class="text-2xl font-bold text-gray-900">매니저 관리</h1>
    <a href="/admin/managers/create" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        매니저 추가
    </a>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    @if($managers->isEmpty())
        <div class="px-6 py-12 text-center">
            <p class="text-gray-400 text-sm">등록된 매니저가 없습니다.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left px-4 py-3 font-medium text-gray-600 w-12">ID</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">이름</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">이메일</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">담당 건수</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">상태</th>
                        <th class="text-left px-4 py-3 font-medium text-gray-600">등록일</th>
                        <th class="w-20"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($managers as $manager)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-gray-400">{{ $manager->id }}</td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $manager->name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $manager->email }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $manager->leads_count }}건</td>
                        <td class="px-4 py-3">
                            @if($manager->is_active)
                                <span class="inline-flex px-2 py-0.5 text-xs font-medium bg-green-100 text-green-700 rounded-full">활성</span>
                            @else
                                <span class="inline-flex px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-500 rounded-full">비활성</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-400">{{ $manager->created_at?->format('Y-m-d') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <a href="/admin/managers/{{ $manager->id }}/edit" class="text-gray-400 hover:text-blue-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="/admin/managers/{{ $manager->id }}" method="POST" onsubmit="return confirm('정말 삭제하시겠습니까? 담당 리드는 미배정으로 변경됩니다.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
