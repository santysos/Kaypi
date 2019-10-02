<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Impuestos extends Model
{
    protected $table = 'tb_impuestos';

    protected $primaryKey = 'idtb_impuestos';

    public $timestamps = false;

    protected $fillable = [

        'tipo_impuesto',
        'porcentaje',
        'codigo_sri',

    ];

    protected $guarded = [

    ];

    public static function impuestos_sri($id)
    {
        return Impuestos::where('tipo_impuesto', '=', $id)
            ->where('condicion', '=', '1')
            ->get();

    }
}
