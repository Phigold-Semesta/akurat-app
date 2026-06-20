\@extends('layouts.app')

@section('title', 'Dashboard Pimpinan')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $stats = [
                ['title' => 'Total Koperasi Terverifikasi', 'value' => '128', 'icon' => 'fa-check-double', 'color' => 'emerald'],
                ['title' => 'Laporan RAT Masuk', 'value' => '85', 'icon' => 'fa-file-invoice', 'color' => 'blue'],
                ['title' => 'Status Kesehatan Rata-rata', 'value' => 'Sehat', 'icon' => 'fa-heartbeat', 'color' => 'yellow'],
            ];
        @endphp
        @foreach($stats as $stat)
        <div class="bg-white dark:bg-emerald-950 p-6 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900 flex items-center justify-center text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400">
                <i class="fas {{ $stat['icon'] }} text-xl"></i>
            </div>
            <div>
                <p class="text-emerald-600 dark:text-emerald-400 font-bold text-xs uppercase tracking-widest">{{ $stat['title'] }}</p>
                <p class="text-3xl font-black text-emerald-950 dark:text-white">{{ $stat['value'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white dark:bg-emerald-950 p-8 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800">
            <h2 class="font-black text-lg uppercase italic mb-6">Distribusi Kesehatan</h2>
            <div class="relative h-64">
                <canvas id="healthChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white dark:bg-emerald-950 p-8 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800">
            <h2 class="font-black text-lg uppercase italic mb-6">Tren Performa Bulanan</h2>
            <div class="relative h-64">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-emerald-950 rounded-3xl shadow-sm border border-emerald-100 dark:border-emerald-800 overflow-hidden">
        <div class="p-8 border-b border-emerald-100 dark:border-emerald-800 flex justify-between items-center">
            <h2 class="font-black text-xl uppercase italic">Data Koperasi Terverifikasi</h2>
            <button class="bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20">
                <i class="fas fa-file-export mr-2"></i>Export Laporan
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-emerald-50/50 dark:bg-emerald-900/30">
                    <tr>
                        <th class="p-6 font-black uppercase text-xs text-emerald-600">No</th>
                        <th class="p-6 font-black uppercase text-xs text-emerald-600">Nama Koperasi</th>
                        <th class="p-6 font-black uppercase text-xs text-emerald-600">Skor Akhir</th>
                        <th class="p-6 font-black uppercase text-xs text-emerald-600">Status</th>
                        <th class="p-6 font-black uppercase text-xs text-emerald-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-100 dark:divide-emerald-800">
                    <tr class="hover:bg-emerald-50/50 dark:hover:bg-emerald-900/20 transition">
                        <td class="p-6 font-bold">1</td>
                        <td class="p-6 font-bold">Koperasi Serba Usaha Makmur</td>
                        <td class="p-6 font-bold text-emerald-600">95,20</td>
                        <td class="p-6"><span class="px-4 py-1.5 rounded-full bg-emerald-100 dark:bg-emerald-800 text-emerald-700 dark:text-emerald-300 font-bold text-[10px] uppercase tracking-wider">Sangat Sehat</span></td>
                        <td class="p-6"><button class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-800 text-emerald-600 hover:bg-emerald-600 hover:text-white transition-all"><i class="fas fa-eye"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Hancurkan instance lama jika ada (mencegah duplikasi saat navigasi SPA)
        if (window.healthChartInstance) window.healthChartInstance.destroy();
        if (window.trendChartInstance) window.trendChartInstance.destroy();

        // 1. Doughnut Chart
        const healthCtx = document.getElementById('healthChart').getContext('2d');
        window.healthChartInstance = new Chart(healthCtx, {
            type: 'doughnut',
            data: {
                labels: ['Sehat', 'Cukup', 'Kurang'],
                datasets: [{
                    data: [70, 20, 10],
                    backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } } 
            }
        });

        // 2. Line Chart
        const trendCtx = document.getElementById('trendChart').getContext('2d');
        window.trendChartInstance = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                datasets: [{
                    label: 'Skor Rata-rata',
                    data: [75, 78, 80, 82, 85, 88],
                    borderColor: '#008f5d',
                    backgroundColor: 'rgba(0, 143, 93, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: false } }
            }
        });
    });
</script>
@endsection