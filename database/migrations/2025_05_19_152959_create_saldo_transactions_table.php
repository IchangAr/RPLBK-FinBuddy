<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldoTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('saldo_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relasi dengan tabel users
            $table->decimal('jumlah', 15, 2); // Jumlah saldo yang ditambahkan
            $table->enum('type', ['credit', 'debit']); // Jenis transaksi
            $table->text('deskripsi')->nullable(); // Deskripsi transaksi
            $table->timestamps(); // Kolom created_at dan updated_at

            // Relasi ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('saldo_transactions');
    }
}
