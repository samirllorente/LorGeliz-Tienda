<?php

namespace App\Http\Controllers;

use App\Imagene;
use App\User;
use App\Http\Requests\UserRequest;
use App\Rules\StrengthPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller

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
    public function index()
    {
        $user = User::where('id', auth()->user()->id)->first();
        return view('user.show', compact('user'));
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
        //
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
    public function update(UserRequest $request)
    {
        

        $user = auth()->user();
        $user->username = request('usuario');
        $user->nombres = request('nombres');
        $user->apellidos = request('apellidos');
        $user->direccion = request('direccion');
        $user->telefono = request('telefono');

        if (request('password')) { //si se envía el password se somete a la rule

            $this->validate(request(), 
             ['password' => ['confirmed', new StrengthPassword]]);
             $user->password = bcrypt(request('password'));
        }
       
        $user->save();

        //if ($request->hasFile('imagen')) {

            //$imagen = $request->file('imagen');

            //$nombre = time().'_'.$imagen->getClientOriginalName();

            //$path = Storage::disk('public')->putFileAs("imagenes/users/" . $user->id, $imagen, $nombre);
           
        //}

        //$img = new Imagene();
        //$img->url = $path;
        //$img->imageable_type = 'App\User';
        //$img->imageable_id = $user->id;

        //$img->save();

        session()->flash('message', ['success', ("Se han actualizado los datos")]);
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
}
