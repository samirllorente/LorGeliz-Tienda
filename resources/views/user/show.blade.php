@extends('layouts.account')

@section('title')
<h1 class="m-0 text-dark"> Mi perfil </h1>
@endsection

@section('breadcumb')
<li class="breadcrumb-item">Mi cuenta</li>
@endsection

@section('content')

<!-- Main content -->
<div class="content">
    <div class="container">
        <div class="row mb-4">
            <div class="pt-1 mx-auto d-flex">
                {{--<img src="{{ url('storage/' . auth()->user()->imagene->url) }}" alt="{{ auth()->user()->nombres }}"--}}
                <img src="{{ auth()->user()->imagene ? auth()->user()->imagene->url : '' }}" alt="{{ auth()->user()->nombres }}"
                    class="rounded-circle image-responsive">
                <h2 style="text-align: center" class="pt-4 pb-4"> {{ auth()->user()->nombres}}</h2>
            </div>
        </div>

        <div class="pl-5 pr-5">
        <form method="POST" action="{{ route('users.update')}}" novalidate enctype="multipart/form-data">
                @method('PUT')

                @csrf

                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header text-center">
                                {{ __("Información de acceso") }}
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">
                                        {{ __("Correo electrónico") }}
                                    </label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" readonly
                                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    name="email" value="{{ $user->email}}" required autofocus />

                                        @if($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">
                                        {{ __("Contraseña") }}
                                    </label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            name="password" required />

                                        @if ($errors->has('password'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                        {{ __("Confirma la contraseña") }}
                                    </label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div><br>

                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header text-center">{{ __("Información del perfil") }}</div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="usuario" class="col-md-4 col-form-label text-md-right">
                                        {{ __("Usuario") }}
                                    </label>
                                    <div class="col-md-6">
                                        <input id="usuario" type="text"
                                            class="form-control{{ $errors->has('usuario') ? ' is-invalid' : '' }}"
                                    name="usuario" value="{{$user->username}}" required />

                                        @if($errors->has('usuario'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('usuario') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nombres" class="col-md-4 col-form-label text-md-right">
                                        {{ __("Nombres") }}
                                    </label>
                                    <div class="col-md-6">
                                        <input id="nombres" type="text"
                                            class="form-control{{ $errors->has('nombres') ? ' is-invalid' : '' }}"
                                    name="nombres" value="{{ $user->nombres}}" required />

                                        @if($errors->has('nombres'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('nombres') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="apellidos" class="col-md-4 col-form-label text-md-right">
                                        {{ __("Apellidos") }}
                                    </label>
                                    <div class="col-md-6">
                                        <input id="apellidos" type="text"
                                            class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}"
                                    name="apellidos" value="{{ $user->apellidos}}" required />

                                        @if($errors->has('apellidos'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('apellidos') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="direccion" class="col-md-4 col-form-label text-md-right">
                                        {{ __("Dirección") }}
                                    </label>
                                    <div class="col-md-6">
                                        <input id="direccion" type="text"
                                            class="form-control{{ $errors->has('apellidos') ? ' is-invalid' : '' }}"
                                    name="direccion" value="{{ $user->direccion}}" required />

                                        @if($errors->has('direccion'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('direccion') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="telefono" class="col-md-4 col-form-label text-md-right">
                                        {{ __("Teléfono") }}
                                    </label>
                                    <div class="col-md-6">
                                        <input id="telefono" type="text"
                                            class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}"
                                            name="telefono" value="{{ $user->telefono}}" required />

                                        @if($errors->has('telefono'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('telefono') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                            </div>


                            <div class="form-group ml-3 mr-2 row">
                                <div class="col-md-6 offset-4">
                                    <input type="file" class="custom-file-input" id="imagen" name="imagen" />
                                    <label class="custom-file-label" for="picture">
                                        {{ "Imagen" }}
                                    </label>

                                    @if ($errors->has('imagen'))
                                    <small class="form-text text-danger">
                                        {{ $errors->first('imagen') }}
                                    </small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <div class="text-center">
                                    <button type="submit" name="revision" class="btn btn-success">
                                        <b>{{ __("Actualizar perfil") }}</b>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>

    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->


@endsection
