@extends('layouts.app')
@section('title', 'Tambah RAT')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-emerald-100 p-8">
    <h2 class="text-xl font-black text-emerald-900 mb-6 uppercase tracking-widest">Input Data RAT Baru</h2>
    
    <form action="{{ route('koperasi.rat.simpan') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-emerald-800 mb-2">Tahun Buku</label>
                <input type="number" name="tahun_buku" class="w-full p-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-emerald-800 mb-2">Tanggal RAT</label>
                <input type="date" name="tgl_rat" class="w-full p-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500" required>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-bold text-emerald-800 mb-2">Tempat RAT</label>
            <input type="text" name="tempat_rat" class="w-full p-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500" required>
        </div>
        
        <div>
            <label class="block text-sm font-bold text-emerald-800 mb-2">Jumlah Peserta</label>
            <input type="number" name="jumlah_peserta" class="w-full p-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500" required>
        </div>
        
        <div>
            <label class="block text-sm font-bold text-emerald-800 mb-2">Upload Dokumen (PDF)</label>
            <input type="file" name="file_dokumen" accept=".pdf" class="w-full p-3 rounded-xl border border-gray-200" required>
        </div>
        
        <div>
            <label class="block text-sm font-bold text-emerald-800 mb-2">Hasil RAT</label>
            <textarea name="hasil_rat" class="w-full p-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500" rows="4"></textarea>
        </div>

        <button type="submit" class="w-full bg-emerald-900 text-white font-black py-4 rounded-xl hover:bg-emerald-800 transition-all shadow-lg">
            SIMPAN DATA
        </button>
    </form> 
    </div>
@endsection