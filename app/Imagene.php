<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagene extends Model
{
    protected $fillable = [
       'nombre', 'url', 'imageble_type', 'imageable_id'
    ];

    public function imageable(){
        return $this->morphTo();
    }
}
