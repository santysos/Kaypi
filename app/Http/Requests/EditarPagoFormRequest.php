<?php

namespace Kaypi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarPagoFormRequest extends FormRequest
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
            'fecha_pago'                        => 'required',
            'valor'                             => 'required',
            'notas'                             => 'required',
            'tipo_pago'                         => 'required',
            'tb_cliente_idtb_cliente'           => 'required',
            'tb_venta_idtb_venta'               => 'required',
        ];
    }
}
