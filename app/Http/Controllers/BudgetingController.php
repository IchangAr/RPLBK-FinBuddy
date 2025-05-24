<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SaldoTransaction;
use App\Models\Budgeting;
use App\Models\Expense;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BudgetingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $saldoTransactions = SaldoTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
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
        $expenses = Expense::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('riwayatPengeluaran', compact('user', 'expenses'));
    }

    public function tambahSaldo(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'saldo' => 'required|numeric|min:1',
                'deskripsi' => 'nullable|string|max:255',
                'kebutuhan' => 'required|numeric|min:0|max:100',
                'keinginan' => 'required|numeric|min:0|max:100',
                'tabungan' => 'required|numeric|min:0|max:100',
                'utang' => 'required|numeric|min:0|max:100',
            ]);

            $totalPercentage = $validatedData['kebutuhan'] + $validatedData['keinginan'] + $validatedData['tabungan'] + $validatedData['utang'];

            if ($totalPercentage != 100) {
                return response()->json([
                    'success' => false,
                    'message' => 'Total persentase alokasi budgeting harus 100%.'
                ], 422);
            }

            $user = Auth::user();

            // Simpan catatan saldo di tabel transaksi SaldoTransaction
            // (Diasumsikan SaldoTransaction adalah untuk history input, bukan saldo utama user)
            SaldoTransaction::create([
                'user_id' => $user->id,
                'jumlah' => $validatedData['saldo'], // Ini adalah jumlah saldo yang baru diinput
                'deskripsi' => $validatedData['deskripsi'] ?? 'Input saldo budgeting',
            ]);

            // Panggil simpanBudgeting untuk memproses alokasi ke Balance dan Budgeting
            $this->simpanBudgeting($user, $request);

            // Jika User model punya kolom 'saldo', dan Anda ingin menambahkannya juga (opsional, tergantung sistem Anda)
            // $userModel = \App\Models\User::find($user->id);
            // $userModel->saldo += $validatedData['saldo'];
            // $userModel->save();

            return response()->json([
                'success' => true,
                'message' => 'Data budgeting berhasil disimpan!',
            ]);

        } catch (ValidationException $e) {
            Log::error('Kesalahan validasi saat tambah saldo budgeting: ' . $e->getMessage(), $e->errors());
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error saat tambah saldo budgeting: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan internal saat menyimpan data.'
            ], 500);
        }
    }

    public function simpanBudgeting($user, Request $request)
    {
        // Ambil nominal input langsung dari user untuk budgeting ini
        $saldoInputSaatIni = $request->saldo; // Saldo yang diinput di form budgeting saat ini
        $kebutuhan = $saldoInputSaatIni * ($request->kebutuhan / 100);
        $keinginan = $saldoInputSaatIni * ($request->keinginan / 100);
        $tabungan = $saldoInputSaatIni * ($request->tabungan / 100);
        $utang = $saldoInputSaatIni * ($request->utang / 100);

        // Simpan detail alokasi dari input ini ke tabel Budgeting (sebagai riwayat alokasi)
        Budgeting::create([
            'user_id' => $user->id,
            'saldo' => $saldoInputSaatIni, // saldo yang dialokasikan saat ini
            'kebutuhan' => $kebutuhan,
            'keinginan' => $keinginan,
            'tabungan' => $tabungan,
            'utang' => $utang,
            'deskripsi' => $request->deskripsi ?? null,
        ]);

        // Update tabel Balance (saldo utama per kategori pengguna)
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

        // Increment saldo di tabel Balance
        $balance->increment('total_saldo', $saldoInputSaatIni);
        $balance->increment('kebutuhan', $kebutuhan);
        $balance->increment('keinginan', $keinginan);
        $balance->increment('tabungan', $tabungan);
        $balance->increment('utang', $utang);
    }
}
