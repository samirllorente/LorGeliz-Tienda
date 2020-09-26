<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    public function ventas (){
        return $this->hasMany(Venta::class);
    }

     public function compras (){
        return $this->hasMany(Compra::class);
    }
}
