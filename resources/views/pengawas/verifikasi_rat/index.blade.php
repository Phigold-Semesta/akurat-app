@extends('layouts.app')
@section('title', 'Verifikasi RAT')

@section('content')
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
    <h2 class="text-2xl font-black text-emerald-900 mb-6 uppercase tracking-widest">Daftar Verifikasi RAT</h2>

    <div class="overflow-hidden rounded-2xl border border-slate-100">
        <table class="w-full">
            <thead class="bg-slate-50 text-emerald-900">
                <tr>
                    <th class="p-4 text-left uppercase text-xs font-bold">Koperasi</th>
                    <th class="p-4 text-left uppercase text-xs font-bold">Dokumen</th>
                    <th class="p-4 text-left uppercase text-xs font-bold">Status</th>
                    <th class="p-4 text-right uppercase text-xs font-bold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($data as $rat)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="p-4 font-bold text-slate-800">{{ $rat->nama_koperasi }}</td>
                    <td class="p-4">
                        <a href="{{ asset('storage/'.$rat->file_dokumen) }}" target="_blank" class="text-emerald-600 font-bold underline hover:text-emerald-800">
                            <i class="fas fa-file-pdf mr-1"></i> Buka PDF
                        </a>
                    </td>
                    <td class="p-4">
                        @if($rat->status_verifikasi == 'terverifikasi')
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full font-bold text-xs">Terverifikasi</span>
                        @else
                            <span class="bg-amber-100 text-amber-700 px-3 py-1 rounded-full font-bold text-xs">Menunggu</span>
                        @endif
                    </td>
                    <td class="p-4 text-right space-x-2">
                        @if($rat->status_verifikasi != 'terverifikasi')
                            <form action="{{ route('pengawas.rat.verifikasi', $rat->id_rat) }}" method="POST" class="inline verifikasi-form">
                                @csrf @method('PUT')
                                <button type="button" class="bg-emerald-600 text-white px-3 py-1 rounded-lg text-xs font-bold hover:bg-emerald-700 transition-all btn-verif">
                                    Verifikasi
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('koperasi.rat.hapus', $rat->id_rat) }}" method="POST" class="inline delete-form">
                            @csrf @method('DELETE')
                            <button type="button" class="bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-bold hover:bg-red-700 transition-all btn-delete">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-slate-400 italic">Belum ada data RAT yang perlu diverifikasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // 1. Notifikasi Sukses
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonColor: '#059669' });
    @endif

    // 2. Konfirmasi Verifikasi
    document.querySelectorAll('.btn-verif').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.verifikasi-form');
            Swal.fire({
                title: 'Verifikasi Laporan?',
                text: "Status akan berubah menjadi Terverifikasi.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                confirmButtonText: 'Ya, Verifikasi!'
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        });
    });

    // 3. Konfirmasi Hapus
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Yakin Hapus?',
                text: "Data yang dihapus tidak dapat dipulihkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        });
    });
</script>
@endsection