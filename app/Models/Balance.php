<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_saldo',
        'kebutuhan',
        'keinginan',
        'tabungan',
        'utang',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Mutator untuk menghitung total saldo
    public function setTotalSaldoAttribute()
    {
        $this->attributes['total_saldo'] = $this->kebutuhan + $this->keinginan + $this->tabungan + $this->utang;
    }

    // Method untuk memperbarui total_saldo setelah perubahan
    public function updateTotalSaldo()
    {
        $this->total_saldo = $this->kebutuhan + $this->keinginan + $this->tabungan + $this->utang;
        $this->save();
    }
}
