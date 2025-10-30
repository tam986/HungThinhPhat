<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Authention
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->quyen != 1) {
            return redirect()->route('login.show')->with('error', Auth::check() ? 'Bạn không phải là admin.' : 'Bạn cần đăng nhập để truy cập.');
        }

        return $next($request);
    }
}