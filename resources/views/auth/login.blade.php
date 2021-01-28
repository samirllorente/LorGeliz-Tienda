@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-4 pt-5">
            <div class="card">
                <div class="card-header" align="center">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><b>{{ __('E-mail') }}</b></label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right"><b>{{ __('Contraseña') }}</b></label>

                            <div class="col-md-7">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                     <b>{{ __('Recuerdame') }}</b> 
                                 </label>
                             </div>
                         </div>
                     </div>
                     <hr>
                     <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-success">
                                {{ __('Ingresar') }}
                            </button>
                            <a href="{{ route('register') }}" class="text-primary">Registrarme</a>
                        </div>
                    </div>
                    <div class="text-center text-secondary">
                        @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}"><b>
                        {{ __('Olvidó su contraseña?') }}</b>
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
@endsection

