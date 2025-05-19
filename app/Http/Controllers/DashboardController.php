<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::find(Auth::id());
        // Contoh data, bisa kamu ganti ambil dari DB
        $labels = ['Pengeluaran', 'Pemasukan'];
        $data = [3, 2];
        // Jika kamu ingin mengambil data dari database, misalnya dari model User


        return view('dashboard', compact('user', 'labels', 'data'));
    }
}
