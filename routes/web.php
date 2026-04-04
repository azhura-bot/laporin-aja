<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RelawanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\RelawanController as AdminRelawanController;
use App\Http\Controllers\Admin\AnalisisController;
use App\Http\Controllers\Admin\KelolaStatusController;
use App\Http\Controllers\Admin\BalasWargaController;

// Route untuk halaman public
Route::get('/', function () {
    return view('home');
})->name('home');

// Route auth (dari Breeze)
require __DIR__.'/auth.php';

// Route untuk user biasa (warga)
Route::middleware(['auth'])->group(function () {
    // Dashboard user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource Laporan (INI PENTING!)
    Route::resource('laporan', LaporanController::class);
    
    // Resource Relawan
    Route::resource('relawan', RelawanController::class);
});

// Route Admin (dengan middleware admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Kelola Laporan
    Route::resource('laporan', AdminLaporanController::class);
    Route::put('laporan/{id}/status', [AdminLaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
    
    // Data Analisis
    Route::get('/analisis', [AnalisisController::class, 'index'])->name('analisis');
    
    // Kelola Status
    Route::get('/kelola-status', [KelolaStatusController::class, 'index'])->name('kelola-status');
    Route::put('/kelola-status/{id}', [KelolaStatusController::class, 'update'])->name('kelola-status.update');
    Route::post('/kelola-status/bulk', [KelolaStatusController::class, 'bulkUpdate'])->name('kelola-status.bulk');
    
    // Balas Warga
    Route::get('/balas-warga', [BalasWargaController::class, 'index'])->name('balas-warga');
    Route::post('/balas-warga/{id}', [BalasWargaController::class, 'store'])->name('balas-warga.store');
    
    // Kelola Relawan
    Route::resource('relawan', AdminRelawanController::class);
    Route::put('relawan/{id}/status', [AdminRelawanController::class, 'updateStatus'])->name('relawan.updateStatus');
});