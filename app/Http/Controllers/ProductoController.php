<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrarProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{

    public function index()
    {

        $sql = DB::select("select producto. * , categoria.nombre as cate from producto
        inner join categoria ON producto.id_categoria=categoria.id_categoria
    where producto.estado=1
    order by producto.id_producto asc");

        return view("vistas/producto/producto", compact("sql"));
    }
    public function create()
    {
        $sql = DB::select("select * from categoria where estado=1");

        return view("vistas/producto/registrar", compact("sql"));
    }

    public function store(RegistrarProductoRequest $request)
    {

        try {
            $sql = DB::insert("insert into producto(id_categoria,nombre,descripcion,precio,estado) values(?,?,?,?,1)", [
                $request->cate,
                $request->nombre,
                $request->descripcion,
                $request->precio,
            ]);
        } catch (\Throwable $th) {
            $sql = 0;
        }
        if ($sql == 1) {
            return back()->with("CORRECTO", "Producto registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }
    public function edit($id)
    {
        $sql = DB::select("select * from producto where id_producto=? and estado=1", [
            $id,
        ]);

        $sql2 = DB::select("select * from categoria where estado=1");

        return view('vistas/producto/actualizar', compact('sql'))->with("cate", $sql2);
    }

    public function update(Request $request, $id)
    {
        try {
            $producto = Producto::where('id_producto', $id)->first();
            $producto->id_categoria = $request->cate;
            $producto->nombre = $request->nombre;
            $producto->descripcion = $request->descripcion;
            $producto->precio = $request->precio;
            $producto->save();
            return back()->with("CORRECTO", "Producto actualizado correctamente");
        } catch (\Throwable $th) {
            return back()->with("INCORRECTO", "Error al actualizar");
        }

    }

    public function destroy($id)
    {
        try {
            $sql = DB::update("update producto set estado=0 where id_producto=?", [
                $id,
            ]);
            if ($sql == 0) {
                $sql = 1;
            }
        } catch (\Throwable $th) {
            $sql = 0;
        }

        if ($sql == 1) {
            return back()->with("CORRECTO", "Producto eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }
}
