<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>의뢰 상세 | {{ $postRequest->keyword }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">의뢰 상세</h1>

        {{-- 의뢰 정보 --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-gray-500">고객사</dt>
                    <dd class="font-medium text-gray-900 mt-1">{{ $postRequest->customer_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">키워드</dt>
                    <dd class="font-medium text-gray-900 mt-1">{{ $postRequest->keyword ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-gray-500">상태</dt>
                    <dd class="mt-1">
                        <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full
                            {{ $postRequest->status === 'completed' ? 'bg-green-50 text-green-700' : 'bg-blue-50 text-blue-700' }}">
                            {{ $postRequest->status }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-gray-500">발행 URL</dt>
                    <dd class="font-medium text-gray-900 mt-1">
                        @if($postRequest->published_url)
                        <a href="{{ $postRequest->published_url }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $postRequest->published_url }}</a>
                        @else
                        -
                        @endif
                    </dd>
                </div>
            </dl>
        </div>

        {{-- 실시간 순위 조회 --}}
        @if($postRequest->published_url)
        <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">실시간 순위</h2>
                <button onclick="checkRank()" id="checkRankBtn" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition cursor-pointer">조회</button>
            </div>
            <div id="rankResult" class="text-center text-gray-400 text-sm">버튼을 눌러 현재 순위를 확인하세요.</div>
        </div>

        <script>
        function checkRank() {
            const btn = document.getElementById('checkRankBtn');
            const result = document.getElementById('rankResult');
            btn.disabled = true;
            btn.textContent = '조회 중...';
            result.innerHTML = '<span class="text-gray-400">순위를 조회하고 있습니다...</span>';

            fetch('/public/check-rank/{{ $postRequest->token }}')
                .then(r => r.json())
                .then(data => {
                    if (data.rank) {
                        result.innerHTML = '<span class="text-3xl font-bold text-blue-600">' + data.rank + '위</span><br><span class="text-xs text-gray-400">' + data.checked_at + ' 기준</span>';
                    } else {
                        result.innerHTML = '<span class="text-gray-500">30위 내 미노출</span>';
                    }
                })
                .catch(() => {
                    result.innerHTML = '<span class="text-red-500">조회 실패</span>';
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.textContent = '조회';
                });
        }
        </script>
        @endif

        {{-- 순위 기록 --}}
        @if($rankRecords->isNotEmpty())
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                <h2 class="text-sm font-semibold text-gray-700">순위 기록</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase">
                            <th class="px-4 py-3 text-left">체크 유형</th>
                            <th class="px-4 py-3 text-left">예정 시각</th>
                            <th class="px-4 py-3 text-left">체크 시각</th>
                            <th class="px-4 py-3 text-left">순위</th>
                            <th class="px-4 py-3 text-left">상태</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($rankRecords as $record)
                        <tr>
                            <td class="px-4 py-3 text-gray-800">{{ $record->check_type ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $record->scheduled_at?->format('m-d H:i') ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $record->checked_at?->format('m-d H:i') ?? '-' }}</td>
                            <td class="px-4 py-3 font-bold {{ $record->rank ? 'text-blue-600' : 'text-gray-400' }}">
                                {{ $record->rank ? $record->rank . '위' : '-' }}
                            </td>
                            <td class="px-4 py-3">
                                @if($record->status === 'completed')
                                <span class="text-green-600 text-xs">완료</span>
                                @elseif($record->status === 'pending')
                                <span class="text-yellow-600 text-xs">대기</span>
                                @else
                                <span class="text-red-600 text-xs">실패</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</body>
</html>
