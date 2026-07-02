@extends('layouts.app')
@section('title', 'Data Koperasi')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-black text-emerald-900 uppercase tracking-tighter mb-8">Data Koperasi</h2>
    <div class="bg-white rounded-3xl shadow-sm border border-emerald-100 p-8">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 uppercase text-[10px] font-black tracking-widest border-b border-emerald-50">
                    <th class="py-4">Nama Koperasi</th>
                    <th class="py-4">Badan Hukum</th>
                    <th class="py-4">Ketua</th>
                </tr>
            </thead>
            <tbody class="font-bold text-emerald-900">
                @foreach($koperasi as $item)
                <tr class="border-b border-emerald-50">
                    <td class="py-6">{{ $item->nama_koperasi }}</td>
                    <td class="py-6">{{ $item->no_badan_hukum }}</td>
                    <td class="py-6">{{ $item->ketua }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection