@extends('layouts.app')
@section('title', 'Profil Pimpinan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-10 relative">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-extrabold text-emerald-900 tracking-tight">Profil Pimpinan</h2>
                <p class="text-slate-500 mt-1">Kelola informasi data diri dan akun pimpinan</p>
            </div>
            <button onclick="document.getElementById('editModal').classList.remove('hidden')" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold transition shadow-lg flex items-center gap-2">
                <i class="fas fa-edit"></i> Edit Profil
            </button>
        </div>

        @if($profil)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Nama Pimpinan</label>
                        <p class="text-lg font-bold text-emerald-900">{{ $profil->nama_pimpinan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Jabatan</label>
                        <p class="text-sm font-semibold text-slate-600">{{ $profil->jabatan ?? '-' }}</p>
                    </div>
                </div>
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">No. Telepon / WhatsApp</label>
                        <p class="text-sm font-semibold text-slate-600">{{ $profil->no_telp ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Status Akun</label>
                        <div class="mt-1">
                            <span class="bg-emerald-100 text-emerald-700 px-4 py-1.5 rounded-full font-bold text-xs">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12 text-slate-400">
                <i class="fas fa-user-slash text-4xl mb-3 opacity-20"></i>
                <p>Data profil pimpinan belum tersedia di database.</p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Edit Profil -->
<div id="editModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl">
        <h3 class="text-xl font-black text-emerald-900 mb-6 uppercase">Edit Profil Pimpinan</h3>
        
        <form action="{{ route('pimpinan.profil.update') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Pimpinan</label>
                <input type="text" name="nama_pimpinan" value="{{ $profil->nama_pimpinan ?? '' }}" class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-600 outline-none font-semibold" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jabatan</label>
                <input type="text" name="jabatan" value="{{ $profil->jabatan ?? '' }}" class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-600 outline-none font-semibold" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">No. Telepon / WhatsApp</label>
                <input type="text" name="no_telp" value="{{ $profil->no_telp ?? '' }}" class="w-full p-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-emerald-600 outline-none font-semibold" required>
            </div>
            <div class="flex gap-4 mt-6">
                <button type="button" onclick="document.getElementById('editModal').classList.add('hidden')" class="flex-1 py-3 bg-slate-100 hover:bg-slate-200 rounded-xl font-bold transition">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-bold transition shadow-lg">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 Notifikasi Sukses -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#059669'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
    </script>
@endif
@endsection