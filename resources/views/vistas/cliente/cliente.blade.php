@extends("layouts/app")
@section('titulo', "cliente")
@section('content')



<h4 class="text-center text-secondary">LISTA DE CLIENTES</h4>


<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dni</th>
                    <th>Telefono</th>
                    <th>Dirección</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($sql as $item)
                <tr>
                 
                    <td>{{$item->id_cliente}}</td>
                    <td>{{$item->nombre}}</td>
                    <td>{{$item->apellido}}</td>
                    <td>{{$item->dni}}</td>
                    <td>{{$item->telefono}}</td>
                    <td>{{$item->direccion}}</td>
                    
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</section>




@endsection