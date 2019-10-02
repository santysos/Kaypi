<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class DetalleRetencion extends Model
{
    protected $table = 'v_ele_retenciones_detalle';

    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [

        'base_imponible',
        'codigo',
        'codigo_sri',
        'fecha_comprobante',
        'numero',
        'numero_comprobante',
        'porcentaje',
        'tipo',
        'tipo_comprobante',
        'valor_retenido',

    ];

    protected $guarded = [

    ];
}
