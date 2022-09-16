@extends('layouts/app')
@section('titulo', "proyecto")

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

<h4 class="text-center text-secondary">LISTA DE PROYECTOS</h4>




<section class="card">
    <div class="card-block d-flex justify-content-center flex-wrap">
        @foreach($sql as $item)
        <div class="card m-2" style="width: 18rem;">
        
            <img src="data:image/jpg;base64,<?= base64_encode($item->foto) ?>" class="card-img-top" width="200px" height="250px">
            <div class="card-body">
                <h5 class="card-title">{{$item->nombre}}</h5>
                <p class="card-text">{{$item->descripcion}}</p>
                <!--<a href="#" class="btn btn-primary">agregar herramientas</a> -->
                <a style="top: 0" href="{{route('herramienta.edit',$item->id_proyecto)}}"
                            class="btn btn-primary ">Agregar Herramientas</a>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection