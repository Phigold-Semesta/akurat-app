@extends('layouts.app')
@section('title', 'Verifikasi Lapangan')

@section('content')
<div x-data="{ 
    showModal: false, 
    namaKop: '', 
    skorPemkes: '', 
    catatanJpfk: '' 
}" class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 p-8">
    
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-black text-emerald-900 dark:text-white uppercase tracking-widest">Verifikasi Lapangan</h2>
            <p class="text-slate-500 dark:text-emerald-200 mt-1 text-sm">Daftar inspeksi fisik koperasi di wilayah pengawasan</p>
        </div>
        <div class="bg-emerald-50 dark:bg-emerald-800 px-4 py-2 rounded-xl text-emerald-700 dark:text-emerald-100 font-bold text-xs uppercase">
            {{ count($data) }} Koperasi Perlu Diinspeksi
        </div>
    </div>
    
    <div class="overflow-hidden rounded-2xl border border-emerald-100 shadow-inner">
        <table class="w-full">
            <thead class="bg-emerald-50 dark:bg-emerald-800 text-emerald-900 dark:text-emerald-100 border-b border-emerald-100">
                <tr>
                    <th class="px-6 py-5 text-left uppercase text-xs font-bold">Nama Koperasi</th>
                    <th class="px-6 py-5 text-left uppercase text-xs font-bold">Alamat</th>
                    <th class="px-6 py-5 text-left uppercase text-xs font-bold">Skor PEMKES</th>
                    <th class="px-6 py-5 text-center uppercase text-xs font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-100 dark:divide-emerald-700 bg-white dark:bg-emerald-900">
                @forelse($data as $koperasi)
                <tr class="hover:bg-emerald-50 dark:hover:bg-emerald-700/50 transition-colors duration-200">
                    <td class="px-6 py-5 font-bold text-slate-800 dark:text-slate-200">{{ $koperasi->nama_koperasi }}</td>
                    <td class="px-6 py-5 text-slate-600 dark:text-slate-400 text-sm">{{ $koperasi->alamat }}</td>
                    <td class="px-6 py-5 font-bold text-emerald-700 dark:text-emerald-300">
                        {{ $koperasi->skor_pemkes ?? 'Belum ada' }}
                    </td>
                    <td class="px-6 py-5 text-center">
                        <button @click="showModal = true; namaKop = '{{ $koperasi->nama_koperasi }}'; skorPemkes = '{{ $koperasi->skor_pemkes }}'; catatanJpfk = '{{ $koperasi->catatan_jpfk }}'" 
                                class="bg-emerald-600 text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-emerald-700 transition-all shadow-lg">
                            <i class="fas fa-clipboard-check mr-2"></i> Input Hasil
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-12 text-center text-slate-400">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
        <div class="bg-white dark:bg-emerald-800 rounded-3xl p-8 w-full max-w-lg shadow-2xl">
            <h3 class="text-xl font-black text-emerald-900 dark:text-white mb-2">Input Hasil Verifikasi</h3>
            <p class="text-sm text-slate-500 dark:text-emerald-200 mb-6" x-text="'Koperasi: ' + namaKop"></p>
            
            <div class="bg-emerald-50 dark:bg-emerald-900 p-4 rounded-xl mb-6 border border-emerald-100">
                <p class="text-xs font-bold text-emerald-800 dark:text-emerald-300 uppercase">Referensi PEMKES Koperasi:</p>
                <p class="text-sm mt-1" x-text="'Skor: ' + (skorPemkes || 'Tidak ada')"></p>
                <p class="text-xs mt-1 text-slate-600 dark:text-emerald-400" x-text="'Catatan: ' + (catatanJpfk || '-')"></p>
            </div>

            <form action="#" method="POST">
                @csrf
                <textarea name="catatan_inspeksi" class="w-full p-4 border border-slate-200 rounded-2xl mb-4" placeholder="Masukkan catatan hasil inspeksi lapangan..." rows="3"></textarea>
                <div class="flex gap-3">
                    <button type="button" @click="showModal = false" class="flex-1 py-3 bg-slate-100 rounded-xl font-bold">Batal</button>
                    <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white rounded-xl font-bold">Simpan Hasil</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection