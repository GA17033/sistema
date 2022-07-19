@extends("layouts/app")
@section('titulo', "tipo usuario")
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

<h4 class="text-center text-secondary">LISTA DE TIPO DE USUARIO</h4>
{{-- <form action="{{route('tipo.create')}}" method="POST">
<div class="modal-body">
    @csrf
    <div class="row">

        <div class="form-group mb-1 col-12">
            <div class="fl-flex-label">
                <input type="text" name="tipo" class="input input__text" placeholder="Tipo usuario *">
                @error('tipo')
                <small class="error error__text">{{$message}}</small>
                @enderror
            </div>
        </div>
        <div class="pb-1 pt-2 text-right">
            <button type="submit" class="btn btn-rounded btn-primary">Guardar</button>
        </div>

        <div class="form-group mb-1 col-12 col-lg-6">
            <input class="input input__text" type="text" placeholder="Tipo de usuario">
            <small class="error error__text">*usuario no registrado</small>
        </div>

        <div class="form-group mb-1 col-12 col-lg-6">
            <select class="input input__select" name="" id="">
                <option value="">opcion 1</option>
                <option value="">opcion 2</option>
                <option value="">opcion 3</option>
                <option value="">opcion 4</option>
            </select>
            <small class="error error__text">*usuario no registrado</small>
        </div>
    </div>

</div>

</form> --}}

<section class="card">
    <div class="card-block">
        <table id="example" class="display table table-striped" cellspacing="0" width="100%">
            <thead class="table-primary">
                <tr>
                    <th>Id</th>
                    <th>Tipo usuario</th>
                    {{-- <th></th> --}}
                </tr>
            </thead>

            <tbody>
                @foreach ($sql as $item)
                <tr>
                    <div class="modal fade bd-example-modal-lg-{{$item->id_tipo}}" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                        <i class="font-icon-close-2"></i>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Modificar tipo de usuario</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group mb-1 col-12">
                                        <form action="{{route('tipo.update',$item->id_tipo)}}" method="POST">
                                            @csrf
                                            <div class="fl-flex-label">
                                                <input type="text" name="tipo" class="input input__text"
                                                    placeholder="Tipo usuario *" value="{{$item->tipo}}">
                                            </div>
                                            <div class="pb-1 pt-2 text-right mt-2">
                                                <button type="submit"
                                                    class="btn btn-rounded btn-primary">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--.modal-->
                    <td>{{$item->id_tipo}}</td>
                    <td>{{$item->tipo}}</td>
                    {{-- <td>

                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target=".bd-example-modal-lg-{{$item->id_tipo}}"><i
                        class="fas fa-edit"></i></button>
                    <form action="{{route('tipo.destroy',$item->id_tipo)}}" method="get"
                        class="d-inline formulario-eliminar">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>

                    </td> --}}
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
</section>




@endsection