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
                                {{-- <img src="#" alt="Texto alternativo" class="logo" width="210" height="90"> --}}
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
                            <td>20205295</td>
                        </tr>
                        <tr>
                            <td>Fecha pedido</td>
                            <td>2019/05/29</td>
                        </tr>
                        <tr>
                            <td>Estado del Pedido</td>
                            <td>Activo</td>
                        </tr>
                        <tr>
                            <td>Vnededor</td>
                            <td>Juan Angel Bernal</td>
                        </tr>                        
                    </table>
                </td>
            </tr>
        </table>


        <table width="100%"  cellspacing="0" border="1" align="center">
            <tr>
                <td colspan="2">
                    <h3><strong>Información del Cliente</strong></h3>
                </td>                            
            </tr>
            <tr>
                <td>Cliente</td>
                <td>Graciela CR</td>
            </tr>
            <tr>
                <td>Documento</td>
                <td>1094886452</td>
            </tr>
            <tr>
                <td>Teléfono</td>
                <td>9999999999</td>
            </tr>  
        </table>

        {{-- Descripcion de los productos --}}
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
                <tr>
                    <td align="center"><span>1</span></td>
                    <td align="center"><span>Manzana</span></td>
                    <td align="center"><span>5</span></td>
                    <td align="center"><span>2.5</span></td>
                    <td align="center"><span>11</span></td>
                </tr>
            </tbody>
        </table>        

        {{-- Seccion para el total y comentarios --}}
        <table width="100%" cellspacing="0" cellspacing="1" border="0" align="center">
            <tr>
                <td align="right"><h3><strong>Total del Pedido</strong></h3></td>
                <td align="center">
                    <h3>26</h3>
                </td>
            </tr>
        </table>

        <table width="100%" cellspacing="0" cellspacing="1" border="1" align="center">
            <tr>
                <td><h3><strong>Comentarios adicionales</strong></h3></td>
                <td>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Sed dolores id quaerat labore numquam nostrum quis magni aliquam sint aut asperiores debitis, optio ullam unde veritatis nulla minima alias similique?
                </td>
            </tr>
        </table>

    </div>
</body>
</html>
