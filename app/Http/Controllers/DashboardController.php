<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use App\Models\Budgeting;
use App\Models\Expense;
use App\Models\SaldoTransaction;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Total pengeluaran dan saldo
        $totalPengeluaran = Expense::where('user_id', $user->id)->sum('jumlah');
        $totalSaldo = Balance::where('user_id', $user->id)->value('total_saldo') ?? 0;
        $totalTabungan = Budgeting::where('user_id', $user->id)->sum('tabungan');
        $pengeluaranTabungan = Expense::where('user_id', $user->id)
            ->where('kategori', 'tabungan')
            ->sum('jumlah');

        // Ambil data untuk 30 hari terakhir
        $days = 30;
        $dates = [];
        $pemasukanData = [];
        $pengeluaranData = [];

        // Siapkan tanggal untuk 30 hari terakhir
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dates[] = $date->format('d M'); // Format: "01 Mei"
        }

        // Ambil data pengeluaran per hari
        $pengeluaranPerHari = Expense::selectRaw('DATE(created_at) as tanggal, SUM(jumlah) as total')
            ->where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::today()->subDays($days))
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal')
            ->toArray();

        // Ambil data pemasukan per hari
        $pemasukanPerHari = SaldoTransaction::selectRaw('DATE(created_at) as tanggal, SUM(jumlah) as total')
            ->where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::today()->subDays($days))
            ->groupBy('tanggal')
            ->pluck('total', 'tanggal')
            ->toArray();

        // Siapkan data untuk grafik
        foreach ($dates as $date) {
            $carbonDate = Carbon::createFromFormat('d M', $date)->format('Y-m-d');
            $pemasukanData[] = $pemasukanPerHari[$carbonDate] ?? 0;
            $pengeluaranData[] = $pengeluaranPerHari[$carbonDate] ?? 0;
        }

        return view('dashboard', compact(
            'user',
            'totalPengeluaran',
            'pemasukanData',
            'pengeluaranData',
            'dates',
            'totalSaldo',
            'totalTabungan',
            'pengeluaranTabungan'
        ));
    }
}
