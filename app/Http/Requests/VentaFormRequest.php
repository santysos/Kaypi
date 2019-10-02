<?php

namespace Kaypi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VentaFormRequest extends FormRequest
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
   
            'tipo_comprobante'=>'required|max:20',
            //'serie_comprobante'=>'max:7',
            'num_comprobante'=>'required|max:10',
            'idarticulo'=>'required',
            'cantidad'=>'required',
            'precio_venta'=>'required',
            'descuento'=>'required',
            'total_venta'=>'required',
            'sub_total_0'=>'required',
            'sub_total_12'=>'required',
            'forma_de_pago'=>'required',
            'tb_cliente_idtb_cliente'=>'required',
            'users_id'=>'required',
        ];
    }
}
