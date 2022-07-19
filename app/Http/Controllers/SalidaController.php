<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalidaController extends Controller
{

    public function index()
    {
        return view("vistas/salida/salida");
    }

    public function buscar($id)
    {

        $sql = DB::select(" select * from producto where estado=1 and (nombre like'%$id%' or descripcion like'%$id%') ");
        return response()->json(['dato' => $sql, 200]);
    }

    public function agregarElemento($id)
    {
        $sql = DB::select(" select * from producto where id_producto=$id and estado=1 ");
        return response()->json(['dato2' => $sql, 200]);
    }

    public function registrarVenta(Request $request)
    {

        $fecha = $date = date('Y-m-d');
        $valores = $request->valores;
        $valores = json_decode($valores);

        /* registrar cliente */
        $reCliente = DB::insert("insert into cliente(nombre,apellido,dni,telefono,direccion)values(?,?,?,?,?)", [
            $valores[0]->cliente,
            $valores[0]->apellido,
            $valores[0]->dni,
            $valores[0]->telefono,
            $valores[0]->direccion
        ]);

        $idCliente = DB::select(" select max(id_cliente) as 'id' from cliente ");
        foreach ($idCliente as $key => $value) {
            $ultIdCli = $value->id;
        }

        /* registrar venta */
        $reVenta = DB::insert("insert into venta(id_cliente,id_usuario,fecha,total,descuento,pagoTotal,estado)values(?,?,?,?,?,?,1)", [
            $ultIdCli,
            $valores[0]->usuario,
            $fecha,
            $valores[0]->total,
            $valores[0]->descuento,
            $valores[0]->totalPagar,
        ]);


        $idVenta = DB::select(" select max(id_venta) as 'id' from venta ");
        foreach ($idVenta as $key => $values) {
            $ultIdVenta = $values->id;
        }

        /* registrar ventaDetalle */

        foreach ($valores as $key => $val) {
            $reVenta = DB::insert("insert into venta_detalle(id_venta,id_producto,precio,cantidad,total,estado)values(?,?,?,?,?,1)", [
                $ultIdVenta,
                $valores[$key]->producto,
                $valores[$key]->precio,
                $valores[$key]->cantidad,
                $valores[$key]->subtotal
            ]);
        }

        /* actualizando stock del producto */
        foreach ($valores as $key => $val) {
            try {
                $desc = $valores[$key]->cantidad;
                $acProducto = DB::update("update producto set stock=(stock-$desc) where id_producto=?", [
                    $valores[$key]->producto
                ]);
            } catch (\Throwable $th) {
            }
        }


        return response()->json([['dato2' => $valores, 'id' => $ultIdVenta], 200]);
    }

    public function venta()
    {
        $sql = DB::select(" SELECT
        cliente.id_cliente,
        cliente.nombre as 'nomCliente',
        cliente.apellido as 'apeCliente',
        cliente.dni,
        cliente.telefono,
        cliente.direccion,
        venta.id_venta,
        venta.estado,
        venta.fecha,
        venta.total as 'totVenta',
        venta_detalle.id_venta_detalle,
        venta_detalle.precio,
        venta_detalle.cantidad,
        venta_detalle.total as 'totVentaDetalle',
        venta.descuento,
        venta.pagoTotal,
        producto.nombre as 'nomProducto',
        producto.descripcion,
        usuario.id_usuario,
        usuario.nombre as 'nomUsuario',
        usuario.apellido as 'apeUsuario',
        producto.id_producto,
        producto.estado as 'proEstado'
        FROM
        cliente
        INNER JOIN venta ON venta.id_cliente = cliente.id_cliente
        INNER JOIN venta_detalle ON venta_detalle.id_venta = venta.id_venta
        INNER JOIN producto ON venta_detalle.id_producto = producto.id_producto
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario where venta.estado=1 group by id_venta order by id_venta desc
         ");

        /* mostrando datos solo de los producto */
        $sql2 = DB::select(" SELECT
         venta.id_venta,
         venta.estado,
         venta_detalle.id_venta_detalle,
         venta_detalle.cantidad,
         venta_detalle.total AS totVentaDetalle,
         producto.nombre AS nomProducto,
         producto.descripcion,
         producto.id_producto,
         venta_detalle.precio
         FROM
         venta
         INNER JOIN venta_detalle ON venta_detalle.id_venta = venta.id_venta
         INNER JOIN producto ON venta_detalle.id_producto = producto.id_producto
         where venta.estado=1
         order by id_venta asc ");

        return view("vistas/salida.ventas", compact("sql"))->with("pro", $sql2);
    }

    public function eliminar($id)
    {
        try {
            $sql = DB::update(" update venta set estado=0 where id_venta=$id ");
            $sql2 = DB::update(" update venta_detalle set estado=0 where id_venta=$id ");
        } catch (\Throwable $th) {
        }
        if ($sql == 1 && $sql == 1) {
            return back()->with("CORRECTO", "Venta eliminado correctamente");
        } else {
            return back()->with("INCORRECTO", "Error al eliminar");
        }
    }
}
