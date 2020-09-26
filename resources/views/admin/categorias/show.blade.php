@extends('layouts.admin')


@section('titulo', 'Ver Categoría')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{route('category.index')}}">Categorías</a></li>
<li class="breadcrumb-item active">@yield('titulo')</li>
@endsection

@section('content')

<div id="">
    <form>
        @csrf

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Administración de Categorias</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                    title="Remove"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">

            <div class="form-group">
                <label for="nombre">Nombre</label>

                <input class="form-control" type="text" name="nombre" id="nombre" value="{{ $categoria->nombre }} "
                readonly>

                <label for="descripcion">Descripción</label>

                <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="5"
                readonly>  {{ $categoria->descripcion }}  
            </textarea>

        </div>

    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <a class="btn btn-danger" href="{{ route('cancelar','category.index') }}">Cancelar</a>

        <a class="btn btn-outline-success float-right" href="{{ route('category.edit',$categoria->slug) }}">Editar</a>

    </div>
    <!-- /.card-footer-->
</div>
<!-- /.card -->
</form>
</div>


@endsection
