<?php

namespace App\Http\Controllers;
Use App\Producto;
Use App\ProductoVenta;
Use App\ProductoReferencia;
Use App\Venta;
Use App\Devolucione;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DevolucionController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        ->join('devoluciones','producto_referencia.id', '=', 'devoluciones.producto_referencia_id')
        ->join('ventas', 'devoluciones.venta_id', '=', 'ventas.id')
        ->join('pedidos', 'ventas.id', '=', 'pedidos.venta_id')
        ->select('productos.*', 'devoluciones.cantidad', 'devoluciones.estado', 'devoluciones.fecha', 'colores.nombre as color', 'tallas.nombre as talla', 'pedidos.id as pedido', 'ventas.id as venta', 'color_producto.id as cop', 'color_producto.slug as slug')
        ->where('ventas.cliente_id', auth()->user()->cliente->id)
        ->paginate(5);

        return view('user.devoluciones.index',compact('productos'));
    }

    public function listarDevolucion()
    {
        $devoluciones = Devolucione::join('ventas', 'devoluciones.venta_id', '=', 'ventas.id')
        ->join('pedidos', 'ventas.id', '=', 'pedidos.venta_id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->join('users', 'clientes.user_id', '=', 'users.id')
        ->select('devoluciones.id','devoluciones.estado', 'devoluciones.fecha','pedidos.id as pedido', 'ventas.id as venta', 'users.nombres', 'users.apellidos'
        ,'clientes.id as cliente')
        ->paginate(5);

        $estados = $this->estados_devolucion();

        return view('admin.devoluciones.index',compact('devoluciones', 'estados'));
    }

    public function mostrarDevolucion($id){

        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        ->join('devoluciones','producto_referencia.id', '=', 'devoluciones.producto_referencia_id')
        ->join('ventas', 'devoluciones.venta_id', '=', 'ventas.id')
        ->select('productos.*', 'devoluciones.cantidad', 'devoluciones.cantidad', 'colores.nombre as color', 'tallas.nombre as talla', 'color_producto.id as cop', 'color_producto.slug as slug')
        ->where('devoluciones.id', $id)
        ->paginate(5);
        

        $devolucion = Devolucione::join('ventas', 'devoluciones.venta_id', '=', 'ventas.id')
        ->join('pedidos', 'ventas.id', '=', 'pedidos.venta_id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->join('users', 'clientes.user_id', '=', 'users.id')
        ->select('devoluciones.id as devolucion','devoluciones.estado', 'devoluciones.fecha','pedidos.id as pedido', 'ventas.id as venta', 'users.nombres', 'users.apellidos'
        ,'clientes.id as cliente')
        ->where('devoluciones.id', $id)
        ->firstOrFail();


        return view('admin.devoluciones.show',compact('devolucion', 'productos'));

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
        if (!$request->ajax()) return redirect('/');

        $ref = $request->ref;
        $venta = $request->venta;
        $cantidad = $request->cantidad;

        $devoluciones = Devolucione::where('producto_referencia_id', $ref)
        ->where('venta_id', $venta)
        ->count();

        if ($devoluciones == 0) {
            $devolucion = new Devolucione();
            $devolucion->fecha = \Carbon\Carbon::now();
            $devolucion->cantidad = $cantidad;
            $devolucion->producto_referencia_id = $ref;
            $devolucion->venta_id = $venta;

            $devolucion->save();

        } 

        $response = ['data' => $devoluciones];
        
        return response()->json($response);
        
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
    public function update(Request $request)
    {
        $devolucion = Devolucione::where('id', $request->devolucion_id)->firstOrFail();
        $devolucion->estado = $request->estado;

        $devolucion->save();

        if ($request->estado == 4) {

            try {

                DB::beginTransaction();

                $producto = ProductoVenta::where('producto_referencia_id', $devolucion->producto_referencia_id)
                ->where('venta_id', $devolucion->venta_id)
                ->first();

                $producto_precio = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
                ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
                ->where('producto_referencia.id', $producto->producto_referencia_id)
                ->get();

                $precio = $producto_precio[0]->precio_actual;

                $cantidad = $producto->cantidad;

                $totalproducto = $precio * $cantidad;

                $venta = Venta::where('id', $producto->venta_id)
                ->first();

                $valor = $venta->valor;

                $venta->valor = $valor - $totalproducto;

                $venta->save();

                $prodreferencia = ProductoReferencia::where('id', $producto->producto_referencia_id)
                ->first();

                $stock = $prodreferencia->stock;

                $prodreferencia->stock = $stock + $devolucion->cantidad;

                $prodreferencia->save();

                $producto->delete();

                DB::commit();


            } catch (Exception $e) {
                DB::rollBack();
            }
           
        }

        session()->flash('message', ['success', ("Se ha actualizado el estado de la solicitud")]);
        return back();
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

    public function devolucionProducto(Request $request){

        if (!$request->ajax()) return redirect('/');

        $devolucion = Devolucione::where('producto_referencia_id', $request->producto)
        ->where('venta_id', $request->venta)
        ->count();

        return ['devolucion' => $devolucion];
    }

    public function estados_devolucion(){

        return [
            1,
            2,
            3,
            4
        ];
    }
}
