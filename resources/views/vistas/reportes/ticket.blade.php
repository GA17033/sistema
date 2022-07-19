<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket</title>
    <style>
        * {
            margin: 5px 3px;
        }

        body {
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 11px;
            text-align: center;
        }

        h1 {
            text-transform: uppercase;
            font-size: 12px;
        }

        .table0 {
            margin: 0;
            margin-left: 10px;
        }

        .tabla3,
        .tabla4,
        .table5 {
            width: 100%;
        }

        .tabla3 td,
        .tabla4 td {
            padding: 1px;
            border-bottom: solid rgb(231, 231, 231) 0.5px;
        }

        .titulo__venta {
            background: rgb(218, 218, 218);
            color: rgb(0, 0, 0);
            font-size: 1em;
            text-align: center;
            padding: 2px 0;
            width: 100%;
        }



        .table5 {
            background: rgb(240, 240, 240);
        }

        .precioTotal {
            font-size: 1em;
            /* font-weight: bold; */
            background: rgb(206, 206, 206);
            color: rgb(0, 0, 0);
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
            color: rgb(128, 128, 128);
        }
    </style>
</head>

<body>
    @foreach ($empresa as $key => $dat)

    <h1>{{$dat->nombre}}</h1>
    @foreach ($sql as $key => $item)
    <table class="table0">
        <tr>
            <td class="title">N° ticket :</td>
            <td>{{$item->id_venta}}</td>
        </tr>
    </table>


    <table class="table0">
        <tr>
            <td class="title">Cliente :</td>
            <td>{{$item->nomCliente}} {{$item->apeCliente}}</td>
        </tr>
    </table>

    <table class="table0">
        <tr>
            <td class="title">Fecha de la venta:</td>
            <td class="centro">{{$item->fecha}}</td>
        </tr>
    </table>
    <div class="datosVenta">
        <h2 class="titulo__venta">DETALLE DE LA VENTA</h2>
        <table class="table5">
            <tr>
                <td class="subtabla">Producto</td>
                <td class="subtabla">Descrip</td>
                <td class="subtabla">Precio</td>
                <td class="subtabla">Cant</td>
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
            <tr style="background: rgb(201, 201, 201)">
                <td colspan="2">Suma total : </td>
                <td colspan="3" class="precioTotal"><span>S/.</span>&nbsp;&nbsp;&nbsp;{{$item->totVenta}}</td>
            </tr>
            <tr style="background: rgb(201, 201, 201)">
                <td colspan="2">Descuento : </td>
                <td colspan="3" class="precioTotal"><span>S/.</span>&nbsp;&nbsp;&nbsp;{{$item->descuento}}</td>
            </tr>
            <tr style="background: rgb(201, 201, 201);font-weight: bold;font-size: 14px">
                <td colspan="2">Total a pagar : </td>
                <td colspan="3" class="precioTotal"><span>S/.</span>&nbsp;&nbsp;&nbsp;{{$item->pagoTotal}}</td>
            </tr>
        </table>
        @endforeach
    </div>
    <footer>
        <p class="mensaje">Gracias por su compra... !</p>
    </footer>
    @endforeach
</body>

</html>