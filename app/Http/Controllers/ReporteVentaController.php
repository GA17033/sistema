<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteVentaController extends Controller
{
    public function prueba($id)
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario  where venta.id_venta=$id
		group by id_venta order by id_venta desc ");

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
         where venta.id_venta=$id
         order by id_venta asc ");

        $empresa = DB::select("select * from empresa");

        /* METODO 2 */
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes.prueba', compact("sql", "sql2", "empresa"));
        return $pdf->stream();
    }
    public function ticket($id)
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario  where venta.id_venta=$id
		group by id_venta order by id_venta desc ");

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
         where venta.id_venta=$id
         order by id_venta asc ");

        $empresa = DB::select("select * from empresa");

        /* METODO 2 */
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper(array(0, 0, 400, 300), 'landscape'); //FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes.ticket', compact("sql", "sql2", "empresa"));
        return $pdf->stream();
    }

    /* reportes de venta */
    public function reHoy()
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario where fecha = CURDATE() and venta.estado=1
         group by id_venta order by id_venta desc
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
         where fecha = CURDATE()
         order by id_venta asc ");
        $sql3 = DB::select(" select sum(total) as 'total', sum(pagoTotal) as 'tot', sum(descuento) as 'desc' from venta where fecha = CURDATE() and venta.estado=1 ");

        /* consulta para el grafico circular */
        $sql4 = DB::select(" SELECT
        producto.nombre,
        sum(venta_detalle.cantidad) as 'tot'
        FROM
        venta
        INNER JOIN venta_detalle ON venta_detalle.id_venta = venta.id_venta
        INNER JOIN producto ON venta_detalle.id_producto = producto.id_producto
        where fecha = CURDATE() and venta.estado=1
        group by producto.nombre ");
        $data = [];
        $data2 = [];
        foreach ($sql4 as $key => $value) {
            array_push($data, $value->nombre);
            array_push($data2, $value->tot);
        }
        //return $data;
        return view("vistas/reportes_ventas/hoy", compact("sql"))
            ->with("pro", $sql2)
            ->with("sql3", $sql3)
            ->with("data", $data)
            ->with("data2", $data2);
    }
    public function diaIndex()
    {
        return view("vistas/reportes_ventas/dia");
    }
    public function diasIndex()
    {
        return view("vistas/reportes_ventas/dias");
    }
    public function mesIndex()
    {
        return view("vistas/reportes_ventas/mes");
    }
    public function mesesIndex()
    {
        return view("vistas/reportes_ventas/meses");
    }
    public function anioIndex()
    {
        return view("vistas/reportes_ventas/anio");
    }
    public function aniosIndex()
    {
        return view("vistas/reportes_ventas/anios");
    }




    public function reDia($fecha)
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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario where fecha = '$fecha' and venta.estado=1
         group by id_venta order by id_venta desc
         ");


        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta where fecha = '$fecha' and venta.estado=1 ");


        //return $data;
        return response()->json([['sql' => $sql, "sql3" => $sql3, "fecha" => $fecha], 200]);
    }

    public function reDias($fecha1, $fecha2)
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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario where fecha BETWEEN '$fecha1' and '$fecha2' and venta.estado=1
         group by id_venta order by id_venta desc
         ");


        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta where fecha BETWEEN '$fecha1' and '$fecha2' and venta.estado=1 ");


        //return $data;
        return response()->json([['sql' => $sql, "sql3" => $sql3, "fecha1" => $fecha1, "fecha2" => $fecha2], 200]);
    }

    public function reMes($fecha)
    {
        $anio = substr($fecha, 0, 4);
        $mes = substr($fecha, 5, 2);

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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario where YEAR(fecha)='$anio' and MONTH(fecha)='$mes' and venta.estado=1
         group by id_venta order by id_venta desc
         ");


        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta where YEAR(fecha)='$anio' and MONTH(fecha)='$mes' and venta.estado=1 ");
        

        //return $data;
        return response()->json([['sql' => $sql, "sql3" => $sql3, "fecha" => $fecha], 200]);
    }

    public function reMeses($fecha1, $fecha2)
    {
        $anio1 = substr($fecha1, 0, 4);
        $mes1 = substr($fecha1, 5, 2);

        $anio2 = substr($fecha2, 0, 4);
        $mes2 = substr($fecha2, 5, 2);

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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario 
        where (YEAR(fecha) BETWEEN '$anio1' and '$anio2')   and (MONTH(fecha) BETWEEN '$mes1' and '$mes2') and venta.estado=1
         group by id_venta order by id_venta desc
         ");


        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta 
        where (YEAR(fecha) BETWEEN '$anio1' and '$anio2')   and (MONTH(fecha) BETWEEN '$mes1' and '$mes2') and venta.estado=1
        ");


        //return $data;
        return response()->json([['sql' => $sql, "sql3" => $sql3, "fecha1" => $fecha1, "fecha2" => $fecha2], 200]);
    }

    public function reAnio($fecha)
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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario 
        where YEAR(fecha)='$fecha' and venta.estado=1
         group by id_venta order by id_venta desc
         ");


        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta 
        where YEAR(fecha)='$fecha' and venta.estado=1
        ");


        //return $data;
        return response()->json([['sql' => $sql, "sql3" => $sql3, "fecha" => $fecha], 200]);
    }

    public function reAnios($fecha1, $fecha2)
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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario 
        where YEAR(fecha) BETWEEN '$fecha1' and '$fecha2' and venta.estado=1
         group by id_venta order by id_venta desc
         ");


        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta 
        where YEAR(fecha) BETWEEN '$fecha1' and '$fecha2' and venta.estado=1
        ");


        //return $data;
        return response()->json([['sql' => $sql, "sql3" => $sql3, "fecha1" => $fecha1, "fecha2" => $fecha2], 200]);
    }

    public function reProdMax()
    {

        $sql = DB::select(" SELECT
        Sum(venta_detalle.total) AS tot,
        producto.nombre,
        producto.id_producto,
        venta_detalle.cantidad AS cant
        FROM
                venta_detalle
                INNER JOIN producto ON venta_detalle.id_producto = producto.id_producto
        where venta_detalle.estado=1
        group by id_producto
        order by cant desc
        limit 5       
                
         ");


        $producto = [];
        $cant = [];
        $tot = [];
        foreach ($sql as $key => $value) {
            array_push($producto, 's/.' . $value->tot . " " . $value->nombre);
            array_push($cant, $value->cant);
        }



        return view("vistas/reportes_ventas/proMax", compact("sql"))->with("prod", $producto)->with("cant", $cant);
    }



    /* REPORTES CON PDF */
    public function pdfHoy()
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario where fecha = CURDATE() and venta.estado=1
         group by id_venta order by id_venta desc
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
         where fecha = CURDATE() and venta.estado=1
         order by id_venta asc ");
        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta where fecha = CURDATE() and venta.estado=1 ");


        $empresa = DB::select("select * from empresa");
        /* METODO 2 */
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes_ventas/pdf/hoy', compact("sql", "sql2", "empresa", "sql3"));
        return $pdf->stream();
    }
    public function pdfDia($fecha)
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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario where fecha = '$fecha' and venta.estado=1
         group by id_venta order by id_venta desc
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
         where fecha = '$fecha'
         order by id_venta asc ");
        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta where fecha = '$fecha' and venta.estado=1 ");

        $fecha = $fecha;

        $empresa = DB::select("select * from empresa");
        /* METODO 2 */
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes_ventas/pdf/dia', compact("sql", "sql2", "empresa", "sql3", "fecha"));
        return $pdf->stream();
    }
    public function pdfDias($fecha1, $fecha2)
    {
        $fecha1 = $fecha1;
        $fecha2 = $fecha2;

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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario where fecha BETWEEN '$fecha1' and '$fecha2' and venta.estado=1
         group by id_venta order by id_venta desc
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
         where fecha BETWEEN '$fecha1' and '$fecha2'
         order by id_venta asc ");
        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta where fecha BETWEEN '$fecha1' and '$fecha2' and venta.estado=1 ");

        $empresa = DB::select("select * from empresa");
        /* METODO 2 */
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes_ventas/pdf/dias', compact("sql", "sql2", "empresa", "sql3", "fecha1", "fecha2"));
        return $pdf->stream();
    }
    public function pdfMes($fecha)
    {
        $anio = substr($fecha, 0, 4);
        $mes = substr($fecha, 5, 2);
        $fecha = $fecha;
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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario where YEAR(fecha)='$anio' and MONTH(fecha)='$mes' and venta.estado=1
         group by id_venta order by id_venta desc
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
         where YEAR(fecha)='$anio' and MONTH(fecha)='$mes' and venta.estado=1
         order by id_venta asc ");
        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta where YEAR(fecha)='$anio' and MONTH(fecha)='$mes' and venta.estado=1 ");
        

        $empresa = DB::select("select * from empresa");
        /* METODO 2 */
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes_ventas/pdf/mes', compact("sql", "sql2", "empresa", "sql3", "fecha"));
        return $pdf->stream();
    }
    public function pdfMeses($fecha1, $fecha2)
    {
        $anio1 = substr($fecha1, 0, 4);
        $mes1 = substr($fecha1, 5, 2);

        $anio2 = substr($fecha2, 0, 4);
        $mes2 = substr($fecha2, 5, 2);

        $fecha1 = $fecha1;
        $fecha2 = $fecha2;

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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario 
        where (YEAR(fecha) BETWEEN '$anio1' and '$anio2')   and (MONTH(fecha) BETWEEN '$mes1' and '$mes2') and venta.estado=1
         group by id_venta order by id_venta desc
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
         where (YEAR(fecha) BETWEEN '$anio1' and '$anio2')   and (MONTH(fecha) BETWEEN '$mes1' and '$mes2') and venta.estado=1
         order by id_venta asc ");
        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta 
        where (YEAR(fecha) BETWEEN '$anio1' and '$anio2')   and (MONTH(fecha) BETWEEN '$mes1' and '$mes2') and venta.estado=1 ");


        $empresa = DB::select("select * from empresa");
        /* METODO 2 */
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes_ventas/pdf/meses', compact("sql", "sql2", "empresa", "sql3", "fecha1", "fecha2"));
        return $pdf->stream();
    }
    public function pdfAnio($fecha)
    {
        $fecha = $fecha;

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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario 
        where YEAR(fecha)='$fecha' and venta.estado=1
         group by id_venta order by id_venta desc
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
         where YEAR(fecha)='$fecha' and venta.estado=1
         order by id_venta asc ");
        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta 
        where YEAR(fecha)='$fecha' and venta.estado=1 ");


        $empresa = DB::select("select * from empresa");
        /* METODO 2 */
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes_ventas/pdf/anio', compact("sql", "sql2", "empresa", "sql3", "fecha"));
        return $pdf->stream();
    }
    public function pdfAnios($fecha1, $fecha2)
    {
        $fecha1 = $fecha1;
        $fecha2 = $fecha2;

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
        GROUP_CONCAT(producto.nombre) AS 'nomProducto',
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
        INNER JOIN usuario ON venta.id_usuario = usuario.id_usuario 
        where YEAR(fecha) BETWEEN '$fecha1' and '$fecha2' and venta.estado=1
         group by id_venta order by id_venta desc
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
         where YEAR(fecha) BETWEEN '$fecha1' and '$fecha2' and venta.estado=1
         order by id_venta asc ");
        $sql3 = DB::select(" select sum(total) as 'tot', sum(descuento) as 'desc', sum(pagoTotal) as 'pagoTotal' from venta 
        where YEAR(fecha) BETWEEN '$fecha1' and '$fecha2' and venta.estado=1 ");


        $empresa = DB::select("select * from empresa");
        /* METODO 2 */
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes_ventas/pdf/anios', compact("sql", "sql2", "empresa", "sql3", "fecha1", "fecha2"));
        return $pdf->stream();
    }
    public function pdfProd()
    {
        $sql = DB::select(" SELECT
        Sum(venta_detalle.total) AS tot,
        producto.nombre,
        producto.id_producto,
        venta_detalle.cantidad AS cant
        FROM
                venta_detalle
                INNER JOIN producto ON venta_detalle.id_producto = producto.id_producto
        where venta_detalle.estado=1
        group by id_producto
        order by cant desc
        limit 5      
         ");



        $empresa = DB::select("select * from empresa");
        /* METODO 2 */
        $pdf = \App::make('dompdf.wrapper');
        //$pdf->setPaper('a4', 'landscape');//FORMATO HORIZONTAL
        $pdf->loadView('vistas/reportes_ventas/pdf/prod', compact("sql", "empresa"));
        return $pdf->stream();
    }
}
