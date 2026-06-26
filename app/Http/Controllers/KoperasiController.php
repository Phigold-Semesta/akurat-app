<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KoperasiController extends Controller implements HasMiddleware
{
    /**
     * Mendefinisikan middleware yang diterapkan pada controller ini.
     * Menggunakan guard 'koperasi' untuk memisahkan sesi dari portal internal.
     */
    public static function middleware(): array
    {
        return [
            'auth:koperasi',
            'role:koperasi',
        ];
    }

    public function index()
    {
        return view('koperasi.dashboard');
    }

    public function riwayat()
    {
        return view('koperasi.riwayat');
    }

    /**
     * RAT: Menampilkan daftar RAT (Read)
     */
    /**
     * RAT: Menampilkan daftar RAT (Read)
     */
    public function inputRat()
    {
        // Cari profil koperasi berdasarkan user yang sedang login
        $koperasi = DB::table('koperasi')->where('id_user', auth()->id())->first();

        // Jika profil tidak ditemukan, beri data kosong agar tidak error
        $data = $koperasi ? DB::table('rat')->where('id_koperasi', $koperasi->id_koperasi)->get() : collect();

        return view('koperasi.rat.index', compact('data'));
    }

    /**
     * RAT: Menampilkan form tambah (Create View)
     */
    public function createRat()
    {
        return view('koperasi.rat.create');
    }

    /**
     * RAT: Menyimpan data (Create Process)
     */
   public function simpanRat(Request $request)
{
    $request->validate([
        'tahun_buku'     => 'required|digits:4',
        'tgl_rat'        => 'required|date',
        'tempat_rat'     => 'required|string|max:255',
        'jumlah_peserta' => 'required|integer',
        'hasil_rat'      => 'nullable|string',
        'file_dokumen'   => 'required|file|mimes:pdf|max:5120',
    ]);

    // AMBIL ID_KOPERASI YANG BENAR DARI TABEL KOPERASI BERDASARKAN ID_USER
    $koperasi = DB::table('koperasi')->where('id_user', auth()->id())->first();

    if (!$koperasi) {
        return redirect()->back()->withErrors(['error' => 'Profil koperasi tidak ditemukan untuk user ini.']);
    }

    $path = $request->file('file_dokumen')->store('dokumen_rat', 'public');

    DB::table('rat')->insert([
        'id_koperasi'    => $koperasi->id_koperasi, // Gunakan ID dari tabel koperasi
        'tahun_buku'     => $request->tahun_buku,
        'tgl_rat'        => $request->tgl_rat,
        'tempat_rat'     => $request->tempat_rat,
        'jumlah_peserta' => $request->jumlah_peserta,
        'hasil_rat'      => $request->hasil_rat,
        'file_dokumen'   => $path,
        'created_at'     => now(),
    ]);

    return redirect()->route('koperasi.input-rat')->with('success', 'Data RAT & Dokumen berhasil ditambahkan!');
}

    /**
     * RAT: Menampilkan form edit (Update View)
     */
    public function editRat($id)
    {
        $rat = DB::table('rat')->where('id_rat', $id)->where('id_koperasi', auth()->id())->firstOrFail();
        return view('koperasi.rat.edit', compact('rat'));
    }

    /**
     * RAT: Memperbarui data (Update Process)
     */
    public function updateRat(Request $request, $id)
    {
        $request->validate([
            'tahun_buku'     => 'required|digits:4',
            'tgl_rat'        => 'required|date',
            'tempat_rat'     => 'required|string|max:255',
            'jumlah_peserta' => 'required|integer',
            'hasil_rat'      => 'nullable|string',
            'file_dokumen'   => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $dataUpdate = [
            'tahun_buku'     => $request->tahun_buku,
            'tgl_rat'        => $request->tgl_rat,
            'tempat_rat'     => $request->tempat_rat,
            'jumlah_peserta' => $request->jumlah_peserta,
            'hasil_rat'      => $request->hasil_rat,
            'updated_at'     => now(),
        ];

        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada
            $oldFile = DB::table('rat')->where('id_rat', $id)->value('file_dokumen');
            if ($oldFile) Storage::disk('public')->delete($oldFile);
            
            $dataUpdate['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_rat', 'public');
        }

        DB::table('rat')
            ->where('id_rat', $id)
            ->where('id_koperasi', auth()->id())
            ->update($dataUpdate);

        return redirect()->route('koperasi.input-rat')->with('success', 'Data RAT berhasil diperbarui!');
    }

    /**
     * RAT: Menghapus data (Delete Process)
     */
    public function hapusRat($id)
    {
        $rat = DB::table('rat')->where('id_rat', $id)->where('id_koperasi', auth()->id())->firstOrFail();
        
        // Hapus file fisik
        if ($rat->file_dokumen) Storage::disk('public')->delete($rat->file_dokumen);
        
        DB::table('rat')->where('id_rat', $id)->delete();

        return redirect()->route('koperasi.input-rat')->with('success', 'Data RAT berhasil dihapus!');
    }
}