<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RatExport; // Tambahkan ini di paling atas
use Illuminate\Support\Facades\Auth; // <--- PASTIKAN BARIS INI ADA DI ATAS
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
    // 1. Statistik Kartu
    $totalTerverifikasi = DB::table('pemkes')->where('status_kesehatan', '!=', 'Dalam Proses')->count();
    $totalRAT = DB::table('rat')->count();
    $skorRataRata = DB::table('pemkes')->avg('skor_pemkes') ?? 0;

    // 2. Data Chart Distribusi Kesehatan
    $distribusi = DB::table('pemkes')
        ->select('status_kesehatan', DB::raw('count(*) as total'))
        ->groupBy('status_kesehatan')
        ->get();

    // 3. Data Tabel Koperasi Terverifikasi
    $koperasiList = DB::table('pemkes')
        ->join('rat', 'pemkes.id_rat', '=', 'rat.id_rat')
        ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
        ->select('koperasi.nama_koperasi', 'pemkes.skor_pemkes', 'pemkes.status_kesehatan')
        ->limit(10)
        ->get();

    return view('pimpinan.dashboard', compact('totalTerverifikasi', 'totalRAT', 'skorRataRata', 'distribusi', 'koperasiList'));
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

    /**
     * Menampilkan profil pimpinan yang sedang login.
     */
   public function profilPimpinan()
    {
        // Cek apakah data pimpinan sudah ada
        $profil = DB::table('pimpinan')
            ->where('id_user', Auth::id())
            ->first();

        // SOLUSI JENIUS: Jika belum ada, buatkan data otomatis agar tidak kosong/null
        if (!$profil) {
            $userId = Auth::id();
            $user = DB::table('user')->where('id_user', $userId)->first();
            
            DB::table('pimpinan')->insert([
                'id_user'       => $userId,
                'nama_pimpinan' => $user->username ?? 'Pimpinan Utama',
                'jabatan'       => 'Pimpinan',
                'no_telp'       => '-',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            // Ambil ulang data yang baru saja dimasukkan
            $profil = DB::table('pimpinan')->where('id_user', $userId)->first();
        }

        return view('pimpinan.profil.index', compact('profil'));
    }

    /**
     * Memproses update profil pimpinan.
     */
    public function updateProfil(Request $request)
    {
        $request->validate([
            'nama_pimpinan' => 'required|string|max:255',
            'jabatan'       => 'required|string|max:100',
            'no_telp'       => 'required|string|max:20',
        ]);

        $pimpinan = DB::table('pimpinan')->where('id_user', Auth::id())->first();

        if (!$pimpinan) {
            return redirect()->back()->with('error', 'Profil pimpinan tidak ditemukan.');
        }

        // Update data di tabel pimpinan
        DB::table('pimpinan')->where('id_user', Auth::id())->update([
            'nama_pimpinan' => $request->nama_pimpinan,
            'jabatan'       => $request->jabatan,
            'no_telp'       => $request->no_telp,
            'updated_at'    => now(),
        ]);

        // Update juga username di tabel user jika diperlukan agar sinkron
        DB::table('user')->where('id_user', Auth::id())->update([
            'username'   => $request->nama_pimpinan,
            'updated_at' => now(),
        ]);

        return redirect()->route('pimpinan.profil')->with('success', 'Profil pimpinan berhasil diperbarui!');
    }
}