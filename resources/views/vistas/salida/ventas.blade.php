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

<h4 class="text-center text-secondary">TODAS LAS VENTAS</h4>
<div class="pb-1 pt-2">
    <a href="{{route('salida.index')}}" class="btn btn-rounded btn-primary"><i class="fas fa-plus"></i>&nbsp;
        Registrar</a>
</div>


<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>id</th>
                    <th>Cliente</th>
                    {{-- <th>Vendedor</th> --}}
                    <th>Fecha</th>
                    <th>Productos</th>
                    {{-- <th>Precio</th>
                    <th>Cantidad</th> --}}
                    <th>Suma total</th>
                    <th>Descuento</th>
                    <th>Total a pagar</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sql as $item)
                <tr>
                    <td>{{$item->id_venta}}</td>
                    <td>{{$item->nomCliente}} {{$item->apeCliente}}</td>
                    {{-- <td>{{$item->nomUsuario}} {{$item->apeUsuario}}</td> --}}
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
                    {{-- <td>S/. {{$item->precio}}</td>
                    <td>{{$item->cantidad}}</td> --}}
                    <td class="text-dark font-weight-bold" style="font-size: 18px">                        
                        <span class="badge bg-primary">S/. {{$item->totVenta}}</span>
                    </td>
                    <td class="text-dark font-weight-bold" style="font-size: 18px">                        
                        <span class="badge bg-warning">S/. {{$item->descuento}}</span>
                    </td>
                    <td class="text-dark font-weight-bold" style="font-size: 18px">                        
                        <span class="badge bg-dark">S/. {{$item->pagoTotal}}</span>
                    </td>
                    <td>

                        
                        <form action="{{route('salida.eliminar',$item->id_venta)}}" method="get"
                            class="d-inline formulario-eliminar">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        <a style="top: 0" target="_blank" href="{{route('reporte.ticket',$item->id_venta)}}"
                            class="btn btn-sm btn-success m-1"><i class="fas fa-ticket-alt"></i></a>
                        <a style="top: 0" target="_blank" href="{{route('reporte.prueba',$item->id_venta)}}"
                            class="btn btn-sm btn-primary m-1"><i class="fas fa-clipboard-list"></i></a>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection