<?php

namespace App\Http\Requests;

use App\Rules\producto\registrar\verificarNombre;
use Illuminate\Foundation\Http\FormRequest;

class RegistrarProductoRequest extends FormRequest
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
            "cate" => "required",
            "nombre" => ["required", new verificarNombre()],
            "precio" => "required|numeric|min:0",
        ];
    }

    public function messages()
    {
        return [
            "cate.required" => "Debe seleccionar una categoria",
        ];
    }
}
