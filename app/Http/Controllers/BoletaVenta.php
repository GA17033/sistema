<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoletaVenta extends Controller
{
    public function boleta()
    {
        $sql = DB::select(" SELECT
        cliente.id_cliente,
        cliente.nombre as 'nomCliente',
        cliente.apellido as 'apeCliente',
        cliente.dni,
        cliente.telefono,
        cliente.direccion,
        venta.id_venta,
        venta.fecha,
        venta.total as 'totVenta',
        venta_detalle.id_venta_detalle,
        venta_detalle.precio,
        venta_detalle.cantidad,
        venta_detalle.total as 'totVentaDetalle',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario  group by id_venta order by id_venta desc
         ");

        /* mostrando datos solo de los producto */
        $sql2 = DB::select(" SELECT
         venta.id_venta,
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
         order by id_venta asc ");

        return view("vistas/salida.boleta", compact("sql"))->with("pro", $sql2);
    }

    public function buscarBoleta($cod)
    {
        $sql = DB::select(" SELECT
        cliente.id_cliente,
        cliente.nombre as 'nomCliente',
        cliente.apellido as 'apeCliente',
        cliente.dni,
        cliente.telefono,
        cliente.direccion,
        venta.id_venta,
        venta.fecha,
        venta.descuento,
        venta.pagoTotal,
        venta.total as 'totVenta',
        venta_detalle.id_venta_detalle,
        venta_detalle.precio,
        venta_detalle.cantidad,
        venta_detalle.total as 'totVentaDetalle',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario where venta.id_venta=$cod group by id_venta order by id_venta desc
         ");

        /* mostrando datos solo de los producto */
        $sql2 = DB::select("  SELECT
        venta.id_venta,
        venta_detalle.id_venta_detalle,
        GROUP_CONCAT(venta_detalle.cantidad) as 'cant',
               GROUP_CONCAT(venta_detalle.total) AS totVentaDetalle,
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
        producto.descripcion,
        producto.id_producto,
        GROUP_CONCAT(venta_detalle.precio) as 'precio'
        FROM
        venta
        INNER JOIN venta_detalle ON venta_detalle.id_venta = venta.id_venta
        INNER JOIN producto ON venta_detalle.id_producto = producto.id_producto
        where venta.id_venta=$cod
        order by id_venta asc ");

        $sql3 = count($sql2);

        return response()->json(['sql' => $sql, 'pro' => $sql2, "can" => $sql3, 200]);
    }
}
