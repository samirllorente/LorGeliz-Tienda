<?php

namespace App\Http\Controllers;

use App\Carrito;
use App\Cliente;
use App\ColorProducto;
use App\Factura;
use App\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $productoSlider = Producto::join('color_producto','productos.id','color_producto.producto_id')
        ->join('imagenes','color_producto.id','imagenes.imageable_id')
        ->join('producto_referencia','color_producto.id','producto_referencia.color_producto_id')
        ->select('productos.*','color_producto.slug as slug','color_producto.id as cop', 'imagenes.url as imagen')
        ->where('productos.slider_principal', 'Si')
        ->where('color_producto.activo', 'Si')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('producto_referencia.stock', '>', '0')
        ->groupBy('color_producto.id')
        ->get();

        //$nuevosproductos = Producto::join('color_producto','productos.id','color_producto.producto_id')
        //->join('imagenes','color_producto.id','imagenes.imageable_id')
        //->join('colores','color_producto.color_id','colores.id')
        //->join('tipos','productos.tipo_id','tipos.id')
        //->join('producto_referencia','color_producto.id','producto_referencia.color_producto_id')
        //->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop', 'tipos.nombre as tipo', 'tipos.id as tipo_id', 'colores.nombre as color', 'imagenes.url as imagen')
        //->where('productos.estado', '=', '1')
        //->where('color_producto.activo', 'Si')
        //->where('imagenes.imageable_type', 'App\ColorProducto')
        //->where('producto_referencia.stock', '>', '0')
        //->groupBy('color_producto.id')
        //->orderBy('color_producto.producto_id', 'DESC')
        //->take(9)
        //->get();

        $producto_mas_visto = Producto::join('color_producto','productos.id','color_producto.producto_id')
        ->join('imagenes','color_producto.id','imagenes.imageable_id')
        ->join('colores','color_producto.color_id','colores.id')
        ->join('tipos','productos.tipo_id','tipos.id')
        ->join('producto_referencia','color_producto.id','producto_referencia.color_producto_id')
        ->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop', 'color_producto.visitas', 'tipos.nombre as tipo', 'tipos.id as tipo_id', 'colores.nombre as color', 'imagenes.url as imagen')
        ->where('color_producto.visitas', '>', '0')
        ->where('color_producto.activo', 'Si')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('producto_referencia.stock', '>', '0')
        ->groupBy('color_producto.id')
        ->orderBy('color_producto.visitas', 'DESC')
        ->take(5)
        ->get();

        
        $productos_vendidos = DB::table('productos')
        ->join('color_producto','productos.id','color_producto.producto_id')
        ->join('imagenes','color_producto.id','imagenes.imageable_id')
        ->join('colores','color_producto.color_id','colores.id')
        ->join('tipos','productos.tipo_id','tipos.id')
        ->join('producto_referencia','color_producto.id','producto_referencia.color_producto_id')
        ->join('producto_venta','producto_referencia.id','producto_venta.producto_referencia_id')
        ->where('color_producto.activo', 'Si')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('producto_referencia.stock', '>', '0')
        ->select('color_producto.id as cop', 'productos.id', 'productos.nombre', 'productos.precio_actual', 'color_producto.slug as slug', 'tipos.nombre as tipo', 'tipos.id as tipo_id', 'colores.nombre as color', 'imagenes.url as imagen', DB::raw('SUM(producto_venta.cantidad) as cantidad')
        )->groupBy('producto_referencia.color_producto_id')
        ->orderBy('cantidad', 'DESC')
        ->take(5)
        ->get();

        //return $productos_vendidos;

        $productosoferta = Producto::join('color_producto','productos.id','color_producto.producto_id')
        ->join('imagenes','color_producto.id','imagenes.imageable_id')
        ->join('colores','color_producto.color_id','colores.id')
        //->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        ->join('producto_referencia','color_producto.id','producto_referencia.color_producto_id')
        ->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop','colores.nombre as color', 'imagenes.url as imagen')
        ->where('productos.estado', '=', '2')
        ->where('color_producto.activo', 'Si')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('producto_referencia.stock', '>', '0')
        ->groupBy('color_producto.id')
        ->orderBy('color_producto.producto_id', 'DESC')
        ->take(5)
        ->get();

        return view('tienda.index', compact('productoSlider', 'producto_mas_visto', 'productos_vendidos', 'productosoferta'));
    }
    // función para implementar index con ajax
    public function productsIndex()
    {
        //$slider = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        //->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        //->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        //->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop', 'imagenes.url as imagen')
        //->where('productos.slider_principal', 'Si')
        //->where('color_producto.activo', 'Si')
        //->where('imagenes.imageable_type', 'App\ColorProducto')
        //->where('producto_referencia.stock', '>', '0')
        //->groupBy('color_producto.id')
        //->get();

        $nuevos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id')
        ->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop', 'tipos.nombre as tipo', 'colores.nombre as color', 'imagenes.url as imagen')
        ->where('productos.estado', '=', '1')
        ->where('color_producto.activo', 'Si')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('producto_referencia.stock', '>', '0')
        ->groupBy('color_producto.id')
        ->orderBy('color_producto.producto_id', 'DESC')
        ->take(6)
        ->get();

        //$populares = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        //->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        //->join('colores', 'color_producto.color_id', '=', 'colores.id')
        //->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        //->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        //->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop', 'color_producto.visitas', 'tipos.//nombre as tipo', 'colores.nombre as color', 'imagenes.url as imagen')
        //->where('color_producto.visitas', '>', '0')
        //->where('color_producto.activo', 'Si')
        //->where('imagenes.imageable_type', 'App\ColorProducto')
        //->where('producto_referencia.stock', '>', '0')
        //->groupBy('color_producto.id')
        //->orderBy('color_producto.visitas', 'DESC')
        //->take(5)
        //->get();

        
        //$vendidos = DB::table('productos')
        //->join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        //->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        //->join('colores', 'color_producto.color_id', '=', 'colores.id')
        //->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        //->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        //->join('producto_venta', 'producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        //->where('color_producto.activo', 'Si')
        //->where('imagenes.imageable_type', 'App\ColorProducto')
        //->where('producto_referencia.stock', '>', '0')
        //->select('color_producto.id as cop', 'productos.id', 'productos.nombre', 'productos.precio_actual', 'color_producto.slug as slug', 'tipos.nombre as tipo', 'colores.nombre as color', 'imagenes.url as imagen', DB::raw('SUM(producto_venta.cantidad) as cantidad')
       // )->groupBy('producto_referencia.color_producto_id')
        //->orderBy('cantidad', 'DESC')
        //->take(5)
        //->get();

        //$ofertas = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        //->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        //->join('colores', 'color_producto.color_id', '=', 'colores.id')
        //->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        //->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        //->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop', 'tipos.nombre as tipo','colores.//nombre as color', 'imagenes.url as imagen')
        //->where('productos.estado', '=', '2')
        //->where('color_producto.activo', 'Si')
        //->where('imagenes.imageable_type', 'App\ColorProducto')
        //->where('producto_referencia.stock', '>', '0')
        //->groupBy('color_producto.id')
        //->orderBy('color_producto.producto_id', 'DESC')
        //->take(2)
        //->get();

        //return ['slider' => $slider, 'nuevos' => $nuevos, 'populares' => $populares, 'vendidos' => $vendidos, 'ofertas' => $ofertas];
        return ['nuevos' => $nuevos];
    }
    
    public function categorias(Request $request)
    {
        $categoria = $request->categoria;
        $subcategoria = $request->subcategoria;
        
        return view('tienda.categoria', compact('categoria','subcategoria'));
    }

    public function checkout()
    {
        $carrito = Carrito::join('clientes','carritos.cliente_id', '=', 'clientes.id')
        ->join('users','clientes.user_id', '=', 'users.id')
        ->where('estado', 1)
        ->where('cliente_id', auth()->user()->cliente->id)
        ->select('carritos.*', 'users.nombres', 'users.apellidos', 'users.direccion', 'users.telefono',
        'users.identificacion')
        ->firstOrFail();

        return view('tienda.checkout', compact('carrito'));
    }

    public function product($slug)
    {
        $producto = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->select('productos.*', 'color_producto.id as cop', 'colores.id as color', 'color_producto.slug as slug', 'color_producto.visitas as visitas', 'colores.nombre as colores')
        ->where('color_producto.slug',$slug)->firstOrFail();
        
        return view('tienda.product', compact('producto'));
    }

    public function getProductos(Request $request)
    {
        //obtener todos los productos, en vista categorías
        if (!$request->ajax()) return redirect('/');

        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->select('color_producto.id as cop','productos.*','color_producto.slug as slug', 'imagenes.url', 'tipos.nombre as tipo', 'colores.nombre as color')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('color_producto.activo', 'Si')
        ->where('producto_referencia.stock', '>', '0')
        ->groupBy('color_producto.id')
        ->paginate(12);

        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];
    }

    public function getProductosByState(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $estado = $request->estado;

        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop', 'imagenes.url', 'tipos.nombre as tipo','colores.nombre as color')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('productos.estado', '=', $estado)
        ->where('color_producto.activo', 'Si')
        ->where('producto_referencia.stock', '>', '0')
        ->groupBy('color_producto.id')
        ->orderBy('color_producto.producto_id', 'DESC')
        ->paginate(12); // obtener productos nuevos o en oferta
        
        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];

    }

    public function getProductosSales(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $productos = DB::table('productos')
        ->join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('producto_venta', 'producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        ->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->select('color_producto.id as cop', 'productos.id', 'productos.nombre', 'productos.precio_actual', 'color_producto.slug as slug', 'tipos.nombre as tipo', 'imagenes.url', 'colores.nombre as color', DB::raw('SUM(producto_venta.cantidad) as cantidad'))
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('color_producto.activo', 'Si')
        ->where('producto_referencia.stock', '>', '0')
        ->groupBy('color_producto.id')
        ->orderBy('cantidad', 'DESC')  
        ->paginate(12); //obtener productos más vendidos

    
        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];
        
    }

    public function getProductosVisitas(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->select('productos.*', 'color_producto.slug as slug', 'color_producto.id as cop', 'color_producto.visitas', 'tipos.nombre as tipo', 'imagenes.url', 'colores.nombre as color')
        ->where('color_producto.visitas', '>', '0')
        ->where('color_producto.activo', 'Si')
        ->where('producto_referencia.stock', '>', '0')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->groupBy('color_producto.id')
        ->orderBy('color_producto.visitas', 'DESC')
        ->paginate(12); // productos más vistos
        
        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];

    }

    public function getProductsByOrder(Request $request)
    {

        if (!$request->ajax()) return redirect('/');

        $criterio = $request->criterio;

        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->select('color_producto.id as cop','productos.*','color_producto.slug as slug', 'imagenes.url', 'tipos.nombre as tipo','colores.nombre as color')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('color_producto.activo', 'Si')
        ->where('producto_referencia.stock', '>', '0')
        ->groupBy('color_producto.id')
        ->orderBy('productos.'.$criterio)
        ->paginate(12); //ordenar productos por nombre o precio

        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];
    }

    public function getProductsByTipo(Request $request)
    {
        
        if (!$request->ajax()) return redirect('/');

        $tipo = $request->tipo;
        
    
        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->select('color_producto.id as cop','productos.*','color_producto.slug as slug', 'imagenes.url', 'tipos.nombre as tipo','colores.nombre as color')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('color_producto.activo', 'Si')
        ->where('tipos.id', $tipo)
        ->where('producto_referencia.stock', '>', '0')
        ->groupBy('color_producto.id')
        ->paginate(12); // obtener productos por tipo

        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];

    }

    public function getProductsByGenre(Request $request)
    {
       if (!$request->ajax()) return redirect('/');

        $genero = $request->genero;

        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tipos', 'productos.tipo_id', '=', 'tipos.id')
        ->join('subcategorias', 'tipos.subcategoria_id', '=', 'subcategorias.id')
        ->join('categorias', 'subcategorias.categoria_id', '=', 'categorias.id')
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->select('color_producto.id as cop','productos.*','color_producto.slug as slug', 'imagenes.url', 'tipos.nombre as tipo','colores.nombre as color')
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->where('color_producto.activo', 'Si')
        ->where('categorias.nombre', $genero)
        ->where('producto_referencia.stock', '>', '0')
        ->groupBy('color_producto.id')
        ->paginate(12); // obtener productos por género
        
        return [
            'pagination' => [
                'total'        => $productos->total(),
                'current_page' => $productos->currentPage(),
                'per_page'     => $productos->perPage(),
                'last_page'    => $productos->lastPage(),
                'from'         => $productos->firstItem(),
                'to'           => $productos->lastItem(),
            ],
            'productos' => $productos
        ];

    }
}
