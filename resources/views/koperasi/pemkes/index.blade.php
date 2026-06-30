@extends('layouts.app')
@section('title', 'Input PEMKES')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-emerald-900 dark:text-white uppercase tracking-tighter">Data PEMKES</h2>
        <p class="text-emerald-600 font-bold uppercase tracking-widest text-sm">Input Penilaian Kesehatan Koperasi</p>
    </div>

    <div class="bg-white dark:bg-emerald-900 rounded-3xl shadow-sm border border-emerald-100 p-10">
        @if(session('success'))
            <div class="bg-emerald-100 text-emerald-800 p-4 rounded-2xl font-bold mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(!$rat)
            <div class="bg-amber-50 text-amber-800 p-6 rounded-2xl border border-amber-200 font-bold">
                Perhatian: Anda harus memiliki data RAT terlebih dahulu sebelum dapat menginput PEMKES.
            </div>
        @else
            <form action="{{ route('koperasi.pemkes.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_rat" value="{{ $rat->id_rat }}">
                
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-slate-50 dark:bg-emerald-800 rounded-2xl">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tahun Buku</p>
                            <p class="font-bold text-slate-800 dark:text-white">{{ $rat->tahun_buku }}</p>
                        </div>
                        <div class="p-4 bg-slate-50 dark:bg-emerald-800 rounded-2xl">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Tempat RAT</p>
                            <p class="font-bold text-slate-800 dark:text-white">{{ $rat->tempat_rat }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Skor PEMKES (0-100)</label>
                        <input type="number" name="skor_pemkes" min="0" max="100" class="w-full p-4 mt-2 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 bg-slate-50 font-bold" placeholder="Masukkan angka 0-100" required>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest ml-1">Catatan JPFK</label>
                        <textarea name="catatan_jpfk" rows="4" class="w-full p-4 mt-2 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-emerald-500 bg-slate-50 font-bold" placeholder="Masukkan catatan hasil pemeriksaan..." required></textarea>
                    </div>

                    <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black hover:bg-emerald-700 transition-all shadow-lg hover:shadow-emerald-500/20 uppercase tracking-widest">
                        Simpan Data PEMKES
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection