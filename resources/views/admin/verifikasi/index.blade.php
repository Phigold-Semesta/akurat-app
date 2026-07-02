@extends('layouts.app')
@section('title', 'Verifikasi PEMKES')

@section('content')
<div class="max-w-7xl mx-auto" x-data="{ openModal: false, selectedId: null }">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-emerald-900 dark:text-white uppercase tracking-tighter">Verifikasi Penilaian</h2>
        <p class="text-emerald-600 font-bold uppercase tracking-widest text-sm">Daftar koperasi yang menunggu persetujuan</p>
    </div>

    <div class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 p-8">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 uppercase text-[10px] font-black tracking-widest border-b border-emerald-50 dark:border-emerald-800">
                    <th class="py-4 px-2">Nama Koperasi</th>
                    <th class="py-4 px-2">Tahun</th>
                    <th class="py-4 px-2">Skor</th>
                    <th class="py-4 px-2">Status</th>
                    <th class="py-4 px-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-bold text-emerald-900 dark:text-emerald-50">
                @foreach($data as $item)
                <tr class="border-b border-emerald-50 dark:border-emerald-800 hover:bg-emerald-50/50">
                    <td class="py-6 px-2">{{ $item->nama_koperasi }}</td>
                    <td class="py-6 px-2">{{ $item->tahun_buku }}</td>
                    <td class="py-6 px-2 text-emerald-600">{{ $item->skor_pemkes }}</td>
                    <td class="py-6 px-2">
                        <span class="px-3 py-1 rounded-full text-[10px] uppercase {{ $item->status_kesehatan == 'Dalam Proses' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                            {{ $item->status_kesehatan }}
                        </span>
                    </td>
                    <td class="py-6 px-2 text-center">
                        <button @click="openModal = true; selectedId = {{ $item->id_pemkes }}" 
                                class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold transition-all shadow-lg">
                            Verifikasi
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" x-cloak>
        <div class="bg-white dark:bg-emerald-900 p-8 rounded-3xl w-full max-w-md shadow-2xl">
            <h3 class="text-xl font-black uppercase mb-6">Pilih Status Verifikasi</h3>
            
            <form :action="'{{ route('admin.verifikasi.proses', ':id') }}'.replace(':id', selectedId)" method="POST">
                @csrf
                <div class="space-y-4">
                    <select name="status" class="w-full p-4 border rounded-2xl font-bold bg-slate-50 dark:bg-emerald-800" required>
                        <option value="Sehat">Sehat</option>
                        <option value="Cukup Sehat">Cukup Sehat</option>
                        <option value="Dalam Pengawasan">Dalam Pengawasan</option>
                    </select>
                    <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black hover:bg-emerald-700 uppercase tracking-widest">
                        Konfirmasi & Generate Sertifikat
                    </button>
                    <button type="button" @click="openModal = false" class="w-full py-4 text-slate-400 font-bold uppercase tracking-widest">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection