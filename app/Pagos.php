<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    protected $table = 'tb_pagos';

    protected $primaryKey = 'idtb_pagos';

    public $timestamps = false;

    protected $fillable = [
        
        'fecha_pago',
        'notas',
        'valor',
        'tb_tipo_pago_idtb_tipo_pago',
        'tb_cliente_idtb_cliente',
        'tb_venta_idtb_venta',

    ];
    protected $guarded = [

    ];

    public static function dpagos($id)
    {
        return Pagos::where('tb_venta_idtb_venta', '=', $id)
        ->where('condicion', '=', '1')
        ->get();

    }
    
}
