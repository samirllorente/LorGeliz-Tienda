<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->unsignedInteger('tipo_id');
            $table->foreign('tipo_id')->references('id')->on('tipos');
            $table->text('descripcion_corta');
            $table-text('descripcion_larga');
            $table->text('especificaciones');
            $table->string('marca');
            $table->decimal('precio_actual');
            $table->decimal('precio_anterior');
            $table->string('porcentaje_descuento');
            $table->enum('estado', [
                \App\Producto::NUEVO, \App\Producto::OFERTA
            ])->default(\App\Producto::NUEVO);
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
        Schema::dropIfExists('productos');
    }
}
