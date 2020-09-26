<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use App\User;
use App\Venta;

use Illuminate\Support\Facades\Mail;
use App\Mail\ClientePrivateMail;

use Illuminate\Http\Request;

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

    public function index(Request $request){

        $keyword = $request->get('keyword');

        $clientes = Cliente::join('users','clientes.user_id', '=', 'users.id')
        ->where('users.nombres','like',"%$keyword%")
        ->orWhere('users.apellidos','like',"%$keyword%")
        ->orWhere('users.direccion','like',"%$keyword%")
        ->orWhere('users.telefono','like',"%$keyword%")
        ->orWhere('users.email','like',"%$keyword%")
        ->select('clientes.id','users.nombres', 'users.apellidos','users.direccion','users.telefono','users.email')
        ->paginate(5);

        return view('admin.clientes.index', compact('clientes'));
    }

    public function show($id){

        $cliente = User::with('imagene')
        ->join('clientes','users.id', '=', 'clientes.user_id')
        ->where('clientes.id', $id)
        ->select('clientes.id','users.*')
        ->firstOrFail();

        $pedidos = Venta::join('clientes','ventas.cliente_id','=','clientes.id')
        ->join('facturas','ventas.factura_id', '=', 'facturas.id')
        ->where('clientes.id',$id)
        ->select('ventas.id as venta','ventas.fecha', 'ventas.valor', 'facturas.prefijo','facturas.consecutivo')
        ->paginate(10);

        $total = 0;

        foreach ($pedidos as $key => $value) {
          $total = $total + $value->valor;
        }

        return view('admin.clientes.show', compact('cliente','pedidos', 'total'));

    }

    public function sendMessage(){
       
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

        } catch (\Exception $exception) {
            $success = false;
        }

        return response()->json(['response' => $success]);
    
    }
    
}
