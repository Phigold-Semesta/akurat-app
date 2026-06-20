<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menampilkan form login internal.
     */
    public function showLoginInternal()
    {
        return view('auth.login_internal');
    }

    /**
     * Menampilkan form login koperasi.
     */
    public function showLoginKoperasi()
    {
        return view('auth.login_koperasi');
    }

    /**
     * Memproses login Internal (Admin, Pimpinan, Pengawas).
     */
    public function loginInternal(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Menggunakan guard 'internal'
        if (Auth::guard('internal')->attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::guard('internal')->user();
            
            // Arahkan ke dashboard internal sesuai role
            return match($user->role) {
                'admin'    => redirect()->intended('/admin/dashboard'),
                'pimpinan' => redirect()->intended('/pimpinan/dashboard'),
                'pengawas' => redirect()->intended('/pengawas/dashboard'),
                default    => redirect()->intended('/'),
            };
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password internal tidak cocok.',
        ]);
    }

    /**
     * Memproses login Koperasi.
     */
    public function loginKoperasi(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Menggunakan guard 'koperasi'
        if (Auth::guard('koperasi')->attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/koperasi/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => 'Email atau password koperasi tidak cocok.',
        ]);
    }

    /**
     * Menangani proses logout dari portal mana pun.
     */
    public function logout(Request $request)
    {
        // Cek guard mana yang aktif untuk di-logout
        $guard = Auth::guard('koperasi')->check() ? 'koperasi' : 'internal';
        
        Auth::guard($guard)->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke portal internal sebagai default landing page
        return redirect('/login/internal');
    }
}