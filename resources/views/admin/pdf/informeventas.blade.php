<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Ventas</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.875rem;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
    </style>
</head>
<body>
    <div>
        <h3>Informe de ventas por mes<span class="derecha">{{now()}}</span></h3>
    </div>
    <div>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Año</th>
                    <th>N° Ventas</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                <tr>
                    <td>
                        @if ($venta->mes == 1)
                        {{"Enero"}}
                        @endif
                        @if ($venta->mes == 2)
                        {{"Febrero"}}
                        @endif
                        @if ($venta->mes == 3)
                        {{"Marzo"}}
                        @endif
                        @if ($venta->mes == 4)
                        {{"Abril"}}
                        @endif
                        @if ($venta->mes == 5)
                        {{"Mayo"}}
                        @endif
                        @if ($venta->mes == 6)
                        {{"Junio"}}
                        @endif
                        @if ($venta->mes == 7)
                        {{"Julio"}}
                        @endif
                        @if ($venta->mes == 8)
                        {{"Agosto"}}
                        @endif
                        @if ($venta->mes == 9)
                        {{"Septiembre"}}
                        @endif
                        @if ($venta->mes == 10)
                        {{"Octubre"}}
                        @endif
                        @if ($venta->mes == 11)
                        {{"Noviembre"}}
                        @endif
                        @if ($venta->mes == 12)
                        {{"Diciembre"}}
                        @endif
                    </td>
                    <td>{{$venta->anio}}</td>
                    <td>{{$venta->cantidad}}</td>
                    <td>${{floatval($venta->total)}}</td>
                </tr>
                @endforeach                                
            </tbody>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$count}}</p>
    </div>    
</body>
</html>