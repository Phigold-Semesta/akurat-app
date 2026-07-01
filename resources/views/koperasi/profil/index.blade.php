@extends('layouts.app_koperasi')
@section('title', 'Profil Koperasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 p-10 relative">
        <h2 class="text-2xl font-black text-emerald-900 dark:text-white uppercase tracking-tighter mb-8 flex items-center gap-3">
            <i class="fas fa-id-card text-emerald-500"></i> Profil Lengkap Koperasi
        </h2>

        @if($profil)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Kolom Kiri: Informasi Utama -->
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Koperasi</label>
                        <p class="text-lg font-bold text-emerald-900 dark:text-emerald-50">{{ $profil->nama_koperasi }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">No. Badan Hukum</label>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->no_badan_hukum }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Alamat</label>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-300 leading-relaxed">{{ $profil->alamat }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Kecamatan</label>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->kecamatan }}</p>
                    </div>
                </div>

                <!-- Kolom Kanan: Detail & Pengurus -->
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status Koperasi</label>
                        <div class="mt-1">
                            <span class="px-4 py-1 bg-emerald-600 text-white rounded-lg text-[10px] font-black uppercase">{{ $profil->status_koperasi }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Tanggal Berdiri</label>
                        <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ \Carbon\Carbon::parse($profil->tgl_berdiri)->format('d F Y') }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Ketua</label>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->ketua }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jumlah Anggota</label>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->jumlah_anggota }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Sekretaris</label>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->sekretaris }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Bendahara</label>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-300">{{ $profil->bendahara }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-10">
                <p class="font-bold text-slate-500">Data profil koperasi belum tersedia.</p>
            </div>
        @endif
    </div>
</div>
@endsection