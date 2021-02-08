<!DOCTYPE>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Venta</title>
    <style>
        body {
        /*position: relative;*/
        /*width: 16cm;  */
        /*height: 29.7cm; */
        /*margin: 0 auto; */
        /*color: #555555;*/
        /*background: #FFFFFF; */
        font-family: Arial, sans-serif; 
        font-size: 14px;
        /*font-family: SourceSansPro;*/
        }

        #logo{
        float: left;
        margin-top: 1%;
        margin-left: 2%;
        margin-right: 2%;
        }

        #imagen{
        width: 100px;
        }

        #datos{
        float: left;
        margin-top: 0%;
        margin-left: 2%;
        margin-right: 2%;
        /*text-align: justify;*/
        }

        #encabezado{
        text-align: center;
        margin-left: 10%;
        margin-right: 35%;
        font-size: 15px;
        }

        #fact{
        /*position: relative;*/
        float: right;
        margin-top: 2%;
        margin-left: 2%;
        margin-right: 2%;
        font-size: 20px;
        }

        section{
        clear: left;
        }

        #cliente{
        text-align: left;
        }

        #facliente{
        width: 40%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #fac, #fv, #fa{
        color: #FFFFFF;
        font-size: 15px;
        }

        #facliente thead{
        padding: 20px;
        background: #2183E3;
        text-align: left;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facvendedor{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facvendedor thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        #facarticulo{
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 15px;
        }

        #facarticulo thead{
        padding: 20px;
        background: #2183E3;
        text-align: center;
        border-bottom: 1px solid #FFFFFF;  
        }

        tfoot tr{
        float: right;
        margin-left: 20%;
        margin-right: 2%;
        }

        #gracias{
        text-align: center; 
        }

    </style>
    <body>
        @foreach ($users as $user)
        <header>
            <div id="logo">
                <img src="{{ url('storage/imagenes/logo/lorgeliz2.jpeg') }}" alt="lorgeliz" id="imagen">
            </div>
            <div id="datos">
                <p id="encabezado">
                    <b>Lorgeliz Tienda</b><br>José Gálvez 1368, Montería - Córdoba, Colombia<br>Telefono:(+57)   3138645929<br>Email: jcarlos.ad7@gmail.com
                </p>
            </div>
            <div id="fact">
            <p>Factura<br>
                {{$user->prefijo}}-{{$user->consecutivo}}</p>
            </div>
        </header>
        <br>
        <section>
            <div>
                <table id="facliente">
                    <thead>                        
                        <tr>
                            <th id="fac">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th><p id="cliente">Sr(a). {{ $user->nombres}} {{ $user->apellidos}}<br>
                            {{ "identificacion"}}: {{$user->identificacion}}<br>
                            Dirección: {{$user->direccion}}<br>
                            Teléfono: {{$user->telefono}}<br>
                            Email: {{$user->email}}</</p></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        @endforeach
        <br>
        <section>
            <div>
                <table id="facvendedor">
                    <thead>
                        <tr id="fv">
                            <th>VENTA</th>
                            <th>FECHA</th>
                            <th>ESTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $user->venta}}</td>
                            <td>{{ date('d/m/Y h:i:s A', strtotime($user->fecha)) }}</td>
                            <td>
                                @if ($user->saldo == 0)
                                {{"CANCELADA"}}
                                @else
                                {{"PENDIENTE"}}
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <br>
        <section>
            <div>
                <table id="facarticulo">
                    <thead>
                        <tr id="fa">
                            <th>CANT</th>
                            <th>DESCRIPCION</th>
                            <th>TALLA</th>
                            <th>COLOR</th>
                            <th>PRECIO UNIT</th>
                            <th>DESC.</th>
                            <th>PRECIO TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productos as $producto)
                        <tr>
                            <td>{{ $producto->cantidad }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->talla }}</td>
                            <td>{{ $producto->color }}</td>
                            <td>${{ floatval($producto->precio_actual) }}</td>
                            <td>{{ $producto->porcentaje_descuento }}</td>
                            <td>${{ $producto->cantidad*$producto->precio_actual-$producto->porcentaje_descuento }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        {{--@foreach ($venta as $v)--}}
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>SUBTOTAL</th>
                            <td>${{ floatval($producto->valor)}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Impuesto</th>
                            <td>$0{{--$v->total*$v->impuesto--}}</td>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>       
                            <th>TOTAL</th>      
                            <td>${{ floatval($producto->valor)}}</td>
                        </tr>
                       {{-- @endforeach--}}
                    </tfoot>
                </table>
            </div>
        </section>
        <br>
        <br>
        <footer>
            <div id="gracias">
                <p><b>Gracias por su compra!</b></p>
            </div>
        </footer>
    </body>
</html>