<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    const NUEVO = 1;
    const OFERTA = 2;
    

    //protected $with = ['tipo']; carga una relación cuando se recupera este modelo

    protected $fillable = ['nombre', 'tipo_id', 'marca', 'talla', 'precioanterior', 'precioactual', 'porcentajededescuento', 'descripcion_corta', 'descripcion_larga', 'especificaciones','slug'];

    //public static function boot () {
      //  parent::boot();
        
       // static::creating(function(Producto $producto) {
          
         // $slug = \Str::slug($producto->nombre);
          
         // $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
          
         // $producto->slug = $count ? "{$slug}-{$count}" : $slug;
          
        //});

   // }

    public function tipo (){
        return $this->belongsTo(Tipo::class);
    }

    public function devoluciones (){
        return $this->hasMany(Devolucione::class);
    }

    public function carritos (){
        return $this->belongsToMany(Carrito::class);
    }

    public function compras (){
        return $this->belongsToMany(Compra::class);
    }

    public function ventas (){
        return $this->belongsToMany(Venta::class);
    }

   // public function imagenes (){
   //     return $this->morphMany('App\Imagene','imageable');
    //}

    //public function productoReferencias() {
     //   return $this->hasMany(ProductoReferencia::class);
    //}

    public function colorproductos() {
        return $this->hasMany(ColorProducto::class);
    }
}
