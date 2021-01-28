@extends('layouts.admin')


@section('titulo', 'Editar Categoría')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('category.index')}}">Categorías</a></li>
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('content')


<div id="update">
<form action="{{ route('category.update', $categoria->id)}}" method="POST">
    {{-- route('category.update',  $categoria) --}}
        @csrf
        @method('PUT')
        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Administración de Categorias</h3>

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

                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre') ?: $categoria->nombre }}"
                autofocus />

                @if($errors->has('nombre'))
                <small class="form-text text-danger">
                    {{ $errors->first('nombre') }}
                </small>
                @endif

                <label for="descripcion">Descripción</label>
                <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="5">{{old('descripcion')? : $categoria->descripcion}}</textarea>

                @if($errors->has('descripcion'))
                <small class="form-text text-danger">
                    {{ $errors->first('descripcion') }}
                </small>
                @endif

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <a class="btn btn-danger" href="{{ route('cancelar','category.index') }}">Cancelar</a>
                <input type="submit" value="Guardar" class="btn btn-primary float-right">
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
    </form>
</div>


@endsection
