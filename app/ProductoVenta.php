<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoVenta extends Model
{
    protected $table = 'producto_venta';
    protected $fillable = [
        'producto_id', 
        'venta_id',
        'cantidad',
    ];

    public $timestamps = false;
}
