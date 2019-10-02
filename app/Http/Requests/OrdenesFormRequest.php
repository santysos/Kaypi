<?php

namespace Kaypi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrdenesFormRequest extends FormRequest
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

            'fecha_entrega' => 'required',
            'total_venta'      => 'required',
            'users_id',
            'abono'            => 'required',
            'observaciones',
            'CodigoCliente',
            'condicion',
            'impuesto',
            'idtb_descripcion_servicios',
            'cantidad',
            'tb_servicios_idtb_servicios',
            'valor_unitario',
            'descripcion',
            'usuario',
        ];
    }
}
