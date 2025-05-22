<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisualController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetingController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\PengeluaranController;


Route::get('/', function () {
    return view('welcome');
});

// Route untuk Budgeting dan menampilkan riwayat
Route::get('/budgeting', [BudgetingController::class, 'index'])->name('budgeting.index');

// Rute untuk halaman dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/visual', [VisualController::class, 'pengeluaranvspemasukan'])->name('visual.pengeluaranvspemasukan');
// Route::get('/visual', [VisualController::class, 'index'])->name('visual.index');
// Route::get('/visual', [VisualController::class, 'visual'])->name('visual');
Route::post('/budgeting/tambah-pengeluaran', [BudgetingController::class, 'tambahPengeluaran'])->name('budgeting.tambahPengeluaran');
Route::get('/riwayatInputSaldo', [BudgetingController::class, 'riwayatInputSaldo'])->name('riwayatInputSaldo');
Route::get('/riwayatPengeluaran', [BudgetingController::class, 'riwayatPengeluaran'])->name('riwayatPengeluaran');

// Route untuk menambah saldo
Route::post('/tambah-saldo', [BudgetingController::class, 'tambahSaldo'])->name('tambah.saldo');
Route::post('/tambah-saldo-dashboard', [DashboardController::class, 'tambahSaldo'])->name('dashboard.tambahSaldo');
// Route::post('/pengeluaran', [BudgetingController::class, 'tambahPengeluaran'])->name('tambah.pengeluaran');


// Route untuk update saldo, gunakan middleware auth
Route::middleware('auth')->post('/update-saldo', [BudgetingController::class, 'updateSaldo'])->name('update.saldo');
Route::get('/riwayat-transaksi', [BudgetingController::class, 'riwayatTransaksi'])->name('riwayat.transaksi');


// Route::post('/pengeluaran/simpan', [PengeluaranController::class, 'simpan'])->name('pengeluaran.simpan');

// Group route untuk user yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visual', [VisualController::class, 'visual'])->name('visual');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('pengeluaran.index');
    Route::post('/pengeluaran/simpan', [PengeluaranController::class, 'simpan'])->name('pengeluaran.simpan');

});

require __DIR__.'/auth.php';
