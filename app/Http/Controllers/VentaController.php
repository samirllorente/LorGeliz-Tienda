<?php

namespace App\Http\Controllers;

use App\Venta;
use App\ProductoVenta;
use App\CarritoProducto;
use App\Carrito;
use App\Pedido;
use App\Producto;
use App\Factura;

use Illuminate\Support\Facades\Mail;
use App\Mail\ClienteMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
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

    public function index(){

        $ventas = Venta::join('clientes','ventas.cliente_id', '=','clientes.id')
        ->join('users','clientes.user_id', '=','users.id')
        ->select('ventas.id','ventas.fecha','ventas.valor','users.nombres', 'clientes.id as cliente')
        ->paginate(5);

        return view('admin.ventas.index', compact('ventas'));
    }

    public function store(Request $request){
        
        if (!$request->ajax()) return redirect('/');

        try {

            DB::beginTransaction();
        
            $facturas = Factura::all('id');
            $consecutivo = $facturas->last();
            
            $id =  $consecutivo->id + 1;

            
            $factura = new Factura();
            $factura->consecutivo = $id;

            $factura->save();

            $venta = new Venta();
            $venta->fecha = \Carbon\Carbon::now();
            $venta->factura_id = $factura->id;
            $venta->valor = $request->total;
            $venta->cliente_id = auth()->user()->cliente->id;

            $venta->save();

            $carritos = CarritoProducto::where('carrito_id', $request->carrito)
            ->get();


            foreach ($carritos as $carrito) {
                
                $productoVenta = new ProductoVenta();

                $productoVenta->producto_referencia_id = $carrito->producto_referencia_id;
                $productoVenta->venta_id = $venta->id;
                $productoVenta->cantidad = $carrito->cantidad;

                $productoVenta->save();
            }

            $car = Carrito::where('id', $request->carrito)->firstOrFail();
            $car->estado = '0';
            $car->save();

            $pedido = new Pedido();
            $pedido->fecha = \Carbon\Carbon::now();
            $pedido->direccion_entrega = Auth()->user()->direccion;
            $pedido->venta_id = $venta->id;
            $pedido->save();

            $cliente = auth()->user()->cliente->id;

            $details = [
                'title' => 'Hemos recibido tu pedido',
                'cliente' => $cliente,
                'url' => url('/pedidos'. $venta->id),
            ];
            
            Mail::to(Auth()->user()->email)->send(new ClienteMessageMail($details));
            
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
        }

        
    }

    public function show($id){

        $venta = Venta::join('clientes','ventas.cliente_id', '=','clientes.id')
        ->join('facturas','ventas.factura_id', '=','facturas.id')
        ->join('users','clientes.user_id', '=','users.id')
        ->select('ventas.id','ventas.fecha','ventas.valor','users.nombres','facturas.prefijo','facturas.consecutivo')
        ->where('ventas.id', $id)->firstOrFail();

        return view('admin.ventas.show', compact('venta'));
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

        $pdf = \PDF::loadView('admin.pdf.venta',['productos'=>$productos,'users'=>$users]);
        return $pdf->download('factura-'.$users[0]->consecutivo.'.pdf');

    }

    
}
