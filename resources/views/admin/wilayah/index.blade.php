@extends('layouts.app')
@section('title', 'Data Wilayah')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="text-3xl font-black text-emerald-900 uppercase tracking-tighter mb-8">Data Wilayah</h2>
    
    <div class="mb-8">
        <div id="map" class="h-96 w-full rounded-3xl border-4 border-emerald-100 shadow-xl bg-emerald-50"></div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-emerald-100 p-8">
        <table class="w-full text-left">
            <thead>
                <tr class="text-slate-400 uppercase text-[10px] font-black tracking-widest border-b border-emerald-50">
                    <th class="py-4">No</th>
                    <th class="py-4">Nama Kecamatan</th>
                </tr>
            </thead>
            <tbody class="font-bold text-emerald-900">
                @foreach($wilayah as $index => $item)
                <tr class="border-b border-emerald-50">
                    <td class="py-6">{{ $index + 1 }}</td>
                    <td class="py-6">{{ $item->kecamatan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi peta pada koordinat Karawang
        var map = L.map('map').setView([-6.315, 107.29], 11);
        
        // Menambahkan layer peta dari OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Placeholder untuk marker (integrasikan dengan GeoJSON nanti)
        L.marker([-6.315, 107.29]).addTo(map)
            .bindPopup("Pusat Wilayah Karawang");
    });
</script>
@endsection