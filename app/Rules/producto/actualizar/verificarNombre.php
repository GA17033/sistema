<?php

namespace App\Rules\producto\actualizar;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class verificarNombre implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /* validando duplicidad de usuario */
        $valUsuario = DB::select("select count(*) as total from producto where nombre=? and id_producto!=? and estado=1", [
            $value,
            $this->id
        ]);
        if ($valUsuario[0]->total > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Este producto ya existe.';
    }
}
