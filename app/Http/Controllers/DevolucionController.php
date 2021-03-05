<?php

namespace App\Http\Controllers;

use App\Cliente;
Use App\Devolucione;
Use App\Producto;
Use App\ProductoVenta;
Use App\ProductoReferencia;
Use App\User;
Use App\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\AdminDevolucionMail;
use App\Mail\DevolucionStatusMail;
use App\Notifications\NotificationDevolution;

use Illuminate\Support\Facades\Mail;


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
    public function index(Request $request)
    {
        $busqueda = $request->busqueda;

        $productos = Producto::
        //orWhere('pedidos.id','like',"%$busqueda%")
        join('color_producto','productos.id','color_producto.producto_id')
        ->join('colores','color_producto.color_id','colores.id') 
        ->join('imagenes','color_producto.id','imagenes.imageable_id')
        ->join('producto_referencia','color_producto.id','producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id','tallas.id')
        ->join('devoluciones','producto_referencia.id','devoluciones.producto_referencia_id')
        ->join('ventas','devoluciones.venta_id','ventas.id')
        ->join('pedidos','ventas.id','pedidos.venta_id')
        ->select('productos.nombre','devoluciones.id', 'devoluciones.cantidad', 'devoluciones.fecha', 'colores.nombre as color', 'tallas.nombre as talla', 'pedidos.id as pedido','color_producto.id as cop', 'color_producto.slug as slug', 'imagenes.url as imagen')
        ->where('ventas.cliente_id', auth()->user()->cliente->id)
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->groupBy('devoluciones.id')
        ->orderBy('devoluciones.created_at','DESC')
        ->paginate(5);
       

        return view('user.devoluciones.index',compact('productos'));
    }

    public function showDevolucion(Request $request, $id)
    {
        $busqueda = $request->busqueda;

        $productos = Producto::
        //orWhere('pedidos.id','like',"%$busqueda%")
        join('color_producto','productos.id','color_producto.producto_id')
        ->join('colores','color_producto.color_id','colores.id') 
        ->join('imagenes','color_producto.id','imagenes.imageable_id')
        ->join('producto_referencia','color_producto.id','producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id','tallas.id')
        ->join('devoluciones','producto_referencia.id','devoluciones.producto_referencia_id')
        ->join('ventas','devoluciones.venta_id','ventas.id')
        ->join('pedidos','ventas.id','pedidos.venta_id')
        ->select('productos.nombre', 'devoluciones.id', 'devoluciones.cantidad', 'devoluciones.estado', 'devoluciones.fecha', 'colores.nombre as color', 'tallas.nombre as talla', 'pedidos.id as pedido','color_producto.id as cop', 'color_producto.slug as slug', 'imagenes.url as imagen')
        ->where('devoluciones.id', $id)
        ->where('ventas.cliente_id', auth()->user()->cliente->id)
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->groupBy('devoluciones.id')
        ->orderBy('devoluciones.created_at','DESC')
        ->paginate(5);
       

        return view('user.devoluciones.show',compact('productos'));
    }

    public function listarDevolucion()
    {
        //devoluciones en panel de admin
        $devoluciones = Devolucione::join('ventas','devoluciones.venta_id','ventas.id')
        ->join('clientes','ventas.cliente_id','clientes.id')
        ->join('users','clientes.user_id','users.id')
        ->select('devoluciones.id','devoluciones.estado', 'devoluciones.fecha', 'ventas.id as venta', 'users.nombres', 'users.apellidos'
        ,'clientes.id as cliente')
        ->orderBy('devoluciones.created_at','DESC')
        ->paginate(5);

        $estados = $this->estados_devolucion();

        return view('admin.devoluciones.index',compact('devoluciones', 'estados'));
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
        ->count(); // verificamos que no se haya solicitado la devolución anteriormente

        if ($devoluciones == 0) {
            $devolucion = new Devolucione();
            $devolucion->fecha = \Carbon\Carbon::now();
            $devolucion->cantidad = $cantidad;
            $devolucion->producto_referencia_id = $ref;
            $devolucion->venta_id = $venta;

            $devolucion->save();

            $admin = User::where('role_id', 2)->get();
            $user = auth()->user();
        
            $details = [
                'title' => 'Se ha solicitado una nueva devolucion',
                'user' => $admin[0]->nombres,
                'cliente' => $user->nombres.' '.$user->apellidos,
                'url' => url('/admin/devoluciones/'. $devolucion->id),
            ];

            //return new AdminDevolucionMail($details);
            Mail::to($admin[0]->email)->send(new AdminDevolucionMail($details));

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
        $producto_devolucion = Producto::join('color_producto','productos.id','color_producto.producto_id')
        ->join('imagenes','color_producto.id','imagenes.imageable_id')
        ->join('colores','color_producto.color_id','colores.id') 
        ->join('producto_referencia','color_producto.id','producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id','tallas.id')
        ->join('devoluciones','producto_referencia.id','devoluciones.producto_referencia_id')
        ->join('ventas','devoluciones.venta_id','ventas.id')
        ->join('clientes','ventas.cliente_id','clientes.id')
        ->join('users','clientes.user_id','users.id')
        ->select('productos.id', 'productos.nombre', 'colores.nombre as color', 'tallas.nombre as talla', 'color_producto.id as cop', 'color_producto.slug as slug', 'imagenes.url as imagen', 'devoluciones.id as devolucion','devoluciones.estado', 'devoluciones.cantidad', 'devoluciones.fecha', 'ventas.id as venta', 'users.nombres', 'users.apellidos'
        ,'clientes.id as cliente')
        ->where('devoluciones.id', $id)
        ->where('imagenes.imageable_type', 'App\ColorProducto')
        ->groupBy('color_producto.id')
        ->paginate(5);
        

        return view('admin.devoluciones.show',compact('producto_devolucion'));
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

        $details = [
            'cliente' => $devolucion->venta->cliente->user->nombres,
            'fecha' => date('d/m/Y', strtotime($devolucion->fecha)),
            'estado' => $devolucion->estado,
            'url' => url('/devoluciones/'. $devolucion->id),
        ];

        if ($request->estado == 4) { // comprobamos si la devolución ha sido efectuada completamente

            try {

                DB::beginTransaction();

                $producto = ProductoVenta::where('producto_referencia_id', $devolucion->producto_referencia_id)
                ->where('venta_id', $devolucion->venta_id)
                ->first(); //buscamos el producto

                $producto_precio = Producto::join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
                ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
                ->where('producto_referencia.id', $producto->producto_referencia_id)
                ->get(); // obtenemos el precio

                $precio = $producto_precio[0]->precio_actual;

                $cantidad = $producto->cantidad; //cantidad del producto vendida

                $totalproducto = $precio * $cantidad; // calculamos subtotal

                $venta = Venta::where('id', $producto->venta_id)
                ->first();

                $valor = $venta->valor;

                $venta->valor = $valor - $totalproducto; // a la venta se resta el subtotal del producto

                $venta->save();

                $prodreferencia = ProductoReferencia::where('id', $producto->producto_referencia_id)
                ->first();

                $stock = $prodreferencia->stock; // se obtiene el stock actual del producto

                $prodreferencia->stock = $stock + $devolucion->cantidad; // al stock se suma la cantidad vendida

                $prodreferencia->save();

                $producto->delete(); // se borra de la venta el producto

                DB::commit();

            } catch (Exception $e) {
                DB::rollBack();
            }
           
        }

        if ($devolucion->estado == 2) {
            $mensaje = 'La devolución está en estudio';
         }
         if ($devolucion->estado == 3) {
             $mensaje = 'La devolución fue rechazada';
         }
         if ($devolucion->estado == 4) {
             $mensaje = 'La devolución fue aprobada';
         }

        //notificacion para el cliente
        $arrayData = [
            'notificacion' => [
                'msj' => $mensaje,
                'url' => url('/devoluciones/'. $devolucion->id)
            ]
        ];

        Cliente::findOrFail($devolucion->venta->cliente->id)->notify(new NotificationDevolution($arrayData));

        //return new DevolucionStatusMail($details);
        Mail::to($devolucion->venta->cliente->user->email)->send(new DevolucionStatusMail($details));

        session()->flash('message', ['success', ("Se ha actualizado el estado de la solicitud")]);
        return back();
    }

    // esta función al parecer no se utiliza
    public function devolucionProducto(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $devolucion = Devolucione::where('producto_referencia_id', $request->producto)
        ->where('venta_id', $request->venta)
        ->count();

        return ['devolucion' => $devolucion];
    }

    public function estados_devolucion()
    {
        return [
            1,
            2,
            3,
            4
        ];
    }

    public function pdfListarDevoluciones(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');
        
        $devoluciones = Devolucione::join('ventas', 'devoluciones.venta_id', '=', 'ventas.id')
        ->join('pedidos', 'ventas.id', '=', 'pedidos.venta_id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->join('users', 'clientes.user_id', '=', 'users.id')
        ->select('devoluciones.id','devoluciones.estado', 'devoluciones.fecha','pedidos.id as pedido', 'ventas.id as venta', 'users.nombres', 'users.apellidos'
        ,'clientes.id as cliente')
        ->get();

        $count = 0;
        foreach ($devoluciones as $devolucion) {
            $count = $count + 1;
        }

        $pdf = \PDF::loadView('admin.pdf.listado_devoluciones',['devoluciones'=>$devoluciones, 'count'=>$count])
        ->setPaper('a4', 'landscape');
        
        return $pdf->download('listado_devoluciones.pdf');
    }
}
