<?php

namespace Kaypi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditarArticuloFormRequest extends FormRequest
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
            'codigo'=>'required|max:50',
            'nombre'=>'required|max:100',
            'stock'=>'required|numeric',
            'pvp'=>'required|numeric',
            'descripcion'=>'max:512',
            'imagen'=>'mimes:jpeg,bmp,png,jpg',
        ];
    }
}
