<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaldoController; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BudgetingController;
use App\Http\Controllers\VisualController;

Route::get('/', function () {
    return view('welcome');
});

// Route untuk Budgeting dan menampilkan riwayat
Route::get('/budgeting', [BudgetingController::class, 'index'])->name('budgeting.index');



Route::get('/riwayatInputSaldo', [BudgetingController::class, 'riwayatInputSaldo'])->name('riwayatInputSaldo');


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
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/visual', [VisualController::class, 'visual'])->name('visual');
});

require __DIR__.'/auth.php';
