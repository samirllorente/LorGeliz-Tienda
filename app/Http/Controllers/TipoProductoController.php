<?php

namespace App\Http\Controllers;

use App\Tipo;
use App\Http\Requests\TipoRequest;
use Illuminate\Http\Request;


class TipoProductoController extends Controller
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
        $nombre = $request->get('nombre');
       
        $tipos = Tipo::where('nombre','like',"%$nombre%")->orderBy('id')->paginate(5);
        return view('admin.tipo_producto.index',compact('tipos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tipo_producto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoRequest $request)
    {
        $tipo = new Tipo();
        $tipo->nombre = $request->nombre;
        $tipo->descripcion = $request->descripcion;
        $tipo->subcategoria_id = $request->subcategory_id;

        $tipo->save();

        session()->flash('message', ['success', ("Se ha creado el tipo exitosamente")]);
        return redirect()->route('tipo.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $tipo = Tipo::where('slug',$slug)->firstOrFail();
        return view('admin.tipo_producto.show',compact('tipo'));
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $tipo = Tipo::where('slug',$slug)->firstOrFail();
        return view('admin.tipo_producto.edit',compact('tipo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(TipoRequest $request, Tipo $tipo)
    public function update(TipoRequest $request, $id)
    {
        $tipo = Tipo::where('id', $id)->firstOrFail();

        $tipo->nombre = $request->nombre;
        $tipo->descripcion = $request->descripcion;
        $tipo->subcategoria_id = $request->subcategory_id;

        $tipo->save();

        session()->flash('message', ['success', ("Se ha creado editado el tipo exitosamente")]);
        return redirect()->route('tipo.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //public function destroy(Tipo $tipo)
    public function destroy($id)
    {
        try{

            $tipo = Tipo::where('id', $id)->firstOrFail();

            $tipo->delete();

            session()->flash('message', ['success', ("Se ha eliminado el tipo de producto")]);

            return redirect()->route('tipo.index');
        }

        catch (\Exception $exception){

            session()->flash('message', ['warning', ("No se puede eliminar la subcategoría porque está en uso")]);

            return redirect()->route('tipo.index');
        }
    }


    public function getTipo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $id  = $request->subcategoria;
        $tipos = Tipo::where('subcategoria_id', $id)->get(); 
        
        $response = ['data' => $tipos];
        
        return response()->json($response);

    }
}
