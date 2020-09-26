
@extends('layouts.account')

@section('title')
<h1 class="m-0 text-dark"> Mis pedidos </h1>
@endsection

@section('breadcumb')
<li class="breadcrumb-item">Mis pedidos</li>
@endsection


@section('content')

<div id="venta_cliente">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-2">Información de mis pedidos</h3>

                            <div class="card-tools">
                                <form>
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="keyword" class="form-control float-right"
                                            placeholder="buscar" value="{{ request()->get('keyword') }}">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
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
                                        <th scope="col">Estado</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col" colspan="2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($ventas as $venta)

                                    <tr>
                                        <td>{{ $venta->id }}</td>
                                        <td>{{ date('d/m/Y', strtotime($venta->fecha)) }}</td>
                                        <td>{{ $venta->prefijo }}{{ $venta->consecutivo }}</td>
                                        <td><span class="badge badge-success">
                                            @if ($venta->estado == 1 )
                                            {{ "pendiente" }}
                                            @endif
                                            @if ($venta->estado == 2)
                                            {{ "en proceso"}}
                                            @endif
                                            @if ($venta->estado == 3)
                                            {{ "enviado"}}
                                            @endif
                                            @if ($venta->estado == 4)
                                            {{ "entregado"}}
                                            @endif
                                            </span>
                                        </td>
                                        <td>${{ floatval($venta->valor) }}</td>
                                        <td><a href="{{ route('show.pedido', $venta->id)}}"
                                        class="btn btn-primary" title="ver pedido">
                                        <i class="fas fa-eye"></i></a>
                                        </td>
                                        <td><a href=""
                                            class="btn btn-success" title="descargar factura" v-on:click.prevent="pdfVenta({{$venta->id}})">
                                            <i class="fas fa-download"></i></a>
                                        </td>

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
        </div>

    </div>
</div>


@endsection




