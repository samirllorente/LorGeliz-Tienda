<?php

namespace App\Http\Controllers;


use App\CarritoProducto;
use App\Carrito;
use App\Factura;
use App\Pago;
use App\Pedido;
use App\Producto;
use App\ProductoReferencia;
use App\ProductoVenta;
use App\User;
use App\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClienteMessageMail;
use App\Mail\AdminVentaMail;
use App\Notifications\NotificationAdmin;


class VentaController extends Controller
{
    public $x_ref_payco;
    public $x_cod_response;
    public $x_amount;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('epaycoConfirm');
    }

    public function index(Request $request)
    {
        $busqueda = $request->busqueda;
        
        $estado = $request->estado;

        if (!$estado) {

           $ventas = Venta::join('clientes','ventas.cliente_id', '=','clientes.id')
           ->join('users','clientes.user_id', '=','users.id')
           ->select('ventas.id','ventas.fecha','ventas.valor','ventas.estado','users.nombres','users.apellidos','clientes.id as cliente')
           ->orderBy('ventas.id', 'DESC')
           ->orWhere('ventas.valor', 'like',"%$busqueda%")
           ->orWhere('users.nombres', 'like',"%$busqueda%") //buscar ventas por valor a clientes
           ->paginate(5);

        } else {
            $ventas = Venta::join('clientes','ventas.cliente_id', '=','clientes.id')
            ->join('users','clientes.user_id', '=','users.id')
            ->select('ventas.id','ventas.fecha','ventas.valor', 'ventas.estado','users.nombres','users.apellidos','clientes.id as cliente')
            ->orderBy('ventas.id', 'DESC')
            ->orWhere('ventas.estado', $estado) //buscar ventas por estado
            ->paginate(5);
        }

        return view('admin.ventas.index', compact('ventas'));
    }

    public function epayco_register(Request $request)
    {
        //dd($request);
        $p_cust_id_cliente = '71480';
        $p_key = '03311b932a61ca0805ee7f7d5ca7f0dd7faad74c';
        $this->x_ref_payco = $request->x_ref_payco;
        $x_transaction_id = $request->x_transaction_id;
        $this->x_amount = $request->x_amount;
        $x_currency_code = $request->x_currency_code;
        $x_signature = $request->x_signature;
        //$signature = hash('sha256', $p_cust_id_cliente. '^' . $p_key . '^' . $this->x_ref_payco . '^' . $x_transaction_id . '^' . $this->x_amount . '^' .$x_currency_code);
       
        $signature=hash('sha256',
                       $p_cust_id_cliente.'^'
                      .$p_key.'^'
                      .$this->x_ref_payco.'^'
                      .$x_transaction_id.'^'
                      .$this->x_amount.'^'
                      .$x_currency_code
                    );
        //Validamos la firma
        if ($x_signature == $signature) {
        //if($this->x_cod_response = $request->x_cod_response) {
        /*Si la firma esta bien podemos verificar los estado de la transacción*/
        //$this->x_cod_response = $request->x_cod_response;
        switch ((int) $this->x_cod_response) {
        case 1:
        # code transacción aceptada
            //$this->store();
            dd($request);
        break;
        case 2:
        # code transacción rechazada
        break;
        case 3:
        # code transacción pendiente
            //$this->store();
            dd($request);
        break;
        case 4:
        # code transacción fallida
        break;
        }
        } else {
        die("Firma no valida");
        }
                
    }
//esta función es para probar la confirmación por el método post
    public function epaycoConfirm(Request $request)
    {
        dd($request);
        $p_cust_id_cliente = '71480';
        $p_key = '03311b932a61ca0805ee7f7d5ca7f0dd7faad74c';
        $this->x_ref_payco = $request->x_ref_payco;
        $x_transaction_id = $request->x_transaction_id;
        $this->x_amount = $request->x_amount;
        $x_currency_code = $request->x_currency_code;
        $x_signature = $request->x_signature;
        $signature = hash('sha256', $p_cust_id_cliente . '^' . $p_key . '^' . $this->x_ref_payco . '^' . $x_transaction_id . '^' . $this->x_amount . '^' . $x_currency_code);
        $x_response = $request->x_response;
        $x_motivo = $request->x_response_reason_text;
        $x_id_invoice = $request->x_id_invoice;
        $x_autorizacion = $request->x_approval_code;
        //Validamos la firma
        //if ($x_signature == $signature) {
        /*Si la firma esta bien podemos verificar los estado de la transacción*/
        if($this->x_cod_response = $request->x_cod_response){
        //$this->x_cod_response = $request->x_cod_response;
        switch ((int) $this->x_cod_response) {
        case 1:
        # code transacción aceptada
        $this->store();
        break;
        case 2:
        # code transacción rechazada
        //echo "transacción rechazada";
        break;
        case 3:
        # code transacción pendiente
        //echo "transacción pendiente";
        break;
        case 4:
        # code transacción fallida
        //echo "transacción fallida";
        break;
        }
        } else {
        die("Firma no valida");
        }
    }

    public function show($id)
    {

        $venta = Venta::join('clientes','ventas.cliente_id', '=','clientes.id')
        ->join('facturas','ventas.factura_id', '=','facturas.id')
        ->join('users','clientes.user_id', '=','users.id')
        ->select('ventas.id','ventas.fecha','ventas.valor','ventas.saldo','ventas.estado','users.nombres', 'users.apellidos','facturas.prefijo','facturas.consecutivo','clientes.id as cliente')
        ->where('ventas.id', $id)->firstOrFail();

        return view('admin.ventas.show', compact('venta'));
    }

    public function anular(Venta $venta)
    {
        $venta->estado = 3;
        $venta->save();

        $pago = Pago::where('venta_id', $venta->id)->first();

        if ($pago) {
            $pago->estado = 5; // se anula el pago
            $pago->save();
        }

        $productoVenta = ProductoVenta::where('venta_id', $venta->id)->get();
        foreach ($productoVenta as $key => $producto) {
           $prod = $producto->producto_referencia_id;
           $cantidad = $producto->cantidad; // se obtiene la cantidad del producto vendida

           $prof = ProductoReferencia::where('id', $prod)->first();
           $stock = $prof->stock;

           $prof->stock = $stock + $cantidad; // se restituye al stock la cantidad vendida

           $prof->save();
        }

        session()->flash('message', ['success', ("Se ha anulado la venta exitosamente")]);

        return back();
    }

    public function registrarPago(Venta $venta)
    {
        $venta->estado = 1;
        $venta->saldo = 0;
        $venta->save();

        $total = $venta->valor;
        $venta_id = $venta->id;
        $x_ref_payco = 0;
        $x_cod_response = 1;

        $payment =  new PaymentController();
        $payment->store($x_ref_payco, $total, $venta_id, $x_cod_response);// se envían las variables al método store de pagos

        session()->flash('message', ['success', ("Se ha registrado el pago exitosamente")]);

        return back();
    }

    public function store()
    {
        try {
            $x_ref_payco = ($this->x_ref_payco) ? $this->x_ref_payco : 0; // si no viene la ref. se pone 0
            $x_cod_response = ($this->x_cod_response) ? $this->x_cod_response : 3;
            $x_amount = ($this->x_amount) ? $this->x_amount : 0;
        
            DB::beginTransaction();
        
            if ($x_cod_response == 1 || $x_cod_response == 3) {// si la transacción es aceptada o está pendiente

                $facturas = Factura::all('id');
                $consecutivo = $facturas->last();// se obtiene le ultimo id de facturas
                
                $id =  $consecutivo->id + 1;
    
                $factura = new Factura();
                $factura->consecutivo = $id;
    
                $factura->save();
    
                //$car = Carrito::where('id', $request->carrito)->firstOrFail();
                $car = Carrito::where('cliente_id', auth()->user()->cliente->id)
                ->where('estado', 1)
                ->firstOrFail(); // se busca el carrito del cliente
    
                //$car->estado = '0';
                //$car->save();
    
                $venta = new Venta();
                $venta->fecha = \Carbon\Carbon::now();
                $venta->factura_id = $factura->id;
                //$venta->valor = $request->total;
                $venta->valor =  $car->total;
                $venta->cliente_id = auth()->user()->cliente->id;
                $venta->saldo = $car->total - $x_amount; // si el pago no fue por epayco o está pendiente, la venta queda con saldo

                if ($x_cod_response == 1) {
                    $venta->estado = 1; // si el pago fue exitoso, la venta queda pagada
                    $venta->save();

                    $total = $car->total;
                    $venta_id = $venta->id;
                    $payment =  new PaymentController();
                    $payment->store($x_ref_payco, $total, $venta_id, $x_cod_response);
                }
                else{
                    $venta->estado = 2;
                    $venta->save();
                }

    
                $admin = User::where('role_id', 2)->get();
    
                $details = [
                    'title' => 'Se ha efectuado una nueva venta',
                    'user' => $admin[0]->nombres,
                    'valor' => $venta->valor,
                    'url' => url('/admin/ventas/'. $venta->id),
                ];
                
                Mail::to($admin[0]->email)->send(new AdminVentaMail($details));

                $numVentas = DB::table('ventas')->where('id', $venta->id)->count();

                $arrayData = [
                    'ventas' => [
                        'numero' => $numVentas,
                        'msj' => 'nueva venta',
                        'url' => url('/admin/ventas/'. $venta->id)
                    ]
                ];

                foreach ($admin as $user) {
                    User::findOrFail($user->id)->notify(new NotificationAdmin($arrayData));
                }

                DB::commit();

                $response = ['data' => 'success', 'pedido' => $venta->pedido->id];
                return response()->json($response);
            }

        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function listadoVentasPdf()
    {
        $ventas = Venta::join('clientes','ventas.cliente_id', '=','clientes.id')
        ->join('users','clientes.user_id', '=','users.id')
        ->select('ventas.id','ventas.fecha','ventas.valor', 'ventas.estado','users.nombres','clientes.id as cliente')
        ->orderBy('ventas.id', 'DESC')
        ->get();

        $count = 0;
        foreach ($ventas as $venta) {
            $count = $count + 1;
        }

        $pdf = \PDF::loadView('admin.pdf.listadoventas',['ventas'=>$ventas, 'count'=>$count])
        ->setPaper('a4', 'landscape');
        
        return $pdf->download('listadoventas.pdf');

    }

    public function facturaVentaAdmin(Request $request, $id)
    {

        $productos = Producto::join('color_producto','productos.id', '=', 'color_producto.producto_id')
        ->join('colores', 'color_producto.color_id', '=', 'colores.id') 
        ->join('producto_referencia', 'color_producto.id', '=', 'producto_referencia.color_producto_id')
        ->join('tallas','producto_referencia.talla_id', '=', 'tallas.id')
        ->join('producto_venta','producto_referencia.id', '=', 'producto_venta.producto_referencia_id')
        ->join('ventas','ventas.id', '=', 'producto_venta.venta_id')
        ->select('productos.*', 'producto_venta.cantidad', 'colores.nombre as color', 'tallas.nombre as talla', 'producto_referencia.id as referencia','color_producto.id as cop', 'color_producto.slug as slug', 'ventas.valor') 
        ->where('ventas.id', '=', $id)->get();
        
        $users = Venta::join('clientes','ventas.cliente_id', '=', 'clientes.id')
        ->join('users','clientes.user_id', '=', 'users.id')
        ->join('facturas', 'ventas.factura_id', '=', 'facturas.id')
        ->select('users.nombres', 'users.identificacion','users.direccion','users.telefono','users.email', 'ventas.id as venta', 'ventas.fecha','ventas.saldo', 'facturas.prefijo', 'facturas.consecutivo')
        ->where('ventas.id', '=', $id)->get();

        $pdf = \PDF::loadView('admin.pdf.venta',['productos'=>$productos,'users'=>$users]);
        return $pdf->download('factura-'.$users[0]->consecutivo.'.pdf');

    }

}
