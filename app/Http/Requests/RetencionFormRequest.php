<?php

namespace Kaypi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RetencionFormRequest extends FormRequest
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
            'direccion_establecimiento' => 'required',
            'documento'      => 'required',
            'fecha' => 'required',
            'secuencial',
            'razon_social',
            'impuesto',
            'porcentaje',
            'base_imponible',
            'usuario',
        ];
    }
}
