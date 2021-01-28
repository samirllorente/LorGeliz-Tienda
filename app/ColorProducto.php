<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColorProducto extends Model
{
    protected $table = 'color_producto';
    protected $fillable = [
        'producto_id', 
        'color_id',
        'visitas',
        'slug',
        'slider_principal'
    ];

    public static function boot () {
        parent::boot();
        
        static::creating(function(ColorProducto $colorproducto) {

            $nombre = request()->nombre;
            $id = request()->color;

            $color = Color::where('id', $id)->first();
            
            $slug = \Str::slug($nombre);
            
            //$count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            
            $colorproducto->slug = "{$slug}-{$color['nombre']}";
          
        });

    }

    public $timestamps = false;

    public function producto () {
        return $this->belongsTo(Producto::class);
    }

    public function color (){
        return $this->belongsTo(Color::class);
    }

    public function productoReferencias (){
        return $this->hasMany(ProductoReferencia::class);
    }

    public function imagenes (){
        return $this->morphMany('App\Imagene','imageable');
    }
}
