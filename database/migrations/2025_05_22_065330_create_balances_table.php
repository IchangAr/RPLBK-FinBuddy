<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancesTable extends Migration
{
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique();
            $table->bigInteger('total_saldo')->default(0);
            $table->bigInteger('kebutuhan')->default(0);
            $table->bigInteger('keinginan')->default(0);
            $table->bigInteger('tabungan')->default(0);
            $table->bigInteger('utang')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('balances');
    }
}
