@extends('layouts/app')
@section('titulo', "salida")

@section('content')
<style>
    td {
        height: 10px !important;
        padding: 0 !important;
        margin: 0 !important;
        padding-left: 10px !important;
    }

    tr:hover {
        color: black;
        background: rgb(240, 240, 240);
    }

    fieldset {
        padding: 5px;
        background: #f5f4ef00;
        color: #000;
    }

    legend {
        color: #222222;
        font-weight: bold;
        font-size: 18px;
        padding: 8px;
        padding-left: 15px;
    }

    input {
        padding-left: 28px !important;
    }

    .mensajeTotal {
        background: rgb(44, 161, 103);
        width: 400px;
        margin: 0;
        color: white
    }

    .mensajePagar {
        background: rgb(28, 90, 59);
        width: 400px;
        margin: 0;
        color: white
    }

    .desc {
        display: flex;
        justify-content: flex-end;
    }

    .desc__div {
        background: rgb(233, 147, 91);
        width: 400px;
        margin: 0;
        color: white
    }
</style>
{{-- notificaciones --}}





{{-- <h4 class="text-center text-secondary">VENTA DE PRODUCTOS</h4> --}}

<section class="card">
    <div class="card-block">
        <input type="hidden" value="{{Auth::user()->id_usuario}}" id="id">
        <div class="row">

            <div class="fl-flex-label mb-3 col-12">
                <input type="text" name="nombre" autofocus class="input input__text p-4" id="nombre"
                    placeholder="Buscar nombre producto *" value="">
            </div>

        </div>
        <div class="mb-4">
            <button type="button" id="buscar" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Buscar</button>
        </div>


        <div style="overflow-x: auto;max-height: 228px;">
            <table class="display table d-none" width="100%" id="tabla1">
                <thead>
                    <tr>
                        <th class="py-3">Nombre</th>
                        <th class="py-3">Descripción</th>
                        <th class="py-3">Stock</th>
                        <th class="py-3">Precio</th>
                        <th class="py-3"></th>
                    </tr>
                </thead>

                <tbody class="tbody">

                </tbody>
            </table>
            <div class="alert bg-light d-none" id="mensaje1"><i class="fas fa-times-circle"></i> No se encontraron
                productos</div>
        </div>

        <div style="overflow-x: auto" class="mt-3 bg-light">
            <h4 class="text-center text-secondary p-2">PRODUCTOS A LA VENTA</h4>
            <div class="mb-2 d-flex justify-content-between gap-4 flex-wrap">
                <button type="button" id="registrarVenta" class="btn btn-success">
                    <i class="fas fa-cart-plus"></i>&nbsp;&nbsp;
                    Registrar Venta</button>

                <div class="alert d-flex justify-content-between align-items-center mensajeTotal">
                    <p class="m-0">Monto total : </p>
                    <h6 class="font-weight-bold m-0">S/. <span style="font-size: 20px" id="pagoTotal">00.00</span></h6>
                </div>
            </div>

            <div class="desc mb-2">
                <div class="alert d-flex justify-content-between align-items-center desc__div">
                    <p class="m-0">Descuento : </p>
                    <h6 class="m-0"><input type="number" min="0" class="form-control font-weight-bold text-dark"
                            step="0.50" placeholder="Descuento" id="descuento" value="00.00"></h6>
                </div>
            </div>
            <div class="desc">
                <div class="alert d-flex justify-content-between align-items-center mensajePagar">
                    <p class="m-0">Total a pagar : </p>
                    <h6 class="font-weight-bold m-0">S/. <span style="font-size: 25px" id="totalPagar">00.00</span></h6>
                </div>
            </div>
            <div class="mb-2">
                <fieldset>
                    <legend>Datos del cliente</legend>
                    <form class="formCliente">
                        <div class="fl-flex-label mb-2 col-12 col-md-6">
                            <input type="text" style="border: rgb(0, 140, 255) solid 2px" required
                                class="input input__text bg-white" id="cliente" placeholder="Nombre del cliente">
                        </div>
                        <div class="fl-flex-label mb-3 col-12 col-md-6">
                            <input type="text" class="input input__text bg-white" id="apellido"
                                placeholder="Apellido del cliente">
                        </div>
                        {{-- <div class="fl-flex-label mb-3 col-12 col-md-6">
                            <input type="text" class="input input__text bg-white" id="dni"
                                placeholder="Dni del cliente *">
                        </div> --}}
                        <div class="fl-flex-label mb-3 col-12 col-md-6">
                            <input type="text" class="input input__text bg-white" id="telefono"
                                placeholder="Telefono del cliente">
                        </div>
                        <div class="fl-flex-label mb-3 col-12 col-md-6">
                            <input type="text" class="input input__text bg-white" id="direccion"
                                placeholder="Dirección del cliente">
                        </div>
                    </form>
                </fieldset>
            </div>
            <table class="display table table-xs" width="100%" id="tabla2">
                <thead>
                    <tr>
                        <th class="py-3">Nombre</th>
                        <th class="py-3">Precio</th>
                        <th class="py-3">Cant</th>
                        <th class="py-3">Total</th>
                        <th class="py-3"></th>
                    </tr>
                </thead>

                <tbody class="tbody2">
                </tbody>
            </table>
            <div class="alert bg-light d-none" id="mensaje2"><i class="fas fa-times-circle"></i> No se encontraron
                productos
            </div>





        </div>
    </div>
</section>

<script>
    function buscar() {
        let valor=document.getElementById("nombre").value;
        
        
        var ruta = "{{ url('buscar-producto') }}/" + valor + "";
        $.ajax({
            url: ruta,
            type: "get",
            success: function(data) {
                let tabla=document.getElementById("tabla1")
                let mensaje1=document.getElementById("mensaje1")

                let tr=document.createElement("tr");
                let tbody=document.querySelector(".tbody");
                let fragmento=document.createDocumentFragment();
                let td="";
                
                if (data.dato.length > 0) {
                    tabla.classList.remove("d-none")
                    mensaje1.classList.add("d-none")

                    
                    data.dato.forEach(function(item,index){
                    td+=`<tr class="p-0 m-0 tr1">
                            <td>${item.nombre}</td>
                            <td>${item.descripcion}</td>
                            <td>${item.stock}</td>
                            <td>S/. ${item.precio}</td>
                            <td><button type="button" value="${item.id_producto}" class="btn btn-success agregar"><i class="fas fa-plus"></i></button></td>
                        </tr>`;
                    //tr.innerHTML=td;
                    tbody.innerHTML=td

                    /* eventos para agregar */
                    let agregar=document.querySelectorAll(".agregar")
                    agregar.forEach(function(ele, index){
                        ele.addEventListener("click", function(){
                            agregarEle(ele)                            
                        })
                    });
                   

                })
                } else {
                    tabla.classList.add("d-none")
                    mensaje1.classList.remove("d-none")
                    tbody.innerHTML=""
                }
            },
            error: function(data) {
                $("#prom").html(data.error);
                let tbody=document.querySelector(".tbody");
                tbody.innerHTML=""
                
            }
        })
    }

</script>

<script>
    let desc=document.getElementById("nombre");
    let boto=document.getElementById("buscar");

    desc.addEventListener("blur",buscar)
    desc.addEventListener("keyup",buscar)
    desc.addEventListener("change",buscar)

    boto.addEventListener("click",buscar)

    
    function agregarEle(ele){
        let id=ele.value;
        var ruta = "{{ url('agregar-elemento') }}/" + id + "";
        $.ajax({
            url: ruta,
            type: "get",
            success: function(data) {
                let tabla2=document.getElementById("tabla2")
                let mensaje2=document.getElementById("mensaje2")

                let tr=document.createElement("tr");
                let tbody2=document.querySelector(".tbody2");
                let fragmento=document.createDocumentFragment();
                let td="";
                
                if (data.dato2.length > 0) {
                    
                    tabla2.classList.remove("d-none")
                    mensaje2.classList.add("d-none")
                    
                    data.dato2.forEach(function(item,index){
                    td+=`
                    <tr class="tr2">
                        <td>
                            ${item.nombre}
                            <input type="hidden" value="${item.id_producto}">
                        </td>
                        <td id="precio" style="font-size:20px;font-weight:bold">
                            <input id="price" readonly style="width:130px;font-size:20px;font-weight:bold" type="number" 
                            class="form-control form-control-sm price" min="0" value="${item.precio}" placeholder="0">
                        </td>
                        <td>
                            <input style="width:90px;font-size:20px;font-weight:bold" type="number" class="form-control 
                            form-control-sm cantidad" min="0" value="1" placeholder="0" id="cantidad">
                        </td>
                        <td>
                            <input readonly id="tot" style="width:130px;font-size:20px;font-weight:bold" type="number" class="form-control form-control-sm tot" 
                            min="0" value="${item.precio}" placeholder="0">
                        </td>
                        <td><button type="button" value="${item.id_producto}" class="btn btn-danger quitar"><i class="fas fa-times"></i></button></td>
                    </tr>`;
                    //tr.innerHTML=td;
                    tbody2.insertAdjacentHTML("beforeend",td)
                    })

                    
                    /* eventos para quitar */
                    //let quitar=document.querySelectorAll(".quitar")
                    $(".quitar").click(function(el, index){
                        let tbody3=document.querySelector(".tbody2");
                        let nodo=this.parentNode.parentNode;
                        try {
                            tbody3.removeChild(nodo)
                        } catch (error) {                            
                        }

                        /* total a pagar */
                        let totalPagar=0;
                        document.querySelectorAll(".tr2").forEach(function(el,index){
                            let sum=parseFloat(el.children[3].children[0].value)
                            totalPagar= totalPagar + sum
                            document.getElementById("pagoTotal").innerHTML=totalPagar
                            let descuento=document.getElementById("descuento").value;
                            document.getElementById("totalPagar").innerHTML=(totalPagar-descuento)
                        });
                        if(document.querySelectorAll(".tr2").length <= 0){
                            document.getElementById("pagoTotal").innerHTML="00.00"
                            document.getElementById("totalPagar").innerHTML="00.00"
                            document.getElementById("descuento").value="00.00";
                        }
                    })
                    /* eventos para sumar el precio */
                     $(".cantidad").change(function(e,inde){
                         let cantidad=(e.target.value)
                         //let total=document.getElementById("tot").value=(pre*cantidad)
                         $(".tr2").change(function(e,inde){
                            let pre=(e.target.parentNode.parentNode).children[1].children[0].value
                            let tot=(e.target.parentNode.parentNode).children[3].children[0]
                            tot.value=(parseInt(cantidad) * parseFloat(pre))

                            /* total a pagar */
                            let totalPagar=0;
                            document.querySelectorAll(".tr2").forEach(function(el,index){
                                let sum=parseFloat(el.children[3].children[0].value)
                                totalPagar= totalPagar + sum
                                document.getElementById("pagoTotal").innerHTML=totalPagar
                                let descuento=document.getElementById("descuento").value;
                                document.getElementById("totalPagar").innerHTML=(totalPagar-descuento)
                            });
                         })
                     })
                     /* total a pagar */
                     let totalPagar=0;
                     document.querySelectorAll(".tr2").forEach(function(el,index){
                        let sum=parseFloat(el.children[3].children[0].value)
                        totalPagar= totalPagar + sum
                        document.getElementById("pagoTotal").innerHTML=totalPagar
                        let descuento=document.getElementById("descuento").value;
                        document.getElementById("totalPagar").innerHTML=(totalPagar-descuento)
                    });

                    $(function notificacion(){
                        new PNotify({
                            title:"AGREGADO",
                            type:"info",
                            text:"producto agregado correctamente",
                            styling:"bootstrap3"
                        });		
                    });

            } else {
                    tabla2.classList.add("d-none")
                    mensaje2.classList.remove("d-none")
                    tbody2.innerHTML=""
            }



            },
            error: function(data) {
                $("#prom").html(data.error);
                let tbody=document.querySelector(".tbody");
                tbody.innerHTML=""
                
            }
        })

        /* EVENTOS PARA SUMAR PRECIO */        
    }

    /* alpine js */
    //let cantidad=document.querySelectorAll(".cantidad");
    
        
        
</script>

{{-- registrar venta --}}
<script>
    function vender(){
        let cliente=document.getElementById("cliente").value;
        let apellido=document.getElementById("apellido").value;
        let dni="";
        let telefono=document.getElementById("telefono").value;
        let direccion=document.getElementById("direccion").value;

        let id=document.getElementById("id").value;
        let total=document.getElementById("pagoTotal").innerHTML;
        let descuento=document.getElementById("descuento").value;
        let totalPagar=document.getElementById("totalPagar").innerHTML;

        let tr2=document.querySelectorAll(".tr2")
        let datos=[];
        tr2.forEach(function(el,index){
            datos.push(
                {
                    "cliente":cliente,
                    "apellido":apellido,
                    "dni":dni,
                    "telefono":telefono,
                    "direccion":direccion,
                    "usuario":id,
                    "producto":el.children[0].children[0].value,
                    "precio":el.children[1].children[0].value,
                    "cantidad":el.children[2].children[0].value,
                    "subtotal":el.children[3].children[0].value,
                    "total":total,
                    "descuento":descuento,
                    "totalPagar":totalPagar,
                }
            )
        });
        
        console.log(datos)
        
        
         var ruta = "{{ url('registrar-salida') }}";
         $.ajax({
             url: ruta,
             type: "post",
             data:{valores : JSON.stringify(datos)},
             headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
             success: function(data) {
                $(function notificacion(){
                    $(".tbody").empty();
                    $(".tbody2").empty();
                    document.getElementById("pagoTotal").innerHTML="00.00"
                    document.getElementById("totalPagar").innerHTML="00.00"
                    document.getElementById("descuento").value="00.00"
                    document.querySelector(".formCliente").reset()

                        new PNotify({
                        title:"CORRECTO",
                        type:"success",
                        text:"PRODUCTO VENDIDO CORRECTAMENTE",
                        styling:"bootstrap3"
                    });                    
                });
                setTimeout(() => {
                    //window.open=("ver-ticket-ventas-${data[0].id}", '_blank')
                    window.open("http://localhost:80/sistemaVentas/public/ver-ticket-ventas-" + data[0].id, '_blank');
                }, 1000);
             },
             error: function(data) {
                
             }
         })
    }
    let registarVenta=document.getElementById("registrarVenta");
    registarVenta.addEventListener("click", vender)
</script>

{{-- funciones para el descuento --}}
<script>
    $("#descuento").change(function(){
        let montoTotal=document.getElementById("pagoTotal").innerHTML;
        let descuento=document.getElementById("descuento").value;
        let totalPagar=(montoTotal-descuento);
        document.getElementById("totalPagar").innerHTML=totalPagar;
    })


    
</script>




@endsection