<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller implements HasMiddleware
{
    /**
     * Mendefinisikan middleware yang diterapkan pada controller ini.
     */
    public static function middleware(): array
    {
        return [
            'auth:internal',
            'role:admin',
        ];
    }

    /**
     * Menampilkan dashboard admin.
     */
    public function index()
    {
        // Hitung total pengajuan untuk dashboard
        $totalPengajuan = DB::table('pemkes')->count();
        $diproses = DB::table('pemkes')->where('status_kesehatan', 'Dalam Proses')->count();
        
        return view('admin.dashboard', compact('totalPengajuan', 'diproses'));
    }

    /**
     * Menampilkan daftar verifikasi koperasi.
     */
    public function indexVerifikasi()
    {
        $data = DB::table('pemkes')
            ->join('rat', 'pemkes.id_rat', '=', 'rat.id_rat')
            ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
            ->select('pemkes.*', 'koperasi.nama_koperasi', 'rat.tahun_buku')
            ->orderBy('pemkes.created_at', 'desc')
            ->get();

        return view('admin.verifikasi.index', compact('data'));
    }

    /**
     * Proses verifikasi, update status, dan generate sertifikat otomatis.
     */
    public function prosesVerifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Sehat,Cukup Sehat,Dalam Pengawasan'
        ]);

        $data = DB::table('pemkes')
            ->join('rat', 'pemkes.id_rat', '=', 'rat.id_rat')
            ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
            ->where('id_pemkes', $id)
            ->first();

        // 1. Data untuk template PDF
        $pdfData = [
            'nama'    => $data->nama_koperasi,
            'skor'    => $data->skor_pemkes,
            'status'  => $request->status,
            'tanggal' => now()->format('d F Y')
        ];
        
        // 2. Generate PDF
        $pdf = Pdf::loadView('admin.sertifikat.template', $pdfData);
        
        // 3. Simpan PDF ke storage/app/public/sertifikat/
        $fileName = 'Sertifikat_' . $data->nama_koperasi . '_' . time() . '.pdf';
        $path = 'sertifikat/' . $fileName;
        Storage::disk('public')->put($path, $pdf->output());

        // 4. Update Database
        DB::table('pemkes')->where('id_pemkes', $id)->update([
            'status_kesehatan' => $request->status,
            'file_sertifikat'  => $path,
            'updated_at'       => now(),
        ]);

        return redirect()->route('admin.verifikasi.index')->with('success', 'Verifikasi sukses! Sertifikat telah digenerate.');
    }
}