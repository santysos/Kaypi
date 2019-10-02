<?php

namespace Kaypi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticuloFormRequest extends FormRequest
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
                'idtb_categoria'=>'required',
                'codigo'=>'required|unique:tb_articulo|max:13',
                'nombre'=>'required|max:100',
                'stock'=>'required|numeric',
                'iva'=>'numeric',
                'pvp'=>'numeric',
                'pvp1'=>'numeric',
                'pvp2'=>'numeric',
                'descripcion'=>'max:512',
                'imagen'=>'mimes:jpeg,bmp,png,jpg',
        ];
        
    }
}
