@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-800">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <select class="p-3 rounded-xl border border-emerald-200 dark:bg-emerald-900 dark:border-emerald-700 dark:text-white">
                <option>2025</option>
            </select>
            <select class="p-3 rounded-xl border border-emerald-200 dark:bg-emerald-900 dark:border-emerald-700 dark:text-white">
                <option>Semua Kecamatan</option>
            </select>
            <input type="text" placeholder="Cari nama koperasi..." class="p-3 rounded-xl border border-emerald-200 dark:bg-emerald-900 dark:border-emerald-700 dark:text-white placeholder:dark:text-emerald-400">
            <button class="bg-emerald-600 text-white py-3 rounded-xl font-bold hover:bg-emerald-700 transition-all flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $summaries = [
                ['title' => 'Rata-rata Skor', 'value' => '78,45', 'cat' => 'Cukup Sehat', 'icon' => 'fa-chart-line', 'color' => 'emerald'],
                ['title' => 'Skor Tertinggi', 'value' => '95,20', 'cat' => 'Sangat Sehat', 'icon' => 'fa-trophy', 'color' => 'blue'],
                ['title' => 'Skor Terendah', 'value' => '45,30', 'cat' => 'Tidak Sehat', 'icon' => 'fa-exclamation-triangle', 'color' => 'yellow'],
                ['title' => 'Total Dinilai', 'value' => '75', 'cat' => '58.6% dari 128', 'icon' => 'fa-building', 'color' => 'purple'],
            ];
        @endphp
        @foreach($summaries as $item)
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
                        @for($i=1; $i<=8; $i++)
                        <tr class="hover:bg-emerald-50 dark:hover:bg-emerald-900 transition-all">
                            <td class="py-4">{{ $i }}</td>
                            <td class="py-4 font-bold">Koperasi Contoh {{ $i }}</td>
                            <td class="py-4 font-bold">75,00</td>
                            <td class="py-4"><span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-full text-[10px] font-bold">Sudah Dinilai</span></td>
                            <td class="py-4"><i class="fas fa-eye text-emerald-600 dark:text-emerald-400 cursor-pointer"></i></td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Konfigurasi Chart Kesehatan (Doughnut)
    const healthCtx = document.getElementById('healthChart').getContext('2d');
    new Chart(healthCtx, {
        type: 'doughnut',
        data: {
            labels: ['Sangat Sehat', 'Sehat', 'Cukup Sehat', 'Tidak Sehat'],
            datasets: [{
                data: [12, 28, 24, 11],
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444']
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom', labels: { color: '#94a3b8' } } } }
    });

    // Konfigurasi Chart Tren (Line)
    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [{
                label: 'Skor Rata-rata',
                data: [65, 70, 72, 75, 78, 79],
                borderColor: '#10b981',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(16, 185, 129, 0.1)'
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