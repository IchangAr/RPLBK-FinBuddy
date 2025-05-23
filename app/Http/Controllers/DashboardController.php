<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\SaldoTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Total pengeluaran
        $totalPengeluaran = Expense::where('user_id', $user->id)->sum('jumlah');
        // Total pemasukan
        $totalSaldo = Balance::where('user_id', $user->id)->value('total_saldo');

        // Ambil data pengeluaran per bulan
        $pengeluaranPerBulan = Expense::selectRaw('MONTH(created_at) as bulan, SUM(jumlah) as total')
            ->where('user_id', $user->id)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan');

        // Ambil data pemasukan per bulan
        $pemasukanPerBulan = SaldoTransaction::selectRaw('MONTH(created_at) as bulan, SUM(jumlah) as total')
            ->where('user_id', $user->id)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan');

        // Siapkan array data per bulan (default 0)
        $pengeluaranData = [];
        $pemasukanData = [];
        $saldoBulanan = [];

        for ($i = 1; $i <= 12; $i++) {
            $pengeluaran = $pengeluaranPerBulan[$i] ?? 0;
            $pemasukan = $pemasukanPerBulan[$i] ?? 0;

            $pengeluaranData[] = $pengeluaran;
            $pemasukanData[] = $pemasukan;
            $saldoBulanan[] = $pemasukan - $pengeluaran;
        }

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // Untuk pie chart summary
        $labels = ['Pemasukan', 'Pengeluaran'];
        $data = [array_sum($pemasukanData), array_sum($pengeluaranData)];

        return view('dashboard', compact(
            'user',
            'totalPengeluaran',
            'pemasukanData',
            'pengeluaranData',
            'saldoBulanan',
            'months',
            'labels',
            'data',
            'totalSaldo',
        ));
    }
}
