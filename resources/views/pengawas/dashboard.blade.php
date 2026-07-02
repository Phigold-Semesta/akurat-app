@extends('layouts.app')
@section('title', 'Dashboard Pengawas')

@section('content')
<div class="space-y-6">
    <!-- Statistik Kartu (Dinamis) -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $stats = [
                ['title' => 'Rata-rata Skor', 'value' => number_format($skorRataRata, 2), 'cat' => $statusRataRata, 'icon' => 'fa-chart-line', 'color' => 'emerald'],
                ['title' => 'Skor Tertinggi', 'value' => number_format($skorTertinggi, 2), 'cat' => 'Sangat Sehat', 'icon' => 'fa-trophy', 'color' => 'blue'],
                ['title' => 'Total Koperasi', 'value' => $totalKoperasi, 'cat' => 'Terdaftar di Sistem', 'icon' => 'fa-building', 'color' => 'yellow'],
                ['title' => 'Total Dinilai', 'value' => $totalDinilai, 'cat' => 'Koperasi Terverifikasi', 'icon' => 'fa-check-double', 'color' => 'purple'],
            ];
        @endphp
        @foreach($stats as $item)
        <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl border border-emerald-100 dark:border-emerald-800 shadow-sm">
            <div class="flex justify-between items-start mb-4">
                <div class="text-sm font-bold text-emerald-900 dark:text-emerald-100">{{ $item['title'] }}</div>
                <i class="fas {{ $item['icon'] }} text-{{ $item['color'] }}-500"></i>
            </div>
            <div class="text-3xl font-black text-emerald-950 dark:text-white mb-1">{{ $item['value'] }}</div>
            <div class="text-xs font-bold text-{{ $item['color'] }}-600 uppercase">{{ $item['cat'] }}</div>
        </div>
        @endforeach
    </div>

    <!-- Chart & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-800">
                <h3 class="font-black text-emerald-900 dark:text-white mb-4">Distribusi Kesehatan</h3>
                <canvas id="healthChart" class="w-full h-56"></canvas>
            </div>
            <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-800">
                <h3 class="font-black text-emerald-900 dark:text-white mb-4">Tren Skor Bulanan</h3>
                <canvas id="trendChart" class="w-full h-56"></canvas>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white dark:bg-emerald-950 p-6 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-800">
            <h3 class="font-black text-emerald-900 dark:text-white mb-6">Daftar Hasil Penilaian Koperasi</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-emerald-900 dark:text-emerald-100">
                    <thead class="text-emerald-500 uppercase text-xs border-b dark:border-emerald-800">
                        <tr>
                            <th class="pb-4">No</th>
                            <th class="pb-4">Nama Koperasi</th>
                            <th class="pb-4">Skor</th>
                            <th class="pb-4">Status</th>
                            <th class="pb-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-emerald-800">
                        @foreach($koperasiList as $index => $item)
                        <tr class="hover:bg-emerald-50 dark:hover:bg-emerald-900 transition-all">
                            <td class="py-4">{{ $index + 1 }}</td>
                            <td class="py-4 font-bold">{{ $item->nama_koperasi }}</td>
                            <td class="py-4 font-bold">{{ number_format($item->skor_pemkes, 2) }}</td>
                            <td class="py-4"><span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-full text-[10px] font-bold">{{ $item->status_kesehatan }}</span></td>
                            <td class="py-4"><a href="#"><i class="fas fa-eye text-emerald-600 dark:text-emerald-400 cursor-pointer"></i></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const healthCtx = document.getElementById('healthChart').getContext('2d');
    new Chart(healthCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($distribusiLabels) !!},
            datasets: [{
                data: {!! json_encode($distribusiData) !!},
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });

    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($trendLabels) !!},
            datasets: [{
                data: {!! json_encode($trendData) !!},
                borderColor: '#10b981',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(16, 185, 129, 0.1)'
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });
</script>
@endsection