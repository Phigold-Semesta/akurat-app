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
   /**
 * Menampilkan dashboard utama untuk aktor Pengawas dengan data dinamis.
 */
/**
 * Menampilkan dashboard utama untuk aktor Pengawas dengan data dinamis.
 */
public function index()
{
    // 1. Mengambil data statistik kartu
    $totalKoperasi = DB::table('koperasi')->count(); // Variabel baru untuk jumlah koperasi
    $skorRataRata = DB::table('pemkes')->avg('skor_pemkes') ?? 0;
    $statusRataRata = $skorRataRata > 80 ? 'Sangat Sehat' : ($skorRataRata > 60 ? 'Cukup Sehat' : 'Tidak Sehat');
    $skorTertinggi = DB::table('pemkes')->max('skor_pemkes') ?? 0;
    $skorTerendah = DB::table('pemkes')->min('skor_pemkes') ?? 0;
    $totalDinilai = DB::table('pemkes')->count();

    // 2. Data untuk Grafik Distribusi Kesehatan
    $distribusi = DB::table('pemkes')
        ->select('status_kesehatan', DB::raw('count(*) as total'))
        ->groupBy('status_kesehatan')
        ->get();
    
    $distribusiLabels = $distribusi->pluck('status_kesehatan');
    $distribusiData = $distribusi->pluck('total');

    // 3. Data untuk Tren Skor (Contoh: tren per bulan)
    $trend = DB::table('pemkes')
        ->select(DB::raw('MONTHNAME(created_at) as bulan'), DB::raw('AVG(skor_pemkes) as rata_skor'))
        ->groupBy('bulan')
        ->orderBy(DB::raw('MIN(created_at)'))
        ->get();

    $trendLabels = $trend->pluck('bulan');
    $trendData = $trend->pluck('rata_skor');

    // 4. Data untuk Tabel Koperasi
    $koperasiList = DB::table('pemkes')
        ->join('rat', 'pemkes.id_rat', '=', 'rat.id_rat')
        ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
        ->select('koperasi.nama_koperasi', 'pemkes.skor_pemkes', 'pemkes.status_kesehatan')
        ->limit(8)
        ->get();

    return view('pengawas.dashboard', compact(
        'totalKoperasi', 'skorRataRata', 'statusRataRata', 'skorTertinggi', 'skorTerendah', 
        'totalDinilai', 'distribusiLabels', 'distribusiData', 
        'trendLabels', 'trendData', 'koperasiList'
    ));
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
     * Menampilkan daftar koperasi untuk verifikasi lapangan.
     */
    /**
     * Menampilkan daftar koperasi untuk verifikasi lapangan.
     */
    public function indexLapangan()
    {
        // SOLUSI JENIUS: Ambil data berbasis RAT dan Koperasi secara presisi 
        // agar setiap baris data di view pasti membawa id_rat yang valid untuk form input.
        $data = DB::table('rat')
            ->join('koperasi', 'rat.id_koperasi', '=', 'koperasi.id_koperasi')
            ->leftJoin('pemkes', 'rat.id_rat', '=', 'pemkes.id_rat')
            ->select(
                'rat.id_rat', // <--- SANGAT PENTING: ID RAT wajib dibawa untuk form
                'koperasi.id_koperasi', 
                'koperasi.nama_koperasi', 
                'koperasi.alamat', 
                'koperasi.status_koperasi',
                'pemkes.skor_pemkes', 
                'pemkes.catatan_jpfk'
            )
            ->get();

        return view('pengawas.verifikasi_lapangan.index', compact('data'));
    }

/**
     * Memproses data submit verifikasi lapangan dari form.
     */
  public function prosesLapangan(Request $request)
    {
        // 1. Validasi data inputan dari form
        $request->validate([
            'id_rat'          => 'required', 
            'tgl_verifikasi'  => 'required|date',
            'status_validasi' => 'required|string|max:255',
            'rekomendasi'     => 'nullable|string',
        ]);

        // Penanganan Upload File Berita Acara (BA) jika ada
        $namaFile = null;
        /*
        if ($request->hasFile('file_ba_verifikasi')) {
            $file = $request->file('file_ba_verifikasi');
            $namaFile = 'BA_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/ba_verifikasi'), $namaFile);
        }
        */

        // AMBIL ID PENGAWAS YANG SESUAI DENGAN USER LOGIN
        $pengawas = DB::table('pengawas_lapangan')
            ->where('id_user', Auth::id())
            ->first();

        if (!$pengawas) {
            return redirect()->back()->with('error', 'Gagal: Data profil pengawas untuk user ini tidak ditemukan.');
        }

        // 2. Logika Insert Database ke tabel verifikasi_rat
        DB::table('verifikasi_rat')->insert([
            'id_rat'             => $request->id_rat,
            'id_pengawas'        => $pengawas->id_pengawas, // Menggunakan id_pengawas yang valid dari tabel pengawas_lapangan
            'tgl_verifikasi'     => $request->tgl_verifikasi,
            'status_validasi'    => $request->status_validasi,
            'rekomendasi'        => $request->rekomendasi,
            'file_ba_verifikasi' => $namaFile,
            'created_at'         => now(),
            'updated_at'         => now()
        ]);

        // 3. Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data verifikasi lapangan berhasil disimpan!');
    }
    
    /**
     * Menampilkan semua data koperasi yang terdaftar.
     */
    public function indexDataKoperasi()
    {
        $data = DB::table('koperasi')->get();
        return view('pengawas.data_koperasi.index', compact('data'));
    }

   /**
 * Menampilkan profil pengawas lapangan yang sedang login.
 */
public function profilPengawas()
{
    $pengawas = DB::table('pengawas_lapangan')
        ->where('id_user', Auth::id())
        ->first();
            
    return view('pengawas.profil.index', compact('pengawas'));
}

/**
 * Update profil pengawas.
 */
public function updateProfil(Request $request)
{
    // INVESTIGASI TAHAP 1: Cek apakah inputan masuk
    // Jika Anda sudah melihat array datanya, silakan beri komentar (//) baris ini
    // dd($request->all()); 

    $request->validate([
        'nama_pengawas' => 'required|string|max:255',
        'jabatan'       => 'required|string|max:100',
        'no_telp'       => 'required|string|max:20',
        'wilayah_tugas' => 'required|string|max:255',
    ]);

    // INVESTIGASI TAHAP 2: Cek ID User yang sedang aktif
    // dd(Auth::id()); 

    // EKSEKUSI: Lakukan update dengan kondisi WHERE yang spesifik
    $affected = DB::table('pengawas_lapangan')
        ->where('id_user', Auth::id())
        ->update([
            'nama_pengawas' => $request->nama_pengawas,
            'jabatan'       => $request->jabatan,
            'no_telp'       => $request->no_telp,
            'wilayah_tugas' => $request->wilayah_tugas,
            'updated_at'    => now(),
        ]);

    // INVESTIGASI TAHAP 3: Cek apakah database benar-benar menemukan row-nya
    // Jika $affected bernilai 0, berarti sistem tidak menemukan row dengan id_user tersebut
    if ($affected === 0) {
        // Cek dulu di database: apakah id_user di tabel pengawas_lapangan 
        // benar-benar berisi angka yang sama dengan Auth::id() Anda?
        // Jika belum ada datanya, gunakan DB::table('pengawas_lapangan')->insert(...)
        return redirect()->route('pengawas.profil.index')->with('error', 'Gagal: Data tidak ditemukan atau tidak ada perubahan.');
    }

    return redirect()->route('pengawas.profil.index')->with('success', 'Profil berhasil diperbarui!');
}
}