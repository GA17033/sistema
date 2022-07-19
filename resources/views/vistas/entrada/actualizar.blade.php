@extends('layouts/app')
@section('titulo', "actualizar entrada")

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


<h4 class="text-center text-secondary">ENTRADA DE PRODUCTOS</h4>

<div class="mb-0 col-12 bg-white p-5">
    @foreach ($sql0 as $item)
    <form action="{{route('entrada.update',$item->id_entrada)}}" method="POST">
        @csrf
        <div class="row">
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input hidden type="password" name="id" id="id" value="{{$item->id_producto}}">
                <input hidden type="password" name="preAntes" value="{{$item->cantidad}}">
                <select class="input input__select" name="producto" id="val">
                    <option value="">Seleccionar producto...</option>
                    @foreach ($producto as $item2)
                    <option {{$item->id_producto == $item2->id_producto ? 'selected' : ''}}
                        value="{{$item2->id_producto}}">
                        @if ($item2->estado==0)
                        {{$item2->nombre}} (ELIMINADO)
                        @else
                        {{$item2->nombre}}
                        @endif
                    </option>
                    @endforeach
                </select>
                @error('producto')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
            {{-- <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <select class="input input__select" name="proveedor">
                    <option value="">Seleccionar proveedor...</option>
                    @foreach ($pro as $provee)
                    <option {{$item->id_proveedor == $provee->id_proveedor ? 'selected' : ''}}
            value="{{$provee->id_proveedor}}">
            {{$provee->nombre}} {{$provee->apellido}}</option>
            @endforeach
            </select>
            @error('proveedor')
            <small class="error error__text">{{$message}}</small>
            @enderror
        </div> --}}

        <div class="fl-flex-label mb-4 col-12 col-lg-6">
            <input type="number" step="0.01" min="0" name="precio" class="input input__text" id="precio"
                placeholder="Precio *" value="{{old('precio',$item->precio)}}">
            @error('precio')
            <small class="error error__text">{{$message}}</small>
            @enderror
        </div>
        <div class="fl-flex-label mb-4 col-12 col-lg-6">
            <input type="number" min="0" name="stock" class="input input__text" placeholder="Stock *"
                value="{{old('stock',$item->cantidad)}}">
            @error('stock')
            <small class="error error__text">{{$message}}</small>
            @enderror
        </div>

        <div class="fl-flex-label mb-4 col-12 col-lg-6">
            <div class="form-check">

            </div>
        </div>

        <div class="text-right mt-0">
            <a href="{{route('entrada.index')}}" class="btn btn-rounded btn-secondary m-2">Atras</a>
            <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
        </div>
</div>

</form>
@endforeach
</div>

<script type="text/javascript">
    $('#val').change(function() {
    recargarProducto();
    });
</script>
<script type="text/javascript">
    function recargarProducto() {
        const id=document.getElementById("id").value;
        let producto=document.getElementById("val").value;
        let div=document.querySelector(".form-check");

        if (id==producto) {
            div.innerHTML="";
        }else{
            div.innerHTML=`
            <div class="form-check bg-light text-danger p-2">
                <input class="form-check-input" type="radio" name="eliminar" value="si" id="flexRadioDefault2" checked>
                <label class="form-check-label" for="flexRadioDefault2">
                    Se eliminará el stock que se ha agregado al PRODUCTO anterior
                </label>
            </div>
            

            `
        }

    }
</script>


@endsection