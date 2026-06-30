@extends('layouts.app')
@section('title', 'Profil Pengawas')

@section('content')
<style>[x-cloak] { display: none !important; }</style>

<div x-data="{ showEditModal: false }" class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 p-10">
        <div class="flex justify-between items-start mb-10">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 bg-emerald-600 rounded-full flex items-center justify-center text-white text-3xl font-black shadow-lg">
                    {{ substr($pengawas->nama_pengawas ?? 'P', 0, 1) }}
                </div>
                <div>
                    <h2 class="text-3xl font-black text-emerald-900 dark:text-white uppercase tracking-tighter">{{ $pengawas->nama_pengawas ?? 'Data Belum Lengkap' }}</h2>
                    <p class="text-emerald-600 font-bold uppercase tracking-widest text-sm">{{ $pengawas->jabatan ?? 'Jabatan Belum Diatur' }}</p>
                </div>
            </div>
            <button @click="showEditModal = true" class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-lg hover:shadow-emerald-500/20">
                Edit Profil
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="p-6 bg-slate-50 dark:bg-emerald-800 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Telepon</p>
                <p class="font-bold text-slate-800 dark:text-white">{{ $pengawas->no_telp ?? '-' }}</p>
            </div>
            <div class="p-6 bg-slate-50 dark:bg-emerald-800 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Wilayah Tugas</p>
                <p class="font-bold text-slate-800 dark:text-white">{{ $pengawas->wilayah_tugas ?? '-' }}</p>
            </div>
            <div class="p-6 bg-slate-50 dark:bg-emerald-800 rounded-2xl border border-slate-100">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Jabatan</p>
                <p class="font-bold text-slate-800 dark:text-white">{{ $pengawas->jabatan ?? '-' }}</p>
            </div>
        </div>
    </div>

    <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4" x-cloak>
        <div class="bg-white dark:bg-emerald-800 rounded-3xl p-8 w-full max-w-lg shadow-2xl transform transition-all">
            <h3 class="text-xl font-black mb-6 uppercase tracking-tighter text-emerald-900 dark:text-white">Edit Profil Pengawas</h3>
            
            <form action="{{ route('pengawas.profil.update') }}" method="POST">
                @csrf 
                @method('PUT')
                <div class="space-y-4">
                    <label class="text-xs font-bold text-slate-500">Nama Lengkap</label>
                    <input type="text" name="nama_pengawas" value="{{ old('nama_pengawas', $pengawas->nama_pengawas ?? '') }}" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                    
                    <label class="text-xs font-bold text-slate-500">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $pengawas->jabatan ?? '') }}" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                    
                    <label class="text-xs font-bold text-slate-500">Nomor Telepon</label>
                    <input type="text" name="no_telp" value="{{ old('no_telp', $pengawas->no_telp ?? '') }}" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                    
                    <label class="text-xs font-bold text-slate-500">Wilayah Tugas</label>
                    <input type="text" name="wilayah_tugas" value="{{ old('wilayah_tugas', $pengawas->wilayah_tugas ?? '') }}" class="w-full p-4 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 bg-slate-50" required>
                </div>
                
                <div class="flex gap-3 mt-8">
                    <button type="button" @click="showEditModal = false" class="flex-1 py-3 bg-slate-100 dark:bg-emerald-700 rounded-xl font-bold hover:bg-slate-200 transition-all">Batal</button>
                    <button type="submit" class="flex-1 py-3 bg-emerald-600 text-white rounded-xl font-bold hover:bg-emerald-700 transition-all shadow-lg">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection