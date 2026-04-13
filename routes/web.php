<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RelawanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\RelawanController as AdminRelawanController;
use App\Http\Controllers\Admin\OperatorController as AdminOperatorController;
use App\Http\Controllers\Admin\AnalisisController;
use App\Http\Controllers\Admin\KelolaStatusController;
use App\Http\Controllers\Admin\BalasWargaController;
use App\Http\Controllers\Admin\DaerahButuhRelawanController;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboardController;
use App\Http\Controllers\Operator\LaporanController as OperatorLaporanController;
use App\Models\DaerahButuhRelawan;
use App\Models\Relawan;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk halaman public
Route::get('/', function () {
    $hasRelawanTable = Schema::hasTable('relawans');
    $hasDaerahTable = Schema::hasTable('daerah_butuh_relawan');

    $totalRelawan = $hasRelawanTable ? Relawan::count() : 0;
    $relawanAktif = $hasRelawanTable ? Relawan::where('status', 'aktif')->count() : 0;
    $relawanPending = $hasRelawanTable ? Relawan::where('status', 'pending')->count() : 0;
    $activeSkills = $hasRelawanTable
        ? Relawan::where('status', 'aktif')->select('keahlian')->distinct()->pluck('keahlian')
        : collect();
    $daerahButuhRelawan = $hasDaerahTable
        ? DaerahButuhRelawan::aktif()
            ->orderByRaw("FIELD(prioritas, 'kritis', 'tinggi', 'sedang', 'rendah')")
            ->paginate(6)
        : new \Illuminate\Pagination\LengthAwarePaginator([], 0, 6);

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
    Route::resource('relawan', RelawanController::class)->only(['create', 'store']);
});

Route::middleware(['auth', 'operator'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/', [OperatorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [OperatorLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/riwayat', [OperatorLaporanController::class, 'history'])->name('laporan.history');
    Route::get('/riwayat/{laporan}', [OperatorLaporanController::class, 'historyShow'])->name('laporan.history.show');
    Route::get('/laporan/{laporan}', [OperatorLaporanController::class, 'show'])->name('laporan.show');
    Route::put('/laporan/{laporan}/progress', [OperatorLaporanController::class, 'updateProgress'])->name('laporan.progress');
});

// Route Admin (dengan middleware admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Kelola Laporan
    Route::resource('laporan', AdminLaporanController::class)->only(['index', 'show', 'destroy']);
    Route::put('laporan/{id}/status', [AdminLaporanController::class, 'updateStatus'])->name('laporan.updateStatus');
    Route::put('laporan/{id}/assign-operator', [AdminLaporanController::class, 'assignOperator'])->name('laporan.assignOperator');
    
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
    Route::resource('relawan', AdminRelawanController::class)->only(['index', 'show', 'destroy']);
    Route::post('/relawan/bulk', [AdminRelawanController::class, 'bulkUpdate'])->name('relawan.bulk');
    Route::put('relawan/{id}/status', [AdminRelawanController::class, 'updateStatus'])->name('relawan.updateStatus');
    // Kelola Operator
    Route::resource('operator', AdminOperatorController::class)->except(['show']);
    Route::put('operator/{id}/status', [AdminOperatorController::class, 'updateStatus'])->name('operator.updateStatus');
    
    // Kelola Daerah Butuh Relawan
    Route::resource('daerah-butuh-relawan', DaerahButuhRelawanController::class);
    Route::put('daerah-butuh-relawan/{id}/toggle', [DaerahButuhRelawanController::class, 'toggleStatus'])->name('daerah-butuh-relawan.toggle');
});
