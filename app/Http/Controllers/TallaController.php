<?php

namespace App\Http\Controllers;

use App\Producto;
use App\ProductoReferencia;
use App\Talla;
use Illuminate\Http\Request;

class TallaController extends Controller
{

    public function getTalla(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id  = $request->producto;
        $tipo = Producto::where('id', $id)->firstOrFail(); 

        $tallas = Talla::where('tipo_id', $tipo->tipo_id)->get();
        
        $response = ['data' => $tallas];
        
        return response()->json($response);


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

        return ['tallas' => $tallas];
    }
}
