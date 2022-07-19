@extends('layouts/app')
@section('titulo', "categoria")

@section('content')

{{-- notificaciones --}}

@if (session('DUPLICADO'))
<script>
    $(function notificacion(){
    new PNotify({
        title:"DUPLICADO",
        type:"error",
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

<h4 class="text-center text-secondary">LISTA DE CATEGORIAS</h4>
@if(!(Auth::user()->tipo_usuario === 1 && Auth::user()->tipo_usuario === 3 ))
    <div class="pb-1 pt-2">
        <a href="{{route('categoria.create')}}" class="btn btn-rounded btn-primary"><i class="fas fa-plus"></i>&nbsp;
            Registrar</a>
    </div>
                
 @endif
               



<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>id</th>
                    <th>Nombre</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sql as $item)
                <tr>
                    <td>{{$item->id_categoria}}</td>
                    <td>{{$item->nombre}}</td>
                    
                    <td>

                        <a style="top: 0" href="{{route('categoria.edit',$item->id_categoria)}}"
                            class="btn btn-sm btn-warning m-1"><i class="fas fa-edit"></i></a>
                        <form action="{{route('categoria.destroy',$item->id_categoria)}}" method="get"
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