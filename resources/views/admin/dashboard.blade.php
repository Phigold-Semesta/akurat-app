@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['title' => 'Total Koperasi', 'value' => '245', 'icon' => 'fa-building', 'color' => 'text-emerald-600'],
                ['title' => 'Data Pengguna', 'value' => '82', 'icon' => 'fa-users', 'color' => 'text-blue-600'],
                ['title' => 'Laporan RAT', 'value' => '1.204', 'icon' => 'fa-file-invoice', 'color' => 'text-purple-600'],
                ['title' => 'Aktivitas Hari Ini', 'value' => '15', 'icon' => 'fa-history', 'color' => 'text-orange-600'],
            ];
        @endphp
        
        @foreach($stats as $stat)
        <div class="bg-white dark:bg-emerald-900 p-6 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-800 flex items-center justify-center {{ $stat['color'] }}">
                <i class="fas {{ $stat['icon'] }} text-xl"></i>
            </div>
            <div>
                <p class="text-emerald-600 dark:text-emerald-300 font-bold text-sm">{{ $stat['title'] }}</p>
                <p class="text-2xl font-black">{{ $stat['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 overflow-hidden">
            <div class="p-6 border-b border-emerald-100 dark:border-emerald-800">
                <h2 class="font-black text-lg uppercase italic">Log Aktivitas Terbaru</h2>
            </div>
            <div class="p-0">
                <table class="w-full text-left">
                    <thead class="bg-emerald-50 dark:bg-emerald-950/50">
                        <tr>
                            <th class="p-6 font-black uppercase text-xs">User</th>
                            <th class="p-6 font-black uppercase text-xs">Aksi</th>
                            <th class="p-6 font-black uppercase text-xs">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-100 dark:divide-emerald-800">
                        <tr>
                            <td class="p-6 font-bold text-sm">Admin Dinas</td>
                            <td class="p-6 text-sm">Mengupdate Data Koperasi</td>
                            <td class="p-6 text-sm text-emerald-500">2 Menit Lalu</td>
                        </tr>
                        <tr>
                            <td class="p-6 font-bold text-sm">Pengawas Lapangan</td>
                            <td class="p-6 text-sm">Validasi RAT Koperasi</td>
                            <td class="p-6 text-sm text-emerald-500">1 Jam Lalu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 p-6">
            <h2 class="font-black text-lg uppercase italic mb-6">Aksi Cepat</h2>
            <div class="space-y-4">
                <a href="#" class="flex items-center gap-4 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-800 hover:bg-emerald-100 transition">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-600"><i class="fas fa-plus"></i></div>
                    <span class="font-bold">Tambah Pengguna</span>
                </a>
                <a href="#" class="flex items-center gap-4 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-800 hover:bg-emerald-100 transition">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-600"><i class="fas fa-map-marker-alt"></i></div>
                    <span class="font-bold">Kelola Wilayah</span>
                </a>
                <a href="#" class="flex items-center gap-4 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-800 hover:bg-emerald-100 transition">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-emerald-600"><i class="fas fa-file-pdf"></i></div>
                    <span class="font-bold">Generate Laporan</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection