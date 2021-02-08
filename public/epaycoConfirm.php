<?php

require __DIR__.'/../bootstrap/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';
    $app->make('Illuminate\Contracts\Http\Kernel')
    ->handle(Illuminate\Http\Request::capture());
    //aquí llegan todas las transacciones echas por PayU en metodo POST 
//instancia del controlador
    $test = new App\Http\Controllers\VentaController();
//acesso a las funciones
$test->epaycoConfirm($_POST);

?>