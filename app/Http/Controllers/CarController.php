<?php

namespace App\Http\Controllers;

use App\Carrito;
use App\Producto;
use App\CarritoProducto;
use App\ProductoReferencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarController extends Controller
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

    public function buscarCarrito(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
        
        $carrito = Carrito::where('estado', '1')
        ->where('cliente_id', auth()->user()->cliente->id)
        ->get();

        return ['carrito' => $carrito];
    }

    public function store(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');
        //$carrito = Carrito::where('cliente_id', auth()->user()->cliente->id)->where('estado', '1')->firstOrFail();

        try {

            DB::beginTransaction();

            $producto = ProductoReferencia::join('color_producto', 'producto_referencia.color_producto_id', '=', 'color_producto.id')
            ->join('productos', 'color_producto.producto_id', '=','productos.id')
            ->where('producto_referencia.color_producto_id', $request->producto)
            ->where('producto_referencia.talla_id', $request->talla)
            ->select('producto_referencia.id as referencia', 'productos.*')
            ->get();

            $precio = $producto[0]->precio_actual;
            $cantidad = $request->cantidad;

            $carrito = new Carrito();
            $carrito->fecha = \Carbon\Carbon::now();
            $carrito->total = $cantidad * $precio;
            $carrito->cliente_id = auth()->user()->cliente->id;
            $carrito->estado = '1';

            $carrito->save();

            $carritoProducto = new CarritoProducto();
            $carritoProducto->producto_referencia_id = $producto[0]->referencia;
            $carritoProducto->carrito_id = $carrito->id;
            $carritoProducto->cantidad = $cantidad;

            $carritoProducto->save();

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }

    
    }


    public function update(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');

        try {

            DB::beginTransaction();

            $carrito = Carrito::where('id', $request->carrito)->firstOrFail();

            $producto = ProductoReferencia::join('color_producto', 'producto_referencia.color_producto_id', '=', 'color_producto.id')
            ->join('productos', 'color_producto.producto_id', '=','productos.id')
            ->where('producto_referencia.color_producto_id', $request->producto)
            ->where('producto_referencia.talla_id', $request->talla)
            ->select('producto_referencia.id as referencia', 'productos.*')
            ->get();

            $total = $carrito->total;
            $precio = $producto[0]->precio_actual;
            
            $carrito->total = ($request->cantidad * $precio) + $total;

            $carrito->save();


            $cart = CarritoProducto::where('carrito_id',$carrito->id)
            ->where('producto_referencia_id',$producto[0]->referencia)
            ->first();

            if ($cart) {

                $cart->cantidad = $cart->cantidad + $request->cantidad;

                $cart->save();
                
            }
            else{

                $carritoProducto = new CarritoProducto();

                $carritoProducto->producto_referencia_id = $producto[0]->referencia;
                $carritoProducto->carrito_id = $carrito->id;
                $carritoProducto->cantidad = $request->cantidad;

                $carritoProducto->save();

            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }
        
    }


    public function delete(Carrito $carrito)
    {
        try{

            $carrito->delete();

            //session()->flash('message', ['success', ("Se ha eliminado la clase exitosamente")]);
            return back();
        }

        catch (\Exception $exception){
            return back();
        }
    }
}
