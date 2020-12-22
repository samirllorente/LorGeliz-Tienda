<?php

namespace App\Http\Controllers;


use App\Cliente;
use App\Pedido;
use App\User;
use App\Venta;
use App\Mail\ClientePrivateMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class ClienteController extends Controller
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

    public function index(Request $request)
    {
        $keyword = $request->get('keyword');

        $clientes = Cliente::join('users','clientes.user_id', '=', 'users.id')
        ->where('users.nombres','like',"%$keyword%")
        ->orWhere('users.apellidos','like',"%$keyword%")
        ->orWhere('users.identificacion','like',"%$keyword%")
        ->orWhere('users.direccion','like',"%$keyword%")
        ->orWhere('users.telefono','like',"%$keyword%")
        ->orWhere('users.email','like',"%$keyword%")
        ->select('clientes.id','users.nombres', 'users.apellidos', 'users.identificacion','users.direccion','users.telefono','users.email')
        ->paginate(5);

        return view('admin.clientes.index', compact('clientes'));
    }

    public function show($id)
    {
        $cliente = User::with('imagene')
        ->join('clientes','users.id', '=', 'clientes.user_id')
        ->where('clientes.id', $id)
        ->select('clientes.id','users.*')
        ->firstOrFail();

        $pedidos = Pedido::join('ventas', 'pedidos.venta_id', 'ventas.id')
        ->join('clientes','ventas.cliente_id','=','clientes.id')
        ->join('facturas','ventas.factura_id', '=', 'facturas.id')
        ->where('clientes.id',$id)
        ->where('ventas.estado', '!=', '3')
        ->select('pedidos.id','pedidos.fecha', 'ventas.valor', 'facturas.prefijo','facturas.consecutivo')
        ->paginate(10);

        $total = 0;

        foreach ($pedidos as $key => $value) {
          $total = $total + $value->valor;
        }

        return view('admin.clientes.show', compact('cliente','pedidos', 'total'));

    }

    public function sendMessage()
    {
        $info = \request('info');
        $data = [];
        parse_str($info, $data);

        $cliente = User::join('clientes', 'users.id', '=', 'clientes.user_id')
        ->where('clientes.id', $data['cliente_id'])
        ->select('users.*')
        ->first();

        try {
            
            Mail::to($cliente->email)->send(new ClientePrivateMail($cliente->nombres, $data['message']));
            $success = true;
            return new ClientePrivateMail($cliente->nombres, $data['message']);


        } catch (\Exception $exception) {
            $success = false;
        }

        return response()->json(['response' => $success]);
    
    }

    public function pdfListadoClientes()
    {
        $clientes = Cliente::join('users','clientes.user_id', '=', 'users.id')
        ->select('clientes.id','users.nombres', 'users.apellidos','users.direccion','users.telefono','users.email')
        ->paginate(10);

        $count = 0;
        foreach ($clientes as $cliente) {
            $count = $count + 1;
        }

        $pdf = \PDF::loadView('admin.pdf.listadoclientes',['clientes'=>$clientes, 'count'=>$count])
        ->setPaper('a4', 'landscape');
        
        return $pdf->download('listadoclientes.pdf');

    }
    
}
