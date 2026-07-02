@extends('layouts.app')
@section('title', 'Dashboard Pimpinan')

@section('content')
<div class="space-y-8">
    <!-- Statistik Dinamis -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $stats = [
                ['title' => 'Total Koperasi Terverifikasi', 'value' => $totalTerverifikasi, 'icon' => 'fa-check-double', 'color' => 'emerald'],
                ['title' => 'Laporan RAT Masuk', 'value' => $totalRAT, 'icon' => 'fa-file-invoice', 'color' => 'blue'],
                ['title' => 'Skor Kesehatan Rata-rata', 'value' => number_format($skorRataRata, 2), 'icon' => 'fa-heartbeat', 'color' => 'yellow'],
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="bg-white dark:bg-emerald-950 p-6 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-{{ $stat['color'] }}-600">
                <i class="fas {{ $stat['icon'] }} text-xl"></i>
            </div>
            <div>
                <p class="text-emerald-600 font-bold text-xs uppercase tracking-widest">{{ $stat['title'] }}</p>
                <p class="text-3xl font-black text-emerald-950 dark:text-white">{{ $stat['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Chart & Tabel -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-emerald-950 p-8 rounded-3xl shadow-sm border">
            <h2 class="font-black uppercase italic mb-6">Distribusi Kesehatan</h2>
            <canvas id="healthChart"></canvas>
        </div>
        <div class="lg:col-span-2 bg-white dark:bg-emerald-950 p-8 rounded-3xl shadow-sm border">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="p-4 font-black uppercase text-xs text-emerald-600">Nama Koperasi</th>
                        <th class="p-4 font-black uppercase text-xs text-emerald-600">Skor</th>
                        <th class="p-4 font-black uppercase text-xs text-emerald-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($koperasiList as $item)
                    <tr>
                        <td class="p-4 font-bold">{{ $item->nama_koperasi }}</td>
                        <td class="p-4 font-bold text-emerald-600">{{ $item->skor_pemkes }}</td>
                        <td class="p-4"><span class="px-3 py-1 rounded-full bg-emerald-100 text-xs font-bold">{{ $item->status_kesehatan }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const healthCtx = document.getElementById('healthChart').getContext('2d');
    new Chart(healthCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($distribusi->pluck('status_kesehatan')) !!},
            datasets: [{
                data: {!! json_encode($distribusi->pluck('total')) !!},
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
            }]
        }
    });
</script>
@endsection