<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\AnalyticsService;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'phone' => ['required', 'string', 'regex:/^01[016789]-?\d{3,4}-?\d{4}$/'],
        ]);

        $lead = Lead::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'utm_source' => $request->input('utm_source'),
            'utm_medium' => $request->input('utm_medium'),
            'utm_campaign' => $request->input('utm_campaign'),
            'variant' => $request->input('variant'),
            'referrer' => $request->header('referer'),
        ]);

        // 방문자-리드 연결 (전환 추적)
        AnalyticsService::linkLeadToVisitor($lead, $request);

        // 텔레그램 알림 발송
        TelegramService::notifyNewLead($lead);

        return redirect('/thanks');
    }
}
