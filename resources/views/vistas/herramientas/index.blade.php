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
@foreach ($sql as $item)
<h4 class="text-center text-secondary">{{$item->nombre}}</h4>
@endforeach

@foreach ($sql as $item)
<div class="pb-1 pt-2">
    <a href="{{route('herramienta.create',$item->id_proyecto)}}" class="btn btn-rounded btn-primary"><i class="fas fa-plus"></i>&nbsp;
        Registrar</a>
</div>
@endforeach

<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>id</th>
                    <th>Producto_id</th>
                    <th>Cantidad</th>
                    <th></th>
                   
                </tr>
            </thead>

            <tbody>
                @foreach ($sql2 as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->cate }}</td> 
                    <th>{{$item->cantidad}}</th>
                    <td>
                            <form action="{{route('herramienta.destroy',$item->id)}}" method="get"
                            class="d-inline formulario-eliminar">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</section>


@endsection
