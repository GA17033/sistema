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

<h4 class="text-center text-secondary">Inventario</h4>

<div class="pb-1 pt-2">
    <a href="{{route('inventario.create')}}" class="btn btn-rounded btn-primary"><i class="fas fa-plus"></i>&nbsp;
        Registrar</a>
</div>

<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>id</th>
                    <th>Producto</th>
                    <th>stock</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sql as $item)
                <tr>
                    <td>{{$item->id_inventario}}</td>
                    <td>{{$item->cate}}</td>
                    <td>
                        {{-- {{$item->stock}} --}} 
                        @if ($item->stock <= 5 && $item->stock > 2)
                            <p style="background: rgb(255, 174, 0);padding: 5px"><i class="fas fa-exclamation-triangle"></i> &nbsp;{{$item->stock}}</p>
                        @else
                            @if ($item->stock < 3)                            
                            <p style="background: rgb(194, 0, 0);color: white;padding: 5px"><i class="fas fa-times"></i> &nbsp;{{$item->stock}}</p>
                            @else
                            {{$item->stock}}
                            @endif
                        @endif
                    </td>
                    <td>
                            <form action="{{route('inventario.destroy',$item->id_inventario)}}" method="get"
                            class="d-inline formulario-eliminar">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        
                   
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection