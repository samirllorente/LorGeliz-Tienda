<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevolucionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->integer('cantidad');
            $table->unsignedInteger('producto_referencia_id');
            $table->foreign('producto_referencia_id')->references('id')->on('producto_referencia');
            $table->unsignedInteger('venta_id');
            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->enum('estado', [
                \App\Devolucione::PENDIENTE,\App\Devolucione::EN_PROCESO,
                \App\Devolucione::RECHAZADA,\App\Devolucione::COMPLETADA
            ])->default(\App\Devolucione::PENDIENTE);
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
        Schema::dropIfExists('devoluciones');
    }
}
