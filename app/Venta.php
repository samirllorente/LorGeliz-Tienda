<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['fecha', 'factura', 'valor', 'cliente_id'];
    
    public function pedido (){
        return $this->hasOne(Pedido::class);
    }

    public function devolucione (){
        return $this->hasOne(Devolucione::class);
    }

    public function productos (){
        return $this->belongsToMany(Producto::class);
    }

    public function metodoPago (){
        return $this->belongsTo(MetodoPago::class);
    }

    public function cliente (){
        return $this->belongsTo(Cliente::class);
    }

    public function factura (){
        return $this->belongsTo(Factura::class);
    }

    public function pago (){
        return $this->hasOne(Pago::class);
    }

public static function boot () {
    parent::boot();
        
    static::created(function(Venta $venta) {

        $cart = Carrito::where('cliente_id', auth()->user()->cliente->id)
        ->where('estado', 1)
        ->firstOrFail();

        $cart->estado = '0';
        $cart->save();

        $carritos = CarritoProducto::where('carrito_id', $cart->id)
        ->get();
    
        foreach ($carritos as $carrito) {
            
            $productoVenta = new ProductoVenta();

            $productoVenta->producto_referencia_id = $carrito->producto_referencia_id;
            $productoVenta->venta_id = $venta->id;
            $productoVenta->cantidad = $carrito->cantidad;

            $productoVenta->save();
        }
        
        $pedido = new Pedido();
        $pedido->fecha = \Carbon\Carbon::now();
        $pedido->direccion_entrega = Auth()->user()->direccion;
        $pedido->venta_id = $venta->id;
        $pedido->save();

        //$cliente = auth()->user()->cliente->id;

        //$details = [
            //'title' => 'Hemos recibido tu pedido',
            //'cliente' => $cliente,
            //'url' => url('/pedidos/'. $venta->id),
        //];
        
        //Mail::to(Auth()->user()->email)->send(new ClienteMessageMail($details));
        
    });

 }

}
