<?php

namespace App\Http\Controllers;

use App\Models\Income;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function index()
{
    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // Mengambil data pemasukan yang terkait dengan user yang sedang login
        $incomes = Income::where('user_id', auth()->id())->get();

        // Mengirimkan data ke view
        return view('income.index', compact('incomes'));
    }


}
