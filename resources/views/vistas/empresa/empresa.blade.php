@extends('layouts/app')
@section('titulo', "info empresa")

@section('content')

<style>
    img.logo {
        width: 130px;
        border-radius: 50%;
        box-shadow: 0px 0px 20px rgb(226, 226, 226);
        margin-top: -20px;
        margin-bottom: 40px;
    }

    .logo {
        font-size: 130px;
        color: rgb(228, 228, 228);
    }

    .img {
        background: rgb(247, 251, 255);
    }
</style>

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

@if (session('AVISO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"AVISO",
        type:"error",
        text:"{{session('AVISO')}}",
        styling:"bootstrap3"
    });		
});
</script>
@endif


<h4 class="text-center text-secondary">DATOS DE LA EMPRESA</h4>

<div class="mb-0 col-12 bg-white p-5 pt-0">
    @foreach ($sql as $item)


    <div class="d-flex justify-content-around align-items-center flex-wrap gap-5 pt-5 pb-3 mb-3 img">
        <div class="text-center">
            @if ($item->foto==null)
            <p class="logo">
                <i class="far fa-frown"></i>
            </p>
            @else
            <img class="logo" src="data:image/jpg;base64,<?= base64_encode($item->foto) ?>" alt="">
            @endif
        </div>
        <div>
            <h6 class="text-dark font-weight-bold">Modificar imagen</h6>
            <form action="{{route('empresa.updateImg')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$item->id_empresa}}">
                <div class="alert alert-secondary">Selecciona una imagen no muy <b>pesado</b> y en un formato <b>jpg</b>
                    ...!</div>
                <div class="fl-flex-label mb-4 col-12">
                    <input type="file" name="foto" class="input form-control-file input__text" value="">
                    @error('foto')
                    <small class="error error__text">{{$message}}</small>
                    @enderror
                </div>
                <div class="d-flex justify-content-end gap-4">
                    <div class="text-right mt-0">
                        <button type="submit" class="btn btn-rounded btn-success"><i
                                class="fas fa-save"></i>&nbsp;&nbsp; Modificar logo</button>
                    </div>
                    <div class="text-right mt-0">
                        <a href="{{route('empresa.destroy',$item->id_empresa)}}" class="btn btn-rounded btn-danger"><i
                                class="fas fa-trash"></i>&nbsp;&nbsp; Eliminar logo</a>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <form action="{{route('empresa.update')}}" method="POST">
        @csrf
        <div class="row">
            <input type="hidden" name="id" value="{{$item->id_empresa}}">
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="nombre" class="input input__text" id="nombre" placeholder="Nombre"
                    value="{{$item->nombre}}">
            </div>

            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="ubicacion" class="input input__text" placeholder="Ubicación"
                    value="{{$item->ubicacion}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="telefono" class="input input__text" placeholder="Telefono"
                    value="{{$item->telefono}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="ruc" class="input input__text" placeholder="RUC" value="{{$item->ruc}}">
            </div>
            <div class="fl-flex-label mb-4 col-12 col-lg-6">
                <input type="text" name="correo" class="input input__text" placeholder="Correo"
                    value="{{$item->correo}}">
            </div>


            <div class="text-right mt-0">
                <button type="submit" class="btn btn-rounded btn-primary"><i class="fas fa-save"></i>&nbsp;&nbsp;
                    Guardar cambios</button>
            </div>
        </div>


    </form>



    @endforeach
</div>




@endsection