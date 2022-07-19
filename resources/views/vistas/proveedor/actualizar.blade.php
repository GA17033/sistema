@extends('layouts/app')
@section('titulo', "registrar proveedor")

@section('content')


{{-- notificaciones --}}

@if (session('DUPLICADO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"DUPLICADO",
        type:"warning",
        text:"{{session('DUPLICADO')}}",
        styling:"bootstrap3"
    });		
});
</script>
@endif

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


<h4 class="text-center text-secondary">ACTUALIZAR PROVEEDOR</h4>

<div class="mb-0 col-12 bg-white p-5">
    @foreach ($sql as $item)
    <form action="{{route('proveedor.update',$item->id_proveedor)}}" method="POST">
        @csrf
        <div class="row">

            <input hidden type="password" name="id" value="{{$item->id_proveedor}}">
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="nombre" class="input input__text" id="nombre" placeholder="Nombre *"
                    value="{{old('nombre',$item->nombre)}}">
                @error('nombre')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="telefono" class="input input__text" placeholder="Telefono"
                    value="{{old('telefono',$item->telefono)}}">
                @error('telefono')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="direccion" class="input input__text" placeholder="Direccion"
                    value="{{old('direccion',$item->direccion)}}">
                @error('direccion')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>


            <div class="text-right mt-0">
                <a href="{{route('proveedor.index')}}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
            </div>
        </div>

    </form>
    @endforeach
</div>




@endsection