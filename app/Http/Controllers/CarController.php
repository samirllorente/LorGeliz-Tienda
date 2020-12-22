<?php

namespace App\Http\Controllers;

use App\Carrito;
use App\CarritoProducto;
use App\Cliente;
use App\ColorProducto;
use App\Producto;
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
        //$this->middleware('auth');
    }

    public function index()
    {
        
        $cliente = Cliente::where('user_id',auth()->user()->id)->firstOrFail();
       
        $productos = Producto::
        join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        ->join('carrito_producto', 'carrito_producto.producto_referencia_id','=','producto_referencia.id')
        ->join('carritos','carritos.id', '=', 'carrito_producto.carrito_id')
        ->select('productos.id as codigo','productos.nombre', 'productos.precio_actual', 'productos.descripcion_corta','color_producto.slug', 'carritos.total as total', 'carrito_producto.cantidad', 'carritos.id as carrito', 'colores.nombre as color', 'color_producto.id as cop','tallas.nombre as talla', 'producto_referencia.id as ref', 'producto_referencia.stock', 'imagenes.url as imagen')
        ->where('carritos.estado', 1)
        ->where('carritos.cliente_id', $cliente->id)
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->groupBy('producto_referencia.id')
        //->groupBy('color_producto.id')
        ->get();

        return view('tienda.cart', compact('productos'));
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
            ->select('producto_referencia.id as referencia', 'producto_referencia.stock','productos.*')
            ->get();

            $total = $carrito->total;
            $precio = $producto[0]->precio_actual;
            
            $carrito->total = ($request->cantidad * $precio) + $total;

            $cart = CarritoProducto::where('carrito_id',$carrito->id)
            ->where('producto_referencia_id',$producto[0]->referencia)
            ->first();

            if ($cart) {

                $nuevaCantidad = $cart->cantidad + $request->cantidad;

                if ($nuevaCantidad > $producto[0]->stock) {

                    $response = ['data' => 'error', 'carrito' => $cart->cantidad, 'stock' => $producto[0]->stock];
                    return response()->json($response);
                }
                else{
                    $cart->cantidad = $nuevaCantidad;
                    $cart->save();
                }
            }
            else{

                $carritoProducto = new CarritoProducto();

                $carritoProducto->producto_referencia_id = $producto[0]->referencia;
                $carritoProducto->carrito_id = $carrito->id;
                $carritoProducto->cantidad = $request->cantidad;

                $carritoProducto->save();
            }

            $carrito->save();

            DB::commit();

            $response = ['data' => 'success'];

            return response()->json($response);

        } catch (Exception $e) {
            DB::rollBack();
        }
        
    }


    public function delete(Request $request)
    {
        if (!$request->ajax()) return redirect('/cart');
        
        try{

            DB::beginTransaction();

            $productos = CarritoProducto::where('carrito_id', $request->carrito)->get();

            foreach ($productos as $producto) {
                $producto->delete();
            }

            $carrito = Carrito::where('id', $request->carrito)->first();

            $carrito->delete();
            DB::commit();
        }

        catch (\Exception $exception){
             DB::rollBack();
        }
    }

    public function updateProduct(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        try {
            
            DB::beginTransaction();

            $productos = $request->producto;
            $cantidad = $request->unidades;

            $carrito = Carrito::where('cliente_id', auth()->user()->cliente->id)
            ->where('estado', 1)
            ->first();

            $total = 0;
        
            foreach ($productos as $key => $value) {

               
                $carrito_productos = CarritoProducto::where('carrito_id', $carrito->id)
                ->where('producto_referencia_id', $value)
                ->first();
                
                $cnt = $carrito_productos->cantidad;

                $carrito_productos->cantidad = $cantidad[$key];

                if ($cantidad[$key] == 0) {
                    $carrito_productos->delete();
                } else {
                    $carrito_productos->save();
                }
                
                $producto = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
                ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
                ->where('producto_referencia.id', $value)
                ->select('productos.precio_actual')
                ->first();
            
                $tproduct = $producto->precio_actual * ($cantidad[$key] - $cnt);
                $total = $total + $tproduct;
               
            }

            $carrito->total = $carrito->total + $total;
            $carrito->save();

            DB::commit();

            $response = ['data' => 'success'];
            
            return response()->json($response);

        } catch (\Exception $exception){
            DB::rollBack();
        }
        
    }

    public function userCart(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        if (auth()->user()) {
            $productos = CarritoProducto::join('carritos','carritos.id', '=', 'carrito_producto.carrito_id')
            ->where('carritos.cliente_id', auth()->user()->cliente->id)
            ->where('carritos.estado', 1)
            ->count();
        }
        else{
            $productos = 0;
        }

        $response = ['data' => $productos];
        
        return response()->json($response);
    }

    public function remove(Request $request)
    {
        if (!$request->ajax()) return redirect('/cart');

        try {
           
            $carrito = Carrito::where('cliente_id', auth()->user()->cliente->id)
            ->where('estado', '1')->first();

            $car_producto = CarritoProducto::where('producto_referencia_id', $request->producto)
            ->where('carrito_id', $carrito->id)
            ->first();

            $producto = Producto::join('color_producto', 'productos.id', 'color_producto.producto_id')
            ->join('producto_referencia', 'color_producto.id', 'producto_referencia.color_producto_id')
            ->where('producto_referencia.id', $request->producto)
            ->first();

            $carrito->total = $carrito->total - ($producto->precio_actual * $car_producto->cantidad);

            $carrito->save();

            $car_producto->delete();

        } catch (\Exception $exception) {
            
        }
    }
}
