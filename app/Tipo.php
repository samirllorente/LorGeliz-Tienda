<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    
    protected $fillable = [
        'nombre', 
        'descripcion',
        'subcategoria_id',
    ];

    //public $timestamps = false;

    public static function boot () {
        parent::boot();
        
        static::creating(function(Tipo $tipo) {
          
          $slug = \Str::slug($tipo->descripcion);
          
          $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
          
          $tipo->slug = $count ? "{$slug}-{$count}" : $slug;
          
        });

    }
    

    public function subcategoria (){
        return $this->belongsTo(Subcategoria::class);
    }

    public function productos (){
        return $this->hasMany(Producto::class);
    }

    public function tallas (){
        return $this->belongsToMany(Talla::class);
    }


}
