<?php

namespace App\Http\Requests;

use App\Rules\usuario\registrar\duplicidadCorreo;
use App\Rules\usuario\registrar\duplicidadUsuario;
use Illuminate\Foundation\Http\FormRequest;

class RegistrarUsuario extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "tipo" => "required",
            "usuario" => ["required","alpha_num",new duplicidadUsuario()],
            "password" => "required",
            "correo" => ["required","email","email:rfc,dns", new duplicidadCorreo()]
        ];
    }

    public function attributes()
    {
        return [
            "tipo" => "tipo de usuario",
            "password" => "contraseña"
        ];
    }
}
