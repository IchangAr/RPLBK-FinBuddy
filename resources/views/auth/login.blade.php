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
            // Log data yang diterima
            Log::info('Data request diterima:', $request->all());

            // Validasi input
            $validated = $request->validate([
                'saldo' => 'required|numeric|min:1',
                'kategori' => 'required|in:kebutuhan,keinginan,tabungan,utang',
                // 'tanggal' => 'required|string', // Format: "Kam, 22 Mei 2025"
                'deskripsi' => 'nullable|string|max:255',
            ]);

            $user = Auth::user();
            $kategori = $validated['kategori'];
            $jumlah = $validated['saldo'];
            $deskripsi = $validated['deskripsi'] ?? 'Tidak ada deskripsi';

            // Parse tanggal dari format Flatpickr
            // try {
            //     $tanggal = Carbon::createFromFormat('D, d M Y', $validated['tanggal'])->format('Y-m-d');
            // } catch (\Exception $e) {
            //     Log::error('Gagal memparse tanggal: ' . $validated['tanggal'], ['error' => $e->getMessage()]);
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Format tanggal tidak valid.',
            //     ], 422);
            // }

            // Ambil data balance
            $balance = Balance::where('user_id', $user->id)->first();

            // Cek jika balance tidak ada atau saldo kategori tidak cukup
            if (!$balance) {
                Log::error('Balance tidak ditemukan untuk user_id: ' . $user->id);
                return response()->json([
                    'success' => false,
                    'message' => 'Data saldo tidak ditemukan.',
                ], 422);
            }

            if ($balance->$kategori < $jumlah) {
                Log::warning('Saldo tidak mencukupi untuk kategori: ' . $kategori, [
                    'saldo_tersedia' => $balance->$kategori,
                    'jumlah_dibutuhkan' => $jumlah
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Saldo kategori tidak mencukupi.',
                ], 422);
            }

            // Simpan pengeluaran
            Expense::create([
                'user_id' => $user->id,
                'kategori' => $kategori,
                'jumlah' => $jumlah,
                // 'tanggal' => $tanggal,
                'deskripsi' => $deskripsi,
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

            return response()->json([
                'success' => true,
                'message' => 'Pengeluaran berhasil disimpan!',
                'newSaldo' => $balance->$kategori,
            ]);

        } catch (\Exception $e) {
            Log::error('Error menyimpan pengeluaran:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan pengeluaran.',
            ], 500);
        }
    }
}
