<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proveedore;

class ProveedorController extends Controller
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
        $nombre = $request->get('nombre');
       
        $proveedores = Proveedore::where('nombre','like',"%$nombre%")->orderBy('created_at')->paginate(5);
        return view('admin.proveedores.index',compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proveedor = new Proveedore();
        $proveedor->nombre = $request->nombre;
        $proveedor->nit = $request->nit;
        $proveedor->razon_social = $request->razon_social;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;

        $proveedor->save();

        session()->flash('message', ['success', ("Se ha creado el proveedor exitosamente")]);
        return redirect()->route('proveedor.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $proveedor = Proveedore::where('slug',$slug)->firstOrFail();
        
        return view('admin.proveedores.show',compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $proveedor = Proveedore::where('slug',$slug)->firstOrFail();
        
        return view('admin.proveedores.edit',compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proveedore $proveedor)
    {
        $proveedor->nombre = $request->nombre;
        $proveedor->nit = $request->nit;
        $proveedor->razon_social = $request->razon_social;
        $proveedor->direccion = $request->direccion;
        $proveedor->telefono = $request->telefono;
        $proveedor->email = $request->email;

        $proveedor->save();

        session()->flash('message', ['success', ("Se ha editado el proveedor exitosamente")]);
        return redirect()->route('proveedor.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Proveedor $proveedor)
    {
        try{

            $proveedor->delete();

            session()->flash('message', ['success', ("Se ha eliminado el proveedor")]);

            return redirect()->route('proveedor.index');
        }

        catch (\Exception $exception){

            session()->flash('message', ['warning', ("Ha ocurrido un error al eliminar el proveedor")]);

            return redirect()->route('proveedor.index');
        }
    }
}
