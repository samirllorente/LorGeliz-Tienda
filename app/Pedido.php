<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    const PENDIENTE = 1;
    const PROCESADO = 2;
    const ENVIADO = 3;
    const ENTREGADO = 4;

    public function venta (){
        return $this->belongsTo(Venta::class);
    }

}
