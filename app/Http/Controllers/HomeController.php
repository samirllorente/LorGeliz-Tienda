<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Producto;
use App\Carrito;
use App\Cliente;
use App\ColorProducto;
use App\Factura;

use Illuminate\Http\Request;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productoSlider = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop')
        ->where('productos.slider_principal', 'Si')
        ->where('productos.activo', 'Si')
        ->get();

        $nuevosproductos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id')
        ->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop')
        ->where('productos.estado', '=', '1')
        ->where('productos.activo', 'Si')
        ->orderBy('color_producto.producto_id', 'DESC')
        ->take(6)
        ->get();

        $producto_mas_visto = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id')
        ->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop', 'color_producto.visitas')
        ->where('color_producto.visitas', '>', '0')
        ->where('productos.activo', 'Si')
        ->orderBy('color_producto.visitas', 'DESC')
        ->take(5)
        ->get();
        
        $productos_vendidos = DB::table('productos')
        ->join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id')
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas', 'tallas.id', '=', 'producto_referencia.talla_id')
        ->join('producto_venta', 'producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        ->where('productos.activo', 'Si')
        ->select('color_producto.id as cop', 'productos.id', 'productos.nombre', 'productos.precio_actual', 'color_producto.slug as slug', DB::raw('SUM(producto_venta.cantidad) as cantidad')
        )->groupBy('producto_referencia.color_producto_id')
        ->orderBy('cantidad', 'DESC')
        ->take(5)
        ->get();

        $productosoferta = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id')
        ->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop')
        ->where('productos.estado', '=', '2')
        ->where('productos.activo', 'Si')
        ->orderBy('color_producto.producto_id', 'DESC')
        ->take(5)
        ->get();

        return view('tienda.index', compact('productoSlider', 'producto_mas_visto', 'productos_vendidos', 'nuevosproductos', 'productosoferta'));
    }



    public function categorias()
    {
        return view('tienda.categoria');
    }

    public function cart()
    {
        
        $cliente = Cliente::where('user_id',auth()->user()->id)->firstOrFail();
       
        $productos = Producto::
        //join('producto_referencia','productos.id', '=', 'producto_referencia.producto_id')
        join('color_producto','productos.id', '=', 'color_producto.producto_id')
        //->join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        //->join('colores','producto_referencia.color_id', '=', 'colores.id')
        ->join('carrito_producto', 'carrito_producto.producto_referencia_id','=','producto_referencia.id')
        ->join('carritos','carritos.id', '=', 'carrito_producto.carrito_id')
        ->select('productos.id as codigo','productos.nombre', 'productos.precio_actual', 'color_producto.slug', 'carritos.total as total', 'carrito_producto.cantidad', 'carritos.id as carrito', 'colores.nombre as color', 'color_producto.id as cop','tallas.nombre as talla')
        //->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('carritos.estado', 1)
        ->where('carritos.cliente_id', $cliente->id)
        ->get();
       // ->paginate(5);

        //return $productos;

        return view('tienda.cart', compact('productos'));
    }

    public function checkout()
    {
        $carrito = Carrito::where('estado', 1)
        ->where('cliente_id', auth()->user()->cliente->id)
        ->firstOrFail();

        return view('tienda.checkout', compact('carrito'));
    }

    public function product($slug)
    {
        $producto = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->select('productos.*', 'color_producto.id as cop', 'colores.id as color', 'color_producto.slug as slug', 'color_producto.visitas as visitas')
        ->where('color_producto.slug',$slug)->firstOrFail();
        
        return view('tienda.product', compact('producto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getProductos(Request $request){

        if (!$request->ajax()) return redirect('/');

        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id')
        ->select('color_producto.id as cop','productos.*','color_producto.slug as slug')
        ->where('productos.activo', 'Si')
        ->get();

        return ['productos' => $productos];

        //return Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        //->join('colores', 'color_producto.color_id', '=', 'colores.id')
        //->select('productos.*', 'color_producto.id as cop', 'color_producto.slug as slug')
        //->get();
    }
}
