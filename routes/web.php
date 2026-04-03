<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/warga/dashboard', [WargaController::class, 'dashboard'])->name('warga.dashboard');
Route::get('/warga/laporan', [WargaController::class, 'laporan'])->name('warga.laporan');
Route::post('/warga/laporan/store', [WargaController::class, 'store'])->name('warga.laporan.store');
