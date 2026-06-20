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

// Grouping route dengan middleware auth agar aman
Route::middleware(['auth'])->group(function () {
    
    // Dashboard untuk Admin Dinas
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Dashboard untuk Pimpinan
    Route::get('/pimpinan/dashboard', [PimpinanController::class, 'index'])->name('dashboard');

    // Dashboard untuk Pengawas
    Route::get('/pengawas/dashboard', [PengawasController::class, 'index'])->name('dashboard');

    // Dashboard untuk Koperasi
    Route::get('/koperasi/dashboard', [KoperasiController::class, 'index'])->name('dashboard');
    
});