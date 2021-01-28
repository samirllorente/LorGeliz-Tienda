@extends('layouts.admin')


@section('titulo', 'Editar Producto')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('product.index')}}">Productos</a></li>
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection


@section('estilos')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="{{ asset('adminlte/plugins/ekko-lightbox/ekko-lightbox.css') }}">
@endsection


@section('content')


<div id="productos">

    <form action="{{ route('product.update', $producto->id)}}" method="POST" enctype="multipart/form-data">
        {{-- route('product.update', $producto->id)--}}
        @csrf
        @method('PUT')

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- SELECT2 EXAMPLE -->


                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Datos generados automáticamente</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>Visitas</label>
                                    <input class="form-control" type="number" id="visitas" name="visitas" readonly
                                        value="">


                                </div>
                                <div class="form-group">

                                    <label>Stock</label>
                                    <input class="form-control" type="number" id="stock" name="stock">

                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>Ventas</label>
                                    <input class="form-control" type="number" id="ventas" name="ventas" readonly
                                        value="">
                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->


                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                </div>
                <!-- /.card -->


                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Datos del producto</h3>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre</label>
                                <input class="form-control" type="text" id="nombre" name="nombre" value="{{ old('nombre') 
                                ?: $producto->nombre}}">
                                </div>
                                <!-- /.form-group -->

                                @if($errors->has('nombre'))
                                <small class="form-text text-danger">
                                    {{ $errors->first('nombre') }}
                                </small>
                                @endif
                            </div>
                            <!-- /.col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Marca</label>
                                    <input class="form-control" type="text" id="marca" name="marca" value="{{ old('marca')
                                    ?: $producto->marca}}">
                                </div>

                                @if($errors->has('marca'))
                                <small class="form-text text-danger">
                                    {{ $errors->first('marca') }}
                                </small>
                                @endif

                            </div>

                        </div>
                        <!-- /.row -->

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>Categoria</label>
                                    <select name="category_id" id="category_id" class="form-control "
                                        style="width: 100%;">
                                        @foreach(\App\Categoria::pluck('nombre', 'id') as $id => $categoria)

                                        <option {{ (int) old('category_id') === $id || $producto->tipo->subcategoria->categoria->id === $id ? 'selected' : '' }} value="{{ $id }}">
                                            {{ $categoria }}
                                        </option>

                                        @endforeach

                                    </select>
                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subcategoria</label>
                                    <select name="subcategory_id" id="subcategory_id" class="form-control "
                                        style="width: 100%;">
                                        @foreach(\App\Subcategoria::where('categoria_id',$producto->tipo->subcategoria->categoria->id)->pluck('nombre', 'id') as $id => $subcategoria)

                                        <option {{ (int) old('subcategory_id') === $id || $producto->tipo->subcategoria->id === $id ? 'selected' : '' }} value="{{ $id }}">
                                            {{ $subcategoria }}
                                        </option>

                                        @endforeach
                                        
                                    </select>

                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <label>Tipo de producto</label>
                                    <select name="tipo_id" id="tipo_id" class="form-control "
                                    style="width: 100%;" required>

                                   @foreach(\App\Tipo::where('subcategoria_id',$producto->tipo->subcategoria->id)->pluck('nombre', 'id') as $id => $tipo)

                                    <option {{ (int) old('tipo_id') === $id || $producto->tipo->id === $id ? 'selected' : '' }} value="{{ $id }}">
                                        {{ $tipo }}
                                    </option>

                                    @endforeach
                                
                                    </select>
        
                                </div>

                            </div>

                            {{--<div class="col-md-6">
                                <div class="form-group">
                                    <label>Color</label>
                                    <select name="color" id="color" class="form-control">
                                        @foreach (\App\Color::pluck( 'nombre','id') as $id => $nombre)
                                        <option  {{ $producto->color === $id ? 'selected' : '' }} value="{{ $id}}">
                                            {{ $nombre}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                @if($errors->has('color'))
                                <small class="form-text text-danger">
                                    {{ $errors->first('color') }}
                                </small>
                                @endif
                            </div>--}}

                        </div>


                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                </div>

                <!-- /.card -->

                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Sección de Precios</h3>


                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">

                                    <label>Precio anterior</label>

                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input class="form-control" type="number" id="precioanterior"
                                        v-model="precioanterior" name="precioanterior" min="0" step=".01">
                                    </div>

                                    @if($errors->has('precioanterior'))
                                    <small class="form-text text-danger">
                                        {{ $errors->first('precioanterior') }}
                                    </small>
                                    @endif

                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->


                            <div class="col-md-3">
                                <div class="form-group">

                                    <label>Precio actual</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input class="form-control" type="number" id="precioactual" name="precioactual"
                                        v-model="precioactual" min="0" value="" step=".01">
                                    </div>

                                    @if($errors->has('precioactual'))
                                    <small class="form-text text-danger">
                                        {{ $errors->first('precioactual') }}
                                    </small>
                                    @endif

                                    <span id="descuento">
                                        @{{ generardescuento }}
                                    </span>

                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->

                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>Porcentaje de descuento</label>
                                    <div class="input-group">
                                        <input v-model="porcentajededescuento" class="form-control" type="number"
                                            id="porcentajededescuento" name="porcentajededescuento" step="any" min="0"
                                            max="100" value="">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">%</span>
                                        </div>

                                    </div>

                                    @if($errors->has('porcentajededescuento'))
                                    <small class="form-text text-danger">
                                        {{ $errors->first('porcentajededescuento') }}
                                    </small>
                                    @endif

                                    <br>
                                    <div class="progress">
                                        <div id="barraprogreso" class="progress-bar" role="progressbar"                           
                                        v-bind:style="{width: porcentajededescuento+'%'}"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">@{{ porcentajededescuento }}%
                                        </div>
                                    </div>
                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->

                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                </div>
                <!-- /.card -->

                <div class="row">
                    <div class="col-md-6">

                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Descripciones del producto</h3>
                            </div>
                            <div class="card-body">
                                <!-- Date dd/mm/yyyy -->
                                <div class="form-group">
                                    <label>Descripción corta:</label>

                                    <textarea class="form-control ckeditor" name="descripcion_corta"
                                        id="descripcion_corta" rows="3">
                                        {!! $producto->descripcion_corta !!}
                                    </textarea>

                                </div>

                                @if($errors->has('descripcion_corta'))
                                <small class="form-text text-danger">
                                    {{ $errors->first('descripcion_corta') }}
                                </small>
                                @endif
                                <!-- /.form group -->

                                <div class="form-group">
                                    <label>Descripción larga:</label>

                                    <textarea class="form-control ckeditor" name="descripcion_larga"
                                        id="descripcion_larga" rows="5">
                                        {!! $producto->descripcion_larga !!}
                                    </textarea>

                                </div>

                                @if($errors->has('descripcion_larga'))
                                <small class="form-text text-danger">
                                    {{ $errors->first('descripcion_larga') }}
                                </small>
                                @endif

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col-md-6 -->


                    <div class="col-md-6">

                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Especificaciones y otros datos</h3>
                            </div>
                            <div class="card-body">
                                <!-- Date dd/mm/yyyy -->
                                <div class="form-group">
                                    <label>Especificaciones:</label>

                                    <textarea class="form-control ckeditor" name="especificaciones"
                                        id="especificaciones" rows="3">
                                        {!! $producto->especificaciones !!}
                                    </textarea>

                                </div>

                                @if($errors->has('especificaciones'))
                                <small class="form-text text-danger">
                                    {{ $errors->first('especificaciones') }}
                                </small>
                                @endif
                                <!-- /.form group -->

                                <div class="form-group">
                                    <label>Datos de interes:</label>

                                    <textarea class="form-control ckeditor" name="datos_de_interes"
                                        id="datos_de_interes" rows="5">
                                    </textarea>

                                </div>

                                @if($errors->has('datos_de_interes'))
                                <small class="form-text text-danger">
                                    {{ $errors->first('datos_de_interes') }}
                                </small>
                                @endif

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col-md-6 -->


                </div>
                <!-- /.row -->


                {{--<div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Imágenes</h3>


                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="form-group">

                            <label for="imagenes">Añadir imágenes</label>

                            <input type="file" class="form-control-file" name="imagenes[]" id="imagenes[]" multiple
                                accept="image/*">

                            <div class="description">
                                Un número ilimitado de archivos pueden ser cargados en este campo.
                                <br>
                                Límite de 2048 MB por imagen.
                                <br>
                                Tipos permitidos: jpeg, png, jpg, gif, svg.
                                <br>
                            </div>

                        </div>

                        @if($errors->has('imagenes'))
                        <small class="form-text text-danger">
                            {{ $errors->first('imagenes') }}
                        </small>
                        @endif


                    </div>


                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                </div>
                <!-- /.card -->

                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">
                            Galeria de imagenes
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            @foreach (\App\Imagene::where('imageable_type', 'App\ColorProducto')
                            ->where('imageable_id', $producto->cop)->pluck('url', 'id') as $id => $imagen)
                            <div id="idimagen-{{$id}}" class="col-sm-2">
                                <a href="{{ url('storage/' . $imagen)}}" data-toggle="lightbox" data-title="Id:{{ $id }}"
                                    data-gallery="gallery">
                                    <img style="width:150px; height:150px;" src="{{ url('storage/' . $imagen) }}"
                                    class="img-fluid mb-2" />
                                </a>
                                <br>
                                <a href="{{ $imagen }}" v-on:click.prevent="eliminarimagen({{$id}})">
                                    <i class="fas fa-trash-alt" style="color:red"></i> Id:{{ $id }}
                                </a>
                            </div>
                            @endforeach

                        </div>
                    </div>
                </div>--}}

                <div class="card card-danger">
                    <div class="card-header">
                        <h3 class="card-title">Administración</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">

                                    <label>Estado</label>
                                    <select name="estado" id="estado" class="form-control " style="width: 100%;">
                                        @foreach($estados as $estado)
                                        <option @if ($producto->estado == $estado)
                                            selected
                                            @endif value="{{$estado}}">
                                            @if ($estado == 1)
                                            {{ "nuevo" }} 
                                            @else
                                            {{"En oferta"}}
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->
                            <div class="col-sm-6">
                                <!-- checkbox -->
                                <div class="form-group clearfix">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="activo" name="activo" disabled
                                        @if($producto->activo=='Si')
                                        checked
                                        @endif>
                                        <label class="custom-control-label" for="activo">Activo</label>
                                    </div>

                                </div>

                                @if($errors->has('activo'))
                                <small class="form-text text-danger">
                                    {{ $errors->first('activo') }}
                                </small>
                                @endif

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="sliderprincipal"
                                            name="sliderprincipal"
                                            @if($producto->slider_principal=='Si')
                                            checked
                                            @endif>
                                            <label class="custom-control-label" for="sliderprincipal">Aparece en el Slider
                                            principal</label>
                                    </div>
                                </div>

                                @if($errors->has('sliderprincipal'))
                                <small class="form-text text-danger">
                                    {{ $errors->first('sliderprincipal') }}
                                </small>
                                @endif

                            </div>

                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">

                                    <a class="btn btn-danger" href="{{route('product.index')}}">Cancelar</a>
                                    <input type="submit" value="Guardar" class="btn btn-primary float-right">

                                </div>
                                <!-- /.form-group -->

                            </div>
                            <!-- /.col -->

                        </div>
                        <!-- /.row -->

                    </div>

                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                </div>
                <!-- /.card -->


            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </form>
</div>

@endsection

@section('scripts')

<!-- Select2 -->
<script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

<script src="{{ asset('adminlte/ckeditor/ckeditor.js') }}"></script>

<!-- Ekko Lightbox -->
<script src="{{ asset('adminlte/plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>



<script>
    window.data = {
        editar: 'Si',
        datos: {
            "precioanterior": "{{$producto->precio_anterior}}",
            "porcentajededescuento": "{{$producto->porcentaje_descuento}}"
        }
    }
    $(function () {
        //Initialize Select2 Elements
        $('#category_id').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        //uso de lightbox
        $(document).on('click', '[data-toggle="lightbox"]', function (event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });

    });
</script>

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

        $(document).on('change', '#subcategory_id', function(e) { 
			e.preventDefault();

			var subcategoria = parseInt($('#subcategory_id').val());

			if (subcategoria != 0) {

				$.ajax({
					type: "GET",
					url: "{{ route('tipo.get') }}",
					data:{subcategoria:subcategoria},
					dataType: 'json',
					success: function (response) {

						$('#tipo_id').html('');
						$('#tipo_id').append('<option value="0">Seleccione una</option>')
						
						$.each(response.data, function (key, value) {
							$('#tipo_id').append("<option value='" 
								+ value.id + "'>" + value.nombre + "</option>");
						});
						
					}

				});

			}

		});

	});
</script>

@endsection