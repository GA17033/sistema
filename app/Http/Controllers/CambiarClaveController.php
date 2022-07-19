<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CambiarClaveController extends Controller
{
    public function index()
    {
        return view("vistas/backup.backup");
    }
    public function update(Request $request)
    {

        $request->validate([
            "claveActual" => "required",
            "claveNuevo" => "required",
        ]);

        $id = Auth::user()->id_usuario;
        $verClaveAn = DB::select(" select password from usuario where id_usuario=$id ");
        $pass = md5($request->claveNuevo);

        if ($verClaveAn[0]->password != md5($request->claveActual)) {
            return back()->with("AVISO", "La contraseña actual es INCORRECTA");
        }
        try {
            $sql = DB::update(" update usuario set password=? where id_usuario=? ", [
                $pass,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Contraseña modificado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al modificar");
        }
    }
}
