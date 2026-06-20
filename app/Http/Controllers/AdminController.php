<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{
    /**
     * Mendefinisikan middleware yang diterapkan pada controller ini.
     * Menggunakan pendekatan statis agar dikenali oleh IDE dan Laravel.
     */
    public static function middleware(): array
    {
        return [
            // Memastikan user login melalui guard 'internal'
            'auth:internal',
            // Memastikan role user adalah 'admin'
            'role:admin',
        ];
    }

    /**
     * Menampilkan dashboard admin.
     */
    public function index()
    {
        return view('admin.dashboard');
    }
}