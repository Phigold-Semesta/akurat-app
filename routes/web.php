<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PimpinanController;
use App\Http\Controllers\PengawasController;
use App\Http\Controllers\KoperasiController;

// Landing Page
Route::get('/', function () {
    return redirect()->route('login.internal');
});

// Auth Routes: Menampilkan form login
Route::get('/login/internal', [AuthController::class, 'showLoginInternal'])->name('login.internal');
Route::get('/login/koperasi', [AuthController::class, 'showLoginKoperasi'])->name('login.koperasi');
// Rute Signup
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'registerKoperasi']);


// Auth Routes: Memproses logika login
Route::post('/login/internal', [AuthController::class, 'loginInternal']);
Route::post('/login/koperasi', [AuthController::class, 'loginKoperasi']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Grup Dashboard Koperasi
Route::middleware(['auth:koperasi'])->prefix('koperasi')->group(function () {
    Route::get('/dashboard', [KoperasiController::class, 'index'])->name('dashboard.koperasi');
    Route::get('/profil', [KoperasiController::class, 'profilKoperasi'])->name('koperasi.profil');
    // Tambahkan rute ini:
    Route::post('/koperasi/profil/update', [App\Http\Controllers\KoperasiController::class, 'updateProfil'])->name('koperasi.profil.update');
    Route::get('/hasil-penilaian', [KoperasiController::class, 'hasilPenilaian'])->name('koperasi.hasil-penilaian');
    Route::get('/hasil-penilaian/unduh/{id}', [KoperasiController::class, 'unduhSertifikat'])->name('koperasi.unduh-sertifikat');
    
    // Rute CRUD RAT (Input RAT)
    Route::get('/rat', [KoperasiController::class, 'inputRat'])->name('koperasi.input-rat');
    Route::get('/rat/create', [KoperasiController::class, 'createRat'])->name('koperasi.rat.create');
    Route::post('/rat/simpan', [KoperasiController::class, 'simpanRat'])->name('koperasi.rat.simpan');
    Route::get('/rat/{id}/edit', [KoperasiController::class, 'editRat'])->name('koperasi.rat.edit');
    Route::put('/rat/{id}', [KoperasiController::class, 'updateRat'])->name('koperasi.rat.update');
    Route::delete('/rat/{id}', [KoperasiController::class, 'hapusRat'])->name('koperasi.rat.hapus');

    // --- Rute Baru: Menu PEMKES ---
    Route::get('/pemkes', [KoperasiController::class, 'indexInputPemkes'])->name('koperasi.pemkes.index');
    Route::post('/pemkes/store', [KoperasiController::class, 'storePemkes'])->name('koperasi.pemkes.store');
});

// Grup Dashboard Internal (Admin, Pimpinan, Pengawas)
Route::middleware(['auth:internal'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // --- Rute Manajemen Verifikasi (AKURAT) ---
    Route::get('/admin/verifikasi', [AdminController::class, 'indexVerifikasi'])->name('admin.verifikasi.index');
    Route::post('/admin/verifikasi/{id}', [AdminController::class, 'prosesVerifikasi'])->name('admin.verifikasi.proses');
// --- Rute Manajemen Data Utama ---
    // Menu Data Pengguna
    Route::get('/pengguna', [AdminController::class, 'indexPengguna'])->name('admin.pengguna.index');
    
    // Menu Data Koperasi
    Route::get('/koperasi', [AdminController::class, 'indexKoperasi'])->name('admin.koperasi.index');
    
    // Menu Data Wilayah
    Route::get('/wilayah', [AdminController::class, 'indexWilayah'])->name('admin.wilayah.index');


    Route::get('/pimpinan/dashboard', [PimpinanController::class, 'index'])->name('pimpinan.dashboard');
   
    Route::get('/pimpinan/laporan', [PimpinanController::class, 'indexLaporan'])->name('pimpinan.laporan.index');
    Route::get('/pimpinan/export/pdf', [PimpinanController::class, 'exportPdf'])->name('pimpinan.export.pdf');
    Route::get('/pimpinan/export/excel', [PimpinanController::class, 'exportExcel'])->name('pimpinan.export.excel');
    
    // Rute Dashboard & Verifikasi RAT Pengawas
    Route::get('/pengawas/dashboard', [PengawasController::class, 'index'])->name('pengawas.dashboard');
    Route::get('/pengawas/verifikasi-rat', [PengawasController::class, 'indexVerifikasi'])->name('pengawas.rat.index');
    Route::put('/pengawas/verifikasi-rat/{id}', [PengawasController::class, 'verifikasiRat'])->name('pengawas.rat.verifikasi');
// Verifikasi Lapangan (Fitur Baru yang dihidupkan)
Route::get('/pengawas/verifikasi-lapangan', [PengawasController::class, 'indexLapangan'])->name('pengawas.lapangan.index');

// Data Koperasi (Menu Baru)
Route::get('/pengawas/data-koperasi', [PengawasController::class, 'indexDataKoperasi'])->name('pengawas.koperasi.index');

// Profil Pengawas (Menu Baru)
Route::get('/pengawas/profil', [PengawasController::class, 'profilPengawas'])->name('pengawas.profil.index');

Route::put('/pengawas/profil/update', [PengawasController::class, 'updateProfil'])->name('pengawas.profil.update');
});