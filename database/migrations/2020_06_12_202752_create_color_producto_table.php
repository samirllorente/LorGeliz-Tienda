<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('color_producto', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('color_id');
            $table->foreign('color_id')->references('id')->on('color');
            $table->unsignedInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('producto');
            $table->integer('visitas');
            $table->string('slug');
            $table->string('slider_principal');
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
        Schema::dropIfExists('color_producto');
    }
}
