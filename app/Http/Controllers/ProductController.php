<?php

namespace App\Http\Controllers;
use App\ColorProducto;
use App\Producto;
use App\ProductoReferencia;
use App\Imagene;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
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
        ->where('productos.nombre','like',"%$nombre%")
        ->select('productos.*', 'color_producto.id as cop', 'colores.nombre as color', 'color_producto.slug as slug')
        ->orderBy('productos.created_at')->paginate(5);

       // return $productos;

        return view('admin.productos.index',compact('productos'));
    }

    public function create()
    {
        return view('admin.productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        
        $producto = new Producto;

        $producto->nombre = $request->nombre;
        $producto->tipo_id = $request->tipo_id;
        $producto->marca = $request->marca;
        $producto->precio_anterior = $request->precioanterior;
        $producto->precio_actual = $request->precioactual;
        $producto->porcentaje_descuento = $request->porcentajededescuento;
        $producto->descripcion_corta = $request->descripcion_corta;
        $producto->descripcion_larga = $request->descripcion_larga;
        $producto->especificaciones = $request->especificaciones;
        $producto->estado = $request->estado;


        if ($request->activo) {
            $producto->activo = 'Si';    
        }
        else {
            $producto->activo = 'No';    
        }

        if ($request->sliderprincipal) {
            $producto->slider_principal = 'Si';    
        }
        else {
            $producto->slider_principal = 'No';    
        }
        

        $producto->save();

        $url_imagenes = [];

        if ($request->hasFile('imagenes')) {

            $imagenes = $request->file('imagenes');

            foreach ($imagenes as $imagen) {

                $nombre = time().'_'.$imagen->getClientOriginalName();

                $path = Storage::disk('public')->putFileAs("imagenes/productos/producto" . $producto->id, $imagen, $nombre);

                $url_imagenes[]['url'] = $path;


            }

        }

        $colorproducto = new ColorProducto();
        $colorproducto->producto_id = $producto->id;
        $colorproducto->color_id = $request->color;

        $colorproducto->save();


        $colorproducto->imagenes()->createMany($url_imagenes);
        
        session()->flash('message', ['success', ("Se ha creado el producto exitosamente")]);

        return redirect()->route('product.index');

    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $producto = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->select('productos.*', 'color_producto.id as cop', 'colores.id as color', 'color_producto.slug as slug')
        ->where('color_producto.slug',$slug)->firstOrFail();

        //return $producto;
        
        return view('admin.productos.show',compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $producto = $producto = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->select('productos.*', 'color_producto.id as cop', 'colores.id as color')
        ->where('color_producto.slug',$slug)->firstOrFail();
        
        return view('admin.productos.edit',compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        //dd($request);
        $producto->nombre = $request->nombre;
        $producto->tipo_id = $request->tipo_id;
        $producto->marca = $request->marca;
        $producto->precio_anterior = $request->precioanterior;
        $producto->precio_actual = $request->precioactual;
        $producto->porcentaje_descuento = $request->porcentajededescuento;
        $producto->descripcion_corta = $request->descripcion_corta;
        $producto->descripcion_larga = $request->descripcion_larga;
        $producto->especificaciones = $request->especificaciones;
        $producto->estado = $request->estado;

        if ($request->activo) {
            $producto->activo= 'Si';    
        }
        else {
            $producto->activo= 'No';    
        }

        if ($request->sliderprincipal) {
            $producto->slider_principal= 'Si';    
        }
        else {
            $producto->slider_principal= 'No';    
        }
        

        $producto->save();

        $url_imagenes = [];

        if ($request->hasFile('imagenes')) {

            $imagenes = $request->file('imagenes');

            foreach ($imagenes as $imagen) {

                $nombre = time().'_'.$imagen->getClientOriginalName();

                $path = Storage::disk('public')->putFileAs("imagenes/productos/producto" . $producto->id, $imagen, $nombre);

                $url_imagenes[]['url'] = $path;


            }

        }


        $colorproducto = ColorProducto::where('producto_id', $producto->id)
        ->where('color_id', $request->color)
        ->firstOrFail();

        $colorproducto->imagenes()->createMany($url_imagenes);
        
        session()->flash('message', ['success', ("Se ha actualizado el producto exitosamente")]);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        try{

            $producto->delete();

            session()->flash('message', ['success', ("Se ha eliminado el producto")]);

            return redirect()->route('product.index');
        }

        catch (\Exception $exception){

            session()->flash('message', ['warning', ("Ha ocurrido un error al eliminar el producto")]);

            return redirect()->route('product.index');
        }
    }

    public function addColor($slug)
    {
        $producto = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->select('productos.*', 'color_producto.id as cop', 'colores.id as color', 'color_producto.slug as slug')
        ->where('color_producto.slug',$slug)->firstOrFail();

        //return $producto;
        
        return view('admin.productos.nuevocolor',compact('producto'));
    }

    public function storeColor(Request $request)
    {
        //dd($request);

        $producto = $request->producto;

        $url_imagenes = [];

        if ($request->hasFile('imagenes')) {

            $imagenes = $request->file('imagenes');

            foreach ($imagenes as $imagen) {

                $nombre = time().'_'.$imagen->getClientOriginalName();

                $path = Storage::disk('public')->putFileAs("imagenes/productos/producto" . $producto, $imagen, $nombre);

                $url_imagenes[]['url'] = $path;


            }

        }

        $colorproducto = new ColorProducto();
        $colorproducto->producto_id = $producto;
        $colorproducto->color_id = $request->color;

        $colorproducto->save();


        $colorproducto->imagenes()->createMany($url_imagenes);
        
        session()->flash('message', ['success', ("Se ha creado el producto exitosamente")]);

        return redirect()->route('product.index');

    }

    public function eliminarImagen(Request $request,$id)
    {
        if (!$request->ajax()) return redirect('/');

        $image = Imagene::find($id);

        $eliminar = Storage::disk('public')->delete($image->url);

        $image->delete();

        return "eliminado id:".$id.' '.$eliminar;
    }

    public function setVisitas(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $producto = ColorProducto::where('id', $id)->first();
        $visitas = $producto->visitas;
        $producto->visitas = $visitas + 1;

        $producto->save();

    }

}
