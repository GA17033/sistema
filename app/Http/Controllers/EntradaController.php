<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntradaController extends Controller
{
    public function index()
    {

        $sql = DB::select("SELECT
        entrada.id_entrada,
        entrada.id_producto,
        entrada.id_proveedor,
        entrada.cantidad,
        entrada.precio,
        entrada.fecha,
        entrada.estado,
        producto.nombre,
        producto.descripcion
        FROM
        entrada
        INNER JOIN producto ON entrada.id_producto = producto.id_producto
        where entrada.estado=1
order by entrada.id_entrada asc");

        return view("vistas/entrada/entrada", compact("sql"));
    }

    public function create()
    {
        $provee = DB::select("select * from proveedor where estado=1");
        $sql = DB::select("select producto.* , categoria.nombre as cate from producto
        inner join categoria ON producto.id_categoria=categoria.id_categoria
        where producto.estado=1
        order by producto.id_producto asc");

        return view("vistas/entrada/registrar", compact("sql"))->with("provee", $provee);
    }

    public function store(Request $request)
    {
        $fecha = date("Y-m-d");
        $request->validate([
            "producto" => "required",
            //"proveedor" => "required",
            "stock" => "required|min:0",
            "precio" => "required",
        ]);

        try {
            $sql = DB::insert("insert into entrada(id_producto,cantidad,precio,fecha,estado) values(?,?,?,?,1)", [
                $request->producto,
                $request->stock,
                $request->precio,
                $fecha
            ]);
        } catch (\Throwable $th) {
        }

        try {
            $producto = DB::select("select stock from producto where id_producto=$request->producto");
            foreach ($producto as $key => $value) {
                $stock = $value->stock;
            }
            $sumaStock = $stock + $request->stock;

            $actualizando = DB::update("update producto set stock=? where id_producto=?", [
                $sumaStock,
                $request->producto,
            ]);
        } catch (\Throwable $th) {
        }


        if ($sql == 1 and $actualizando == 1) {
            return back()->with("CORRECTO", "Entrada registrado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al registrar");
        }
    }


    public function edit($id)
    {
        $sql0 = DB::select("SELECT
        entrada.id_entrada,
        entrada.id_producto,
        entrada.id_proveedor,
        entrada.cantidad,
        entrada.precio,
        producto.nombre,
        producto.descripcion
        FROM
        entrada
        INNER JOIN producto ON entrada.id_producto = producto.id_producto where id_entrada=$id
        ");
        $sql = DB::select("select * from producto where estado=1");
        $sql2 = DB::select("select * from categoria where estado=1");
        $sql3 = DB::select("select * from proveedor where estado=1");

        return view('vistas/entrada/actualizar', compact('sql0'))->with("cate", $sql2)->with("pro", $sql3)->with("producto", $sql);
    }

    public function update(Request $request, $id_entrada)
    {
        $request->validate([
            "producto" => "required",
            //"proveedor" => "required",
            "stock" => "required|min:0",
            "precio" => "required",
        ]);

        $id = $request->id;
        $producto = $request->producto;
        $stock = $request->stock;
        $preAntes = $request->preAntes;
        $res = $request->eliminar;
        if ($res == "si") {
            /* actualizando producto */
            try {
                $sql = DB::update("update producto set stock=(stock - $preAntes) where id_producto=?", [
                    $id
                ]);
                if ($sql == 0) {
                    $sql = 1;
                }
            } catch (\Throwable $th) {
                $sql = 0;
            }
            /* actualizando entrada */
            try {
                $sql2 = DB::update("update entrada set id_producto=?, cantidad=$stock, precio=? where id_entrada=?", [
                    $producto,
                    $request->precio,
                    $id_entrada
                ]);
                if ($sql2 == 0) {
                    $sql2 = 1;
                }
            } catch (\Throwable $th) {
                $sql2 = 0;
            }
            /* actualizando producto */
            try {
                $sql3 = DB::update("update producto set stock=(stock + $stock) where id_producto=?", [
                    $producto
                ]);
                if ($sql3 == 0) {
                    $sql3 = 1;
                }
            } catch (\Throwable $th) {
                $sql3 = 0;
            }
        } else {
            if ($res == "no") {
                $sql = 1;
                /* actualizando entrada */
                try {
                    $sql2 = DB::update("update entrada set id_producto=?, cantidad=$stock, precio=? where id_entrada=?", [
                        $producto,
                        $request->precio,
                        $id_entrada
                    ]);
                    if ($sql2 == 0) {
                        $sql2 = 1;
                    }
                } catch (\Throwable $th) {
                    $sql2 = 0;
                }
                /* actualizando producto */
                try {
                    $sql3 = DB::update("update producto set stock=(stock + $stock) where id_producto=?", [
                        $producto
                    ]);
                    if ($sql3 == 0) {
                        $sql3 = 1;
                    }
                } catch (\Throwable $th) {
                    $sql3 = 0;
                }
            } else {
                /* actualizando producto */
                try {
                    $sql = DB::update("update producto set stock=(stock - $preAntes) where id_producto=?", [
                        $id
                    ]);
                    if ($sql == 0) {
                        $sql = 1;
                    }
                } catch (\Throwable $th) {
                    $sql = 0;
                }
                /* actualizando entrada */
                try {
                    $sql2 = DB::update("update entrada set id_producto=?, cantidad=$stock, precio=? where id_entrada=?", [
                        $producto,
                        $request->precio,
                        $id_entrada
                    ]);
                    if ($sql2 == 0) {
                        $sql2 = 1;
                    }
                } catch (\Throwable $th) {
                    $sql2 = 0;
                }
                /* actualizando producto */
                try {
                    $sql3 = DB::update("update producto set stock=(stock + $stock) where id_producto=?", [
                        $producto
                    ]);
                    if ($sql3 == 0) {
                        $sql3 = 1;
                    }
                } catch (\Throwable $th) {
                    $sql3 = 0;
                }
            }
        }




        if ($sql == 1 and $sql2 == 1 and $sql3 == 1) {
            return back()->with("CORRECTO", "Entrada y Producto actualizado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al actualizar");
        }
    }
}
