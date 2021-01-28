@extends('layouts.admin')


@section('titulo', 'Editar Subcategoría')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('subcategory.index')}}">Subcategorías</a></li>
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('content')


<div id="update">
<form action="{{ route('subcategory.update', $subcategoria->id)}}" method="POST"> 
    {{-- route('subcategory.update', $subcategoria)--}}
        @csrf
        @method('PUT')
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Administración de Subcategorias</h3>

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
                            <input class="form-control" type="text" name="nombre" id="nombre" value="{{$subcategoria->nombre}}" >

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

                                <option {{ (int) old('category_id') === $id || $subcategoria->categoria->id === $id ? 'selected' : '' }} value="{{ $id }}">
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
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="5">{{$subcategoria->descripcion}}</textarea>

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
                <a class="btn btn-danger" href="{{ route('cancelar','subategory.index') }}">Cancelar</a>
                <input type="submit" value="Guardar" class="btn btn-primary float-right">
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
    </form>
</div>


@endsection
