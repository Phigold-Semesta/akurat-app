<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\KoperasiController;

// Landing Page - Diarahkan otomatis ke Login Internal
Route::get('/', function () {
    return redirect()->route('login.internal');
});

// Auth Routes: Menampilkan form login
Route::get('/login/internal', [AuthController::class, 'showLoginInternal'])->name('login.internal');
Route::get('/login/koperasi', [AuthController::class, 'showLoginKoperasi'])->name('login.koperasi');

// Auth Routes: Memproses logika login
Route::post('/login/internal', [AuthController::class, 'loginInternal']);
Route::post('/login/koperasi', [AuthController::class, 'loginKoperasi']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Grup Dashboard Koperasi
Route::middleware(['auth:koperasi'])->prefix('koperasi')->group(function () {
    Route::get('/dashboard', [KoperasiController::class, 'index'])->name('dashboard.koperasi');
    Route::get('/riwayat', [KoperasiController::class, 'riwayat'])->name('koperasi.riwayat');
    
    // Rute CRUD RAT (Input RAT)
    Route::get('/rat', [KoperasiController::class, 'inputRat'])->name('koperasi.input-rat');
    Route::get('/rat/create', [KoperasiController::class, 'createRat'])->name('koperasi.rat.create');
    Route::post('/rat/simpan', [KoperasiController::class, 'simpanRat'])->name('koperasi.rat.simpan');
    Route::get('/rat/{id}/edit', [KoperasiController::class, 'editRat'])->name('koperasi.rat.edit');
    Route::put('/rat/{id}', [KoperasiController::class, 'updateRat'])->name('koperasi.rat.update');
    Route::delete('/rat/{id}', [KoperasiController::class, 'hapusRat'])->name('koperasi.rat.hapus');
});

// Grup Dashboard Internal (Admin, Pimpinan, Pengawas)
Route::middleware(['auth:internal'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard.admin');
    Route::get('/pimpinan/dashboard', [PimpinanController::class, 'index'])->name('dashboard.pimpinan');
    Route::get('/pengawas/dashboard', [PengawasController::class, 'index'])->name('dashboard.pengawas');
});