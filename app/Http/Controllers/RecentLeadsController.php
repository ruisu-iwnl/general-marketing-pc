<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\FakeLeadGenerator;
use Carbon\Carbon;

class RecentLeadsController extends Controller
{
    public function index(FakeLeadGenerator $generator)
    {
        $now = Carbon::now();
        $sixtyMinutesAgo = $now->copy()->subMinutes(60);

        // 실제 리드: 최근 60분, 이름 마스킹
        $realLeads = Lead::where('created_at', '>=', $sixtyMinutesAgo)
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($lead) use ($now) {
                $name = mb_substr($lead->name, 0, 1) . '○○';
                $createdAt = Carbon::parse($lead->created_at);
                $diffMinutes = $createdAt->diffInMinutes($now);

                return [
                    'name' => $name,
                    'region' => null,
                    'time' => $createdAt->format('H:i'),
                    'timestamp' => $createdAt->timestamp,
                    'is_fake' => false,
                ];
            })
            ->toArray();

        // 생성 데이터
        $fakeLeads = $generator->generate();

        // 합산 후 시간순 정렬 (최신 먼저)
        $allLeads = array_merge($realLeads, $fakeLeads);
        usort($allLeads, fn ($a, $b) => $b['timestamp'] - $a['timestamp']);

        // 최대 20건
        $allLeads = array_slice($allLeads, 0, 20);

        // 응답 가공: is_fake 제거, ago 추가
        $response = array_map(function ($item) use ($now) {
            $diffMinutes = intval(($now->timestamp - $item['timestamp']) / 60);
            $ago = $diffMinutes < 1 ? '방금 전' : $diffMinutes . '분 전';

            return [
                'name' => $item['name'],
                'region' => $item['region'],
                'time' => $item['time'],
                'ago' => $ago,
            ];
        }, $allLeads);

        return response()->json(array_values($response));
    }
}
