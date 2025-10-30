<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthForAction
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            flash()->error('Vui lòng đăng nhập để thực hiện hành động này.');
            return redirect()->route('login.form');
        }
        return $next($request);
    }
}
