<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaldoController; // <- Pastikan ini juga ada
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\BudgetingController;
=======
use App\Http\Controllers\IncomeController;
>>>>>>> e6ee24fdb8bd9992d1960b029bee74405bcd1c5f

Route::get('/', function () {
    return view('welcome');
});

// Route untuk Budgeting dan menampilkan riwayat
Route::get('/budgeting', [BudgetingController::class, 'index'])->name('budgeting.index');

<<<<<<< HEAD


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
=======
Route::get('/riwayatInput', function () {
    return view('riwayatInput');
});
Route::get('/riwayatPengeluaran', function () {
    return view('riwayatPengeluaran');
});

Route::middleware('auth')->group(function () {
>>>>>>> e6ee24fdb8bd9992d1960b029bee74405bcd1c5f
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/income', [IncomeController::class, 'index'])->name('income.index');
});


require __DIR__.'/auth.php';
