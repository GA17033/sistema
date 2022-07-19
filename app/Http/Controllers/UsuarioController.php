<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarUsuarioRequest;
use App\Http\Requests\RegistrarUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{


    public function index()
    {

        $sql = DB::select("select usuario.* , tipo_usuario.tipo from usuario
        inner join tipo_usuario ON tipo_usuario.id_tipo=usuario.tipo_usuario
where usuario.estado=1
order by usuario.id_usuario asc");

        return view("vistas/usuario/usuario", compact("sql"));
    }

    public function create()
    {
        $sql = DB::select("select * from tipo_usuario");

        return view("vistas/usuario/registrar", compact("sql"));
    }

    public function store(RegistrarUsuario $request)
    {

        try {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
        } catch (\Throwable $th) {
            $foto = "";
        }
        $claveE = md5($request->password);
        try {
            if ($foto == "") {
                $sql = DB::insert("insert into usuario(tipo_usuario,nombre,apellido,usuario,password,dni,telefono,direccion,correo,estado) values(?,?,?,?,?,?,?,?,?,1)", [
                    $request->tipo,
                    $request->nombre,
                    $request->apellido,
                    $request->usuario,
                    $claveE,
                    $request->dni,
                    $request->telefono,
                    $request->direccion,
                    $request->correo,
                ]);
            } else {
                $sql = DB::insert("insert into usuario(tipo_usuario,nombre,apellido,usuario,password,dni,telefono,direccion,correo,foto,estado) values(?,?,?,?,?,?,?,?,?,?,1)", [
                    $request->tipo,
                    $request->nombre,
                    $request->apellido,
                    $request->usuario,
                    $claveE,
                    $request->dni,
                    $request->telefono,
                    $request->direccion,
                    $request->correo,
                    $foto,
                ]);
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Usuario registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }

    public function actualizarImagen(Request $request)
    {

        try {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
        } catch (\Throwable $th) {
            $foto = "";
        }

        if ($foto == "") {
            return back()->with("INCORRECTO", "No se ha seleccionado ninguna foto");
        } else {
            try {
                $sql = DB::update("update usuario set foto=? where id_usuario=?", [
                    $foto,
                    $request->id
                ]);
                if ($sql == 0) {
                    $sql = 1;
                }
            } catch (\Throwable $th) {
                $sql = 0;
            }
        }




        if ($sql == 1) {
            return back()->with("CORRECTO", "Foto del perfil actualizado");
        } else {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }

    public function eliminarImagen($id)
    {
        try {
            $sql = DB::update("update usuario set foto=? where id_usuario=?", [
                "",
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Foto del perfil eliminado");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }


    public function edit($id)
    {
        $sql = DB::select("select * from usuario where id_usuario=? and estado=1", [
            $id
        ]);

        $sql2 = DB::select("select * from tipo_usuario");

        return view('vistas/usuario/actualizar', compact('sql'))->with("tipoUsuario", $sql2);
    }

    public function update(ActualizarUsuarioRequest $request, $id)
    {

        //$claveE = md5($request->password);


        try {
            $sql = DB::update("update usuario set tipo_usuario=?, nombre=?, apellido=?, usuario=?, dni=?, telefono=?, direccion=?, correo=?
         where id_usuario=?", [
                $request->tipo,
                $request->nombre,
                $request->apellido,
                $request->usuario,
                $request->dni,
                $request->telefono,
                $request->direccion,
                $request->correo,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Usuario actualizado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }


    public function destroy($id)
    {
        try {
            $sql = DB::update("update usuario set estado=0 where id_usuario=?", [
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Usuario eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }
}
