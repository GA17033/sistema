<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarPerfilUsuarioRequest;
use App\Http\Requests\ActualizarUsuarioRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function datos($id)
    {
        $sql = DB::select(" select * from usuario where id_usuario=$id ");
        return view("vistas/usuarioProfile.usuario", compact("sql"));
    }

    public function editar(ActualizarPerfilUsuarioRequest $request)
    {
        try {
            $sql = DB::update(" update usuario set nombre=?, apellido=?, usuario=?, dni=?, telefono=?, direccion=?, correo=? where id_usuario=? ", [
                $request->nombre,
                $request->apellido,
                $request->usuario,
                $request->dni,
                $request->telefono,
                $request->direccion,
                $request->correo,
                $request->id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Datos modificado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al modificar");
        }
    }

    public function editarImg(Request $request)
    {
        try {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
        } catch (\Throwable $th) {
            $foto = "";
        }
        if ($foto == "") {
            return back()->with("AVISO", "Debe seleccionar una foto ...!");
        }

        try {
            $sql = DB::update(" update usuario set foto=? where id_usuario=? ", [
                $foto,
                $request->id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Imagen modificado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al modificar");
        }
    }

    public function eliminarImg($id)
    {
        try {
            $sql = DB::update(" update usuario set foto=null where id_usuario=? ", [
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Imagen eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }
}
