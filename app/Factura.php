<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable = ['prefijo', 'consecutivo'];
    public $timestamps = false;
    
    public function venta (){
        return $this->hasOne(Venta::class);
    }
}
