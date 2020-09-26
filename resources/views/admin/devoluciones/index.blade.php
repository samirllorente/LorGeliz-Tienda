
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
                            <h3 class="card-title mb-2">Solicitudes de cambio de productos</h3>

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
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Pedido</th>
                                        <th scope="col">Cliente</th>
                                        <th scope="col">Estado de la solicitud</th>
                                        <th scope="col" colspan="2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($devoluciones as $devolucion)

                                    <tr>
                                        <td>{{ $devolucion->id}}</td>
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
                                        <td><a href="{{ route('devolucion.show', $devolucion->id) }}"
                                            class="btn btn-primary" title="ver solicitud"><i class="fas fa-eye"></i></a>
                                        </td>
                                        <td><a href="" class="btn btn-success" title="actualizar estado"                   data-toggle="modal"
                                        data-target="#modalEstado"
                                        data-id="{{$devolucion['id']}}"><i class="fas fa-pen"></i></a>
                                        </td>
                                    </tr>
                                        
                                    @endforeach
                                    
                                </tbody>

                            </table>
                           {{ $devoluciones->appends($_GET)->links() }} 
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>

    </div>

    <div class="modal fade" id="modalEstado" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header modal-primary">
                    <h5 class="modal-title" id="appModalLabel">actualizar estado de la solicitud</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    
                </div>

                <div class="modal-body">

                    <form id='formEstado' class="form-horizontal"
                        action="{{ route('devolucion.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="text-input">Estado de la solicitud</label>
                            <div class="col-md-8">
                                <select name="estado" id="estado" class="form-control">
                                    <option value="">Seleccione uno</option>
                                    @foreach($estados as $estado)
                                        @if ($estado == 1)
                                            <option value="{{ $estado }}">
                                                {{ "pendiente" }}
                                            </option>
                                        @endif

                                        @if ($estado == 2)
                                            <option value="{{ $estado }}">
                                                {{ "en proceso"}}
                                            </option>
                                        @endif

                                        @if ($estado == 3)
                                            <option value="{{ $estado }}">
                                                {{ "rechazada"}}
                                            </option>
                                        @endif

                                        @if ($estado == 4)
                                            <option value="{{ $estado }}">
                                               {{ "completada"}}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>

                                @if($errors->has('estado'))
                                <small class="form-text text-danger">
                                    {{ $errors->first('estado') }}
                                </small>
                                @endif

                                <input type="hidden" name="devolucion_id" id="devolucion_id" value=""/>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary float-left" id="aceptar">Enviar <i
                                class="far fa-paper-plane"></i></button>
                        <button type="reset" class="btn btn-danger float-right" id="rechazar">Cancelar</button>

                    </form>
                </div>

                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script>
$(document).ready(function () {
    $('.btn-success').click(function (e) { 
        e.preventDefault();

        const id = jQuery(this).data('id');
        $('#devolucion_id').val(id);
    });
});

</script>
@endsection


