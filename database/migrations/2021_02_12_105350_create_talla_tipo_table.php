<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTallaTipoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talla_tipo', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('talla_id');
            $table->foreign('talla_id')->references('id')->on('tallas');
            $table->unsignedInteger('tipo_id');
            $table->foreign('tipo_id')->references('id')->on('tipos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('talla_tipo');
    }
}
