<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expenses';

    // Definisikan kolom yang dapat diisi massal
    protected $fillable = [
        'user_id', 'budgeting_id', 'kategori', 'jumlah', 'deskripsi'
    ];

    // Definisikan relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Definisikan relasi dengan model Budgeting
    public function budgeting()
    {
        return $this->belongsTo(Budgeting::class);

    }

    // public function dashboard()
    // {
    //     return $this->belongsTo(Dashboard::class);

    // }


}
