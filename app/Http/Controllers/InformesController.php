<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Producto;
use App\ProductoReferencia;
use App\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformesController extends Controller
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

    public function informeVentas(Request $request)
    {

        $anio = date('Y');

        $ventas=DB::table('ventas as v')
        ->select(DB::raw('MONTH(v.fecha) as mes'),
        DB::raw('YEAR(v.fecha) as anio'),
        DB::raw('COUNT(v.id) as cantidad'),
        DB::raw('SUM(v.valor) as total'))
        ->whereYear('v.fecha',$anio)
        ->where('v.estado', '!=', '3')
        ->groupBy(DB::raw('MONTH(v.fecha)'),DB::raw('YEAR(v.fecha)'))
        ->paginate(5); //obtener ventas por meses

        return view('admin.informes.ventas.index',compact('ventas'));
    }

    public function mostrarVentas(Request $request,$mes)
    {

        $fecha_de = $request->get('fecha_de');
        $fecha_a = $request->get('fecha_a');

        $anio = date('Y');

        if ($fecha_de == '') {
           $fecha_de = '01/01/'.$anio;
        }

        if ($fecha_a == '') {
            $fecha_a = \Carbon\Carbon::now();
        }

        $ventas=DB::table('ventas')
        ->join('producto_venta', 'ventas.id', '=', 'producto_venta.venta_id')
        ->join('facturas', 'ventas.factura_id', '=', 'facturas.id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->join('users', 'clientes.user_id', '=', 'users.id')
        ->select('ventas.*','users.nombres', 'clientes.id as cliente', 'facturas.prefijo', 'facturas.consecutivo',
        DB::raw('SUM(producto_venta.cantidad) as cantidad'))
        ->whereMonth('ventas.fecha',$mes)
        ->whereBetween('ventas.fecha',[$fecha_de, $fecha_a])
        ->groupBy('ventas.id')
        ->orderBy('ventas.created_at', 'DESC')
        ->paginate(5); //obtener ventas en el mes seleccionado

        return view('admin.informes.ventas.show',compact('ventas'));
    }

    public function ventaProductos(Request $request)
    {
        //$fecha_de = $request->get('fecha_de');
        //$fecha_a = $request->get('fecha_a');

        //if ( $fecha_de =='' && $fecha_a =='') {
            //$fecha_a = \Carbon\Carbon::now();
            //$fecha_de = \Carbon\Carbon::now();
        //}

        $busqueda = $request->busqueda;

        $productos = DB::table('productos')
        ->orWhere('productos.nombre','like',"%$busqueda%")
        ->orWhere('colores.nombre','like',"%$busqueda%")
        ->orWhere('tallas.nombre','like',"%$busqueda%")
        ->join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id')
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas', 'tallas.id', '=', 'producto_referencia.talla_id')
        ->join('producto_venta', 'producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        ->select('color_producto.id as cop', 'productos.id as codigo', 'productos.nombre', 'colores.nombre as color',
        'tallas.nombre as talla', DB::raw('SUM(producto_venta.cantidad) as cantidad')
        )->groupBy('producto_referencia.id')
        ->orderBy('cantidad', 'DESC')
        ->paginate(5); //informe de productos más vendidos
        
        return view('admin.informes.productos.index',compact('productos'));
    }

    public function informeClientes(Request $request)
    {
        $busqueda = $request->busqueda;

        $clientes = DB::table('clientes')
        ->orWhere('users.id','like',"%$busqueda%")
        ->orWhere('users.nombres','like',"%$busqueda%")
        ->orWhere('users.apellidos','like',"%$busqueda%")
        ->orWhere('users.telefono','like',"%$busqueda%")
        ->orWhere('users.email','like',"%$busqueda%")
        ->join('ventas', 'clientes.id', '=', 'ventas.cliente_id')
        ->join('users', 'clientes.user_id', '=', 'users.id')
        ->select('users.id as user','users.nombres', 'users.apellidos', 'users.telefono', 'users.email',
        'clientes.id as id_cliente',
        DB::raw('COUNT(ventas.id) as cantidad'))
        ->groupBy('ventas.cliente_id')
        ->orderBy('cantidad', 'DESC')
        ->paginate(5);

        return view('admin.informes.clientes.index',compact('clientes'));

    }

    public function informePagos(Request $request)
    {
        $anio = date('Y');

        $pagos=DB::table('pagos as p')
        ->select(DB::raw('MONTH(p.fecha) as mes'),
        DB::raw('YEAR(p.fecha) as anio'),
        DB::raw('COUNT(p.id) as cantidad'),
        DB::raw('SUM(p.monto) as total'))
        ->whereYear('p.fecha',$anio)
        ->groupBy(DB::raw('MONTH(p.fecha)'),DB::raw('YEAR(p.fecha)'))
        ->paginate(5);

        return view('admin.informes.pagos.index',compact('pagos'));
    }

    public function mostrarPagos(Request $request,$mes)
    {

        $fecha_de = $request->get('fecha_de');
        $fecha_a = $request->get('fecha_a');

        $anio = date('Y');

        if ($fecha_de == '') {
           $fecha_de = '01/01/'.$anio;
        }

        if ($fecha_a == '') {
            $fecha_a = \Carbon\Carbon::now();
        }

        $pagos=DB::table('pagos')
        ->join('ventas', 'pagos.venta_id', '=', 'ventas.id')
        ->select('pagos.*')
        ->whereMonth('pagos.fecha',$mes)
        ->whereBetween('pagos.fecha',[$fecha_de, $fecha_a])
        ->groupBy('pagos.id')
        ->orderBy('pagos.created_at', 'DESC')
        ->paginate(5);

        return view('admin.informes.pagos.show',compact('pagos'));
    }
    
    public function pdfInformeVentas(Request $request)
    {

        $fecha_de = $request->get('fecha_de');
        $fecha_a = $request->get('fecha_a');

        $anio = date('Y');

        if ( $fecha_de =='' && $fecha_a =='') {

            $ventas=DB::table('ventas as v')
            ->select(DB::raw('MONTH(v.fecha) as mes'),
            DB::raw('YEAR(v.fecha) as anio'),
            DB::raw('COUNT(v.id) as cantidad'),
            DB::raw('SUM(v.valor) as total'))
            ->whereYear('v.fecha',$anio)
            ->groupBy(DB::raw('MONTH(v.fecha)'),DB::raw('YEAR(v.fecha)'))
            ->get();

        }

        $count = 0;
        foreach ($ventas as $venta) {
            $count = $count + 1;
        }

        $pdf = \PDF::loadView('admin.pdf.informeventas',['ventas'=>$ventas, 'count'=>$count])->setPaper('a4', 'landscape');
        return $pdf->download('ventas.pdf');

    }

    public function pdfInformeProductos(Request $request)
    {
        //$fecha_de = $request->get('fecha_de');
        //$fecha_a = $request->get('fecha_a');

        //if ( $fecha_de =='' && $fecha_a =='') {
            //$fecha_a = \Carbon\Carbon::now();
            //$fecha_de = \Carbon\Carbon::now();
        //}

        $productos = DB::table('productos')
        ->join('color_producto', 'productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id')
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas', 'tallas.id', '=', 'producto_referencia.talla_id')
        ->join('producto_venta', 'producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        ->select('color_producto.id as cop','productos.id as codigo','productos.nombre','colores.nombre as color',
        'tallas.nombre as talla',DB::raw('SUM(producto_venta.cantidad) as cantidad')
        )->groupBy('producto_referencia.id')
        ->orderBy('cantidad', 'DESC')
        ->get();
        
        $count = 0;
        foreach ($productos as $producto) {
            $count = $count + 1;
        }

        $pdf = \PDF::loadView('admin.pdf.informeproductos',['productos'=>$productos, 'count'=>$count])
        ->setPaper('a4', 'landscape');

        return $pdf->download('productos.pdf');

    }

    public function pdfInformeClientes(Request $request)
    {
        $clientes = DB::table('clientes')
        ->join('ventas', 'clientes.id', '=', 'ventas.cliente_id')
        ->join('users', 'clientes.user_id', '=', 'users.id')
        ->select('users.id as user','users.nombres', 'users.telefono', 'users.email',
        'clientes.id as id_cliente',
        DB::raw('COUNT(ventas.id) as cantidad'))
        ->groupBy('ventas.cliente_id')
        ->orderBy('cantidad', 'DESC')
        ->get();

        $count = 0;
        foreach ($clientes as $cliente) {
            $count = $count + 1;
        }

        $pdf = \PDF::loadView('admin.pdf.informeclientes',['clientes'=>$clientes, 'count'=>$count])
        ->setPaper('a4', 'landscape');
        return $pdf->download('clientes.pdf');
    }

    public function pdfVentaShow(Request $request)
    {
        $ventas=DB::table('ventas')
        ->join('producto_venta', 'ventas.id', '=', 'producto_venta.venta_id')
        ->join('facturas', 'ventas.factura_id', '=', 'facturas.id')
        ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
        ->join('users', 'clientes.user_id', '=', 'users.id')
        ->select('ventas.*','users.nombres', 'clientes.id as cliente', 'facturas.prefijo', 'facturas.consecutivo',
        DB::raw('SUM(producto_venta.cantidad) as cantidad'))
        ->whereMonth('ventas.fecha',$request->mes)
        ->groupBy('ventas.id')
        ->get();

        $count = 0;
        foreach ($ventas as $venta) {
            $count = $count + 1;
        }

        $pdf = \PDF::loadView('admin.pdf.informeventashow',['ventas'=>$ventas, 'count'=>$count])
        ->setPaper('a4', 'landscape');
        return $pdf->download('ventas_mes.pdf');
    }
}
