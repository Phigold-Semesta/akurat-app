<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

class PimpinanController extends Controller implements HasMiddleware
{
    /**
     * Mendefinisikan middleware yang diterapkan pada controller ini.
     * Menggunakan guard 'internal' agar hanya pihak internal yang bisa mengakses.
     */
    public static function middleware(): array
    {
        return [
            // Memastikan user login sebagai pihak internal
            'auth:internal',
            // Memastikan role user adalah 'pimpinan'
            'role:pimpinan',
        ];
    }

    /**
     * Menampilkan dashboard utama untuk aktor Pimpinan.
     */
    public function index()
    {
        return view('pimpinan.dashboard');
    }

    /**
     * Menampilkan ringkasan laporan strategis untuk pimpinan.
     */
    public function laporanStrategis()
    {
        return view('pimpinan.laporan_strategis');
    }
}