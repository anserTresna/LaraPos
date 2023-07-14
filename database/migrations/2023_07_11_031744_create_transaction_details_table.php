<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
    $table->increments('id');
    $table->unsignedInteger('product_id');
    $table->unsignedInteger('transaction_id');
    $table->integer('quantity');
    $table->decimal('subtotal', 13, 2);
    $table->timestamps();

    // Add foreign key constraints
    $table->foreign('product_id')->references('id')->on('produk')->onDelete('cascade');
    $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
});

    }

    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
