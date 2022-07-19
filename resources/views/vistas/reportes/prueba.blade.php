<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte</title>
    <style>
        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 11px;
            text-align: center;
        }

        h1 {
            text-transform: uppercase;
        }

        .logo img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            float: left;
            margin-top: -10px;
            margin-left: 4px;
            border-radius: 300%;
        }

        .datos {
            text-align: left;
        }

        .datos p {
            border-bottom: solid rgb(231, 231, 231) 0.5px;
            padding: 4px;
        }

        .table1 {
            width: 100%;
        }

        .table2 {
            margin-bottom: -18px;
        }

        .table2 td {
            padding: 6px;
            border-bottom: solid rgb(231, 231, 231) 0.5px;
            /* background: rgb(231, 231, 231); */
        }


        .datos h2 {
            background: rgb(0, 150, 250);
            color: white;
            font-size: 1em;
            text-align: center;
            padding: 10px 0;
        }

        .cabeza {
            margin-top: 28px;
        }

        .tabla3,
        .tabla4,
        .table5 {
            width: 100%;
        }

        .tabla3 td,
        .tabla4 td {
            padding: 6px;
            border-bottom: solid rgb(231, 231, 231) 0.5px;
        }

        .titulo__cliente,
        .titulo__venta {
            background: rgb(7, 84, 104);
            color: white;
            font-size: 1em;
            text-align: center;
            padding: 10px 0;
            width: 100%;
        }

        .titulo__cliente {
            text-align: left;
            padding-left: 10px;
        }

        .table5 {
            background: rgb(240, 240, 240);
        }

        .precioTotal {
            font-size: 1.2em;
            font-weight: bold;
            color: rgb(7, 31, 34);
        }

        .title {
            font-weight: 700;
        }

        .subtabla {
            background: rgb(221, 221, 221);
        }

        .centro {
            text-align: center;
        }

        .mensaje {
            font-style: italic;
            color: rgb(78, 78, 78);
        }
    </style>
</head>

<body>
    @foreach ($empresa as $key => $dat)
    <div class="logo">

        <?php
        try { ?>
        <img src="data:image/jpg;base64,<?= base64_encode($dat->foto) ?>" alt="">
        <?php } catch (\Exception $e) {
        ss;
        }
        ?>
    </div>
    <h1>{{$dat->nombre}}</h1>
    @foreach ($sql as $key => $item)
    <div class="cabeza">
        <table class="table1">
            <tr>
                <td class="table02">
                    <table class="table2">
                        <tr>
                            <td class="title">R.U.C</td>
                            <td>{{$dat->ruc}}</td>
                        </tr>
                        <tr>
                            <td class="title">Ubicación</td>
                            <td>{{$dat->ubicacion}}</td>
                        </tr>
                        <tr>
                            <td class="title">Teléfono</td>
                            <td>{{$dat->telefono}}</td>
                        </tr>
                        <tr>
                            <td class="title">Correo</td>
                            <td>{{$dat->correo}}</td>
                        </tr>
                    </table>
                </td>


                <td>
                    <div class="datos">
                        <h2>BOLETA DE VENTA</h2>
                        <p>
                            <table>
                                <tr>
                                    <td class="title">R.U.C</td>
                                    <td>{{$dat->ruc}}</td>
                                </tr>
                            </table>
                        </p>
                        <p>
                            <table>
                                <tr>
                                    <td class="title">N°</td>
                                    <td>{{$item->id_venta}}</td>
                                </tr>
                            </table>
                        </p>
                        <p>
                            <table>
                                <tr>
                                    <td class="title">Fecha</td>
                                    <td><?= date('d-m-Y h:i:s') ?></td>
                                </tr>
                            </table>
                        </p>
                    </div>
                </td>
            </tr>
        </table>


    </div>
    <div class="cliente">
        <table class="tabla3">
            <tr>
                <td style="padding: 0" colspan="2">
                    <h2 class="titulo__cliente">DATOS DEL CLIENTE</h2>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td class="title">Nombre</td>
                            <td>{{$item->nomCliente}}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td class="title">Apellido</td>
                            <td>{{$item->apeCliente}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td class="title">Dni</td>
                            <td>{{$item->dni}}</td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td class="title">Teléfono</td>
                            <td>{{$item->telefono}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td class="title">Dirección</td>
                            <td>{{$item->direccion}}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="datosVenta">
        <table class="tabla4">
            <tr>
                <td style="padding: 0">
                    <h2 class="titulo__venta">N°</h2>
                </td>
                <td style="padding: 0">
                    <h2 class="titulo__venta">PRODUCTOS</h2>
                </td>
                <td style="padding: 0">
                    <h2 class="titulo__venta">FECHA</h2>
                </td>

            </tr>

            <tr>
                <td class="centro">{{$key+1}}</td>
                <td class="centro">
                    <table class="table5">
                        <tr>
                            <td class="subtabla">Nombre</td>
                            <td class="subtabla">Descripción</td>
                            <td class="subtabla">Precio</td>
                            <td class="subtabla">Cantidad</td>
                            <td class="subtabla">Subtotal</td>
                        </tr>
                        @foreach ($sql2 as $ite)
                        <tr>
                            <td>{{$ite->nomProducto}}</td>
                            <td>{{$ite->descripcion}}</td>
                            <td>S/. {{$ite->precio}}</td>
                            <td>{{$ite->cantidad}}</td>
                            <td>S/. {{$ite->totVentaDetalle}}</td>
                        </tr>
                        @endforeach
                    </table>
                </td>
                <td class="centro">{{$item->fecha}}</td>
            </tr>
            <tr>
                <td colspan="2">Suma total : </td>
                <td class="precioTotal"><span>S/.</span>&nbsp;&nbsp;&nbsp;{{$item->totVenta}}</td>
            </tr>
            <tr>
                <td colspan="2">Descuento : </td>
                <td class="precioTotal"><span>S/.</span>&nbsp;&nbsp;&nbsp;{{$item->descuento}}</td>
            </tr>
            <tr style="background: rgb(61, 160, 66)">
                <td colspan="2">Total a pagar : </td>
                <td class="precioTotal"><span>S/.</span>&nbsp;&nbsp;&nbsp;{{$item->pagoTotal}}</td>
            </tr>
            @endforeach



        </table>
    </div>
    <footer>
        <p class="mensaje">Gracias por su compra... !</p>
    </footer>
    @endforeach
</body>

</html>