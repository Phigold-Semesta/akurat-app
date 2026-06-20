<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

class PengawasController extends Controller implements HasMiddleware
{
    /**
     * Mendefinisikan middleware untuk aktor Pengawas.
     * Menggunakan guard 'internal' karena pengawas termasuk dalam lingkup internal.
     */
    public static function middleware(): array
    {
        return [
            // Memastikan user login sebagai pihak internal
            'auth:internal',
            // Memastikan role user adalah 'pengawas'
            'role:pengawas',
        ];
    }

    /**
     * Menampilkan dashboard utama untuk aktor Pengawas.
     */
    public function index()
    {
        return view('pengawas.dashboard');
    }

    /**
     * Menampilkan laporan atau data audit untuk pengawasan.
     */
    public function laporan()
    {
        return view('pengawas.laporan');
    }
}