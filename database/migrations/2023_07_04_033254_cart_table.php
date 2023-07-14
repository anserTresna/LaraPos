<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new Class extends Migration
{
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity');
            $table->unsignedInteger('produk_id');
            $table->timestamps();

            $table->foreign('produk_id')->references('id')->on('produk');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart');
    }
};
