@extends('layouts.admin')


@section('titulo', 'Editar proveedor')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('proveedor.index')}}">Proveedores</a></li>
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('content')

<div id="proveedor">
    <form action="{{route('proveedor.update', $proveedor)}}" method="POST">
            @csrf
            @method('PUT')
    
            <div class="container-fluid">
    
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Editar proveedores</h3>
    
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse"><i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                                title="Remove"><i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
    
                        <div class="row">
                            <div class="col-md-6">
    
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                <input class="form-control" type="text" name="nombre" id="nombre" value="{{ $proveedor->nombre}}" >
                                    <label for="nombre">Razón social</label>
                                    <input class="form-control" type="text" name="razon_social" id="razon_social" value="{{ $proveedor->razon_social}}" >
    
                                </div>
    
                            </div>
    
                            <div class="col-md-6">
    
                                <div class="form-group">
                                    <label for="nit">Nit</label>
                                    <input class="form-control" type="text" name="nit" id="nit" value="{{ $proveedor->nit}}" >
                                    <label for="nombre">Dirección</label>
                                    <input class="form-control" type="text" name="direccion" id="direccion" value="{{ $proveedor->direccion}}" >
    
                                </div>
    
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
    
                                <div class="form-group">
                                    <label for="nombre">Teléfono</label>
                                    <input class="form-control" type="text" name="telefono" id="telefono" value="{{ $proveedor->telefono}}" >
                                </div>
    
                            </div>
    
                            <div class="col-md-6">
                                <div class="form-group">
    
                                    <label for="nombre">Email</label>
                                    <input class="form-control" type="text" name="email" id="email" value="{{ $proveedor->email}}" >
    
                                </div>
                            </div>
    
                        </div>
    
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a class="btn btn-danger" href="{{ route('cancelar','proveedor.index') }}">Cancelar</a>
                        <input type="submit" value="Guardar" class="btn btn-primary float-right">
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
    
    
    
            </div>
    
        </form>
    
    
    </div>



@endsection
