@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-800">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <select class="p-3 rounded-xl border border-emerald-200 dark:bg-emerald-900 dark:border-emerald-700 dark:text-white">
                <option>Tahun: 2026</option>
            </select>
            <select class="p-3 rounded-xl border border-emerald-200 dark:bg-emerald-900 dark:border-emerald-700 dark:text-white">
                <option>Semua Kecamatan</option>
            </select>
            <input type="text" placeholder="Cari nama koperasi..." class="p-3 rounded-xl border border-emerald-200 dark:bg-emerald-900 dark:border-emerald-700 dark:text-white placeholder:dark:text-emerald-400">
            <button class="bg-emerald-600 text-white py-3 rounded-xl font-bold hover:bg-emerald-700 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i> Filter Data
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $summaries = [
                ['title' => 'Total Koperasi', 'value' => '245', 'cat' => 'Terdaftar di Sistem', 'icon' => 'fa-building', 'color' => 'emerald'],
                ['title' => 'Data Pengguna', 'value' => '82', 'cat' => 'Akun Aktif', 'icon' => 'fa-users', 'color' => 'blue'],
                ['title' => 'Laporan RAT', 'value' => '1.204', 'cat' => 'Tervalidasi', 'icon' => 'fa-file-invoice', 'color' => 'purple'],
                ['title' => 'Aktivitas Hari Ini', 'value' => '15', 'cat' => 'Log Sistem', 'icon' => 'fa-history', 'color' => 'orange'],
            ];
        @endphp
        @foreach($summaries as $item)
        <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl border border-emerald-100 dark:border-emerald-800 shadow-sm hover:shadow-md transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="text-sm font-bold text-emerald-900 dark:text-emerald-100">{{ $item['title'] }}</div>
                <i class="fas {{ $item['icon'] }} text-{{ $item['color'] }}-500"></i>
            </div>
            <div class="text-3xl font-black text-emerald-950 dark:text-white mb-1">{{ $item['value'] }}</div>
            <div class="text-xs font-bold text-{{ $item['color'] }}-600 uppercase tracking-wider">{{ $item['cat'] }}</div>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-800">
                <h3 class="font-black text-emerald-900 dark:text-white mb-4">Distribusi Kesehatan</h3>
                <canvas id="healthChart" class="w-full h-56"></canvas>
            </div>
            <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-800">
                <h3 class="font-black text-emerald-900 dark:text-white mb-4">Tren Aktivitas</h3>
                <canvas id="trendChart" class="w-full h-56"></canvas>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white dark:bg-emerald-950 p-6 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-800">
            <h3 class="font-black text-emerald-900 dark:text-white mb-6 uppercase italic">Log Aktivitas Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-emerald-900 dark:text-emerald-100">
                    <thead class="text-emerald-500 uppercase text-xs border-b dark:border-emerald-800">
                        <tr>
                            <th class="pb-4">User</th>
                            <th class="pb-4">Aksi</th>
                            <th class="pb-4">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-emerald-800">
                        <tr class="hover:bg-emerald-50 dark:hover:bg-emerald-900 transition-all">
                            <td class="py-4 font-bold">Admin Dinas</td>
                            <td class="py-4">Mengupdate Data Koperasi Karawang</td>
                            <td class="py-4 text-emerald-500">2 Menit Lalu</td>
                        </tr>
                        <tr class="hover:bg-emerald-50 dark:hover:bg-emerald-900 transition-all">
                            <td class="py-4 font-bold">Pengawas Lapangan</td>
                            <td class="py-4">Validasi RAT Koperasi Sejahtera</td>
                            <td class="py-4 text-emerald-500">1 Jam Lalu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart 1: Distribusi Kesehatan
    new Chart(document.getElementById('healthChart').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Sehat', 'Cukup Sehat', 'Tidak Sehat'],
            datasets: [{
                data: [120, 85, 40],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { color: '#94a3b8' } } } }
    });

    // Chart 2: Tren Aktivitas
    new Chart(document.getElementById('trendChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Aktivitas',
                data: [40, 55, 45, 60, 80, 75],
                borderColor: '#008f5d',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(0, 143, 93, 0.1)'
            }]
        },
        options: { 
            responsive: true, 
            plugins: { legend: { display: false } },
            scales: { y: { grid: { color: '#334155' }, ticks: { color: '#94a3b8' } }, x: { ticks: { color: '#94a3b8' } } }
        }
    });
</script>
@endsection