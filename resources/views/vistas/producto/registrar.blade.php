@extends('layouts/app')
@section('titulo', "registrar producto")

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


<h4 class="text-center text-secondary">REGISTRO DE PRODUCTOS</h4>

<div class="mb-0 col-12 bg-white p-5">
    <form action="{{route('producto.store')}}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <select class="input input__select" name="cate">
                    <option value="">Seleccionar categoria...</option>
                    @foreach ($sql as $item)
                    <option {{old('cate') == $item->id_categoria ? 'selected' : ''}} value="{{$item->id_categoria}}">
                        {{$item->nombre}}</option>
                    @endforeach
                </select>
                @error('cate')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="nombre" class="input input__text" id="nombre" placeholder="Nombre *"
                    value="{{old('nombre')}}">
                @error('nombre')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="number" step="0.01" min="0" name="precio" class="input input__text" id="precio"
                    placeholder="Precio *" value="{{old('precio',0)}}">
                @error('precio')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12">
                <textarea class="input input__text" name="descripcion" cols="30" rows="3"
                    placeholder="Descripcion del producto">{{old('descripcion')}}</textarea>
            </div>

            <div class="text-right mt-0">
                <a href="{{route('producto.index')}}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
            </div>
        </div>

    </form>
</div>




@endsection