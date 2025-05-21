<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\VisualController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/visual', function () {
    return view('visual');
});

Route::get('/pengeluaran', function () {
    return view('pengeluaran');
});

// Route untuk Budgeting dan menampilkan riwayat
Route::get('/budgeting', [BudgetingController::class, 'index'])->name('budgeting.index');


Route::get('/riwayatInputSaldo', [BudgetingController::class, 'riwayatInputSaldo'])->name('riwayatInputSaldo');
Route::get('/riwayatPengeluaran', [BudgetingController::class, 'riwayatPengeluaran'])->name('riwayatPengeluaran');

// Route untuk menambah saldo
Route::post('/tambah-saldo', [BudgetingController::class, 'tambahSaldo'])->name('tambah.saldo');

// Menambahkan saldo dan riwayat di dashboard
Route::post('/tambah-saldo-dashboard', [DashboardController::class, 'tambahSaldo'])->name('dashboard.tambahSaldo');

// Route untuk update saldo, gunakan middleware auth
Route::middleware('auth')->post('/update-saldo', [BudgetingController::class, 'updateSaldo'])->name('update.saldo');
Route::get('/riwayat-transaksi', [BudgetingController::class, 'riwayatTransaksi'])->name('riwayat.transaksi');


// Group route untuk user yang sudah login
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visual', [VisualController::class, 'visual'])->name('visual');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
