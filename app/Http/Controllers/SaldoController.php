<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SaldoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
        'saldo' => 'required|numeric|min:0'
    ]);

    // Tambahkan logika simpan saldo

    return back()->with('success', 'Saldo berhasil ditambahkan!');
    }
}
