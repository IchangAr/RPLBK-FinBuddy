<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function updateSaldo(Request $request)
    {
        // Validasi input saldo
        $request->validate([
            'saldo' => 'required|numeric|min:0',
        ]);

        // Mendapatkan user yang sedang login
        $user = \App\Models\User::find(Auth::id());

        // Pastikan user ditemukan
        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan!');
        }

        // Mengupdate saldo
        $user->saldo = $request->saldo;

        // Simpan perubahan saldo ke database
        if ($user->save()) {
            return redirect()->back()->with('success', 'Saldo berhasil diperbarui!');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui saldo.');
        }
    }
}

