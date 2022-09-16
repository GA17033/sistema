@extends('layouts/app')
@section('titulo', "registrar producto")

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


<h4 class="text-center text-secondary">ACTUALIZAR PROYECTO</h4>

<div class="mb-0 col-12 bg-white p-5">
    @foreach ($sql as $item)
    <form action="{{route('proyecto.update',$item->id_proyecto)}}" method="POST">
        @csrf
        <div class="row">
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input hidden type="password" name="id" value="{{$item->id_proyecto}}">
                <select class="input input__select" name="cate">
                    <option value="">Seleccionar Encargado...</option>
                    @foreach ($cate as $item2)
                    <option {{$item->id_usuario == $item2->id_usuario ? 'selected' : ''}} value="{{$item2->id_usuario}}">
                        {{$item2->nombre}}</option>
                    @endforeach
                </select>
                @error('cate')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="nombre" class="input input__text" id="nombre" placeholder="Nombre *"
                    value="{{old('nombre',$item->nombre)}}">
                @error('nombre')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            <div class="fl-flex-label mb-4 col-12">
                <textarea class="input input__text" name="descripcion" cols="30" rows="3"
                    placeholder="Descripcion del producto">{{old('descripcion',$item->descripcion)}}</textarea>
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="file" name="foto" class="input form-control-file input__text" value="{{old('foto')}}">
            </div>


            <div class="text-right mt-0">
                <a href="{{route('proyecto.index')}}" class="btn btn-rounded btn-secondary m-2">Atras</a>
                <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
            </div>
        </div>
        
    </form>
    @endforeach
</div>




@endsection