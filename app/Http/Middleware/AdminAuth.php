<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        $keyFile = storage_path('admin.key');

        // 비밀번호 파일 없으면 → 로그인 페이지(최초 설정 모드)
        if (! file_exists($keyFile)) {
            if (! $request->is('admin/login')) {
                return redirect('/admin/login');
            }

            return $next($request);
        }

        // 세션 인증 안됨 → 로그인 페이지
        if (! $request->session()->get('admin_auth')) {
            if (! $request->is('admin/login')) {
                return redirect('/admin/login');
            }
        }

        return $next($request);
    }
}
