<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $fillable = ['fecha', 'total', 'cliente_id', 'estado'];
    
    public function cliente (){
        return $this->belongsTo(Cliente::class);
    }

    public function productos (){
        return $this->belongsToMany(Producto::class);
    }

   
}
