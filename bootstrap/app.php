<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; // Tambahan untuk menangani Request

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Mendaftarkan alias middleware agar bisa dipanggil dengan nama pendek
        $middleware->alias([
            'role'     => \App\Http\Middleware\CheckRole::class,
            'koperasi' => \App\Http\Middleware\KoperasiMiddleware::class,
        ]);

        // Solusi dinamis untuk mengatasi error "Route [login] not defined" pada sistem Multi-Auth
        $middleware->redirectGuestsTo(function (Request $request) {
            // Jika user mencoba mengakses URL koperasi tapi sesi habis/belum login
            if ($request->is('koperasi') || $request->is('koperasi/*')) {
                return route('login.koperasi');
            }
            // Jika user mencoba mengakses URL internal (admin/pimpinan/pengawas)
            return route('login.internal');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();