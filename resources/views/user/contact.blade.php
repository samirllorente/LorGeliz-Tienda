@extends('layouts.account')

@section('breadcumb')
<li class="breadcrumb-item">Formulario de Contacto</li>
@endsection

@section('content')
<div class="container p-5">
    <div class="row">
        <div class="col-md-6 mx-auto">
           
            <div class="card">

                <div class="card-header bg-dark text-white text-center">

                    <h3>Formulario de Contacto</h3>

                </div>

                <div class="card-body">

                    <form action="">

                        <div class="form-group">
                          <input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-describedby="helpId">
                        </div>

                        <div class="form-group">
                            <textarea name="mensaje" id="mensaje" class="form-control" placeholder="Message" cols="30" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="button" name="" id="" class="btn btn-primary btn-block">Enviar</button>
                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
