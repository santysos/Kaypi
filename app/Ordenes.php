<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Ordenes extends Model
{
    protected $table = 'tb_ordenes';

    protected $primaryKey = 'idtb_ordenes';

    public $timestamps = false;

    protected $fillable = [

        'fecha_entrega',
        'total_venta',
        'impuesto',
        'abono',
        'observaciones',
        'tb_cliente_idtb_cliente',
        'condicion',
        'users_id_asignado',
        'users_id_asignador',

    ];

    protected $guarded = [

    ];
}
