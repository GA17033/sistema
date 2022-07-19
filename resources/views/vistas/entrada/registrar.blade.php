@extends('layouts/app')
@section('titulo', "entrada")

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





<h4 class="text-center text-secondary">REGISTRO DE ENTRADA DE PRODUCTOS</h4>

@if (session('INCORRECTO'))
<div class="alert alert-danger">{{session('INCORRECTO')}}</div>
@endif

@if (session('CORRECTO'))
<div class="alert alert-success">{{session('CORRECTO')}}</div>
<div class="alert alert-info">El stock de tu producto se ha INCREMENTADO</div>
@endif

<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    {{-- <th>id</th> --}}
                    <th>Categoria</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    {{-- <th>Provedor</th> --}}
                    <th>Precio</th>
                    <th>Stock</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sql as $item)
                <tr>
                    <form action="{{route('entrada.store')}}" method="POST">
                        @csrf
                        {{-- <td>{{$item->id_categoria}}</td> --}}
                        <td>
                            {{$item->cate}}
                            <input hidden type="password" name="producto" class="form-control"
                                value="{{$item->id_producto}}">
                        </td>
                        <td>
                            {{$item->nombre}}
                        </td>
                        <td>{{$item->descripcion}}</td>
                        {{-- <td>
                            <select class="form-control" required name="proveedor" id="">
                                <option value="">Seleccionar...</option>
                                @foreach ($provee as $pro)
                                <option value="{{$pro->id_proveedor}}">{{$pro->nombre}} {{$pro->apellido}}</option>
                                @endforeach
                            </select>
                        </td> --}}
                        <td>
                            <input type="number" name="precio" step="0.01" class="form-control"
                                value="{{$item->precio}}" placeholder="Precio de entrada">
                        </td>
                        <td>
                            <input type="number" title="Este valor aumentará el stock de tus productos" name="stock"
                                required min="0" class="form-control" value="0" placeholder="Cantidad">
                        </td>
                        <td>
                            <button type="submit" class="btn btn-success m-1"><i class="fas fa-plus"></i></button>
                        </td>
                    </form>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection