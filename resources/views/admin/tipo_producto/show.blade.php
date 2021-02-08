@extends('layouts.admin')


@section('titulo', 'Ver Tipo de producto')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('tipo.index')}}">Tipos de productos</a></li>
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('content')

<div id="">
    <form>
        @csrf

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Administración de tipos de productos</h3>

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
                        <input class="form-control" type="text" name="nombre" id="nombre" value="{{$tipo->nombre}}" readonly>
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


                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" cols="30"
                                rows="5" readonly>

                                {{$tipo->descripcion}}
                            </textarea>

                        </div>
                    </div>
                </div>


            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a class="btn btn-danger" href="">Cancelar</a>

                <a class="btn btn-outline-success float-right"
                href="{{ route('tipo.edit', $tipo->slug)}}">Editar</a>

            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
    </form>
</div>


@endsection
