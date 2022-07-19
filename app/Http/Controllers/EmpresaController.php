<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmpresaController extends Controller
{
    public function datos()
    {
        $sql = DB::select(" select * from empresa ");
        return view("vistas/empresa.empresa", compact("sql"));
    }

    public function editar(Request $request)
    {
        try {
            $sql = DB::update(" update empresa set nombre=?, ubicacion=?, telefono=?, ruc=?, correo=? where id_empresa=? ", [
                $request->nombre,
                $request->ubicacion,
                $request->telefono,
                $request->ruc,
                $request->correo,
                $request->id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Datos modificado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al modificar");
        }
    }

    public function editarImg(Request $request)
    {
        $request->validate([
            "foto" => "mimes:jpg"
        ]);
        try {
            $foto = file_get_contents($_FILES['foto']['tmp_name']);
        } catch (\Throwable $th) {
            $foto = "";
        }
        if ($foto == "") {
            return back()->with("AVISO", "Debe seleccionar una imagen ...!");
        }

        try {
            $sql = DB::update(" update empresa set foto=? where id_empresa=? ", [
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
            $sql = DB::update(" update empresa set foto=null where id_empresa=? ", [
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
