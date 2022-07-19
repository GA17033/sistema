@extends('layouts/app')
@section('titulo',"ventas por dia")
@section('content')
<h4 class="text-center text-secondary">VENTAS POR DIA</h4>

<div class="container">
    <div class="col-12">
        <label for="fecha1">Ingrese la fecha</label>
        <input type="date" id="fecha1" class="input input__text p-4">
    </div>

    <div class="mb-4 mt-3">
        <button type="button" id="buscar" class="btn btn-primary">
            <i class="fas fa-search"></i>
            Buscar</button>
    </div>
</div>


<div class="d-flex flex-wrap flex-xl-nowrap justify-content-center align-items-center">
    <div class="overflow-auto p-3 container">
        <div class="pb-1 pt-2">
            <a href="" target="_blank" id="imprimir" class="btn btn-success"><i class="fas fa-print"></i>&nbsp;
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

            <tbody id="body1">

            </tbody>
        </table>
    </div>

</div>

<script>
    let fecha=document.getElementById("fecha1");
    let boton=document.getElementById("buscar");
    fecha.addEventListener("change", buscarVenta)
    boton.addEventListener("click", buscarVenta)

    function buscarVenta(){
        let valor=document.getElementById("fecha1").value;

        var ruta = "{{ url('reporte-dia-search/') }}/" + valor + "";
        $.ajax({
            url: ruta,
            type: "get",
            success: function(data) {
                let imprimir=document.getElementById("imprimir");
                imprimir.href=`reporte-pdf-dia-${data[0].fecha}`;
                let tr=document.createElement("tr")
                let body=document.getElementById("body1")
                let div=""
                data[0].sql.forEach(function(el,index){                    
                    div+=`
                    <tr>
                        <td>${el.nomCliente}</td>
                        <td>${el.fecha}</td>
                        <td>${el.nomProducto}</td>
                        <td>${el.totVenta}</td>
                        <td>${el.descuento}</td>
                        <td>${el.pagoTotal}</td>
                    </tr>
                    `                    
                });
                div+=`
                    <tr>
                        <td colspan="3" class="font-weight-bold">Suma total de la venta :</td>
                        <td class="text-dark font-weight-bold" style="font-size: 18px">
                            <span class="badge bg-primary">S/. ${data[0].sql3[0].tot}</span>
                        </td>
                        <td class="text-dark font-weight-bold" style="font-size: 18px">
                            <span class="badge bg-primary">S/. ${data[0].sql3[0].desc}</span>
                        </td>
                        <td class="text-dark font-weight-bold" style="font-size: 18px">
                            <span class="badge bg-primary">S/. ${data[0].sql3[0].pagoTotal}</span>
                        </td>
                    </tr>
                `
                body.innerHTML=div

            },
            error: function(data) {
                
            }
        })
    }
</script>


@endsection