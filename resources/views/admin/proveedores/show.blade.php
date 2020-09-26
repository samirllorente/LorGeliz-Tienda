@extends('layouts.admin')


@section('titulo', 'Ver proveedor')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('proveedor.index')}}">Proveedores</a></li>
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('content')

<div id="proveedor">
    <form action="" method="POST">
            @csrf
    
            <div class="container-fluid">
    
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Administrar proveedores</h3>
    
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
                                <input class="form-control" type="text" name="nombre" id="nombre" value="{{ $proveedor->nombre}}" readonly>
                                    <label for="nombre">Razón social</label>
                                    <input class="form-control" type="text" name="razon_social" id="razon_social" value="{{ $proveedor->razon_social}}" readonly>
    
                                </div>
    
                            </div>
    
                            <div class="col-md-6">
    
                                <div class="form-group">
                                    <label for="nit">Nit</label>
                                    <input class="form-control" type="text" name="nit" id="nit" value="{{ $proveedor->nit}}" readonly>
                                    <label for="nombre">Dirección</label>
                                    <input class="form-control" type="text" name="direccion" id="direccion" value="{{ $proveedor->direccion}}" readonly>
    
                                </div>
    
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-md-6">
    
                                <div class="form-group">
                                    <label for="nombre">Teléfono</label>
                                    <input class="form-control" type="text" name="telefono" id="telefono" value="{{ $proveedor->telefono}}" readonly>
                                </div>
    
                            </div>
    
                            <div class="col-md-6">
                                <div class="form-group">
    
                                    <label for="nombre">Email</label>
                                    <input class="form-control" type="text" name="email" id="email" value="{{ $proveedor->email}}" readonly>
    
                                </div>
                            </div>
    
                        </div>
    
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <a class="btn btn-danger" href="{{ route('cancelar','proveedor.index') }}">Cancelar</a>
                        <a class="btn btn-outline-success float-right" href="">Editar</a>
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
    
    
    
            </div>
    
        </form>
    
    
    </div>



@endsection
