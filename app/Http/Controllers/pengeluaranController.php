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
        Log::info('Data request diterima:', $request->all());

        $request->validate([
            'saldo' => 'required|numeric|min:1',
            'kategori' => 'required|in:kebutuhan,keinginan,tabungan,utang',
            'deskripsi' => 'nullable|string|max:255',
        ], [
            'tanggal.regex' => 'Format tanggal tidak valid. Gunakan format seperti "Kam, 22 Mei 2025".',
        ]);

        $user = Auth::user();
        $kategori = $request->kategori;
        $jumlah = $request->saldo;

        $balance = Balance::where('user_id', $user->id)->first();

        if (!$balance) {
            Log::error('Balance tidak ditemukan untuk user_id: ' . $user->id);
            return response()->json([
                'success' => false,
                'message' => 'Data saldo tidak ditemukan.'
            ], 404);
        }

        if ($balance->$kategori < $jumlah) {
            Log::warning('Saldo tidak mencukupi untuk kategori: ' . $kategori, [
                'saldo_tersedia' => $balance->$kategori,
                'jumlah_dibutuhkan' => $jumlah
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Saldo kategori tidak mencukupi.'
            ], 422);
        }

        Expense::create([
            'user_id' => $user->id,
            'kategori' => $kategori,
            'jumlah' => $jumlah,
            'deskripsi' => $request->deskripsi ?? 'Tidak ada deskripsi',
        ]);

        $balance->decrement($kategori, $jumlah);
        $balance->decrement('total_saldo', $jumlah);
        $balance->refresh(); // refresh agar properti saldo terbaru bisa diakses

        Log::info('Saldo setelah pengurangan:', [
            'kategori' => $kategori,
            'saldo_kategori' => $balance->$kategori,
            'total_saldo' => $balance->total_saldo
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran berhasil disimpan.',
            'newSaldo' => $balance->$kategori,
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Jika validasi gagal, kirim pesan error ke JSON
        return response()->json([
            'success' => false,
            'message' => $e->validator->errors()->first()
        ], 422);
    } catch (\Exception $e) {
        Log::error('Error menyimpan pengeluaran:', ['error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menyimpan pengeluaran.'
        ], 500);
    }
}
}
