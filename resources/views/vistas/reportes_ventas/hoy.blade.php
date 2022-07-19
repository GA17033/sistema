@extends('layouts/app')
@section('titulo',"ventas de hoy")
@section('content')
<h4 class="text-center text-secondary">VENTAS DE HOY</h4>
<div class="d-flex flex-wrap flex-xl-nowrap justify-content-center align-items-center">
    <div class="overflow-auto p-3 container">
        <div class="pb-1 pt-2">
            <a target="_blank" href="{{route('pdf.hoy')}}" class="btn btn-success"><i class="fas fa-print"></i>&nbsp;
                Imprimir</a>
        </div>
        <table class="table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Productos</th>
                    <th>Suma total</th>
                    <th>Descuento</th>
                    <th>Total a pagar</th>
                </tr>
            </thead>
    
            <tbody>
                @foreach ($sql as $item)
                <tr>
                    <td>{{$item->nomCliente}} {{$item->apeCliente}}</td>
                    <td>{{$item->fecha}}</td>
                    <td>
                        <table class="table table-secondary">
                            <thead>
                                <tr>
                                    <th style="background: rgb(190, 209, 233)">nombre</th>
                                    <th style="background: rgb(190, 209, 233)">descripción</th>
                                    <th style="background: rgb(190, 209, 233)">precio</th>
                                    <th style="background: rgb(190, 209, 233)">cantidad</th>
                                    <th style="background: rgb(190, 209, 233)">subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pro as $ite)
                                @if ($item->id_venta==$ite->id_venta)
                                <tr>
                                    <td>{{$ite->nomProducto}}</td>
                                    <td>{{$ite->descripcion}}</td>
                                    <td>S/. {{$ite->precio}}</td>
                                    <td>{{$ite->cantidad}}</td>
                                    <td>S/. {{$ite->totVentaDetalle}}</td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td class="text-dark">
                        S/. {{$item->totVenta}}
                    </td>
                    <td class="text-dark">
                        S/. {{$item->descuento}}
                    </td>
                    <td class="text-dark">
                        S/. {{$item->pagoTotal}}
                    </td>
                </tr>
                @endforeach
    
                @foreach ($sql3 as $i)
                <tr>
                    <td colspan="3" class="font-weight-bold">Suma total de la venta :</td>
                    <td colspan="" class="text-dark font-weight-bold" style="font-size: 18px">
                        <span class="badge bg-primary">S/. {{$i->total}}</span>
                    </td>
                    <td colspan="" class="text-dark font-weight-bold" style="font-size: 18px">
                        <span class="badge bg-primary">S/. {{$i->desc}}</span>
                    </td>
                    <td colspan="" class="text-dark font-weight-bold" style="font-size: 18px">
                        <span class="badge bg-primary">S/. {{$i->tot}}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="width: 300px;">
        <h6 class="text-center">Cantidad de productos vendidos</h6>
        <canvas id="grafica"></canvas>
    </div>
</div>
<script>
    let datas = <?php echo json_encode($data); ?>
    
    let datas2 = <?php echo json_encode($data2); ?>

    const $grafica = document.querySelector("#grafica");
    const etiquetas = datas
    const datosIngresos = {        
        data: datas2, // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
        // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
        backgroundColor: [
            'rgba(163,221,203,0.8)',
            'rgba(232,233,161,0.8)',
            'rgba(230,181,102,0.8)',
            'rgba(229,112,126,0.8)',
        ],// Color de fondo
        borderColor: [
            'rgba(163,221,203,1)',
            'rgba(232,233,161,1)',
            'rgba(230,181,102,1)',
            'rgba(229,112,126,1)',
        ],// Color del borde
        borderWidth: 1,// Ancho del borde
    };
    new Chart($grafica, {
        type: 'pie',// Tipo de gráfica. Puede ser dougnhut o pie
        data: {
            labels: etiquetas,
            datasets: [
                datosIngresos,
                // Aquí más datos...
            ]
        },
        
    });
    
</script>
@endsection