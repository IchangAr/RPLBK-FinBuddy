<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SaldoTransaction;
use App\Models\Budgeting;  // Tambahkan model Budgeting

class BudgetingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil riwayat transaksi saldo pengguna
        $saldoTransactions = SaldoTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data budgeting terakhir untuk user ini (jika ada)
        $budgeting = Budgeting::where('user_id', $user->id)->latest()->first();

        return view('budgeting', compact('user', 'saldoTransactions', 'budgeting'));
    }

    public function riwayatInputSaldo()
    {
        $user = Auth::user();

        $saldoTransactions = SaldoTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayatInputSaldo', compact('user', 'saldoTransactions'));
    }

    public function riwayatPengeluaran()
    {
        $user = Auth::user();

        $saldoTransactions = SaldoTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('riwayatPengeluaran', compact('user', 'saldoTransactions'));
    }

    public function tambahSaldo(Request $request)
    {
        // Validasi input saldo dan komentar
        $request->validate([
            'saldo' => 'required|numeric|min:1',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        $user = \App\Models\User::find(Auth::id());

        // Update saldo pengguna
        $user->saldo += $request->saldo;
        $user->save();

        // Simpan catatan saldo di tabel transaksi
        SaldoTransaction::create([
            'user_id' => $user->id,
            'jumlah' => $request->saldo,
            'deskripsi' => $request->deskripsi ?? null,
        ]);

        // Simpan data budgeting ke tabel budgetings
        $this->simpanBudgeting($user, $request);

        return redirect()->route('budgeting.index')->with('success_modal', true);
    }

    public function simpanBudgeting($user, $request)
    {
        // Kalkulasi alokasi budgeting berdasarkan saldo yang baru
        $saldo = $user->saldo; // Saldo yang sudah diperbarui
        $kebutuhan = $saldo * ($request->kebutuhan / 100);
        $keinginan = $saldo * ($request->keinginan / 100);
        $tabungan = $saldo * ($request->tabungan / 100);
        $utang = $saldo * ($request->utang / 100);

        // Simpan data budgeting ke dalam tabel 'budgetings'
        Budgeting::create([
            'user_id' => $user->id,
            'saldo' => $saldo,  // Saldo total
            'kebutuhan' => $kebutuhan,  // Alokasi kebutuhan
            'keinginan' => $keinginan,  // Alokasi keinginan
            'tabungan' => $tabungan,  // Alokasi tabungan
            'utang' => $utang,  // Alokasi utang
            'deskripsi' => $request->deskripsi ?? null,
        ]);
    }
}
