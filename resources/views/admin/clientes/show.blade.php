@extends('layouts.admin')


@section('titulo', 'Información de Clientes')

@section('breadcrumb')
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection


@section('content')


<div id="index" class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Información de {{ $cliente->nombres}}</h3>

                <div class="card-tools">

                    <form>
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="keyword" class="form-control float-right" placeholder="Buscar"
                            value="{{ request()->get('keyword') }}">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 110px;">
                <table class="table table-head-fixed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Imagen</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Dirección</th>
                            <th>Telefóno</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{$cliente->id }} </td>
                            <td>
                                @if ($cliente->imagene)
                                <img style="height: 40px; width: 40px;"
                                src="{{ url('storage/' . $cliente->imagene->url) }}"
                                class="rounded-circle">
                                @else
                                <img style="height: 40px; width: 40px;"
                                src=""
                                class="rounded-circle">
                                @endif
                            </td>
                            <td>{{$cliente->nombres }} </td>
                            <td>{{$cliente->apellidos }} </td>
                            <td>{{$cliente->direccion }} </td>
                            <td>{{$cliente->telefono }} </td>
                            <td>{{$cliente->email }} </td>
                        </tr>
                        
                    </tbody>
                </table>
                
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-2">Información de Pedidos</h3>

                <div class="card-tools">
                </div>
            </div>
            <!-- /.card-header -->

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Factura</th>
                            <th scope="col">Valor</th>
                            <th scope="col" colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($pedidos as $pedido)

                        <tr>
                            <td>{{ $pedido->venta }}</td>
                            <td>{{ date('d/m/Y', strtotime($pedido->fecha)) }}</td>
                            <td>{{ $pedido->prefijo }}{{ $pedido->consecutivo }}</td>
                            <td>${{ floatval($pedido->valor)}}</td>
                            <td><a href="{{ route('mostrar.pedido', $pedido->venta)}}" class="btn btn-primary"
                            title="ver pedido"><i class="fas fa-eye"></i></a>
                            </td>
                            <td><a href="" class="btn btn-success"
                            title="imprimir"><i class="fas fa-print"></i></a>
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-right">Total: ${{ floatval($total)}}</td>
                            <td colspan="3" class="text-left"></td>
                        </tr>

                    </tfoot>
                </table>

                {{ $pedidos->appends($_GET)->links() }} 
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row -->

@endsection
