<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    public function user (){
        return $this->belongsTo(User::class);
    }

    public function carritos (){
        return $this->hasMany(Carrito::class);
    }

    public function ventas (){
        return $this->hasMany(Venta::class);
    }
}
