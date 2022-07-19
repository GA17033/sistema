<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    public function index()
    {
        $sql = DB::select("select * from cliente");
        return view("vistas/cliente/cliente", compact("sql"));
    }
}
