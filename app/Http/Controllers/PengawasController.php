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
     * Menampilkan daftar koperasi untuk verifikasi lapangan.
     */
    public function indexLapangan()
    {
        // Mengambil data dengan join berantai
        $data = DB::table('koperasi')
            // Join ke tabel RAT dulu untuk mendapatkan koneksi ke PEMKES
            ->leftJoin('rat', 'koperasi.id_koperasi', '=', 'rat.id_koperasi')
            // Baru join ke tabel PEMKES berdasarkan id_rat
            ->leftJoin('pemkes', 'rat.id_rat', '=', 'pemkes.id_rat')
            ->select(
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