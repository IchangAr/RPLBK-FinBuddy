<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',     // Menambahkan user_id agar bisa digunakan dalam mass assignment
        'jumlah',      // Kolom jumlah untuk saldo
        'type',        // Jenis transaksi (credit/debit)
        'deskripsi',   // Deskripsi transaksi (opsional)
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

