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
    // 1. Mengambil data real dari database
    $totalKoperasi = DB::table('koperasi')->count();
    $totalPengguna = DB::table('user')->count(); // Sesuai nama tabel di image_6cda0c.png
    $totalRAT = DB::table('rat')->count();
    $totalVerifikasi = DB::table('verifikasi_rat')->count();

    // 2. Data untuk grafik distribusi kesehatan
    $distribusiKesehatan = DB::table('pemkes')
        ->select('status_kesehatan', DB::raw('count(*) as total'))
        ->groupBy('status_kesehatan')
        ->get();

    // 3. Data untuk Tabel Hasil Penilaian Koperasi (Dinamis)
    $koperasiList = DB::table('pemkes')
        ->join('rat', 'pemkes.id_rat', '=', 'rat.id_rat')
        ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
        ->select('koperasi.nama_koperasi', 'pemkes.skor_pemkes', 'pemkes.status_kesehatan')
        ->limit(8)
        ->get();

    return view('admin.dashboard', compact(
        'totalKoperasi', 'totalPengguna', 'totalRAT', 'totalVerifikasi', 
        'distribusiKesehatan', 'koperasiList'
    ));
}

// --- MANAJEMEN MENU ADMINISTRASI (Baru) ---

    // 1. Data Pengguna
    public function indexPengguna()
    {
        $users = DB::table('user')->get(); // Sesuaikan dengan tabel user Anda
        return view('admin.pengguna.index', compact('users'));
    }

    // 2. Data Koperasi
    public function indexKoperasi()
    {
        $koperasi = DB::table('koperasi')->get();
        return view('admin.koperasi.index', compact('koperasi'));
    }

    // 3. Data Wilayah
   // 3. Data Wilayah (Mengambil daftar kecamatan unik dari tabel koperasi)
    public function indexWilayah()
{
    // Ambil data jumlah koperasi per kecamatan untuk warna peta
    $statistik = DB::table('koperasi')
        ->select('kecamatan', DB::raw('count(*) as total'))
        ->groupBy('kecamatan')
        ->get();

    // Data untuk tabel tetap ada
    $wilayah = $statistik; 

    return view('admin.wilayah.index', compact('wilayah'));
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
 
        // 1. Ambil data lengkap — TAMBAHKAN no_badan_hukum & alamat
        //    (sesuaikan nama kolom ini dengan struktur tabel koperasi kamu
        //    jika namanya berbeda, mis. 'nomor_bh' atau 'alamat_koperasi')
        $data = DB::table('pemkes')
            ->join('rat', 'pemkes.id_rat', '=', 'rat.id_rat')
            ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
            ->select(
                'pemkes.*',
                'koperasi.nama_koperasi',
                'koperasi.no_badan_hukum',
                'koperasi.alamat',
                'rat.tahun_buku'
            )
            ->where('id_pemkes', $id)
            ->first();
 
        // 2. PENTING: cek data ada atau tidak, supaya tidak fatal error
        //    kalau $id tidak ditemukan di database
        if (!$data) {
            return redirect()->route('admin.verifikasi.index')
                ->with('error', 'Data verifikasi dengan ID tersebut tidak ditemukan.');
        }
 
        // Update status terbaru ke object $data sebelum dipakai di PDF,
        // supaya sertifikat menampilkan status yang BARU dipilih admin,
        // bukan status lama dari database.
        $data->status_kesehatan = $request->status;
 
        // 3. Susun $pdfData SESUAI variabel yang dipakai di template blade
        $pdfData = [
            'koperasi' => $data, // dipakai sbg $koperasi->nama_koperasi, ->no_badan_hukum, ->alamat
            'pemkes'   => $data, // dipakai sbg $pemkes->skor_pemkes, ->status_kesehatan
 
            'tahun_buku'     => $data->tahun_buku,
            'tanggal_terbit' => now()->translatedFormat('d F Y'),
 
            // Skor per indikator — sesuaikan nama kolom ini dengan
            // kolom asli di tabel `pemkes` kamu
            'skor_tata_kelola'      => $data->skor_tata_kelola ?? '-',
            'skor_profil_resiko'    => $data->skor_profil_resiko ?? '-',
            'skor_kinerja_keuangan' => $data->skor_kinerja_keuangan ?? '-',
            'skor_permodalan'       => $data->skor_permodalan ?? '-',
            'total_skor'            => $data->skor_pemkes ?? '-',
        ];
 
        // 4. Bungkus proses generate PDF dengan try-catch,
        //    supaya kalau gagal, user diarahkan balik dengan pesan jelas
        //    (bukan halaman 500 yang bikin "nyangkut" di URL POST)
        try {
            $pdf = Pdf::loadView('admin.sertifikat.template', $pdfData);
 
            $fileName = 'Sertifikat_' . $data->nama_koperasi . '_' . time() . '.pdf';
            $path = 'sertifikat/' . $fileName;
            Storage::disk('public')->put($path, $pdf->output());
 
            DB::table('pemkes')->where('id_pemkes', $id)->update([
                'status_kesehatan' => $request->status,
                'file_sertifikat'  => $path,
                'updated_at'       => now(),
            ]);
 
            return redirect()->route('admin.verifikasi.index')
                ->with('success', 'Verifikasi sukses! Sertifikat telah digenerate.');
 
        } catch (\Throwable $e) {
            return redirect()->route('admin.verifikasi.index')
                ->with('error', 'Gagal membuat sertifikat: ' . $e->getMessage());
        }
    }
}