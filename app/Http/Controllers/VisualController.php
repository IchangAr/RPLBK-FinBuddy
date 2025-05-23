<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Expense;
use App\Models\Income;
use App\Models\SaldoTransaction;
use App\Models\Balance;
use Illuminate\Http\Request;

class VisualController extends Controller
{
    public function visual()
    {
        $user = Auth::user();

        // Total pengeluaran seluruhnya
        $totalPengeluaran = Expense::where('user_id', $user->id)->sum('jumlah');
        $totalSaldo = Balance::where('user_id', $user->id)->value('total_saldo');

        // Ambil data pengeluaran per bulan (1-12)
        $pengeluaranPerBulan = Expense::selectRaw('MONTH(created_at) as bulan, SUM(jumlah) as total')
            ->where('user_id', $user->id)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan');

        // Ambil data pemasukan per bulan (1-12)
        $pemasukanPerBulan = SaldoTransaction::selectRaw('MONTH(created_at) as bulan, SUM(jumlah) as total')
            ->where('user_id', $user->id)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan');

        // Siapkan array data per bulan (default 0 jika tidak ada data)
        $pengeluaranData = [];
        $pemasukanData = [];

        for ($i = 1; $i <= 12; $i++) {
            $pengeluaranData[] = $pengeluaranPerBulan[$i] ?? 0;
            $pemasukanData[] = $pemasukanPerBulan[$i] ?? 0;
        }

        $months = [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ];

        $balance = Balance::where('user_id', $user->id)->first();
        $pengeluaranPerKategori = Expense::where('user_id', $user->id)
            ->select('kategori', DB::raw('SUM(jumlah) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $kategoriData = [
            'kebutuhan' => [
                'budget' => $balance->kebutuhan,
                'pengeluaran' => $pengeluaranPerKategori['kebutuhan'] ?? 0,
            ],
            'keinginan' => [
                'budget' => $balance->keinginan,
                'pengeluaran' => $pengeluaranPerKategori['keinginan'] ?? 0,
            ],
            'tabungan' => [
                'budget' => $balance->tabungan,
                'pengeluaran' => $pengeluaranPerKategori['tabungan'] ?? 0,
            ],
            'utang' => [
                'budget' => $balance->utang,
                'pengeluaran' => $pengeluaranPerKategori['utang'] ?? 0,
            ],
        ];

        return view('visual', compact(
            'user',
            'totalPengeluaran',
            'pengeluaranData',
            'pemasukanData',
            'months',
            'totalSaldo',
            'kategoriData'
        ));
    }
}
