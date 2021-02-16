<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TallaTipo extends Model
{
    protected $table = 'talla_tipo';
    protected $fillable = [
        'talla_id', 
        'tipo_id',
    ];

    public $timestamps = false;
}
