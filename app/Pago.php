<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = ['ref_epayco','fecha','monto','venta_id','estado'];
    //public $timestamps = false;

    public function venta(){
       return $this->belongsTo(Venta::class);
    }
}
