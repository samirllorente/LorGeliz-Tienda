<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClientToAdminMail;

class ContactoController extends Controller
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

    public function contacto()
    {
        return view('user.contact');
    }

    public function sendMail(Request $request)
    {
        $admin = User::where('role_id', 2)->get();
        $user = auth()->user();
    
        $details = [
            'title' => 'Has recibido un email de un cliente',
            'cliente' => $user->nombres.' '.$user->apellidos,
            'mensaje' => $request->mensaje,
            'url' => url('/admin/clientes/'. $user->cliente->id),
        ];

        //return new ClientToAdminMail($details);
        Mail::to($admin[0]->email)->send(new ClientToAdminMail($details));
    }

}
