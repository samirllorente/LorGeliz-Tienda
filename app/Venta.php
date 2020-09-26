<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['fecha', 'factura', 'valor', 'cliente_id'];
    
    public function pedido (){
        return $this->hasOne(Pedido::class);
    }

    public function devolucione (){
        return $this->hasOne(Devolucione::class);
    }

    //public function articulos (){
        //return $this->belongsToMany(Articulo::clasProducto

    public function productos (){
        return $this->belongsToMany(Producto::class);
    }

    public function metodoPago (){
        return $this->belongsTo(MetodoPago::class);
    }

    public function cliente (){
        return $this->belongsTo(Cliente::class);
    }

    public function factura (){
        return $this->belongsTo(Factura::class);
    }


}
