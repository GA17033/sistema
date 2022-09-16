<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use Illuminate\Http\Request;
use App\Models\Inventario;
use Illuminate\Support\Facades\DB;

class HerramientaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sql = DB::select("select * from proyectos where estado=1");
        return view("vistas/herramientas/proyecto", compact("sql"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        // $sql = DB::select("select * from proyectos where estado=1 and id_proyecto=?", [$id]);
        $sql = DB::select("select * from producto where estado=1");
        return view("vistas/herramientas/registrar", compact("sql"))->with("id", $id);
    }

    public function indexherramienta()
    {
        $sql = DB::select("select * from herramientas where estado=1");
        return view("vistas/herramientas/registrar", compact("sql"));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cantidadvalida = Inventario::where("id_producto", $request->id_producto)->first();
        if($cantidadvalida->stock  <= $request->cantidad){
            return back()->with("Error", "La cantidad de herramientas es mayor a la cantidad de stock");
        }else{
            $herramienta = new Herramienta();
            $herramienta->id_producto  = $request->id_producto ;
            $herramienta->proyecto_id  = $request->proyecto_id ;
            $herramienta->cantidad  = $request->cantidad ;
            $herramienta->estado = 1;
            $herramienta->save();
            $inventario = Inventario::where("id_producto", $request->id_producto)->first();
            $inventario->stock = $inventario->stock - $request->cantidad;
            $inventario->save();
            return back()->with("CORRECTO", "Herramienta registrada correctamente");
        }

      
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
        $sql = DB::select("select * from proyectos where id_proyecto=? and estado=1", [
            $id,
        ]);

        $sqlH = DB::select("select herramientas. * , producto.nombre as cate from herramientas
        inner join producto ON herramientas.id_producto=producto.id_producto where herramientas.proyecto_id=? and herramientas.estado=1 order by herramientas.id asc", [
            //id_proyecto
            $sql[0]->id_proyecto,
        ]);

        //mostrar tabla herramientas cuandp se seleccione un proyecto

        //$sql2 = DB::select("select * from usuario where estado=1");
        // $sql2 = DB::select("select * from herramientas where estado=1");

        return view('vistas/herramientas/index', compact('sql'))->with("sql2", $sqlH);
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
            $sql = DB::update("update herramientas set estado=0 where id=?", [
                $id
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Proyecto eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }
}
