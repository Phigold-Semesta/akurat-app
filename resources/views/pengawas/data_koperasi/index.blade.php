@extends('layouts.app')
@section('title', 'Data Koperasi')

@section('content')
<div class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 p-8">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-black text-emerald-900 dark:text-white uppercase tracking-widest">Data Koperasi Terdaftar</h2>
        <div class="bg-emerald-50 dark:bg-emerald-800 px-4 py-2 rounded-xl text-emerald-700 dark:text-emerald-100 font-bold text-xs uppercase">
            Total: {{ count($data) }} Koperasi
        </div>
    </div>
    
    <div class="overflow-hidden rounded-2xl border border-emerald-100">
        <table class="w-full">
            <thead class="bg-emerald-50 dark:bg-emerald-800 text-emerald-900 dark:text-emerald-100">
                <tr>
                    <th class="px-6 py-5 text-left uppercase text-xs font-bold">Nama Koperasi</th>
                    <th class="px-6 py-5 text-left uppercase text-xs font-bold">Kecamatan</th>
                    <th class="px-6 py-5 text-left uppercase text-xs font-bold">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-100 dark:divide-emerald-700 bg-white dark:bg-emerald-900">
                @forelse($data as $koperasi)
                <tr class="hover:bg-emerald-50 dark:hover:bg-emerald-700/50 transition-all">
                    <td class="px-6 py-5 font-bold text-slate-800 dark:text-slate-200">{{ $koperasi->nama_koperasi }}</td>
                    <td class="px-6 py-5 text-slate-600 dark:text-slate-400 text-sm">{{ $koperasi->kecamatan ?? '-' }}</td>
                    <td class="px-6 py-5">
                        <span class="px-3 py-1 rounded-full font-bold text-[10px] uppercase bg-emerald-100 text-emerald-700">
                            {{ $koperasi->status_koperasi }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-6 py-12 text-center text-slate-400">Belum ada data koperasi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection