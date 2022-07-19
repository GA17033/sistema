<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrarProveedorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index()
    {

        $sql = DB::select("select * from proveedor 
            where proveedor.estado=1
            order by id_proveedor asc");

        return view("vistas/proveedor/proveedor", compact("sql"));
    }
    public function create()
    {

        return view("vistas/proveedor/registrar");
    }

    public function store(RegistrarProveedorRequest $request)
    {

        try {
            $sql = DB::insert("insert into proveedor(nombre,telefono,direccion,estado) values(?,?,?,1)", [
                $request->nombre,
                $request->telefono,
                $request->direccion,
            ]);
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Proveedor registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }
    public function edit($id)
    {
        $sql = DB::select("select * from proveedor where id_proveedor=? and estado=1", [
            $id
        ]);
        return view('vistas/proveedor/actualizar', compact('sql'));
    }

    public function update(RegistrarProveedorRequest $request, $id)
    {
        try {
            $sql = DB::update("update proveedor set nombre=?,  telefono=?, direccion=?,
         where id_proveedor=?", [
                $request->nombre,
                $request->telefono,
                $request->direccion,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Proveedor actualizado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }


    public function destroy($id)
    {
        try {
            $sql = DB::update("update proveedor set estado=0 where id_proveedor=?", [
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Proveedor eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }
}
