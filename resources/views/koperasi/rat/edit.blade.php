@extends('layouts.app_koperasi')
@section('title', 'Edit RAT')

@section('content')
<div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-emerald-100 p-8">
    <a href="{{ route('koperasi.input-rat') }}" class="inline-flex items-center text-emerald-700 font-bold mb-6 hover:text-emerald-900 transition-all">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
    </a>

    <h2 class="text-xl font-black text-emerald-900 mb-6 uppercase tracking-widest">Edit Data RAT</h2>
    
    <form action="{{ route('koperasi.rat.update', $rat->id_rat) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-emerald-800 mb-2">Tahun Buku</label>
                <input type="number" name="tahun_buku" value="{{ $rat->tahun_buku }}" class="w-full p-3 rounded-xl border border-gray-200" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-emerald-800 mb-2">Tanggal RAT</label>
                <input type="date" name="tgl_rat" value="{{ $rat->tgl_rat }}" class="w-full p-3 rounded-xl border border-gray-200" required>
            </div>
        </div>
        <div>
            <label class="block text-sm font-bold text-emerald-800 mb-2">Tempat RAT</label>
            <input type="text" name="tempat_rat" value="{{ $rat->tempat_rat }}" class="w-full p-3 rounded-xl border border-gray-200" required>
        </div>
        <div>
            <label class="block text-sm font-bold text-emerald-800 mb-2">Jumlah Peserta</label>
            <input type="number" name="jumlah_peserta" value="{{ $rat->jumlah_peserta }}" class="w-full p-3 rounded-xl border border-gray-200" required>
        </div>
        <div>
            <label class="block text-sm font-bold text-emerald-800 mb-2">Ganti Dokumen (Opsional)</label>
            <input type="file" name="file_dokumen" accept=".pdf" class="w-full p-3 rounded-xl border border-gray-200">
            <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak ingin mengubah file lama.</p>
        </div>
        <div>
            <label class="block text-sm font-bold text-emerald-800 mb-2">Hasil RAT</label>
            <textarea name="hasil_rat" class="w-full p-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-emerald-500" rows="4">{{ $rat->hasil_rat }}</textarea>
        </div>
        <button class="w-full bg-emerald-600 text-white font-black py-4 rounded-xl shadow-lg hover:bg-emerald-700 transition-all">UPDATE DATA</button>
    </form>
</div>
@endsection