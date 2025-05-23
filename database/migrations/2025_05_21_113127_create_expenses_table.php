<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            // Enum kategori sesuai dengan input <select> di form
            $table->enum('kategori', ['kebutuhan', 'keinginan', 'tabungan', 'utang']);

            $table->bigInteger('jumlah');
            $table->text('deskripsi')->nullable();


            $table->timestamps();

            // Relasi
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}
