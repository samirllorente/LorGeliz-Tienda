@extends('layouts.admin')


@section('titulo', 'Administración de Proveedores')

@section('breadcrumb')
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection


@section('content')


<div id="index" class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sección de proveedores</h3>

                <div class="card-tools">

                    <form>
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="nombre" class="form-control float-right" placeholder="Buscar"
                            value="{{ request()->get('nombre') }}">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 300px;">
            <a class=" m-2 float-right btn btn-primary" href="{{ route('proveedor.create')}}">Crear</a>
                <table class="table table-head-fixed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Razón social</th>
                            <th>Nit</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th colspan="3"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($proveedores as $proveedor)

                        <tr>
                            <td> {{$proveedor->id }} </td>
                            <td> {{$proveedor->nombre }} </td>
                            <td> {{$proveedor->razon_social }} </td>
                            <td> {{$proveedor->nit }} </td>
                            <td> {{$proveedor->direccion }} </td>
                            <td> {{$proveedor->telefono }} </td>
                            <td> {{$proveedor->email }} </td>


                        <td> <a class="btn btn-primary" href="{{ route('proveedor.show', $proveedor->slug)}}">Ver</a></td>

                            <td> <a class="btn btn-success" href="{{ route('proveedor.edit', $proveedor->slug)}}">Editar</a>
                            </td>

                            <td>@include('admin.proveedores.delete')</td>

                        </tr>
                        @endforeach


                    </tbody>
                </table>
                {{ $proveedores->appends($_GET)->links() }}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row -->

@endsection
