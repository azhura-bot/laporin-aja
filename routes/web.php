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
use App\Http\Controllers\Admin\DaerahButuhRelawanController;
use App\Models\DaerahButuhRelawan;
use App\Models\Relawan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk halaman public
Route::get('/', function () {
    $totalRelawan = Relawan::count();
    $relawanAktif = Relawan::where('status', 'aktif')->count();
    $relawanPending = Relawan::where('status', 'pending')->count();
    $activeSkills = Relawan::where('status', 'aktif')->select('keahlian')->distinct()->pluck('keahlian');
    $daerahButuhRelawan = DaerahButuhRelawan::aktif()->orderBy('prioritas', 'desc')->take(6)->get();

    return view('home', compact('totalRelawan', 'relawanAktif', 'relawanPending', 'activeSkills', 'daerahButuhRelawan'));
})->name('home');

// Route untuk halaman portal warga (tanpa auth)
Route::get('/portal-warga', function () {
    return view('portal.warga');
})->name('warga.portal');

// Route auth (dari Breeze)
require __DIR__.'/auth.php';

// Route untuk user biasa (warga) - membutuhkan autentikasi
Route::middleware(['auth'])->group(function () {
    // Dashboard user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource Laporan
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
    Route::post('/relawan/bulk', [AdminRelawanController::class, 'bulkUpdate'])->name('relawan.bulk');
    Route::put('relawan/{id}/status', [AdminRelawanController::class, 'updateStatus'])->name('relawan.updateStatus');
    // Kelola Operator
    Route::resource('operator', OperatorController::class);
    Route::put('operator/{id}/status', [OperatorController::class, 'updateStatus'])->name('operator.updateStatus');
    
    // Kelola Daerah Butuh Relawan
    Route::resource('daerah-butuh-relawan', DaerahButuhRelawanController::class);
    Route::put('daerah-butuh-relawan/{id}/toggle', [DaerahButuhRelawanController::class, 'toggleStatus'])->name('daerah-butuh-relawan.toggle');
});