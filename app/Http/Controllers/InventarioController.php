<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Inventario;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql = DB::select("select inventario.*, producto.nombre as cate from inventario
        inner join producto ON inventario.id_producto=producto.id_producto
        where inventario.estado=1 order by inventario.id_inventario asc");
        return view("vistas/inventario/index", compact("sql"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sql = DB::select("select * from producto where estado=1");
        return view("vistas/inventario/registrar", compact("sql"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $existente = Inventario::where('id_producto', $request->id_producto)->first();
        if($existente){
            return back()->with("ERROR", "El producto ya existe en el inventario");
        }

        $inventario =  new Inventario();
        $inventario->id_producto= $request->id_producto;
        $inventario->stock= $request->stock;
        $inventario->estado= 1;
        $inventario->save();
        return back()->with("CORRECTO", "Inventario registrado correctamente");

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
        //
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
            $sql = DB::update("update inventario set estado=0 where id_inventario=?", [
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "producto eliminado del inventario correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }
}
