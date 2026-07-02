@extends('layouts.app_koperasi')
@section('title', 'Profil Koperasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 p-10 relative">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-black text-emerald-900 dark:text-white uppercase tracking-tighter flex items-center gap-3">
                <i class="fas fa-id-card text-emerald-500"></i> Profil Lengkap Koperasi
            </h2>
            <button onclick="document.getElementById('editModal').classList.remove('hidden')" 
                    class="bg-emerald-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-emerald-700 transition shadow-lg">
                <i class="fas fa-edit mr-2"></i> Edit Profil
            </button>
        </div>

        @if($profil)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Koperasi</label><p class="text-lg font-bold text-emerald-900 dark:text-emerald-50">{{ $profil->nama_koperasi }}</p></div>
                    <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">No. Badan Hukum</label><p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->no_badan_hukum }}</p></div>
                    <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat</label><p class="text-sm font-semibold text-slate-600 dark:text-slate-300 leading-relaxed">{{ $profil->alamat }}</p></div>
                    <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kecamatan</label><p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->kecamatan }}</p></div>
                </div>
                <div class="space-y-6">
                    <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status Koperasi</label><div class="mt-1"><span class="px-4 py-1 bg-emerald-600 text-white rounded-lg text-[10px] font-black uppercase">{{ $profil->status_koperasi }}</span></div></div>
                    <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Berdiri</label><p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($profil->tgl_berdiri)->format('d F Y') }}</p></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Ketua</label><p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->ketua }}</p></div>
                        <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jumlah Anggota</label><p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->jumlah_anggota }}</p></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sekretaris</label><p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->sekretaris }}</p></div>
                        <div><label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Bendahara</label><p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->bendahara }}</p></div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Edit -->
<div id="editModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white dark:bg-emerald-900 rounded-3xl p-8 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-black mb-6 uppercase text-emerald-900 dark:text-white">Edit Profil Koperasi</h3>
        <form action="{{ route('koperasi.profil.update') }}" method="POST" class="grid grid-cols-2 gap-4">
            @csrf
            <div class="col-span-2"><label class="text-xs font-bold">Nama Koperasi</label><input type="text" name="nama_koperasi" value="{{ $profil->nama_koperasi }}" class="w-full p-3 rounded-xl border border-emerald-200 mt-1" required></div>
            <div><label class="text-xs font-bold">No. Badan Hukum</label><input type="text" name="no_badan_hukum" value="{{ $profil->no_badan_hukum }}" class="w-full p-3 rounded-xl border border-emerald-200 mt-1"></div>
            <div><label class="text-xs font-bold">Kecamatan</label><input type="text" name="kecamatan" value="{{ $profil->kecamatan }}" class="w-full p-3 rounded-xl border border-emerald-200 mt-1"></div>
            <div class="col-span-2"><label class="text-xs font-bold">Alamat</label><textarea name="alamat" class="w-full p-3 rounded-xl border border-emerald-200 mt-1">{{ $profil->alamat }}</textarea></div>
            <div><label class="text-xs font-bold">Tanggal Berdiri</label><input type="date" name="tgl_berdiri" value="{{ $profil->tgl_berdiri }}" class="w-full p-3 rounded-xl border border-emerald-200 mt-1"></div>
            <div><label class="text-xs font-bold">Jumlah Anggota</label><input type="number" name="jumlah_anggota" value="{{ $profil->jumlah_anggota }}" class="w-full p-3 rounded-xl border border-emerald-200 mt-1"></div>
            <div><label class="text-xs font-bold">Ketua</label><input type="text" name="ketua" value="{{ $profil->ketua }}" class="w-full p-3 rounded-xl border border-emerald-200 mt-1"></div>
            <div><label class="text-xs font-bold">Sekretaris</label><input type="text" name="sekretaris" value="{{ $profil->sekretaris }}" class="w-full p-3 rounded-xl border border-emerald-200 mt-1"></div>
            <div><label class="text-xs font-bold">Bendahara</label><input type="text" name="bendahara" value="{{ $profil->bendahara }}" class="w-full p-3 rounded-xl border border-emerald-200 mt-1"></div>
            <div class="col-span-2 flex gap-4 mt-4">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="flex-1 py-3 bg-slate-200 rounded-xl font-bold">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#059669'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
    </script>
@endif
@endsection