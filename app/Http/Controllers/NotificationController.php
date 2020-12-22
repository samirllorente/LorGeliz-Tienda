<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Cliente;
use Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getNotification()
    {
        $unreadNotifications = Auth::user()->unreadNotifications;
        
        $fechaActual = date('Y-m-d');

        foreach ($unreadNotifications as $notification) {
            if ($fechaActual != $notification->created_at->toDateString()) {
               $notification->markAsRead();
            }
        }

        return Auth::user()->unreadNotifications;
    }

    public function clientNotification()
    {
        $cliente = Cliente::where('user_id', auth()->user()->id)->firstOrFail();

        return Notification::where('notifiable_type', 'App\Cliente')
        ->where('notifiable_id', $cliente->id)
        ->get();
        
    }

    public function setRead(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $notification = Notification::where('id', $request->id)->firstOrFail();
        $notification->read_at =  \Carbon\Carbon::now();

        $notification->save();
    }
}

