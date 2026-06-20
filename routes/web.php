<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\KoperasiController;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes: Menampilkan form login
Route::get('/login/internal', [AuthController::class, 'showLoginInternal'])->name('login.internal');
Route::get('/login/koperasi', [AuthController::class, 'showLoginKoperasi'])->name('login.koperasi');

// Auth Routes: Memproses logika login
Route::post('/login/internal', [AuthController::class, 'loginInternal']);
Route::post('/login/koperasi', [AuthController::class, 'loginKoperasi']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Grouping route dengan middleware auth yang disesuaikan per guard
// Kita memisahkan grup agar middleware auth mengenali guard masing-masing

// Grup Dashboard Koperasi
Route::middleware(['auth:koperasi'])->group(function () {
    Route::get('/koperasi/dashboard', [KoperasiController::class, 'index'])->name('dashboard.koperasi');
});

// Grup Dashboard Internal (Admin, Pimpinan, Pengawas)
Route::middleware(['auth:internal'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard.admin');
    Route::get('/pimpinan/dashboard', [PimpinanController::class, 'index'])->name('dashboard.pimpinan');
    Route::get('/pengawas/dashboard', [PengawasController::class, 'index'])->name('dashboard.pengawas');
});