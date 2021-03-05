@extends('layouts.admin')


@section('titulo', 'Administración de Ventas')

@section('breadcrumb')
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection


@section('content')


<div id="factura_venta" class="row">

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
                            <th>Cliente</th>
                            <th>Factura</th>
                            <th>Valor</th>
                            <th>Saldo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                            <th colspan="9"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>{{ $venta->id }}</td>
                            <td>{{ date('d/m/Y h:i:s A', strtotime($venta->fecha)) }}</td>
                            <td><a href="{{ route('cliente.show', $venta->cliente)}}">{{ $venta->nombres }} {{ $venta->apellidos}}</a></td>
                            <td>{{ ($venta->prefijo) }}{{ ($venta->consecutivo) }}</td>
                            <td>${{ floatval($venta->valor) }}</td>
                            <td>${{ floatval($venta->saldo) }}</td>
                            <td>
                                @if ($venta->estado == 1)
                                {{ "Pagada" }}
                                @endif
                                @if ($venta->estado == 2)
                                {{ "Con saldo" }}
                                @endif
                                @if ($venta->estado == 3)
                                {{ "Anulada" }}
                                @endif
                            </td>
                            @if ($venta->estado == 2 & !$venta->pago)
                            <td>
                                <form action="{{ route('venta.pagar', $venta->id)}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary" title="registrar pago"><i class="fas fa-money-bill-wave"></i></button>
                                </form>
                            </td>
                            @endif
                            <td><a href="" class="btn btn-success" title="imprimir factura" 
                                    v-on:click.prevent="facturaVenta({{$venta->id}})">
                                    <i class="fas fa-print"></i>
                                </a>
                            </td>
                            <td><a href="{{ route('pedidos.show-id', $venta->pedido->id)}}" class="btn btn-info"
                                    title="ver pedido"><i class="fas fa-shopping-cart"></i></a>
                            </td>

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
