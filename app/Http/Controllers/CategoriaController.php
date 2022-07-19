<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function index()
    {
        $sql = DB::select("select * from categoria where estado=1");
        return view("vistas/categoria/categoria", compact("sql"));
    }

    public function create()
    {
        return view("vistas/categoria/registrar");
    }

    public function store(Request $request)
    {

      

        $duplicado = DB::select("select count(*) as total from categoria where nombre=? and estado=1 ", [
            $request->nombre
        ]);
        if ($duplicado[0]->total > 0) {
            return back()->with("DUPLICADO", "El nombre" . "'$request->nombre'" . "ya existe");
        }


        $sql = DB::insert(" insert into categoria(nombre,estado) values(?,1) ", [
            $request->nombre
        ]);
        if ($sql == 1) {
            return back()->with("CORRECTO", "Categoria registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }

    public function edit($id)
    {
        $sql = DB::select("select * from categoria where id_categoria=?", [
            $id
        ]);
        return view("vistas/categoria/actualizar", compact("sql"));
    }

    public function update(Request $request, $id)
    {

        $duplicado = DB::select("select count(*) as total from categoria where nombre=? and id_categoria!=$id and estado=1 ", [
            $request->nombre
        ]);
        if ($duplicado[0]->total > 0) {
            return back()->with("DUPLICADO", "El nombre" . "'$request->nombre'" . "ya existe");
        }

        $request->validate([
            "nombre" => "required|alpha_num"
        ]);

        try {
            $sql = DB::update("update categoria set nombre=? where id_categoria=?", [
                $request->nombre,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Categoria actualizado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }

    public function destroy($id)
    {

        try {
            $sql = DB::update("update categoria set estado=0 where id_categoria=?", [
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Categoria eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }
}
