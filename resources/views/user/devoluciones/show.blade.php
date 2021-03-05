
@extends('layouts.account')

@section('title')
<h1 class="m-0 text-dark"> Devoluciones </h1>
@endsection

@section('breadcumb')
<li class="breadcrumb-item">Mis Devoluciones</li>
@endsection


@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-11 mx-auto">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-2">Datos de la devolución</h3>

                            <div class="card-tools">
                                <div class="input-group-append">
                                    <a class="btn btn-success" href="" v-on:click.prevent="" title="imprimir"><i class="fa fa-print"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Pedido</th>
                                        <th scope="col">Estado de tu solicitud</th>
                                    </tr>

                                </thead>

                                <tbody>
                                    <tr>
                                        <td>{{ $productos[0]->id }}</td>
                                        <td>{{ date('d/m/Y h:i A', strtotime($productos[0]->fecha)) }}</td>
                                        <td><a href="{{ route('pedidos.show', $productos[0]->pedido)}}" class=""
                                                title="ver pedido">{{ $productos[0]->pedido }}</a>
                                        </td>
                                        <td><span class="badge badge-success">
                                            @if ($productos[0]->estado == 1 )
                                            {{ "pendiente" }}
                                            @endif
                                            @if ($productos[0]->estado == 2)
                                            {{ "en proceso" }}
                                            @endif
                                            @if ($productos[0]->estado == 3)
                                            {{ "rechazada" }}
                                            @endif
                                            @if ($productos[0]->estado == 4)
                                            {{ "completada" }}
                                            @endif
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-2">Productos que enviaste para cambio</h3>

                            <div class="card-tools">
                                <form>
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="busqueda" class="form-control float-right"
                                            placeholder="buscar" value="{{ request()->get('busqueda') }}">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-search"></i>
                                            </button>
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
                                        <th scope="col">Producto</th>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Talla</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($productos as $producto)

                                    <tr>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>
                                            <a href="{{ route('producto.show', $producto->slug) }}">
                                            {{--<img src="{{ url('storage/' . $producto->imagen) }}" alt="" style="height: 50px; width: 50px;" class="rounded-circle">--}}
                                            <img src="{{ $producto->imagen }}" alt="" style="height: 50px; width: 50px;" class="rounded-circle">
                                            </a>
                                        </td>
                                        <td>{{ $producto->talla }}</td>
                                        <td>{{ $producto->color  }}</td>
                                        <td>{{ $producto->cantidad }}</td>
                                    </tr>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                           {{ $productos->appends($_GET)->links() }} 
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>

    </div>

@endsection


