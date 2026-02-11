<?php

namespace App\Http\Controllers;

use App\Services\AbTestService;
use Illuminate\Support\Facades\View;

class LandingController extends Controller
{
    public function show()
    {
        // auto/weighted 모드에서 ?v= 파라미터 없으면 variant를 URL에 붙여 리다이렉트
        $mode = AbTestService::getMode();
        if (! request('v') && in_array($mode, [AbTestService::MODE_AUTO, AbTestService::MODE_WEIGHTED])) {
            $variant = AbTestService::getVariant();
            $query = request()->query();
            $query['v'] = $variant;

            return redirect()->to('/?'.http_build_query($query));
        }

        $variant = AbTestService::getVariant();

        // variant 뷰가 존재하면 사용
        if (View::exists("variants.{$variant}.landing")) {
            return view("variants.{$variant}.landing", ['variant' => $variant]);
        }

        // fallback: default variant
        $defaultVariant = AbTestService::getDefaultVariant();
        if ($defaultVariant !== $variant && View::exists("variants.{$defaultVariant}.landing")) {
            return view("variants.{$defaultVariant}.landing", ['variant' => $variant]);
        }

        // fallback: variant a
        if (View::exists('variants.a.landing')) {
            return view('variants.a.landing', ['variant' => $variant]);
        }

        // 최종 fallback: 원본 landing
        return view('landing', ['variant' => $variant]);
    }
}
