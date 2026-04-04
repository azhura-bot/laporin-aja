<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Warga\LaporanController;
use App\Http\Controllers\Warga\WargaController; // <-- Tambahkan ini!

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Opsi 1: Jika hanya menampilkan view biasa
Route::get('/portal-warga', function () {
    return view('portal.warga');
})->name('warga.portal');

// Tambahkan pengecekan apakah WargaController ada
Route::get('/warga/dashboard', [WargaController::class, 'dashboard'])->name('warga.dashboard');
Route::get('/warga/laporan', [WargaController::class, 'laporan'])->name('warga.laporan');
Route::post('/warga/laporan/store', [WargaController::class, 'store'])->name('warga.laporan.store');

Route::middleware(['auth'])->group(function () {
    // Dashboard utama
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Resource Laporan
    Route::resource('laporan', LaporanController::class);
});