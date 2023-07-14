<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no_invoice');
            $table->dateTime('tanggal');
            $table->text('catatan')->nullable();
            $table->string('bayar', 255);
            // $table->decimal('bayar', 10, 2);
            $table->string('kasir')->nullable(); // Kolom "kasir" ditambahkan di sini
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
