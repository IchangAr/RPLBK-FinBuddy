<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class VisualController extends Controller
{
    public function visual()
    {
        $user = \App\Models\User::find(Auth::id());
        // Contoh data, bisa kamu ganti ambil dari DB
        $labels = ['Pengeluaran', 'Pemasukan'];
        $data = [3, 2];
        // Jika kamu ingin mengambil data dari database, misalnya dari model User


        return view('visual', compact('user', 'labels', 'data'));
    }
}

