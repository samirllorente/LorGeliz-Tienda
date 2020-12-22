@extends('layouts.admin')


@section('titulo', 'Listado de Pagos')

@section('breadcrumb')
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection


@section('content')


<div id="payments" class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sección de pagos</h3>

                <div class="card-tools">

                    <form>
                        <div class="input-group input-group-sm" style="width: 160px;">
                            <div class="input-group-append">
                                <a href="" class="btn btn-success mx-1" v-on:click.prevent="pdfListPagos()">
                                    <i class="fas fa-print"></i>
                                </a>
                            </div>
                            <input type="text" name="busqueda" class="form-control float-right" placeholder="Buscar"
                            value="{{ request()->get('busqueda') }}">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th># Venta</th>
                            <th>Ref. epayco</th>
                            <th>Valor</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                            <th colspan="7"></th>
                        </tr>
                    </thead>
                    <tbody>
                    
                        @foreach ($pagos as $pago)

                        <tr>
                            <td> {{ $pago->id }} </td>
                            <td> {{ date('d/m/Y', strtotime($pago->fecha)) }}</td>
                            <td> <a href="{{ route('venta.show', $pago->venta_id)}}" title="ver venta">{{$pago->venta_id}}</a></td>
                            <td> {{ $pago->ref_epayco ? : "no aplica"}}</td>
                            <td> ${{ floatval($pago->monto) }}</td>
                            <td>
                                @if ($pago->estado == 1)
                                <span class="badge badge-success">
                                {{ "Aceptado" }}
                                </span>
                                @endif
                                @if ($pago->estado == 2)
                                <span class="badge badge-danger">
                                {{ "Rechazado" }}
                                </span>
                                @endif
                                @if ($pago->estado == 3)
                                <span class="badge badge-warning">
                                {{ "Pendiente" }}
                                </span>
                                @endif
                                @if ($pago->estado == 4)
                                <span class="badge badge-danger">
                                {{ "Fallido" }}
                                </span>
                                @endif
                                @if ($pago->estado == 5)
                                <span class="badge badge-danger">
                                {{ "Anulado" }}
                                </span>
                                @endif
                            </td>
                            <td> <a class="btn btn-primary" href="{{ route('venta.show', $pago->venta_id)}}" title="ver venta"><i class="fas fa-eye"></i></a></td>
                            <td><a href="" class="btn btn-success" title="imprimir" v-on:click.prevent="imprimirPago({{ $pago->id }})"><i class="fas fa-print"></i></a></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                {{ $pagos->appends($_GET)->links() }}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row -->

@endsection
