@extends('layouts.app')

@section('title', 'Dashboard Pimpinan')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-emerald-900 p-6 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800">
            <h3 class="text-emerald-600 dark:text-emerald-300 font-bold">Total Koperasi Terverifikasi</h3>
            <p class="text-4xl font-black mt-2">128</p>
        </div>
        <div class="bg-white dark:bg-emerald-900 p-6 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800">
            <h3 class="text-emerald-600 dark:text-emerald-300 font-bold">Laporan RAT Masuk</h3>
            <p class="text-4xl font-black mt-2">85</p>
        </div>
        <div class="bg-white dark:bg-emerald-900 p-6 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800">
            <h3 class="text-emerald-600 dark:text-emerald-300 font-bold">Status Kesehatan Rata-rata</h3>
            <p class="text-4xl font-black mt-2 text-yellow-500">Sehat</p>
        </div>
    </div>

    <div class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 overflow-hidden">
        <div class="p-6 border-b border-emerald-100 dark:border-emerald-800 flex justify-between items-center">
            <h2 class="font-black text-xl uppercase italic">Data Koperasi Terverifikasi</h2>
            <button class="bg-emerald-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-emerald-700 transition">
                <i class="fas fa-file-export mr-2"></i>Export Laporan
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-emerald-50 dark:bg-emerald-950/50">
                    <tr>
                        <th class="p-6 font-black uppercase text-sm">No</th>
                        <th class="p-6 font-black uppercase text-sm">Nama Koperasi</th>
                        <th class="p-6 font-black uppercase text-sm">Skor Akhir</th>
                        <th class="p-6 font-black uppercase text-sm">Kategori</th>
                        <th class="p-6 font-black uppercase text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-100 dark:divide-emerald-800">
                    <tr class="hover:bg-emerald-50/50 dark:hover:bg-emerald-800/20 transition">
                        <td class="p-6">1</td>
                        <td class="p-6 font-bold">Koperasi Serba Usaha Makmur</td>
                        <td class="p-6">95,20</td>
                        <td class="p-6"><span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs uppercase">Sangat Sehat</span></td>
                        <td class="p-6">
                            <button class="text-emerald-600 hover:text-emerald-800"><i class="fas fa-eye"></i></button>
                        </td>
                    </tr>
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endsection