<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('manager_auth')) {
            return redirect('/manager/login');
        }

        return $next($request);
    }
}
