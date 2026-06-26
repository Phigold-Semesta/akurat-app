@extends('layouts.app')
@section('title', 'Manajemen Laporan RAT')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-emerald-100 p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-black text-emerald-900 uppercase tracking-tight">Riwayat RAT</h2>
            <p class="text-sm text-gray-500">Kelola dokumen rapat anggota tahunan Anda</p>
        </div>
        <a href="{{ route('koperasi.rat.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-md">
            + Tambah Laporan
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-emerald-50 text-emerald-800">
                <tr>
                    <th class="p-4 text-left font-black rounded-l-xl">Tahun</th>
                    <th class="p-4 text-left font-black">Tanggal RAT</th>
                    <th class="p-4 text-left font-black">Tempat</th>
                    <th class="p-4 text-left font-black">Peserta</th>
                    <th class="p-4 text-left font-black">Dokumen</th>
                    <th class="p-4 text-right font-black rounded-r-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $rat)
                <tr class="hover:bg-emerald-50/30">
                    <td class="p-4 font-bold text-slate-800">{{ $rat->tahun_buku }}</td>
                    <td class="p-4 text-slate-600">{{ $rat->tgl_rat }}</td>
                    <td class="p-4 text-slate-600">{{ $rat->tempat_rat }}</td>
                    <td class="p-4 text-slate-600">{{ $rat->jumlah_peserta }} Orang</td>
                    <td class="p-4">
                        @if($rat->file_dokumen)
                            <a href="{{ asset('storage/'.$rat->file_dokumen) }}" target="_blank" class="text-emerald-600 font-bold hover:underline">Lihat PDF</a>
                        @else
                            <span class="text-gray-400 text-sm italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="p-4 text-right space-x-2">
                        <a href="{{ route('koperasi.rat.edit', $rat->id_rat) }}" class="text-amber-600 font-bold hover:underline">Edit</a>
                        <form action="{{ route('koperasi.rat.hapus', $rat->id_rat) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600 font-bold hover:underline" onclick="return confirm('Hapus data?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500 italic">Belum ada data laporan RAT yang diinput.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection