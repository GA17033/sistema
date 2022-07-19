<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Authenticatable
{
    use HasFactory;
    protected $table = "usuario";
    protected $primaryKey = "id_usuario";
    public $timestamps = false;
    protected $fillable = [
        "tipo_usuario", "nombre", "apellido", "usuario", "password", "dni", "telefono", "direccion", "correo", "foto"
    ];


    public function proyecto(){
        return $this->hasMany('App\Models\Proyecto');
    }
}
