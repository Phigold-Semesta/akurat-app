@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Statistik Kartu -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Koperasi -->
        <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl border border-emerald-100 dark:border-emerald-800 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-sm font-bold text-emerald-900 dark:text-emerald-100">Total Koperasi</div>
                <div class="text-3xl font-black text-emerald-950 dark:text-white">{{ $totalKoperasi }}</div>
                <div class="text-xs text-emerald-600 uppercase tracking-wider">Terdaftar di Sistem</div>
            </div>
            <div class="p-3 bg-emerald-50 dark:bg-emerald-900 rounded-xl">
                <i class="fas fa-building text-emerald-600 text-2xl"></i>
            </div>
        </div>
        <!-- Pengguna -->
        <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl border border-emerald-100 dark:border-emerald-800 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-sm font-bold text-emerald-900 dark:text-emerald-100">Total Pengguna</div>
                <div class="text-3xl font-black text-emerald-950 dark:text-white">{{ $totalPengguna }}</div>
                <div class="text-xs text-emerald-600 uppercase tracking-wider">Akun Aktif</div>
            </div>
            <div class="p-3 bg-blue-50 dark:bg-blue-900 rounded-xl">
                <i class="fas fa-users text-blue-600 text-2xl"></i>
            </div>
        </div>
        <!-- RAT -->
        <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl border border-emerald-100 dark:border-emerald-800 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-sm font-bold text-emerald-900 dark:text-emerald-100">Total RAT</div>
                <div class="text-3xl font-black text-emerald-950 dark:text-white">{{ $totalRAT }}</div>
                <div class="text-xs text-emerald-600 uppercase tracking-wider">Laporan Masuk</div>
            </div>
            <div class="p-3 bg-purple-50 dark:bg-purple-900 rounded-xl">
                <i class="fas fa-file-invoice text-purple-600 text-2xl"></i>
            </div>
        </div>
        <!-- Verifikasi -->
        <div class="bg-white dark:bg-emerald-950 p-6 rounded-2xl border border-emerald-100 dark:border-emerald-800 shadow-sm flex items-center justify-between">
            <div>
                <div class="text-sm font-bold text-emerald-900 dark:text-emerald-100">Total Verifikasi</div>
                <div class="text-3xl font-black text-emerald-950 dark:text-white">{{ $totalVerifikasi }}</div>
                <div class="text-xs text-emerald-600 uppercase tracking-wider">Tervalidasi</div>
            </div>
            <div class="p-3 bg-amber-50 dark:bg-amber-900 rounded-xl">
                <i class="fas fa-check-circle text-amber-600 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Chart & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1 bg-white dark:bg-emerald-950 p-6 rounded-2xl shadow-sm border border-emerald-100 dark:border-emerald-800">
            <h3 class="font-black text-emerald-900 dark:text-white mb-4 uppercase">Distribusi Kesehatan</h3>
            <canvas id="healthChart" class="w-full"></canvas>
        </div>
        <div class="lg:col-span-2 bg-emerald-600 p-8 rounded-2xl shadow-xl flex items-center justify-between">
            <div class="text-white">
                <h2 class="text-2xl font-black uppercase mb-2">Selamat Datang, Admin!</h2>
                <p class="font-bold opacity-80">Sistem informasi monitoring koperasi AKURAT v1.0 dalam kondisi optimal.</p>
            </div>
            <i class="fas fa-chart-pie text-6xl text-white/20"></i>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('healthChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($distribusiKesehatan->pluck('status_kesehatan')) !!},
            datasets: [{
                data: {!! json_encode($distribusiKesehatan->pluck('total')) !!},
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444']
            }]
        },
        options: { 
            responsive: true, 
            plugins: { 
                legend: { position: 'bottom', labels: { color: '#94a3b8' } } 
            } 
        }
    });
</script>
@endsection