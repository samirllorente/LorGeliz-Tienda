@extends('layouts.admin')


@section('titulo', 'Información del Pedido')

@section('breadcrumb')
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection


@section('content')

<div class="content">
    <div id="imprimir_pedidos">
            <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-2">Datos básicos</h3>

                            <div class="card-tools">
                                <div class="input-group-append">
                                    <a class="btn btn-success" href="" v-on:click.prevent="imprimir({{ $users[0]->pedido}})" title="imprimir"><i class="fa fa-print"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col"># Pedido</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Dirección de envío</th>
                                        <th scope="col">Teléfono</th>
                                        <th scope="col">Email</th>
                                    </tr>

                                </thead>

                                <tbody>
                                    <tr>
                                        @foreach ($users as $user)
                                            <td>{{ $user->pedido }}</td>
                                            <td><a href="{{ route('cliente.show', $user->cliente)}}"
                                                title="ver cliente">{{ $user->nombres }} {{ $user->apellidos }}</a></td>
                                            <td>{{ date('d/m/Y h:i:s A', strtotime($user->fecha)) }}</td>
                                            <td>{{ $user->direccion }}</td>
                                            <td>{{ $user->telefono }}</td>
                                            <td>{{ $user->email }}</td>
                                        @endforeach
                                        
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-2">Productos del pedido</h3>

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
                                        <th scope="col">Referencia</th>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Talla</th>
                                        <th scope="col">Color</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">Precio unitario</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($productos as $producto)

                                    <tr>
                                        <td>{{ $producto->id }}</td>

                                        <td> 
                                           
                                            <a href="{{ route('producto.show', $producto->slug) }}" title="ver producto">
                                                {{--<img src="{{ url('storage/' . $producto->imagen) }}" alt="" style="height: 50px; width: 50px;" class="rounded-circle">--}}
                                                <img src="{{ $producto->imagen }}" alt="" style="height: 50px; width: 50px;" class="rounded-circle">
                                            </a>
                                        </td>

                                        <td><a href="{{ route('producto.show', $producto->slug) }}"
                                             title="ver producto" style="color: black">{{ $producto->nombre }}
                                            </a>
                                        </td>
                                        <td>{{ $producto->talla }}</td>
                                        <td>{{ $producto->color }}</td>
                                        <td>{{ $producto->cantidad }}</td>
                                        <td>${{ floatval($producto->precio_actual) }}</td>
                                        <td>${{ floatval($producto->precio_actual * $producto->cantidad) }}</td>
                                        <td><a href="{{ route('producto.show', $producto->slug)}}"
                                                class="btn btn-primary" title="ver producto">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>

                                    </tr>

                                    @endforeach

                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="7" class="text-right">Total pedido:</td>
                                        <td colspan="2" class="text-left">${{ floatval($producto->valor) }}</td>
                                    </tr>

                                </tfoot>
                            </table>
                            {{-- {{ $productos->appends($_GET)->links() }} --}}
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
