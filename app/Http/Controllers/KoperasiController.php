<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class KoperasiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth:koperasi',
            'role:koperasi',
        ];
    }

    // Fungsi pembantu agar ID Koperasi selalu sinkron
    private function getKoperasiId()
    {
        $koperasi = DB::table('koperasi')->where('id_user', Auth::id())->first();
        return $koperasi ? $koperasi->id_koperasi : null;
    }

    public function index()
    {
        return view('koperasi.dashboard');
    }

    public function riwayat()
    {
        return view('koperasi.riwayat');
    }

    public function inputRat()
    {
        $koperasiId = $this->getKoperasiId();
        $data = $koperasiId ? DB::table('rat')->where('id_koperasi', $koperasiId)->get() : collect();
        return view('koperasi.rat.index', compact('data'));
    }

    public function createRat()
    {
        return view('koperasi.rat.create');
    }

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

        $koperasiId = $this->getKoperasiId();
        if (!$koperasiId) return redirect()->back()->withErrors(['error' => 'Profil koperasi tidak ditemukan.']);

        $path = $request->file('file_dokumen')->store('dokumen_rat', 'public');

        DB::table('rat')->insert([
            'id_koperasi'    => $koperasiId,
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

    public function editRat($id)
    {
        $koperasiId = $this->getKoperasiId();
        $rat = DB::table('rat')->where('id_rat', $id)->where('id_koperasi', $koperasiId)->firstOrFail();
        return view('koperasi.rat.edit', compact('rat'));
    }

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

        $koperasiId = $this->getKoperasiId();
        $dataUpdate = [
            'tahun_buku'     => $request->tahun_buku,
            'tgl_rat'        => $request->tgl_rat,
            'tempat_rat'     => $request->tempat_rat,
            'jumlah_peserta' => $request->jumlah_peserta,
            'hasil_rat'      => $request->hasil_rat,
            'updated_at'     => now(),
        ];

        if ($request->hasFile('file_dokumen')) {
            $oldFile = DB::table('rat')->where('id_rat', $id)->value('file_dokumen');
            if ($oldFile) Storage::disk('public')->delete($oldFile);
            $dataUpdate['file_dokumen'] = $request->file('file_dokumen')->store('dokumen_rat', 'public');
        }

        DB::table('rat')->where('id_rat', $id)->where('id_koperasi', $koperasiId)->update($dataUpdate);

        return redirect()->route('koperasi.input-rat')->with('success', 'Data RAT berhasil diperbarui!');
    }

    public function hapusRat($id)
    {
        $koperasiId = $this->getKoperasiId();
        $rat = DB::table('rat')->where('id_rat', $id)->where('id_koperasi', $koperasiId)->firstOrFail();
        
        if ($rat->file_dokumen) Storage::disk('public')->delete($rat->file_dokumen);
        
        DB::table('rat')->where('id_rat', $id)->delete();

        return redirect()->route('koperasi.input-rat')->with('success', 'Data RAT berhasil dihapus!');
    }
}