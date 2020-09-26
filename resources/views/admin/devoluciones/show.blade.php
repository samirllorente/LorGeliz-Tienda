
@extends('layouts.admin')


@section('titulo', 'Devoluciones de productos')

@section('breadcrumb')
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection


@section('content')

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-2">Información de la solicitud</h3>
    
                            <div class="card-tools">
    
                            </div>
                        </div>
                        <!-- /.card-header -->
    
                        <div class="card-body table-responsive p-0">
    
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Pedido</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Estado de la solicitud</th>
                                    </tr>
    
                                </thead>
    
                                <tbody>
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($devolucion->fecha)) }}</td>
                                        <td><a href="{{ route('show.pedido', $devolucion->venta)}}"
                                                class="">{{ $devolucion->venta }}</a>
                                        </td>
                                        <td><a href="{{ route('cliente.show', $devolucion->cliente)}}"
                                            class="">{{ $devolucion->nombres}} {{$devolucion->apellidos}}</a>
                                        </td>
                                        <td><span class="badge badge-success">
                                            @if ($devolucion->estado == 1 )
                                            {{ "pendiente" }}
                                            @endif
                                            @if ($devolucion->estado == 2)
                                            {{ "en proceso" }}
                                            @endif
                                            @if ($devolucion->estado == 3)
                                            {{ "rechazada" }}
                                            @endif
                                            @if ($devolucion->estado == 4)
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
                            <h3 class="card-title mb-2">Productos que se enviaron para cambio</h3>

                            <div class="card-tools">
                                <form>
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="keyword" class="form-control float-right"
                                            placeholder="buscar" value="{{ request()->get('keyword') }}">

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
                                        <th scope="col">Id</th>
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
                                        <td>{{ $producto->id }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>
                                            <a href="{{ route('producto.show', $producto->slug) }}">
                                                @foreach(\App\Imagene::where('imageable_type', 'App\ColorProducto')
                                                ->where('imageable_id', $producto->cop)->pluck('url', 'id')->take(1) as $id => $imagen)    
                                                <img src="{{ url('storage/' . $imagen) }}" alt="" style="height: 50px; width: 50px;" class="rounded-circle">
                                                @endforeach
                                            </a>
                                        </td>
                                        <td>{{ $producto->talla }}</td>
                                        <td>{{ $producto->color  }}</td>
                                        <td>{{ $producto->cantidad }}</td>
                                    </tr>
                                        
                                    @endforeach
                                    
                                    
                                </tbody>

                            </table>
                           {{-- $productos->appends($_GET)->links() --}} 
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


