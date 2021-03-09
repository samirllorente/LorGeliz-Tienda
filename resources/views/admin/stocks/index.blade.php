
@extends('layouts.admin')


@section('titulo', 'Inventario de Productos')

@section('breadcrumb')
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('content')

<div id="inventarios" class="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-2">Información de inventario de productos</h3>

                        <div class="card-tools">
                            <form>
                                <div class="input-group input-group-sm" style="width: 190px">
                                    
                                    <input type="text" name="busqueda" class="form-control float-right"
                                    placeholder="buscar" value="{{ request()->get('busqueda') }}">
                                    
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
                                    </div>
                                    <div class="input-group-append">
                                        <a href="" class="btn btn-success mx-1" v-on:click.prevent="pdfInventarios()">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <button type="button" id="new" class="m-2 float-right btn btn-primary" data-toggle="modal"
		                data-target="#modalNota">Agregar <i class="far fa-plus-square"></i></button>
                        <table class="table table-head-fixed">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nombre</th>
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
                                    <td> <a href="{{ route('producto.show', $producto->slug) }}"> 
                                        @foreach(\App\Imagene::where('imageable_type', 'App\ColorProducto')
                                        ->where('imageable_id', $producto->cop)->pluck('url', 'id')->take(1) as $id => $imagen)    
                                        {{--<img src="{{ url('storage/' . $imagen) }}" alt="" style="height: 50px; width: 50px;" class="rounded-circle">--}}
                                        <img src="{{ $imagen }}" alt="" style="height: 50px; width: 50px;" class="rounded-circle">
                                        @endforeach
                                        </a>
                                    </td>
                                    <td>{{ $producto->talla }}</td>
                                    <td>{{ $producto->color }}</td>
                                    <td>{{ $producto->stock }}</td>
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

<div class="modal fade" id="modalNota" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header modal-primary">
				<h5 class="modal-title" id="appModalLabel">Agregar productos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">

            <form id='formStock' class="form-horizontal" action="{{ route('stock.store') }}" method="POST">
                    @csrf
                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Producto</label>
                        <div class="col-md-9">
                            <select name="producto_id" id="producto_id" class="form-control">
                                <option value="">Seleccione uno</option>
                                @foreach(\App\Producto::pluck('nombre', 'id') as $id => $producto)
                                    <option value="{{ $id }}">
                                        {{ $producto }}
                                    </option>
                                @endforeach
                            </select>

                            @if($errors->has('producto_id'))
                            <small class="form-text text-danger">
                                {{ $errors->first('producto_id') }}
                            </small>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Talla</label>
                        <div class="col-md-9">
                            <select name="talla_id" id="talla_id" class="form-control">
                                
                            </select>

                            @if($errors->has('talla_id'))
                            <small class="form-text text-danger">
                                {{ $errors->first('talla_id') }}
                            </small>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Color</label>
                        <div class="col-md-9">
                            <select name="color_id" id="color_id" class="form-control">
                                <option value="">Seleccione uno</option>
                                {{--@foreach(\App\Color::pluck('nombre', 'id') as $id => $color)
                                    <option value="{{ $id }}">
                                        {{ $color }}
                                    </option>
                                @endforeach--}}
                            </select>

                            @if($errors->has('color_id'))
                            <small class="form-text text-danger">
                                {{ $errors->first('color_id') }}
                            </small>
                            @endif

                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 form-control-label" for="text-input">Cantidad</label>
                        <div class="col-md-9">
                            <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="Cantidad"
                             value="{{ old('cantidad') }}">
                        </div>

                        @if($errors->has('cantidad'))
                        <small class="form-text text-danger">
                            {{ $errors->first('cantidad') }}
                        </small>
                        @endif
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
		
		$.ajaxSetup({

			headers: {
				'X-CSRF-TOKEN': $("input[name= _token]").val()
			}
		});

		
        $(document).on('change', '#producto_id', function(e) { 
			e.preventDefault();

			var producto = parseInt($('#producto_id').val());

			if (producto != 0) {

				$.ajax({
					type: "GET",
					url: "{{ route('talla.get') }}",
					data:{producto:producto},
					dataType: 'json',
					success: function (response) {

						$('#talla_id').html('');
						$('#talla_id').append('<option value="0">Seleccione una</option>')
						
						$.each(response.data, function (key, value) {
							$('#talla_id').append("<option value='" 
								+ value.talla_id + "'>" + value.nombre + "</option>");
						});

					}

				});

			}

		});

        $(document).on('change', '#talla_id', function(e) { 
			e.preventDefault();

			var producto = parseInt($('#producto_id').val());

			if (producto != 0) {

				$.ajax({
					type: "GET",
					url: "{{ route('colores.get') }}",
					data:{producto:producto},
					dataType: 'json',
					success: function (response) {

						$('#color_id').html('');
						$('#color_id').append('<option value="0">Seleccione uno</option>')
						
						$.each(response.data, function (key, value) {
							$('#color_id').append("<option value='" 
								+ value.color_id + "'>" + value.nombre + "</option>");
						});

					}

				});

			}

		});

	});
</script>

    
@endsection



