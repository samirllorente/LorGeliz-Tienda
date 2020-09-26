<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarritoProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carrito_producto', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('carrito_id');
            $table->foreign('carrito_id')->references('id')->on('carrito');
            $table->unsignedInteger('producto_referencia_id');
            $table->foreign('producto_referencia_id')->references('id')->on('producto_referencia');
            $table->integer('cantidad');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carrito_producto');
    }
}
