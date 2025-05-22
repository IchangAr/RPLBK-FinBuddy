<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budgeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'saldo',
        'kebutuhan',
        'keinginan',
        'tabungan',
        'utang',
        'deskripsi',
    ];
}
