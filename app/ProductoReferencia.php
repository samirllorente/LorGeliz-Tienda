<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoReferencia extends Model
{
    protected $fillable = ['color_producto_id', 'talla_id', 'stock'];
    protected $table = 'producto_referencia';

    //public $timestamps = false;

   // public function producto () {
   //     return $this->belongsTo(Producto::class);
   // }

   // public function color (){
   //     return $this->belongsTo(Color::class);
    //}

    //public function ColorProducto (){
       //return $this->belongsTo(ColorProducto::class);
    //}

    //public function talla (){
        //return $this->belongsTo(Talla::class);
    //}

    public function devoluciones (){
        return $this->hasMany(Devolucione::class);
    }

    public function carritos (){
        return $this->belongsToMany(Carrito::class);
    }

    public function ventas (){
        return $this->belongsToMany(Venta::class);
    }

}
