@extends('admin.layout')
@section('title', 'API 엔드포인트 관리')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 mb-1">API 엔드포인트 관리</h1>
        <p class="text-sm text-gray-500">외부 호출용 API 엔드포인트를 확인하고 호출 주기를 설정합니다.</p>
    </div>
</div>

{{-- Flash message --}}
@if(session('success'))
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
    {{ session('success') }}
</div>
@endif

{{-- ========================================
     메인 2단 레이아웃
     ======================================== --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- ======== 좌측 영역 (8칼럼) ======== --}}
    <div class="lg:col-span-8">
        <form action="/admin/settings/api" method="POST">
            @csrf

            {{-- ── 통합 호출 URL (권장) ── --}}
            <div class="bg-white border-2 border-green-400 rounded-xl overflow-hidden mb-6">
                <div class="px-4 py-3 bg-green-600 text-white font-semibold text-sm">
                    통합 호출 URL (권장)
                </div>
                <div class="p-4">
                    <p class="text-sm text-gray-500 mb-3">
                        이 URL 하나만 호출하면 아래 모든 API가 설정된 주기에 맞춰 자동으로 실행됩니다.
                    </p>
                    <div class="flex rounded-lg overflow-hidden border border-gray-300 mb-3">
                        <input type="text" id="apiAll" value="{{ url('/api/all') }}" readonly
                               class="flex-1 px-3 py-2 bg-gray-50 text-sm border-0 focus:outline-none min-w-0 font-mono">
                        <button type="button" onclick="copyUrl('apiAll')"
                                class="px-3 py-2 bg-white border-l border-gray-300 text-gray-600 hover:bg-gray-50 text-sm whitespace-nowrap cursor-pointer">복사</button>
                        <button type="button" onclick="testApi('apiAll', 'resultAll')"
                                class="px-3 py-2 bg-white border-l border-gray-300 text-green-600 hover:bg-green-50 text-sm whitespace-nowrap cursor-pointer">테스트</button>
                    </div>
                    <div id="resultAll" class="mb-3"></div>
                    <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm text-green-800">
                        <strong>권장 설정:</strong> 외부에서 이 URL을 <code class="bg-green-100 px-1 rounded">10초</code> 간격으로 호출하세요. 각 작업의 실제 실행 주기는 아래 설정에 따라 자동 관리됩니다.
                    </div>
                </div>
            </div>

            {{-- ── 가짜 리드 생성 ── --}}
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-6">
                <div class="px-4 py-3 bg-violet-600 text-white font-semibold text-sm">가짜 리드 생성</div>
                <div class="p-4">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-3">
                        <div class="md:col-span-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">엔드포인트 URL</label>
                            <div class="flex rounded-lg overflow-hidden border border-gray-300">
                                <input type="text" id="apiFakeLeads" value="{{ url('/api/fake-leads') }}" readonly
                                       class="flex-1 px-3 py-2 bg-gray-50 text-sm border-0 focus:outline-none min-w-0 font-mono">
                                <button type="button" onclick="copyUrl('apiFakeLeads')"
                                        class="px-3 py-2 bg-white border-l border-gray-300 text-gray-600 hover:bg-gray-50 text-sm whitespace-nowrap cursor-pointer">복사</button>
                                <button type="button" onclick="testApi('apiFakeLeads', 'resultFakeLeads')"
                                        class="px-3 py-2 bg-white border-l border-gray-300 text-violet-600 hover:bg-violet-50 text-sm whitespace-nowrap cursor-pointer">테스트</button>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">호출 주기 (초)</label>
                            <input type="number" name="api_interval_fake_leads" value="{{ $intervals['fake_leads']['interval'] }}" min="60" max="86400"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-[11px] text-gray-400 mt-1">권장: 3600 (1시간)</p>
                        </div>
                    </div>
                    <div id="resultFakeLeads" class="mb-3"></div>
                    <p class="text-xs text-gray-500">
                        <strong>기능:</strong> 설정된 스케줄(활성 {{ $fakeLeadActiveCount }}개)에 따라 가짜 상담신청 데이터를 생성합니다.
                        <code class="text-[11px] bg-gray-100 px-1 rounded">?date=YYYY-MM-DD</code> 파라미터로 특정 날짜 전체 생성도 가능합니다.
                    </p>
                </div>
            </div>

            {{-- ── 상태 확인 (호출 주기 없음) ── --}}
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden mb-6">
                <div class="px-4 py-3 bg-gray-500 text-white font-semibold text-sm">상태 확인</div>
                <div class="p-4">
                    <label class="block text-xs font-medium text-gray-600 mb-1">엔드포인트 URL</label>
                    <div class="flex rounded-lg overflow-hidden border border-gray-300 mb-3">
                        <input type="text" id="apiStatus" value="{{ url('/api/status') }}" readonly
                               class="flex-1 px-3 py-2 bg-gray-50 text-sm border-0 focus:outline-none min-w-0 font-mono">
                        <button type="button" onclick="copyUrl('apiStatus')"
                                class="px-3 py-2 bg-white border-l border-gray-300 text-gray-600 hover:bg-gray-50 text-sm whitespace-nowrap cursor-pointer">복사</button>
                        <button type="button" onclick="testApi('apiStatus', 'resultStatus')"
                                class="px-3 py-2 bg-white border-l border-gray-300 text-gray-600 hover:bg-gray-50 text-sm whitespace-nowrap cursor-pointer">테스트</button>
                    </div>
                    <div id="resultStatus" class="mb-3"></div>
                    <p class="text-xs text-gray-500">
                        <strong>기능:</strong> 시스템이 정상 작동 중인지 확인합니다. UptimeRobot 등의 모니터링 서비스에 등록하세요.
                    </p>
                </div>
            </div>

            {{-- 저장 버튼 --}}
            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition cursor-pointer">
                호출 주기 설정 저장
            </button>
        </form>
    </div>

    {{-- ======== 우측 영역 (4칼럼) ======== --}}
    <div class="lg:col-span-4 space-y-6">

        {{-- 호출 주기 안내 --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700">호출 주기 안내</h3>
            </div>
            <div class="p-4">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="text-gray-500 uppercase border-b border-gray-100">
                            <th class="pb-2 text-left font-medium">기능</th>
                            <th class="pb-2 text-right font-medium">권장</th>
                            <th class="pb-2 text-right font-medium">현재</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <tr>
                            <td class="py-2 text-gray-700">가짜 리드 생성</td>
                            <td class="py-2 text-right text-gray-400">3600초</td>
                            <td class="py-2 text-right font-medium text-gray-800">{{ number_format($intervals['fake_leads']['interval']) }}초</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 자동 호출 설정 가이드 --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden" x-data="{ activeTab: null }">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700">자동 호출 설정 가이드</h3>
            </div>
            <div class="divide-y divide-gray-100">
                {{-- Linux Shell --}}
                <div>
                    <button type="button" @click="activeTab = activeTab === 'linux' ? null : 'linux'"
                            class="w-full text-left px-4 py-3 flex justify-between items-center hover:bg-gray-50 transition cursor-pointer">
                        <span class="text-sm text-gray-700">Linux Shell</span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="activeTab === 'linux' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeTab === 'linux'" x-transition class="px-4 pb-4">
                        <div class="bg-gray-900 rounded-lg p-3 text-xs font-mono text-green-400 overflow-x-auto">
                            <div class="text-gray-500 mb-1"># api_call.sh</div>
                            <div>#!/bin/bash</div>
                            <div>while true; do</div>
                            <div class="pl-4">curl -s {{ url('/api/all') }} > /dev/null</div>
                            <div class="pl-4">sleep 10</div>
                            <div>done</div>
                        </div>
                        <p class="text-[11px] text-gray-500 mt-2">
                            실행: <code class="bg-gray-100 px-1 rounded">chmod +x api_call.sh</code><br>
                            백그라운드: <code class="bg-gray-100 px-1 rounded">nohup ./api_call.sh > /dev/null 2>&1 &</code>
                        </p>
                    </div>
                </div>

                {{-- Windows PowerShell --}}
                <div>
                    <button type="button" @click="activeTab = activeTab === 'windows' ? null : 'windows'"
                            class="w-full text-left px-4 py-3 flex justify-between items-center hover:bg-gray-50 transition cursor-pointer">
                        <span class="text-sm text-gray-700">Windows PowerShell</span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="activeTab === 'windows' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeTab === 'windows'" x-transition class="px-4 pb-4">
                        <div class="bg-gray-900 rounded-lg p-3 text-xs font-mono text-blue-400 overflow-x-auto">
                            <div class="text-gray-500 mb-1"># api_call.ps1</div>
                            <div>while ($true) {</div>
                            <div class="pl-4">Invoke-WebRequest -Uri "{{ url('/api/all') }}" -UseBasicParsing | Out-Null</div>
                            <div class="pl-4">Start-Sleep -Seconds 10</div>
                            <div>}</div>
                        </div>
                        <p class="text-[11px] text-gray-500 mt-2">
                            실행: <code class="bg-gray-100 px-1 rounded">powershell -ExecutionPolicy Bypass -File api_call.ps1</code>
                        </p>
                    </div>
                </div>

                {{-- 외부 서비스 --}}
                <div>
                    <button type="button" @click="activeTab = activeTab === 'external' ? null : 'external'"
                            class="w-full text-left px-4 py-3 flex justify-between items-center hover:bg-gray-50 transition cursor-pointer">
                        <span class="text-sm text-gray-700">외부 서비스</span>
                        <svg class="w-4 h-4 text-gray-400 transition-transform" :class="activeTab === 'external' ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="activeTab === 'external'" x-transition class="px-4 pb-4 text-xs text-gray-600 space-y-2">
                        <div class="flex items-start gap-2 p-2 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-800 whitespace-nowrap">cron-job.org</span>
                            <span class="text-gray-400">—</span>
                            <span>무료, 최소 1분 간격 지원</span>
                        </div>
                        <div class="flex items-start gap-2 p-2 bg-gray-50 rounded-lg">
                            <span class="font-medium text-gray-800 whitespace-nowrap">UptimeRobot</span>
                            <span class="text-gray-400">—</span>
                            <span>무료, 5분 간격 모니터링</span>
                        </div>
                        <p class="text-[11px] text-gray-400">등록할 URL: <code class="bg-gray-100 px-1 rounded">{{ url('/api/all') }}</code></p>
                    </div>
                </div>
            </div>
        </div>

        {{-- 마지막 실행 시간 --}}
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700">마지막 실행 시간</h3>
            </div>
            <div class="p-4">
                <table class="w-full text-xs">
                    <tbody class="divide-y divide-gray-50">
                        @foreach($intervals as $key => $item)
                        <tr>
                            <td class="py-2 text-gray-700">{{ $item['label'] }}</td>
                            <td class="py-2 text-right text-gray-500 font-mono">{{ $item['last_run_formatted'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- 복사 토스트 --}}
<div id="copyToast" class="fixed bottom-4 right-4 z-50 hidden">
    <div id="copyToastContent" class="px-4 py-3 rounded-xl shadow-lg text-sm font-medium bg-gray-800 text-white"></div>
</div>

{{-- JavaScript --}}
<script>
function copyUrl(inputId) {
    const url = document.getElementById(inputId).value;
    navigator.clipboard.writeText(url).then(() => {
        const toast = document.getElementById('copyToast');
        const content = document.getElementById('copyToastContent');
        content.textContent = 'URL이 복사되었습니다.';
        toast.classList.remove('hidden');
        setTimeout(() => toast.classList.add('hidden'), 2000);
    });
}

function testApi(inputId, resultId) {
    const url = document.getElementById(inputId).value;
    const resultDiv = document.getElementById(resultId);
    resultDiv.innerHTML = '<div class="flex items-center gap-2 text-sm text-blue-600"><svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> 요청 중...</div>';

    fetch(url)
        .then(r => r.json())
        .then(data => {
            resultDiv.innerHTML = `
                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                    <div class="text-sm font-medium text-green-700 mb-1">성공</div>
                    <pre class="text-[11px] text-gray-700 overflow-auto max-h-40 bg-white rounded-lg p-2 border border-gray-200 font-mono">${JSON.stringify(data, null, 2)}</pre>
                </div>
            `;
        })
        .catch(err => {
            resultDiv.innerHTML = `
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-sm text-red-700">
                    <strong>실패:</strong> ${err.message}
                </div>
            `;
        });
}
</script>
@endsection
