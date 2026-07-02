@extends('layouts.app')
@section('title', 'Data Pengguna')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-black text-emerald-900 uppercase tracking-tighter mb-8">Data Pengguna</h2>
    <div class="bg-white rounded-3xl shadow-sm border border-emerald-100 p-8">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 uppercase text-[10px] font-black tracking-widest border-b border-emerald-50">
                    <th class="py-4">Nama</th>
                    <th class="py-4">Email</th>
                    <th class="py-4">Role</th>
                </tr>
            </thead>
            <tbody class="font-bold text-emerald-900">
                @foreach($users as $user)
                <tr class="border-b border-emerald-50">
                    {{-- Perbaikan: Pastikan properti sesuai dengan kolom database Anda --}}
                    {{-- Jika tabel Anda menggunakan 'nama_lengkap' atau 'username', ganti bagian $user->name --}}
                    <td class="py-6">{{ $user->nama ?? $user->username ?? 'N/A' }}</td>
                    <td class="py-6">{{ $user->email }}</td>
                    <td class="py-6 text-emerald-600">{{ $user->role }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection