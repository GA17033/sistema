<?php

namespace App\Http\Requests;

use App\Rules\usuario\actualizar\verificarCorreo;
use App\Rules\usuario\actualizar\verificarUsuario;
use Illuminate\Foundation\Http\FormRequest;

class ActualizarPerfilUsuarioRequest extends FormRequest
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
            "usuario" => ["required", "alpha_num", new verificarUsuario(request()->id, request()->usuario)],
            "correo" => ["required", "email", "email:rfc,dns", new verificarCorreo(request()->id, request()->correo)],
        ];
    }

    public function attributes()
    {
        return [
            "tipo" => "tipo de usuario",
        ];
    }
}
