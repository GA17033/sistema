@extends('layouts/app')
@section('titulo', "salida")

@section('content')

{{-- notificaciones --}}


@if (session('CORRECTO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"CORRECTO",
        type:"success",
        text:"{{session('CORRECTO')}}",
        styling:"bootstrap3"
    });		
});
</script>
@endif



@if (session('INCORRECTO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"INCORRECTO",
        type:"error",
        text:"{{session('INCORRECTO')}}",
        styling:"bootstrap3"
    });		
});
</script>
@endif

<h4 class="text-center text-secondary">BUSCAR BOLETA</h4>

<div class="fl-flex-label mb-3 col-12">
    <input type="number" id="id" autofocus class="input input__text p-4" placeholder="Número de boleta">
</div>
<div class="mb-4">
    <button type="button" id="buscar" class="btn btn-primary">
        <i class="fas fa-search"></i>
        Buscar</button>
</div>


<section class="card">
    <div class="card-block" id="mostrarTabla">

    </div>
</section>


<script>
    function buscar(ele){
        let desc=document.getElementById("id").value;
        var ruta = "{{ url('salida-boleta-buscar') }}/" + desc + "";
        $.ajax({
            url: ruta,
            type: "get",
            success: function(data) {
                let div=document.getElementById("mostrarTabla")
                div.innerHTML="";
                let tabla=`
                <table class="display table table-striped" cellspacing="0" width="100%">
                    <thead class="table-primary">
                        <tr>
                            <th>id</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Productos</th>
                            <th>Suma total</th>
                            <th>Descuento</th>
                            <th>Total a pagar</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>${data.sql[0].id_venta}</td>
                            <td>${data.sql[0].nomCliente} ${data.sql[0].apeCliente}</td>
                            <td>${data.sql[0].fecha}</td>
                            <td>
                                ${data.pro[0].nomProducto}
                            </td>
                            <td class="text-dark font-weight-bold" style="font-size: 18px">
                                <span class="badge bg-primary">S/. ${data.sql[0].totVenta}</span>
                            </td>
                            <td class="text-dark font-weight-bold" style="font-size: 18px">
                                <span class="badge bg-warning">S/. ${data.sql[0].descuento}</span>
                            </td>
                            <td class="text-dark font-weight-bold" style="font-size: 18px">
                                <span class="badge bg-dark">S/. ${data.sql[0].pagoTotal}</span>
                            </td>
                            <td>
                                <a style="top: 0" target="_blank" href="ver-ticket-ventas-${data.sql[0].id_venta}"
                                class="btn btn-sm btn-success m-1"><i class="fas fa-ticket-alt"></i></a>
                                <a target="_blank" style="top: 0" href="ver-pdf-ventas-${data.sql[0].id_venta}"
                                    class="btn btn-sm btn-primary m-1"><i class="fas fa-clipboard-list"></i></a>
                            </td>
                        </tr>

                    </tbody>
                </table>
                `;               
                    
                    
                    //tr.innerHTML=td;
                    div.insertAdjacentHTML("afterbegin",tabla)


            },
            error: function(data) {
                let div=document.getElementById("mostrarTabla")
                div.innerHTML="";
                
            }
        })

        /* EVENTOS PARA SUMAR PRECIO */        
    }

    let desc=document.getElementById("id");
    let boto=document.getElementById("buscar");

    desc.addEventListener("blur",buscar)
    desc.addEventListener("keyup",buscar)
    desc.addEventListener("change",buscar)

    boto.addEventListener("click",buscar)
  
</script>

@endsection