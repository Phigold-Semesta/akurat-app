@extends('layouts.app_koperasi')
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
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs">Tahun</th>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs">Tanggal</th>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs">Tempat</th>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs">Peserta</th>
                    <th class="px-6 py-5 text-left font-bold uppercase text-xs">Dokumen</th>
                    <th class="px-6 py-5 text-right font-bold uppercase text-xs">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($data ?? [] as $rat)
                <tr class="hover:bg-emerald-50/50 transition-colors duration-200">
                    <td class="px-6 py-5 font-bold text-slate-800">{{ $rat->tahun_buku ?? '-' }}</td>
                    <td class="px-6 py-5 text-slate-600">
                        {{ isset($rat->tgl_rat) ? \Carbon\Carbon::parse($rat->tgl_rat)->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-5 text-slate-600">{{ $rat->tempat_rat ?? '-' }}</td>
                    <td class="px-6 py-5 text-slate-600">{{ $rat->jumlah_peserta ?? 0 }} Peserta</td>
                    <td class="px-6 py-5">
                        @if(!empty($rat->file_dokumen))
                            <a href="{{ asset('storage/'.$rat->file_dokumen) }}" target="_blank" class="text-emerald-600 hover:text-emerald-800 font-bold">
                                <i class="fas fa-file-pdf mr-1"></i> Lihat PDF
                            </a>
                        @else
                            <span class="text-slate-300 text-sm italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-right space-x-2">
                        <a href="{{ route('koperasi.rat.edit', ['id' => $rat->id_rat]) }}" class="bg-amber-100 text-amber-700 hover:bg-amber-200 px-4 py-2 rounded-lg font-bold text-sm transition-all">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('koperasi.rat.hapus', ['id' => $rat->id_rat]) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="bg-red-100 text-red-700 hover:bg-red-200 px-4 py-2 rounded-lg font-bold text-sm transition-all" onclick="return confirm('Yakin ingin menghapus?')">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-folder-open text-4xl mb-3 opacity-20"></i>
                            <p>Data laporan RAT belum tersedia untuk koperasi Anda.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection