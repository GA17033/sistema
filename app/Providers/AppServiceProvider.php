<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $sql = DB::select(" select * from empresa ");
        foreach ($sql as $value) {
            View::share('dato', $value->foto);
            View::share('nombre', $value->nombre);
        }

        $usuario=DB::select(" select count(*) as 'total' from usuario where estado=1 ");
        View::share('usuario', $usuario[0]->total);

        $usuario=DB::select(" select count(*) as 'total' from cliente ");
        View::share('cliente', $usuario[0]->total);

        $usuario=DB::select(" select sum(pagoTotal) as 'tot' from venta where fecha = CURDATE() and estado=1");
        View::share('entrada', $usuario[0]->tot);

        $usuario=DB::select(" select count(*) as 'total' from producto where estado=1 ");
        View::share('producto', $usuario[0]->total);

        /* ventas  VER PRODUCTOS MAS VENDIDOS SEGUN EL MES */
        // SET lc_time_names = 'es_ES'
        $venta=DB::select("
        SELECT
        sum(venta.pagoTotal) as 'tot',
        MONTHNAME(venta.fecha) as 'fecha',
        MONTH(venta.fecha) as 'fechaN',
        venta.total,
        venta.id_venta
        FROM
        venta
        where
        EXTRACT(YEAR FROM fecha) = EXTRACT(YEAR FROM NOW()) and venta.estado=1
        GROUP BY MONTHNAME(venta.fecha)
        ORDER BY Month(fecha)ASC
         ");
         $data=[0,0,0,0,0,0,0,0,0,0,0,0];
         foreach ($venta as $key => $value) {
             $data[$value->fechaN-1]=$value->tot;
        }
        View::share("datas", $data);
    }
}
