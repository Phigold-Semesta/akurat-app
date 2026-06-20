<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KoperasiMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login/koperasi');
        }

        if (Auth::user()->role === 'koperasi') {
            return $next($request);
        }

        return redirect('/');
    }
}