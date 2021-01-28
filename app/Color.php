<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = ['nombre', 'descripcion'];

    protected $table = 'colores';

    //public function productoReferencias() {
    //    return $this->hasMany(ProductoReferencia::class);
    //}

    public function colorProductos () {
        return $this->hasMany(ColorProducto::class);
    }
}
