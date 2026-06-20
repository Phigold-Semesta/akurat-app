<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    // Memeriksa apakah user memiliki role yang diizinkan (admin, pimpinan, atau pengawas)
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login/internal');
        }

        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        return redirect('/'); // Atau arahkan ke halaman akses ditolak
    }
}