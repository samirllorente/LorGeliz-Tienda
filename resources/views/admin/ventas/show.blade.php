@extends('layouts.admin')


@section('titulo', 'Administración de Ventas')

@section('breadcrumb')
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection


@section('content')


<div id="index" class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detalle de la venta</h3>

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
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Valor</th>
                            <th>Factura</th>
                            <th>Cliente</th>
                            <th>Acciones</th>
                            <th colspan="6"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td> {{ $venta->id }} </td>
                            <td> {{ date('d/m/Y', strtotime($venta->fecha)) }} </td>
                            <td> ${{ floatval($venta->valor) }}</td>
                            <td> {{ ($venta->prefijo) }}{{ ($venta->consecutivo) }}</td>
                            <td> {{ $venta->nombres }}</td>
                            <td> <a class="btn btn-primary" href="" title="ver pedido"><i class="fas fa-eye"></i></a></td>
                            <td> <a class="btn btn-success" href="" title="imprimir"><i class="fas fa-print"></i></a></td>

                        </tr>

                    </tbody>
                </table>
               
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row -->

@endsection
