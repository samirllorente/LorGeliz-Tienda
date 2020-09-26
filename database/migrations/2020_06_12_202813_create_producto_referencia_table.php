<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoReferenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_referencia', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('color_producto_id');
            $table->foreign('color_producto_id')->references('id')->on('color_producto');
            $table->unsignedInteger('talla_id');
            $table->foreign('talla_id')->references('id')->on('talla');
            $table->integer('stock');
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
        Schema::dropIfExists('producto_referencia');
    }
}
