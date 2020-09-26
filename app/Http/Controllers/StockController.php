<?php

namespace App\Http\Controllers;
use App\ColorProducto;
use App\Producto;
use App\ProductoReferencia;

use Illuminate\Http\Request;
use App\Http\Requests\StockRequest;

class StockController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $nombre = $request->get('nombre');

        $productos = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        ->where('productos.nombre','like',"%$nombre%")
        ->where('producto_referencia.stock', '>', '0')
        ->select('productos.*', 'producto_referencia.talla_id', 'color_producto.id as cop', 'producto_referencia.stock', 'color_producto.slug as slug', 'colores.nombre as color', 'tallas.nombre as talla')
        ->orderBy('productos.id')->paginate(5);

        return view('admin.stocks.index',compact('productos'));

        
    }

    public function store(StockRequest $request){

        $colorproducto = ColorProducto::where('color_id', $request->color_id)
        ->where('producto_id', $request->producto_id)
        ->first();

        $referencia = ProductoReferencia::where('color_producto_id', $colorproducto->id)
        ->where('talla_id', $request->talla_id)
        ->first();


        if ($referencia == '') {

            $producto = new ProductoReferencia();
            $producto->color_producto_id = $colorproducto->id;
            $producto->talla_id = $request->talla_id;
            $producto->stock = $request->cantidad;
    
            $producto->save();  
        }
        else{

            $referencia->stock = $referencia->stock + $request->cantidad;

            $referencia->save();
        }

        session()->flash('message', ['success', ("Se ha actualizado el inventario exitosamente")]);

        return back();

    }
}
