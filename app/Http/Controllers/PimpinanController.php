<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RatExport; // Tambahkan ini di paling atas

// Anda akan membuat class Export nanti, contoh:
// use App\Exports\RatExport;

class PimpinanController extends Controller implements HasMiddleware
{
    /**
     * Mendefinisikan middleware yang diterapkan pada controller ini.
     */
    public static function middleware(): array
    {
        return [
            'auth:internal',
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
     * Menampilkan daftar semua laporan RAT untuk ditinjau oleh Pimpinan.
     */
    public function indexLaporan()
    {
        // Mengambil data RAT lengkap dengan nama koperasi
        $data = DB::table('rat')
            ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
            ->select('rat.*', 'koperasi.nama_koperasi')
            ->get();

        return view('pimpinan.laporan.index', compact('data'));
    }

    /**
     * Export data ke PDF.
     */
    public function exportPdf()
    {
        $data = DB::table('rat')
            ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
            ->get();
            
        $pdf = Pdf::loadView('pimpinan.laporan.pdf', compact('data'));
        return $pdf->download('Laporan_RAT_Koperasi_' . date('Y-m-d') . '.pdf');
    }

    /**
     * Export data ke Excel.
     */
  public function exportExcel()
{
    return Excel::download(new RatExport, 'Laporan_RAT_Koperasi_' . date('Y-m-d') . '.xlsx');
}

    /**
     * Menampilkan ringkasan laporan strategis untuk pimpinan.
     */
    public function laporanStrategis()
    {
        return view('pimpinan.laporan_strategis');
    }
}