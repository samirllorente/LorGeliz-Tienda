<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Pedido;
use App\Producto;
use App\User;
use App\Venta;
use App\Mail\OrderStatusMail;
use App\Notifications\NotificationClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;



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
        $busqueda = $request->get('busqueda');

        $pedidos = Pedido::orWhere('pedidos.id','like',"%$busqueda%")
       //->orWhere('pedidos.fecha','like',"%$keyword%")
        //orWhere('facturas.id','like',"%$keyword%")
        //->orWhere('ventas.valor','like',"%$keyword%")
        ->join('ventas','pedidos.venta_id', '=','ventas.id')
        ->join('facturas','ventas.factura_id', '=', 'facturas.id')
        ->select('ventas.valor','facturas.prefijo','facturas.consecutivo', 'pedidos.*')
        ->where('ventas.cliente_id', auth()->user()->cliente->id)
        ->where('ventas.estado', '!=', 3)
        ->orderBy('pedidos.created_at', 'DESC')
        ->paginate(5);

        
        return view('user.orders.index', compact('pedidos'));

    }

    public function listarPedidos(Request $request)
    {
        $keyword = $request->get('keyword');

        $pedidos = Pedido::orWhere('pedidos.fecha','like',"%$keyword%")
        ->orWhere('pedidos.id','like',"%$keyword%")
        ->orWhere('users.nombres','like',"%$keyword%")
        ->orWhere('ventas.valor','like',"%$keyword%")
        ->join('ventas','pedidos.venta_id', '=','ventas.id')
        ->join('clientes','ventas.cliente_id', '=','clientes.id')
        ->join('users','clientes.user_id', '=','users.id')
        ->select('pedidos.id','pedidos.fecha', 'ventas.id as venta','ventas.valor','users.nombres','users.apellidos','pedidos.estado', 'clientes.id as cliente')
        ->orderBy('pedidos.created_at', 'DESC')
        ->where('ventas.estado', '!=', '3')
        ->paginate(5); //listado de pedidos admin

        $estados = $this->estados_pedido();

        return view('admin.pedidos.index', compact('pedidos', 'estados'));
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
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        ->join('producto_venta','producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        ->join('ventas','ventas.id', '=', 'producto_venta.venta_id')
        ->join('pedidos','ventas.id', '=', 'pedidos.venta_id')
        ->select('productos.precio_actual', 'productos.nombre', 'producto_venta.cantidad', 'ventas.valor', 'colores.nombre as color', 'tallas.nombre as talla', 'producto_referencia.id as referencia','color_producto.id as cop', 'color_producto.slug as slug','pedidos.id as pedido', 'ventas.id as venta', 'imagenes.url as imagen') 
        ->where('pedidos.id', '=', $id)
        ->where('ventas.cliente_id', auth()->user()->cliente->id)
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->groupBy('producto_referencia.id')
        ->get();

        return view('user.orders.show',compact('productos'));
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
        $pedido = Pedido::where('id', $request->pedido_id)->firstOrFail();
        $pedido->estado = $request->estado;

        $pedido->save(); // se actualiza el estado

        $details = [
    		'cliente' => $pedido->venta->cliente->user->nombres,
    		'fecha' => date('d/m/Y', strtotime($pedido->fecha)),
    		'estado' => $pedido->estado,
    		'url' => url('/pedidos/'. $pedido->id),
    	];

        if ($pedido->estado == 2) {
           $mensaje = 'Tu pedido está siendo preparado';
        }
        if ($pedido->estado == 3) {
            $mensaje = 'Tu pedido está siendo enviado';
        }
        if ($pedido->estado == 4) {
            $mensaje = 'Tu pedido ha sido entregado';
        }

        
        $arrayData = [
            'notificacion' => [
                'msj' => $mensaje,
                'url' => url('/pedidos/'. $pedido->id)
            ]
        ];

        Cliente::findOrFail($pedido->venta->cliente->id)->notify(new NotificationClient($arrayData));

        //return new OrderStatusMail($details);
        Mail::to($pedido->venta->cliente->user->email)->send(new OrderStatusMail($details));

        session()->flash('message', ['success', ("Se ha actualizado el estado del pedido")]);
        return back();
    }


    public function showPedidoAdmin($id)
    {
        $productos = $this->productosOrder($id);

        $users = $this->userPedido($id);

        return view('admin.pedidos.show',compact('productos','users'));

    }

    public function showPdf(Request $request, $id)
    {
        $productos = $this->productosOrder($id);
    
        $users = $this->userPedido($id);

        $pdf = \PDF::loadView('user.pdf.pedido',['productos'=>$productos, 'users'=>$users])
        ->setPaper('a4', 'landscape');
        
        return $pdf->download('pedido-'.$users[0]->pedido.'.pdf');
    }

    public function facturas(Request $request, $id)
    {
        $productos = $this->productosOrder($id);

        $users = Venta::join('clientes','ventas.cliente_id', '=', 'clientes.id')
        ->join('pedidos','ventas.id', '=', 'pedidos.venta_id')
        ->join('users','clientes.user_id', '=', 'users.id')
        ->join('facturas', 'ventas.factura_id', '=', 'facturas.id')
        ->select('users.nombres','users.apellidos','users.identificacion','users.direccion','users.telefono','users.email', 'pedidos.id','ventas.fecha', 'facturas.prefijo', 'facturas.consecutivo', 'ventas.id as venta')
        ->where('pedidos.id', '=', $id)->get();

        $pdf = \PDF::loadView('user.pdf.factura',['productos'=>$productos,'users'=>$users]);
        return $pdf->download('factura-'.$users[0]->consecutivo.'.pdf'); // imprimir factura de cliente

    }

    public function reportePedidosPdf()
    {
        $pedidos = Pedido::join('ventas','pedidos.venta_id','=','ventas.id')
        ->join('clientes','ventas.cliente_id','=','clientes.id')
        ->join('users','clientes.user_id','=','users.id')
        ->where('ventas.estado', '!=', '3')
        ->select('pedidos.*','ventas.valor','users.nombres','users.apellidos')
        ->orderBy('pedidos.fecha')
        ->get();

        $count = 0;
        foreach ($pedidos as $pedido) {
            $count = $count + 1;
        }

        $pdf = \PDF::loadView('admin.pdf.listadopedidos',['pedidos'=>$pedidos, 'count'=>$count])
        ->setPaper('a4', 'landscape');
        
        return $pdf->download('listadopedidos.pdf'); //listado de pedidos en pdf
    }

    public function imprimirPedido(Request $request, $id)
    {
        $productos = $this->productosOrder($id);

        $users = $this->userPedido($id);

        $pdf = \PDF::loadView('admin.pdf.pedido',['productos'=>$productos, 'users'=>$users])
        ->setPaper('a4', 'landscape');
        
        return $pdf->download('pedido-'.$users[0]->pedido.'.pdf'); //imprimir pedido en pdf
    }

    public function productosOrder($id)
    {
        return Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('imagenes', 'color_producto.id', '=', 'imagenes.imageable_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        ->join('producto_venta','producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        ->join('ventas','ventas.id', '=', 'producto_venta.venta_id')
        ->join('pedidos','ventas.id', '=', 'pedidos.venta_id')
        ->select('productos.id','productos.nombre', 'productos.precio_anterior', 'productos.precio_actual', 'productos.porcentaje_descuento', 'producto_venta.cantidad', 'ventas.valor', 'colores.nombre as color', 'tallas.nombre as talla', 'producto_referencia.id as referencia','color_producto.id as cop', 'color_producto.slug as slug','pedidos.id as pedido', 'imagenes.url as imagen') 
        ->where('pedidos.id', '=', $id)
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->groupBy('producto_referencia.id')
        ->get();
    }

    public function userPedido($id)
    {
        return Venta::join('clientes','ventas.cliente_id', '=', 'clientes.id')
        ->join('pedidos','ventas.id', '=', 'pedidos.venta_id')
        ->join('users','clientes.user_id', '=', 'users.id')
        ->select('pedidos.id as pedido','pedidos.fecha','users.nombres','users.apellidos','users.direccion','users.telefono','users.email','users.identificacion','clientes.id as cliente')
        ->where('pedidos.id', '=', $id)->get();
    }

    public function estados_pedido()
    {
        return [
            1,
            2,
            3,
            4
        ];
    }

}
