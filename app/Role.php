<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const CLIENTE = 1;
    const ADMIN = 2;
    
    public function users (){
        return $this->hasMany(User::class);
    }

}
