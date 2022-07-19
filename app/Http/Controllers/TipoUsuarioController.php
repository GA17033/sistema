<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql = DB::select("select * from tipo_usuario");
        return view('vistas/tipo/tipoUsuario', compact("sql"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'tipo' => 'required|alpha|unique:App\Models\TipoUsuario,tipo'
        ]);

        try {
            $sql = DB::insert("insert into tipo_usuario(tipo) values(?)", [
                $request->tipo
            ]);
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Tipo de usuario registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|alpha'
        ]);

        $duplicado = DB::select("select count(*) as total from tipo_usuario where tipo=? and id_tipo!=?", [
            $request->tipo,
            $id
        ]);

        foreach ($duplicado as $key => $value) {
            if ($value->total >= 1) {
                return back()->with("DUPLICADO", "El nombre ya existe");
            }
        }

        try {
            $sql = DB::update("update tipo_usuario set tipo=? where id_tipo=?", [
                $request->tipo,
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Tipo de usuario actualizado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $sql = DB::insert("delete from tipo_usuario where id_tipo=?", [
                $id
            ]);
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Tipo de usuario eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminado");
        }
    }
}
