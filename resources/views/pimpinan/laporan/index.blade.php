@extends('layouts.app')
@section('title', 'Tinjau Laporan RAT')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-emerald-900 tracking-tight">Tinjau Laporan RAT</h2>
            <p class="text-slate-500 mt-1">Monitoring laporan RAT koperasi terverifikasi dan belum</p>
        </div>

        <div class="relative group">
            <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-8 rounded-2xl transition-all shadow-lg hover:shadow-emerald-500/30 flex items-center gap-2">
                <i class="fas fa-file-export"></i> Export Data <i class="fas fa-chevron-down text-xs ml-1"></i>
            </button>
            <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 hidden group-hover:block z-50">
                <a href="{{ route('pimpinan.export.pdf') }}" class="block px-4 py-3 text-slate-700 hover:bg-slate-50 font-bold rounded-t-xl transition-all">
                    <i class="fas fa-file-pdf text-red-600 mr-2"></i> Export PDF
                </a>
                
                <a href="{{ route('pimpinan.export.excel') }}" class="block px-4 py-3 text-slate-700 hover:bg-slate-50 font-bold rounded-b-xl transition-all">
    <i class="fas fa-file-excel text-green-600 mr-2"></i> Export Excel
</a>
            </div>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-100 shadow-inner">
        <table class="w-full">
            <thead class="bg-slate-50 text-emerald-900 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs">Koperasi</th>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs">Tahun Buku</th>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs">Status Verifikasi</th>
                    <th class="px-6 py-5 text-center font-bold uppercase text-xs">Dokumen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($data as $rat)
                <tr class="hover:bg-emerald-50/50 transition-colors duration-200">
                    <td class="px-6 py-5 font-bold text-slate-800">{{ $rat->nama_koperasi }}</td>
                    <td class="px-6 py-5 text-slate-600 font-semibold">{{ $rat->tahun_buku }}</td>
                    <td class="px-6 py-5">
                        @if($rat->status_verifikasi == 'terverifikasi')
                            <span class="bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-full font-bold text-xs">Terverifikasi</span>
                        @else
                            <span class="bg-amber-100 text-amber-700 px-4 py-1.5 rounded-full font-bold text-xs">Menunggu</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
                        <a href="{{ asset('storage/'.$rat->file_dokumen) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800 transition-all font-bold">
                            <i class="fas fa-eye text-lg"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                        <i class="fas fa-folder-open text-4xl mb-3 opacity-20"></i>
                        <p>Belum ada laporan RAT yang masuk.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection