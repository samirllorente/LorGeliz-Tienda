<?php

namespace App\Http\Controllers;


use App\Color;
use App\ColorProducto;
use App\Imagene;
use App\Producto;
use App\ProductoReferencia;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('setVisitas');
    }
    
    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');

        $productos = Producto::orWhere('productos.nombre','like',"%$busqueda%")
        ->orWhere('productos.id','like',"%$busqueda%")
        ->paginate(10);

        return view('admin.productos.index',compact('productos')); //index de productos en admin

    }

    public function product(Request $request, $id)
    {
       
        $busqueda = $request->get('busqueda');
       
        $productos = Producto::where('productos.nombre','like',"%$busqueda%")
        ->join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->select('productos.*','color_producto.id as cop','color_producto.slug as slug','colores.nombre as color', 'color_producto.activo')
        ->where('productos.id', $id)
        ->orderBy('productos.created_at')->paginate(5); //obtener todos los colores de un producto por id
        
        return view('admin.productos.coloresproducto',compact('productos'));

    }   

    public function create()
    {
        return view('admin.productos.create');//vista para crear un producto
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        
        $color = Color::where('id', $request->color)->first(); //se obtiene el color del producto
        
        $producto = new Producto();

        //$producto->nombre = $request->nombre." ".$color['nombre'];
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


                /*$image = Image::make($imagen)->encode('jpg', 75);
                $image->resize(530, 591, function ($constraint){
                    $constraint->upsize();
                });
                
                Storage::disk('dropbox')->put("imagenes/productos/producto".$nombre, $image->stream()->__toString());
                $dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();
                $response = $dropbox->createSharedLinkWithSettings("imagenes/productos/producto" . $nombre, ["requested_visibility" => "public"]);

                $url_imagenes[]['url'] = str_replace('dl=0', 'raw=1', $response['url']);*/

            }

        }

        $colorproducto = new ColorProducto(); //creamos el color
        $colorproducto->producto_id = $producto->id;
        $colorproducto->color_id = $request->color;

        if ($request->activo) {
            $colorproducto->activo = 'Si';    
        }
        else {
            $colorproducto->activo = 'No';    
        }

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
    public function show($id)
    {
        $producto = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        //->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->select('productos.*', 'color_producto.id as cop', 'color_producto.activo')
        ->where('productos.id',$id)->firstOrFail();

        $estados = $this->estado_productos(); 

        return view('admin.productos.show',compact('producto','estados')); //mostrar el producto
    }

    public function showColor($slug)
    {
        $producto = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->select('productos.*', 'color_producto.id as cop', 'color_producto.activo', 'color_producto.color_id as color', 'color_producto.slug')
        ->where('color_producto.slug',$slug)->firstOrFail();

        $estados = $this->estado_productos();

        return view('admin.productos.showcolor',compact('producto','estados')); //mostrar un color de un producto
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $producto = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        //->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->select('productos.*', 'color_producto.id as cop', 'color_producto.activo')
        ->where('productos.id',$id)->firstOrFail();
        
        $estados = $this->estado_productos();

        return view('admin.productos.edit',compact('producto', 'estados')); // editar el producto
    }

    public function editColor($slug)
    {
        $producto = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->select('productos.*', 'color_producto.id as cop', 'color_producto.activo', 'color_producto.color_id as color', 'color_producto.slug')
        ->where('color_producto.slug',$slug)->firstOrFail();

        $estados = $this->estado_productos();

        return view('admin.productos.editcolor',compact('producto','estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, Producto $producto)
    public function update(ProductRequest $request, $id)
    {
        //$color = Color::where('id', $request->color)->first();

        //$producto->nombre = $request->nombre." ".$color['nombre'];
        $producto = Producto::where('id', $id)->firstOrFail();

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

        if ($request->sliderprincipal) {
            $producto->slider_principal= 'Si';    
        }
        else {
            $producto->slider_principal= 'No';    
        }
        

        $producto->save();

        /*$url_imagenes = [];

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

        if ($request->activo) {
            $colorproducto->activo= 'Si';    
        }
        else {
            $colorproducto->activo= 'No';    
        }

        $colorproducto->save();

        $colorproducto->imagenes()->createMany($url_imagenes);*/
        
        session()->flash('message', ['success', ("Se ha actualizado el producto exitosamente")]);

        return redirect()->route('product.index');
    }

    public function updateColor(Request $request, $slug)
    {

        $producto = ColorProducto::where('slug',$slug)->firstOrFail();
        $id = $producto->producto_id;

        if ($request->activo) {
            $producto->activo = 'Si';    
        }
        else {
            $producto->activo = 'No';    // se edita el campo activo del color
        }

        $producto->color_id = $request->color;

        $url_imagenes = [];

        if ($request->hasFile('imagenes')) {

            $imagenes = $request->file('imagenes');
            foreach ($imagenes as $imagen) {

                $nombre = time().'_'.$imagen->getClientOriginalName();

                $path = Storage::disk('public')->putFileAs("imagenes/productos/producto" . $producto->producto_id, $imagen, $nombre);

                $url_imagenes[]['url'] = $path;

                /*$image = Image::make($imagen)->encode('jpg', 75);
                $image->resize(530, 591, function ($constraint){
                    $constraint->upsize();
                });
                
                Storage::disk('dropbox')->put("imagenes/productos/producto".$nombre, $image->stream()->__toString());
                $dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();
                $response = $dropbox->createSharedLinkWithSettings("imagenes/productos/producto" . $nombre, ["requested_visibility" => "public"]);

                $url_imagenes[]['url'] = str_replace('dl=0', 'raw=1', $response['url']);*/
            }

        }   

        $producto->save();

        $producto->imagenes()->createMany($url_imagenes);

        session()->flash('message', ['success', ("Se ha actualizado el producto exitosamente")]);

        return redirect()->route('product.colors', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try{

            $numventas = ProductoReferencia::join('producto_venta', 'producto_referencia.id', 'producto_venta.producto_referencia_id')
            ->join('color_producto', 'producto_referencia.color_producto_id',  'color_producto.id')
            ->where('color_producto.id',$id)
            ->count(); // se consultan las ventas del producto

            $color = ColorProducto::where('id', $id)->first();

            $productos = ColorProducto::where('producto_id', $color->producto_id)->count();//se consultan cuantos colores tiene el producto

            if ($numventas == 0) {

                if ($productos == 1) {
                    Producto::where('id', $color->producto_id)->delete();//si no tiene ventas y hay un sólo color, se elimina
                }

                $color->delete(); // se elimina el color

                $imagenes = Imagene::where('imageable_id', $id)->get();

                foreach ($imagenes as $imagen) {
                    $imagen->delete(); // se eliminan las imágenes de la bd
                }

            }

            else{
                
                $color->activo = 'No';//si tiene ventas, se desactiva

                $color->save();
            }

            session()->flash('message', ['success', ("Se ha desactivado o eliminado el producto")]);

            if ($productos > 1) {
                return back();
            } else {
                return redirect()->route('product.index');
            }
            
        }

        catch (\Exception $exception){

            session()->flash('message', ['warning', ("Ha ocurrido un error al eliminar el producto")]);

            return back();
        }
    }

    public function activate($id)
    {
        $color = ColorProducto::where('id', $id)->first();
        $color->activo = 'Si';

        $color->save(); // se ectiva el color

        session()->flash('message', ['success', ("Se ha activado el producto")]);

        return back();
    }

    public function createColor($id)
    {
        $producto = Producto::where('productos.id',$id)->firstOrFail();
        
        $estados = $this->estado_productos();
        return view('admin.productos.createcolor',compact('producto', 'estados'));
    }

    public function storeColor(Request $request)
    {
        $producto = $request->producto;

        $url_imagenes = [];

        if ($request->hasFile('imagenes')) {

            $imagenes = $request->file('imagenes');

            foreach ($imagenes as $imagen) {

                $nombre = time().'_'.$imagen->getClientOriginalName();

                $path = Storage::disk('public')->putFileAs("imagenes/productos/producto" . $producto, $imagen, $nombre);

                $url_imagenes[]['url'] = $path;

                /*$image = Image::make($imagen)->encode('jpg', 75);
                $image->resize(530, 591, function ($constraint){
                    $constraint->upsize();
                });
                
                Storage::disk('dropbox')->put("imagenes/productos/producto".$nombre, $image->stream()->__toString());
                $dropbox = Storage::disk('dropbox')->getDriver()->getAdapter()->getClient();
                $response = $dropbox->createSharedLinkWithSettings("imagenes/productos/producto" . $nombre, ["requested_visibility" => "public"]);

                $url_imagenes[]['url'] = str_replace('dl=0', 'raw=1', $response['url']);*/

            }

        }

        $colorproducto = new ColorProducto();
        $colorproducto->producto_id = $producto;
        $colorproducto->color_id = $request->color;
        $colorproducto->activo= 'Si'; 

        $colorproducto->save();


        $colorproducto->imagenes()->createMany($url_imagenes);
        
        session()->flash('message', ['success', ("Se ha creado el producto exitosamente")]);

        return redirect()->route('product.colors', $producto);

    }

    public function eliminarImagen(Request $request,$id)
    {
        if (!$request->ajax()) return redirect('/');

        $image = Imagene::find($id);

        $eliminar = Storage::disk('public')->delete($image->url); // se elimina del directorio

        $image->delete(); // se elimina de la bd

        return "eliminado id:".$id.' '.$eliminar;
    }

    public function setVisitas(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $producto = ColorProducto::where('id', $id)->first();
        $visitas = $producto->visitas;
        $producto->visitas = $visitas + 1;

        $producto->save(); // se incrementa el campo visitas

    }

    public function estado_productos()
    {
        return [
            1,
            2
        ];
    }

}
