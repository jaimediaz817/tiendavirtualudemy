<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=7, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $respuesta[0]->nNumeroPedido }}</title>
    <style>
        @page{
            margin: 1.3rem;
            margin-top:  1.9rem;
            padding: 1rem;
        }
        body {
            margin: 0px;
        }
        * {
            font-family: verdana, Arial, Helvetica, sans-serif;
        }
        .cabecera {
            background: #FEFEFE;
            color: #000000;
            padding: 2rem;
            padding-top: .2ewm;
            padding-bottom: 0px;
        }
        .cabecera .logo {
            margin: 5px;
        }
        .cabecera table {
            padding: 1px;
            margin-bottom:  .2rem;
        }
        table {
            font-size: x-small;
        }
        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }
    </style>
</head>
<body>
    <div class="cabecera">
        <table width="100%"  cellspacing="0" border="1" align="center">
            <tr>
                <td>
                    <table width="100%"  cellspacing="1" border="0" align="center">
                        <tr>
                            <td>
                                <img src="{{ $logo }}" alt="Texto alternativo" class="logo" width="210" height="90">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Curso de Laravel y Vue
                            </td>
                        </tr>
                    </table>
                </td>

                <td>
                    <table width="100%" cellspacing="0" cellspacing="1" border="0" align="center">
                        <tr>
                            <td>#Pedido</td>
                            <td>{{ $respuesta[0]->nNumeroPedido }}</td>
                        </tr>
                        <tr>
                            <td>Fecha pedido</td>
                            <td>{{ $respuesta[0]->dFechaPedido }}</td>
                        </tr>
                        <tr>
                            <td>Estado del Pedido</td>
                            <td>{{ $respuesta[0]->cEstadoPedido }}</td>
                        </tr>
                        <tr>
                            <td>Vnededor</td>
                            <td>{{ $respuesta[0]->cVendedor }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <table width="100%"  cellspacing="0" border="1" align="center">
            <tr>
                <td colspan="2">
                    <h3><strong>Informaci??n del Cliente</strong></h3>
                </td>
            </tr>
            <tr>
                <td>Cliente</td>
                <td>{{ $respuesta[0]->cCliente }}</td>
            </tr>
            <tr>
                <td>Documento</td>
                <td>{{ $respuesta[0]->cDocumento }}</td>
            </tr>
            <tr>
                <td>Tel??fono</td>
                <td>{{ $respuesta[0]->cTelefono }}</td>
            </tr>
        </table>

        {{-- Descripcion de los productos --}}
        @if (count($respuesta2) > 0)
        <table width="100%" cellspacing="0" cellspacing="1" border="1" align="center">
            <thead style="background-color: lightgray;">
                <tr align="center" align="middle">
                    <th colspan="5">
                        Detalle del Pedido
                    </th>
                </tr>

                <tr>
                    <th>#</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>SubTotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($respuesta2 as $key => $value)
                <tr>
                    <td align="center"><span>{{ $key + 1 }}</span></td>
                    <td align="center"><span>{{ $value->cProducto }}</span></td>
                    <td align="center"><span>{{ $value->nCantidad }}</span></td>
                    <td align="center"><span>{{ number_format($value->fPrecio, 2) }}</span></td>
                    <td align="center"><span>{{ number_format($value->fSubTotal, 2) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        {{-- Seccion para el total y comentarios --}}
        <table width="100%" cellspacing="0" cellspacing="1" border="0" align="center">
            <tr>
                <td align="right"><h3><strong>Total del Pedido</strong></h3></td>
                <td align="center">
                    <h3>{{ number_format($respuesta[0]->fTotalPedido, 2) }}</h3>
                </td>
            </tr>
        </table>

        @if (!empty($respuesta[0]->cComentario))
        <table width="100%" cellspacing="0" cellspacing="1" border="1" align="center">
            <tr>
                <td><h3><strong>Comentarios adicionales</strong></h3></td>
                <td>
                    {{ $respuesta[0]->cComentario }}
                </td>
            </tr>
        </table>
        @endif

    </div>
</body>
</html>
