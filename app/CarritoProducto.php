<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarritoProducto extends Model
{
    protected $table = 'carrito_producto';
    protected $fillable = [
        'producto_referencia_id', 
        'carrito_id',
        'cantidad',
    ];

    public $timestamps = false;
}
