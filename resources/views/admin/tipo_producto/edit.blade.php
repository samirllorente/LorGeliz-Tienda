@extends('layouts.admin')


@section('titulo', 'Editar Tipo de Producto')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('tipo.index')}}">Tipos de Productos</a></li>
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('content')


<div id="update">
<form action="{{ route('tipo.update', $tipo)}}" method="POST">
        @csrf
        @method('PUT')
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Administración de Tipos</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove"><i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input class="form-control" type="text" name="nombre" id="nombre" value="{{$tipo->nombre}}" >

                            @if($errors->has('nombre'))
                            <small class="form-text text-danger">
                                {{ $errors->first('nombre') }}
                            </small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category_id">Categoría</label>
                            <select name="category_id" id="category_id" class="form-control "
                                style="width: 100%;">
                                @foreach(\App\Categoria::pluck('nombre', 'id') as $id => $categoria)

                                <option {{ (int) old('category_id') === $id || $tipo->subcategoria->categoria->id === $id ? 'selected' : '' }} value="{{ $id }}">
                                    {{ $categoria }}
                                </option>

                                @endforeach

                            </select>

                            @if($errors->has('category_id'))
                            <small class="form-text text-danger">
                                {{ $errors->first('category_id') }}
                            </small>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="category_id">Subcategoría</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control "
                                style="width: 100%;">
                                @foreach(\App\Subcategoria::pluck('nombre', 'id') as $id => $subcategoria)

                                <option {{ (int) old('subcategory_id') === $id || $tipo->subcategoria->id === $id ? 'selected' : '' }} value="{{ $id }}">
                                    {{ $subcategoria }}
                                </option>

                                @endforeach

                            </select>

                            @if($errors->has('subcategory_id'))
                            <small class="form-text text-danger">
                                {{ $errors->first('subcategory_id') }}
                            </small>
                            @endif

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" cols="30"
                                rows="5">

                                {{$tipo->descripcion}}
                            </textarea>

                            @if($errors->has('descripcion'))
                            <small class="form-text text-danger">
                                {{ $errors->first('descripcion') }}
                            </small>
                            @endif

                        </div>
                    </div>
                </div>


            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a class="btn btn-danger" href="{{ route('cancelar','tipo.index') }}">Cancelar</a>
                <input type="submit" value="Guardar" class="btn btn-primary float-right">
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
    </form>
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

		$(document).on('change', '#category_id', function(e) { 
			e.preventDefault();

			var categoria = parseInt($('#category_id').val());

			if (categoria != 0) {

				$.ajax({
					type: "GET",
					url: "{{ route('subcategory.get') }}",
					data:{categoria:categoria},
					dataType: 'json',
					success: function (response) {

						$('#subcategory_id').html('');
						$('#subcategory_id').append('<option value="0">Seleccione una</option>')
						
						$.each(response.data, function (key, value) {
							$('#subcategory_id').append("<option value='" 
								+ value.id + "'>" + value.nombre + "</option>");
						});
						
					}

				});

			}

		});

	});
</script>
    
@endsection
