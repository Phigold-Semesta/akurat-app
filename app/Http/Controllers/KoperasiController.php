<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;

class KoperasiController extends Controller implements HasMiddleware
{
    /**
     * Mendefinisikan middleware yang diterapkan pada controller ini.
     * Menggunakan guard 'koperasi' untuk memisahkan sesi dari portal internal.
     */
    public static function middleware(): array
    {
        return [
            // Memastikan user login sebagai Koperasi
            'auth:koperasi',
            // Memastikan role user adalah 'koperasi'
            'role:koperasi',
        ];
    }

    /**
     * Menampilkan dashboard utama untuk aktor Koperasi.
     */
    public function index()
    {
        return view('koperasi.dashboard');
    }

    /**
     * Menampilkan riwayat transaksi atau layanan koperasi.
     */
    public function riwayat()
    {
        return view('koperasi.riwayat');
    }
}