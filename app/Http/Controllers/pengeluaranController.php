<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PengeluaranController extends Controller
{
    // Tampilkan halaman input pengeluaran
    public function index()
    {
        $user = Auth::user();
        $balance = Balance::where('user_id', $user->id)->first();

        // Ambil saldo kategori
        $saldoKategori = [
            'kebutuhan' => $balance->kebutuhan ?? 0,
            'keinginan' => $balance->keinginan ?? 0,
            'tabungan' => $balance->tabungan ?? 0,
            'utang' => $balance->utang ?? 0,
        ];

        return view('pengeluaran', compact('saldoKategori'));
    }

    // Simpan pengeluaran
    public function simpan(Request $request)
    {
        // Validasi input pengeluaran
        $request->validate([
            'saldo' => 'required|numeric|min:1',
            'kategori' => 'required|string|in:kebutuhan,keinginan,tabungan,utang',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string|max:255',
        ]);

        // Ambil user yang sedang login
        $user = User::find(Auth::id());

        // Ambil pengeluaran dan kategori
        $pengeluaran = (int) $request->saldo;
        $kategori = strtolower($request->kategori);

        // Ambil data balance untuk user ini
        $balance = Balance::where('user_id', $user->id)->first();

        // Pastikan saldo kategori cukup untuk pengeluaran
        if (!$balance || $balance->$kategori < $pengeluaran) {
            return back()->withErrors(['msg' => "Saldo kategori $kategori tidak cukup."]);
        }

        // Update saldo di Balance
        // Ambil balance untuk user
        $balance = Balance::where('user_id', $user->id)->first();

        // Lakukan perubahan pada salah satu kolom (misal kebutuhan)
        $balance->kebutuhan -= 1000000; // Pengurangan atau penambahan
        $balance->updateTotalSaldo();  // Memperbarui total_saldo

        // Simpan perubahan
        $balance->save();
        // Update saldo di User
        $user->total_saldo -= $pengeluaran;
        $user->save();

        // Simpan pengeluaran di tabel Expense
        Expense::create([
            'user_id' => $user->id,
            'kategori' => $kategori,
            'jumlah' => $pengeluaran,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'budgeting_id' => null,  // Sesuaikan ini jika menghubungkan dengan budgeting tertentu
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil disimpan.');
    }
}
