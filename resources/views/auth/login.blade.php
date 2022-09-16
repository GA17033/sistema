<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('bootstrap4/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{asset('css/-Login-form-Page-BS4--Login-form-Page-BS4.css')}}">
</head>

<body>
    <div class="container-fluid">
        <div class="row mh-100vh">
            <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0 align-self-center d-lg-flex align-items-lg-center align-self-lg-stretch bg-white p-5 rounded rounded-lg-0 my-5 my-lg-0" id="login-block">
                <div class="m-auto w-lg-75 w-xl-50">
                    <h2 class="text-info fw-light mb-5"><i class="fa fa-diamond"></i>&nbsp;Diseño De Sistemas</h2>
                    <form method="POST" action="{{ route('login') }}">
                    @csrf

                    
                    @if (session('mensaje'))
                    <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
                        <small>{{ session('mensaje') }}</small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @error('usuario')
                    <div class="alert alert-danger alert-dismissible fade show mb-1" role="alert">
                        <small>{{ $errors->first('usuario') }}</small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @enderror

                    
                    @error('password')
                    <div class="alert alert-danger alert-dismissible fade show mb-2" role="alert">
                        <small>{{ $errors->first('password') }}</small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @enderror
                        <div class="form-group mb-3"><label class="form-label text-secondary">Email</label><input  class="form-control"  id="usuario" type="text" class="input @error('usuario') is-invalid
                        @enderror" name="usuario" title="ingrese su nombre de usuario" autocomplete="usuario"
                            value="{{ old('usuario') }}"></div>
                        <div class="form-group mb-3"><label class="form-label text-secondary">Password</label><input class="form-control" type="password" id="input" class="input @error('password') is-invalid @enderror"
                            name="password" title="ingrese su clave para ingresar" autocomplete="current-password"></div><input name="btningresar"class="btn btn-info mt-2" title="click para ingresar" type="submit" value="INICIAR SESION">
                    </form>
                   
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-end" id="bg-block" style="background-image:url({{asset('img/aldain-austria-316143-unsplash.jpg')}});background-size:cover;background-position:center center;">
                <p class="ms-auto small text-dark mb-2"><a class="text-dark" href="https://unsplash.com/photos/v0zVmWULYTg?utm_source=unsplash&amp;utm_medium=referral&amp;utm_content=creditCopyText" target="_blank"></a><br></p>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
