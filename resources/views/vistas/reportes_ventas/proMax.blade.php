@extends('layouts/app')
@section('titulo',"ventas de hoy")
@section('content')
<h4 class="text-center text-secondary">5 PRODUCTOS MAYOR VENDIDOS</h4>
<div class="d-flex flex-wrap flex-xl-nowrap justify-content-center align-items-center">
    <div class="overflow-auto p-3 container">
        <div class="pb-1 pt-2">
            <a href="{{route('pdf.prod')}}" target="_blank" id="imprimir" class="btn btn-success"><i class="fas fa-print"></i>&nbsp;
                Imprimir</a>
        </div>
        <table class="table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Monto total</th>
                </tr>
            </thead>
    
            <tbody>
                @foreach ($sql as $item)
                <tr>
                    <td>{{$item->nombre}}</td>
                    <td>{{$item->cant}}</td>
                    <td class="text-dark">
                        S/. {{$item->tot}}
                    </td>
                </tr>
                @endforeach
    
                
            </tbody>
        </table>
    </div>
</div>
<div class="d-flex flex-wrap flex-xl-nowrap justify-content-center align-items-center">
    <div class="w-100" style="max-width: 700px">
        <canvas id="grafica"></canvas>
    </div>
</div>
<script>
    let datas = <?php echo json_encode($prod); ?>
    
    let datas2 = <?php echo json_encode($cant); ?>

    const $grafica = document.querySelector("#grafica");
    const etiquetas = datas
    const datosIngresos = {
        label: "5 productos mayor vendidos",
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
        type: 'bar',// Tipo de gráfica. Puede ser dougnhut o pie
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