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
                <h3 class="card-title">Sección de ventas</h3>

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
            <div class="card-body table-responsive p-0">
                <table class="table table-head-fixed">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Valor</th>
                            <th>Cliente</th>
                            <th colspan="5"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($ventas as $venta)

                        <tr>
                            <td> {{ $venta->id }} </td>
                            <td> {{ date('d/m/Y', strtotime($venta->fecha)) }} </td>
                            <td> ${{ floatval($venta->valor) }}</td>
                            <td> <a href="{{ route('cliente.show', $venta->cliente)}}">{{ $venta->nombres }}</a></td>
                            <td> <a class="btn btn-primary" href="{{ route('venta.show', $venta->id)}}"><i class="fas fa-eye"></i></a></td>

                        </tr>
                        @endforeach


                    </tbody>
                </table>
                {{ $ventas->appends($_GET)->links() }}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</div>
<!-- /.row -->

@endsection
