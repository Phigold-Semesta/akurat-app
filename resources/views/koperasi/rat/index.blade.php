@extends('layouts.app')
@section('title', 'Manajemen Laporan RAT')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 md:p-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-emerald-900 tracking-tight">Riwayat Laporan RAT</h2>
            <p class="text-slate-500 mt-1">Sistem Pengawasan Koperasi - Dinas Perindustrian, Perdagangan, Koperasi dan UKM</p>
        </div>
        <a href="{{ route('koperasi.rat.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-8 rounded-2xl transition-all shadow-lg hover:shadow-emerald-500/30 flex items-center gap-2">
            <i class="fas fa-plus-circle"></i> Tambah Laporan
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-100 shadow-inner">
        <table class="w-full">
            <thead class="bg-slate-50 text-emerald-900 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs tracking-wider">Tahun Buku</th>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs tracking-wider">Tanggal RAT</th>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs tracking-wider">Tempat</th>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs tracking-wider">Peserta</th>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs tracking-wider">Dokumen</th>
                    <th class="px-6 py-5 text-right font-bold uppercase text-xs tracking-wider">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($data as $rat)
                <tr class="hover:bg-emerald-50/50 transition-colors duration-200">
                    <td class="px-6 py-5 font-bold text-slate-800">{{ $rat->tahun_buku }}</td>
                    <td class="px-6 py-5 text-slate-600">{{ \Carbon\Carbon::parse($rat->tgl_rat)->format('d M Y') }}</td>
                    <td class="px-6 py-5 text-slate-600">{{ $rat->tempat_rat }}</td>
                    <td class="px-6 py-5 text-slate-600">
                        <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full font-bold text-xs">{{ $rat->jumlah_peserta }} Peserta</span>
                    </td>
                    <td class="px-6 py-5">
                        @if($rat->file_dokumen)
                            <a href="{{ asset('storage/'.$rat->file_dokumen) }}" target="_blank" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-800 font-bold hover:underline">
                                <i class="fas fa-file-pdf"></i> Lihat PDF
                            </a>
                        @else
                            <span class="text-slate-300 text-sm italic">Tidak tersedia</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-right space-x-4">
                        <a href="{{ route('koperasi.rat.edit', $rat->id_rat) }}" class="text-amber-600 hover:text-amber-700 font-bold transition-all hover:underline">Edit</a>
                        <form action="{{ route('koperasi.rat.hapus', $rat->id_rat) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:text-red-700 font-bold transition-all hover:underline" onclick="return confirm('Anda yakin ingin menghapus laporan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-folder-open text-4xl mb-3 opacity-20"></i>
                            <p>Belum ada data laporan RAT yang diinputkan.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection