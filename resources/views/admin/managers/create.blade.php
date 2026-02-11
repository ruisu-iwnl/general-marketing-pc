@extends('admin.layout')
@section('title', '매니저 추가')

@section('content')
<div class="mb-6">
    <a href="/admin/managers" class="text-sm text-gray-400 hover:text-gray-600 transition">&larr; 목록으로</a>
</div>

<div class="max-w-lg">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">매니저 추가</h1>

    <form action="/admin/managers" method="POST" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        @csrf

        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">이름 <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">이메일 <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">비밀번호 <span class="text-red-500">*</span></label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                <p class="mt-1 text-xs text-gray-400">4자 이상 입력해주세요</p>
                @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">텔레그램 채팅 ID</label>
                <input type="text" name="telegram_chat_id" value="{{ old('telegram_chat_id') }}"
                    placeholder="-1001234567890 또는 개인 ID"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 font-mono">
                <p class="mt-1 text-xs text-gray-400">배정 알림을 받을 텔레그램 채팅 ID (선택사항)</p>
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="text-sm text-gray-700">활성화</label>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-3">
            <a href="/admin/managers" class="px-4 py-2 text-gray-600 hover:text-gray-800 text-sm font-medium transition">취소</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition cursor-pointer">
                추가
            </button>
        </div>
    </form>
</div>
@endsection
