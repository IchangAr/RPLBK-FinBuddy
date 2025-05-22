<?php

namespace App\Http\Controllers;

use App\Models\SaldoTransaction;
use Illuminate\Http\Request;
use App\Models\Expense;  // Tambahkan model Budgeting
use Illuminate\Support\Facades\Auth;

class SaldoController extends Controller
{
    public function tambahSaldo(Request $request)
    {
        // Validasi input saldo
        $request->validate([
            'saldo' => 'required|numeric|min:1', // Pastikan saldo yang dimasukkan adalah angka
            'description' => 'nullable|string|max:255', // Deskripsi opsional
        ]);

        // Ambil user yang sedang login
        $user = \App\Models\User::find(Auth::id());

        // Update saldo di tabel users (misal menambah saldo)
        $user->saldo += $request->saldo;
        $user->save();

        // Simpan transaksi saldo ke tabel saldo_transactions
        SaldoTransaction::create([
            'user_id' => $user->id,
            'jumlah' => $request->saldo,
            'type' => 'credit', // Jenis transaksi adalah 'credit' karena menambah saldo
            'deskripsi' => $request->description ?? null, // Deskripsi opsional
        ]);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('budgeting.index')->with('success', 'Saldo berhasil ditambahkan!');
    }
}


