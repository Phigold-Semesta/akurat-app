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

    // --- FITUR RAT ---

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

        return redirect()->route('koperasi.input-rat')->with('success', 'Data RAT berhasil ditambahkan!');
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

    // --- FITUR PEMKES ---

    public function indexInputPemkes()
    {
        $koperasiId = $this->getKoperasiId();
        $rat = DB::table('rat')->where('id_koperasi', $koperasiId)->latest()->first();
        return view('koperasi.pemkes.index', compact('rat'));
    }

    public function storePemkes(Request $request)
    {
        $request->validate([
            'id_rat'       => 'required|exists:rat,id_rat',
            'skor_pemkes'  => 'required|numeric|min:0|max:100',
            'catatan_jpfk' => 'required|string',
        ]);

        DB::table('pemkes')->insert([
            'id_rat'           => $request->id_rat,
            'skor_pemkes'      => $request->skor_pemkes,
            'skor_jpfk'        => 0, 
            'status_kesehatan' => 'Dalam Proses',
            'tahun_penilaian'  => date('Y'),
            'catatan_jpfk'     => $request->catatan_jpfk,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        return redirect()->route('dashboard.koperasi')->with('success', 'Data PEMKES berhasil dikirim!');
    }

    // --- FITUR HASIL PENILAIAN & PROFIL ---

    public function hasilPenilaian()
    {
        $koperasiId = $this->getKoperasiId();
        $hasil = DB::table('pemkes')
            ->join('rat', 'pemkes.id_rat', '=', 'rat.id_rat')
            ->where('rat.id_koperasi', $koperasiId)
            ->orderBy('pemkes.created_at', 'desc')
            ->get();

        return view('koperasi.hasil_penilaian.index', compact('hasil'));
    }

    public function unduhSertifikat($id_pemkes)
    {
        $koperasiId = $this->getKoperasiId();
        $data = DB::table('pemkes')
            ->join('rat', 'pemkes.id_rat', '=', 'rat.id_rat')
            ->where('pemkes.id_pemkes', $id_pemkes)
            ->where('rat.id_koperasi', $koperasiId)
            ->firstOrFail();

        if ($data->file_sertifikat && Storage::disk('public')->exists($data->file_sertifikat)) {
            // Ganti bagian return menjadi seperti ini:
return Storage::download('public/' . $data->file_sertifikat);
        }

        return redirect()->back()->with('error', 'Sertifikat belum tersedia atau tidak ditemukan.');
    }

    public function profilKoperasi()
    {
        $koperasiId = $this->getKoperasiId();
        $profil = DB::table('koperasi')->where('id_koperasi', $koperasiId)->first();
        return view('koperasi.profil.index', compact('profil'));
    }
}