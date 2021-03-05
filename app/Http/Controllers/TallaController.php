<?php

namespace App\Http\Controllers;

use App\Producto;
use App\ProductoReferencia;
use App\Talla;
use App\Tipo;
use Illuminate\Http\Request;

class TallaController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('getProductoTallas');
    }

    public function getTalla(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id  = $request->producto;
        $tipo = Producto::where('id', $id)->firstOrFail(); 

        $tallas = Talla::join('talla_tipo', 'tallas.id', 'talla_tipo.talla_id')
        ->where('talla_tipo.tipo_id', $tipo->tipo_id)
        ->get();
        
        $response = ['data' => $tallas];
        
        return response()->json($response); //obtener tallas al actualizar stock en el modal

    }

    public function getProductoTallas(Request $request, $id)
    {

        if (!$request->ajax()) return redirect('/');

        $tallas = Talla::join('producto_referencia', 'tallas.id', '=', 'producto_referencia.talla_id')
        ->join('color_producto', 'producto_referencia.color_producto_id', '=', 'color_producto.id')
        ->where('producto_referencia.color_producto_id', $id)
        ->where('producto_referencia.stock', '>', '0')
        ->select('tallas.*', 'producto_referencia.stock')
        ->get();

        return ['tallas' => $tallas]; //obtener tallas en la vista productos de la tienda
    }

    public function tallasTipoId(Request $request)
    //obtener las tallas de un tipo de producto para mostrar en el select las que ya han sido seleccionadas, en la vista index de tipo de producto
    {   
        if (!$request->ajax()) return redirect('/');

        $id  = $request->id;

        $tallas = Talla::join('talla_tipo', 'tallas.id', 'talla_tipo.talla_id')
        ->where('talla_tipo.tipo_id', $id)
        ->get();
        
        $response = ['data' => $tallas];
        
        return response()->json($response);
    }

    public function store(Request $request)
    {
        $tipo = Tipo::where('id', $request->tipo_id)->firstOrFail();

        $tallas = $request->tallas_id;

        if ($tallas) {

            $tipo->tallas()->detach();
            foreach($tallas as $talla){
                $tipo->tallas()->attach($talla);
            }
            
            session()->flash('message', ['success', ("Se han creado las tallas")]);

            return back();
        }else {
            session()->flash('message', ['danger', ("Debes indicar las tallas")]);

            return back();
        }
       
    }
}
