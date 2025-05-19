<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Contoh data, bisa kamu ganti ambil dari DB
        $labels = ['Pengeluaran', 'Pemasukan'];
        $data = [3, 2];  // Pengeluaran 750k, Budget 1 juta

        return view('dashboard', compact('labels', 'data'));
    }
}
