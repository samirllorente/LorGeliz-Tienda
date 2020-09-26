
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-2">Productos que enviaste para cambio</h3>

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
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Pedido</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Talla</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Estado de tu solicitud</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($productos as $producto)

                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($producto->fecha)) }}</td>
                                        <td><a href="{{ route('show.pedido', $producto->venta)}}"
                                                class="">{{ $producto->venta }}</a>
                                        </td>
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
                                        <td><span class="badge badge-success">
                                            @if ($producto->estado == 1 )
                                            {{ "pendiente" }}
                                            @endif
                                            @if ($producto->estado == 2)
                                            {{ "en proceso" }}
                                            @endif
                                            @if ($producto->estado == 3)
                                            {{ "rechazada" }}
                                            @endif
                                            @if ($producto->estado == 4)
                                            {{ "completada" }}
                                            @endif
                                            </span>
                                        </td>
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


