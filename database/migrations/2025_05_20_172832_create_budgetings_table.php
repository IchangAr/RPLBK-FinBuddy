<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetingsTable extends Migration
{
    public function up()
{
    Schema::create('budgetings', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->bigInteger('saldo');
        $table->bigInteger('kebutuhan');
        $table->bigInteger('keinginan');
        $table->bigInteger('tabungan');
        $table->bigInteger('utang');
        $table->text('deskripsi')->nullable();
        $table->timestamps();

        // Relasi ke tabel users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}


    public function down()
    {
        Schema::dropIfExists('budgetings');
    }
}
