<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SaldoTransaction;
use App\Models\Budgeting;  // Tambahkan model Budgeting
use App\Models\Expense;  // Tambahkan model Expense

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

        // Mengambil data pengeluaran berdasarkan user_id dan urutkan berdasarkan tanggal terbaru
        $expenses = Expense::where('user_id', $user->id)
            ->orderBy('tanggal', 'desc') // Atau bisa juga menggunakan created_at, tergantung kebutuhan
            ->get();

        // Kirim data expenses dan user ke view
        return view('riwayatPengeluaran', compact('user', 'expenses'));
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
    // Ambil nominal input langsung dari user (jangan total saldo user)
    $saldo = $request->saldo; // pastikan ini ada di request
    $kebutuhan = $saldo * ($request->kebutuhan / 100);
    $keinginan = $saldo * ($request->keinginan / 100);
    $tabungan = $saldo * ($request->tabungan / 100);
    $utang = $saldo * ($request->utang / 100);

    // Simpan ke tabel budgeting - hanya menyimpan nilai sekali input
    Budgeting::create([
        'user_id' => $user->id,
        'saldo' => $saldo,
        'kebutuhan' => $kebutuhan,
        'keinginan' => $keinginan,
        'tabungan' => $tabungan,
        'utang' => $utang,
        'deskripsi' => $request->deskripsi ?? null,
    ]);

    // Tambahkan ke total balance
    $balance = Balance::firstOrCreate(
        ['user_id' => $user->id],
        [
            'total_saldo' => 0,
            'kebutuhan' => 0,
            'keinginan' => 0,
            'tabungan' => 0,
            'utang' => 0,
        ]
    );

    // Update balance dengan increment (akumulasi)
    $balance->increment('total_saldo', $saldo);
    $balance->increment('kebutuhan', $kebutuhan);
    $balance->increment('keinginan', $keinginan);
    $balance->increment('tabungan', $tabungan);
    $balance->increment('utang', $utang);
}
}
