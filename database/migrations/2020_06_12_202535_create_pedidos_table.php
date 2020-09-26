<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha');
            $table->string('direccion_entrega');
            $table->enum('estado', [
                \App\Pedido::PENDIENTE, \App\Pedido::PROCESADO, \App\Pedido::ENVIADO, \App\Pedido::ENTREGADO
            ])->default(\App\Pedido::PENDIENTE);
            $table->unsignedInteger('venta_id');
            $table->foreign('venta_id')->references('id')->on('ventas');
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
        Schema::dropIfExists('pedidos');
    }
}
