<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PengawasController extends Controller implements HasMiddleware
{
    /**
     * Mendefinisikan middleware untuk aktor Pengawas.
     */
    public static function middleware(): array
    {
        return [
            'auth:internal',
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
     * Menampilkan daftar RAT untuk diverifikasi oleh Pengawas.
     */
    public function indexVerifikasi()
    {
        // Mengambil data RAT dan menggabungkannya dengan data Koperasi
        $data = DB::table('rat')
            ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
            ->select('rat.*', 'koperasi.nama_koperasi')
            ->orderBy('rat.status_verifikasi', 'asc') // Menunggu verifikasi tampil di atas
            ->get();

        return view('pengawas.verifikasi_rat.index', compact('data'));
    }

    /**
     * Aksi untuk memverifikasi laporan RAT.
     */
    public function verifikasiRat($id)
    {
        // Update status menjadi terverifikasi dan catat ID pengawas yang bertugas
        DB::table('rat')->where('id_rat', $id)->update([
            'status_verifikasi' => 'terverifikasi',
            'id_pengawas'       => Auth::id(), 
            'updated_at'        => now()
        ]);

        return redirect()->route('pengawas.rat.index')->with('success', 'Laporan RAT berhasil diverifikasi!');
    }

    /**
     * Menampilkan laporan atau data audit untuk pengawasan.
     */
    public function laporan()
    {
        return view('pengawas.laporan');
    }
}