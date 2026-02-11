<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>계약 기간별 현황 | {{ $contractPeriod->customer_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">계약 기간별 현황</h1>
        <p class="text-sm text-gray-500 mb-6">
            {{ $contractPeriod->customer_name }}
            @if($contractPeriod->start_date && $contractPeriod->end_date)
            | {{ $contractPeriod->start_date->format('Y.m.d') }} ~ {{ $contractPeriod->end_date->format('Y.m.d') }}
            @endif
        </p>

        @if($postRequests->isEmpty())
        <div class="bg-white border border-gray-200 rounded-xl p-8 text-center text-gray-400">
            등록된 의뢰가 없습니다.
        </div>
        @else
        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase">
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">키워드</th>
                            <th class="px-4 py-3 text-left">상태</th>
                            <th class="px-4 py-3 text-left">최고순위</th>
                            <th class="px-4 py-3 text-left">최종순위</th>
                            <th class="px-4 py-3 text-left">발행 URL</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($postRequests as $i => $request)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-400">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 text-gray-900 font-medium">
                                <a href="/public/view/{{ $request->token }}" class="hover:text-blue-600">{{ $request->keyword }}</a>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full
                                    {{ $request->status === 'completed' ? 'bg-green-50 text-green-700' : ($request->status === 'in_progress' ? 'bg-blue-50 text-blue-700' : 'bg-gray-100 text-gray-600') }}">
                                    {{ $request->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3 font-bold {{ $request->best_rank ? 'text-blue-600' : 'text-gray-400' }}">
                                {{ $request->best_rank ? $request->best_rank . '위' : '-' }}
                            </td>
                            <td class="px-4 py-3 font-bold {{ $request->latest_rank ? 'text-gray-800' : 'text-gray-400' }}">
                                {{ $request->latest_rank ? $request->latest_rank . '위' : '-' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 text-xs">
                                @if($request->published_url)
                                <a href="{{ $request->published_url }}" target="_blank" class="text-blue-500 hover:underline">보기</a>
                                @else
                                -
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
