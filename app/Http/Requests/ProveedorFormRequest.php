<?php

namespace Kaypi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedorFormRequest extends FormRequest
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
            'nombre_comercial' => 'required|max:60',
            'razon_social'    => 'max:60',
            'direccion'                => 'max:300',
            'ciudad'                   => 'max:25',
            'telefono'                 => 'max:15',
            'pais'                 => 'max:15',
            'cedula_ruc'               => 'max:13|unique:tb_proveedor',
            'email'                    => 'max:45',
        ];
    }
}
