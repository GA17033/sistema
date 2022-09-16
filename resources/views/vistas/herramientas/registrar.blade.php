@extends('layouts/app')
@section('titulo', "registrar proyecto")

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


<h4 class="text-center text-secondary">REGISTRO DE PROYECTOS</h4>

<div class="mb-0 col-12 bg-white p-5">
    <form action="{{route('herramienta.store')}}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <select class="input input__select" name="id_producto">
                    <option value="">Seleccionar Producto...</option>
                    @foreach ($sql as $item)
                    <option {{old('id_producto') == $item->id_producto ? 'selected' : ''}} value="{{$item->id_producto}}">
                        {{$item->nombre}}</option>
                    @endforeach
                </select>
                @error('cate')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
         
            <input type="hidden" name="proyecto_id" value="{{$id}}">

    
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="number" name="cantidad" class="input" placeholder="Cantidad" value="{{old('cantidad')}}">
                @error('cantidad')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            
           

            <div class="text-right mt-0">
                <a href="{{route('herramienta.index')}}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
            </div>
        </div>

    </form>
</div>




@endsection