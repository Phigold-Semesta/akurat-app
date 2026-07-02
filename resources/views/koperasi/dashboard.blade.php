@extends('layouts.app_koperasi')
@section('title', 'Dashboard Koperasi')

@section('content')
<div class="space-y-8">
    <!-- Header Dashboard -->
    <div class="bg-emerald-600 p-8 rounded-3xl shadow-xl text-white flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <h1 class="text-3xl font-black">Selamat Datang, Koperasi</h1>
            <p class="text-emerald-100 mt-2 font-medium">Pantau status laporan RAT dan penilaian kesehatan Anda di sini.</p>
        </div>
        <div class="bg-white/20 backdrop-blur-sm p-6 rounded-2xl border border-white/30 text-center min-w-[200px]">
            <p class="text-emerald-50 text-sm font-bold uppercase tracking-widest">Status Kesehatan Terakhir</p>
            <p class="text-2xl font-black mt-1">{{ $lastPemkes->status_kesehatan ?? 'Belum Dinilai' }}</p>
        </div>
    </div>

    <!-- Konten Dinamis -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Aksi Cepat -->
        <div class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 p-6">
            <h2 class="font-black text-lg uppercase italic mb-6">Aksi Cepat</h2>
            <div class="space-y-4">
                <a href="{{ route('koperasi.rat.create') }}" class="flex items-center gap-4 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-800 hover:bg-emerald-100 transition border border-emerald-100">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-600"><i class="fas fa-file-upload"></i></div>
                    <span class="font-bold text-sm">Input Laporan RAT</span>
                </a>
            </div>
        </div>

        <!-- Riwayat -->
        <div class="lg:col-span-2 bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 overflow-hidden">
            <div class="p-6 border-b border-emerald-100 dark:border-emerald-800">
                <h2 class="font-black text-lg uppercase italic">Riwayat Pengajuan RAT</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-emerald-50 dark:bg-emerald-950/50">
                        <tr>
                            <th class="p-6 font-black uppercase text-xs">Tahun Buku</th>
                            <th class="p-6 font-black uppercase text-xs">Status</th>
                            <th class="p-6 font-black uppercase text-xs">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-100 dark:divide-emerald-800">
                        @foreach($riwayatRat as $rat)
                        <tr>
                            <td class="p-6 font-bold">{{ $rat->tahun_buku }}</td>
                            <td class="p-6">
                                <span class="px-3 py-1 rounded-full {{ $rat->status_verifikasi == 'terverifikasi' ? 'bg-emerald-100 text-emerald-700' : 'bg-yellow-100 text-yellow-700' }} font-bold text-xs uppercase">
                                    {{ $rat->status_verifikasi ?? 'Menunggu' }}
                                </span>
                            </td>
                            <td class="p-6">
                                @if($rat->status_verifikasi == 'terverifikasi')
                                    <a href="{{ route('koperasi.hasil-penilaian') }}" class="text-emerald-600 font-bold text-sm underline">Lihat Detail</a>
                                @else
                                    <span class="text-slate-400 text-sm italic">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection