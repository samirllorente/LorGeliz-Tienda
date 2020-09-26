<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    protected $fillable = ['nombre', 'nit', 'razon_social', 'direccion', 'telefono', 'email','slug'];

    public static function boot () {
        parent::boot();
        
        static::creating(function(Proveedore $proveedor) {
          
          $slug = \Str::slug($proveedor->nombre);
          
          $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
          
          $proveedor->slug = $count ? "{$slug}-{$count}" : $slug;
          
        });

    }
    public function compras (){
        return $this->hasMany(Compra::class);
    }
}
