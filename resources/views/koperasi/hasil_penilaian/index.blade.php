@extends('layouts.app_koperasi')
@section('title', 'Hasil Penilaian')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-black text-emerald-900 dark:text-white uppercase tracking-tighter">Hasil Penilaian RAT</h2>
        <p class="text-emerald-600 font-bold uppercase tracking-widest text-sm">Daftar sertifikat hasil penilaian kesehatan koperasi</p>
    </div>

    <!-- Tabel Hasil -->
    <div class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 p-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 uppercase text-[10px] font-black tracking-widest border-b border-emerald-50 dark:border-emerald-800">
                        <th class="py-4 px-2">Tahun</th>
                        <th class="py-4 px-2">Skor PEMKES</th>
                        <th class="py-4 px-2">Status</th>
                        <th class="py-4 px-2">Catatan</th>
                        <th class="py-4 px-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-emerald-900 dark:text-emerald-50 font-bold">
                    @forelse($hasil as $item)
                        <tr class="border-b border-emerald-50 dark:border-emerald-800 hover:bg-emerald-50/50 dark:hover:bg-emerald-800/30 transition-all">
                            <td class="py-6 px-2">{{ $item->tahun_penilaian }}</td>
                            <td class="py-6 px-2 text-emerald-600">{{ $item->skor_pemkes }}</td>
                            <td class="py-6 px-2">
                                <span class="px-3 py-1 rounded-full text-[10px] uppercase {{ $item->status_kesehatan == 'Sehat' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $item->status_kesehatan }}
                                </span>
                            </td>
                            <td class="py-6 px-2 text-sm text-slate-600 dark:text-slate-400 font-medium">{{ $item->catatan_jpfk }}</td>
                            <td class="py-6 px-2 text-center">
                                @if(!empty($item->file_sertifikat))
                                    <a href="{{ route('koperasi.unduh-sertifikat', $item->id_pemkes) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-emerald-500/20">
                                        <i class="fas fa-download"></i> Unduh
                                    </a>
                                @else
                                    <span class="text-[10px] text-slate-400 uppercase italic">Belum Tersedia</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center font-bold text-slate-400">Belum ada hasil penilaian yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection