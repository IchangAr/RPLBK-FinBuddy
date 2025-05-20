<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SaldoTransaction;

class BudgetingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil riwayat transaksi saldo pengguna
        $saldoTransactions = SaldoTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('budgeting', compact('user', 'saldoTransactions'));
    }

    public function riwayatInputSaldo()
    {
        $user = Auth::user();

        $saldoTransactions = SaldoTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayatInputSaldo', compact('user', 'saldoTransactions'));
    }


    public function tambahSaldo(Request $request)
    {
        // Validasi input saldo dan komentar
        $request->validate([
            'saldo' => 'required|numeric|min:1',
            'comment' => 'nullable|string|max:255',
        ]);

        $user = \App\Models\User::find(Auth::id());

        $user->saldo += $request->saldo;
        $user->save(); // ⬅ Tidak ada 'deskripsi' di sini, jadi aman

        // Simpan catatan saldo di tabel transaksi
        SaldoTransaction::create([
            'user_id' => $user->id,
            'jumlah' => $request->saldo,
            'type' => 'credit',
            'deskripsi' => $request->deskripsi ?? null,
        ]);

        return redirect()->route('budgeting.index')->with('success', 'Saldo berhasil ditambahkan!');
    }
}