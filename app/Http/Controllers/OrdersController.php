<?php

namespace App\Http\Controllers;
use App\Venta;
use App\Producto;
use App\Pedido;
use App\User;
use Illuminate\Http\Request;

class OrdersController extends Controller
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
    public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        $ventas = Venta::orWhere('ventas.fecha','like',"%$keyword%")
        ->orWhere('facturas.id','like',"%$keyword%")
        ->orWhere('ventas.valor','like',"%$keyword%")
        ->join('pedidos','ventas.id', '=','pedidos.venta_id')
        ->join('facturas','ventas.factura_id', '=', 'facturas.id')
        ->select('ventas.*','facturas.prefijo','facturas.consecutivo','pedidos.estado')
        ->where('cliente_id', auth()->user()->cliente->id)
        ->orderBy('ventas.created_at')->paginate(5);
        
        return view('user.orders.index', compact('ventas'));

    }

    public function listarPedidos(Request $request)
    {
        $keyword = $request->get('keyword');

        $ventas = Venta::orWhere('ventas.fecha','like',"%$keyword%")
        ->orWhere('users.nombres','like',"%$keyword%")
        ->orWhere('ventas.valor','like',"%$keyword%")
        ->join('pedidos','ventas.id', '=','pedidos.venta_id')
        ->join('clientes','ventas.cliente_id', '=','clientes.id')
        ->join('users','clientes.user_id', '=','users.id')
        ->select('ventas.id','ventas.fecha','ventas.valor','users.nombres','pedidos.estado', 'pedidos.id as pedido')
        ->orderBy('ventas.created_at')->paginate(5);

        $estados = $this->estados_pedido();

        return view('admin.pedidos.index', compact('ventas', 'estados'));
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
       
        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        ->join('producto_venta','producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        ->join('ventas','ventas.id', '=', 'producto_venta.venta_id')
        ->select('productos.*', 'producto_venta.cantidad', 'ventas.valor', 'colores.nombre as color', 'tallas.nombre as talla', 'producto_referencia.id as referencia','color_producto.id as cop','ventas.id as venta') 
        ->where('ventas.id', '=', $id)
        ->where('ventas.cliente_id', auth()->user()->cliente->id)
        ->get();

        return view('user.orders.show',compact('productos'));
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
        $pedido = Pedido::where('venta_id', $request->pedido_id)->firstOrFail();
        $pedido->estado = $request->estado;

        $pedido->save();

        session()->flash('message', ['success', ("Se ha actualizado el estado del pedido")]);
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

    public function mostrarPedido($id)
    {
        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        ->join('producto_venta','producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        ->join('ventas','ventas.id', '=', 'producto_venta.venta_id')
        ->select('productos.*', 'producto_venta.cantidad', 'ventas.valor', 'colores.nombre as color', 'tallas.nombre as talla', 'producto_referencia.id as referencia','color_producto.id as cop', 'color_producto.slug as slug','ventas.id as venta') 
        ->where('ventas.id', '=', $id)->get();

        $users = Venta::join('clientes','ventas.cliente_id', '=', 'clientes.id')
        ->join('users','clientes.user_id', '=', 'users.id')
        ->select('users.nombres','users.direccion','users.telefono','users.email','ventas.fecha')
        ->where('ventas.id', '=', $id)->get();

       return view('admin.pedidos.show',compact('productos','users'));

    }

    public function pdfVenta(Request $request, $id){

        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        ->join('producto_venta','producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        ->join('ventas','ventas.id', '=', 'producto_venta.venta_id')
        ->select('productos.*', 'producto_venta.cantidad', 'ventas.valor', 'colores.nombre as color', 'tallas.nombre as talla', 'producto_referencia.id as referencia','color_producto.id as cop', 'color_producto.slug as slug','ventas.id as venta') 
        ->where('ventas.id', '=', $id)->get();

        $users = Venta::join('clientes','ventas.cliente_id', '=', 'clientes.id')
        ->join('users','clientes.user_id', '=', 'users.id')
        ->join('facturas', 'ventas.factura_id', '=', 'facturas.id')
        ->select('users.nombres', 'users.identificacion','users.direccion','users.telefono','users.email', 'ventas.id as venta','ventas.fecha', 'facturas.prefijo', 'facturas.consecutivo')
        ->where('ventas.id', '=', $id)->get();

        $pdf = \PDF::loadView('user.pdf.factura',['productos'=>$productos,'users'=>$users]);
        return $pdf->download('factura-'.$users[0]->consecutivo.'.pdf');

    }

    public function estados_pedido(){

        return [
            1,
            2,
            3,
            4
        ];
    }

}
