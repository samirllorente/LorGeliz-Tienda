<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'tipo_id'];

    public function tipo() {
        return $this->belongsTo(Tipo::class);
    }

    public function productoReferencias() {
        return $this->hasMany(ProductoReferencia::class);
    }

}
