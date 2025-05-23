<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PengeluaranController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $balance = Balance::where('user_id', $user->id)->first();

        // Inisialisasi saldo kategori, default ke 0 jika tidak ada
        $saldoKategori = [
            'kebutuhan' => $balance ? $balance->kebutuhan : 0,
            'keinginan' => $balance ? $balance->keinginan : 0,
            'tabungan' => $balance ? $balance->tabungan : 0,
            'utang' => $balance ? $balance->utang : 0,
        ];

        return view('pengeluaran', compact('saldoKategori'));
    }



    public function simpan(Request $request)
    {
        try {
            // Mencatat data request yang diterima
            Log::info('Data request diterima:', $request->all());

            // Validasi input
            $request->validate([
                'saldo' => 'required|numeric|min:1',
                'kategori' => 'required|in:kebutuhan,keinginan,tabungan,utang',
                // 'tanggal' => 'required|string', // Tanggal akan diproses sendiri
                'deskripsi' => 'nullable|string|max:255',
            ], [
                'tanggal.regex' => 'Format tanggal tidak valid. Gunakan format seperti "Kam, 22 Mei 2025".',
            ]);

            $user = Auth::user();
            $kategori = $request->kategori;
            $jumlah = $request->saldo;

            // Ambil data balance untuk user
            $balance = Balance::where('user_id', $user->id)->first();

            // Cek jika balance tidak ada atau saldo kategori tidak cukup
            if (!$balance) {
                Log::error('Balance tidak ditemukan untuk user_id: ' . $user->id);
                return back()->withErrors(['saldo' => 'Data saldo tidak ditemukan.'])->withInput();
            }

            if ($balance->$kategori < $jumlah) {
                Log::warning('Saldo tidak mencukupi untuk kategori: ' . $kategori, [
                    'saldo_tersedia' => $balance->$kategori,
                    'jumlah_dibutuhkan' => $jumlah
                ]);
                return back()->withErrors(['saldo' => 'Saldo kategori tidak mencukupi.'])->withInput();
            }


            // Simpan pengeluaran ke tabel expenses
            Expense::create([
                'user_id' => $user->id,
                'kategori' => $kategori,
                'jumlah' => $jumlah,
                // 'tanggal' => $tanggal,
                'deskripsi' => $request->deskripsi ?? 'Tidak ada deskripsi',
            ]);

            // Kurangi saldo kategori dan total saldo
            $balance->decrement($kategori, $jumlah);
            $balance->decrement('total_saldo', $jumlah);

            // Log setelah pengurangan saldo
            Log::info('Saldo setelah pengurangan:', [
                'kategori' => $kategori,
                'saldo_kategori' => $balance->$kategori,
                'total_saldo' => $balance->total_saldo
            ]);

            return redirect()->route('pengeluaran.index')->with('success', 'Pengeluaran berhasil disimpan.');
        } catch (\Exception $e) {
            // Log error umum
            Log::error('Error menyimpan pengeluaran:', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan pengeluaran.'])->withInput();
        }
    }
}
