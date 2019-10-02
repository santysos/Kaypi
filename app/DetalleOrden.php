<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class DetalleOrden extends Model
{
    protected $table = 'tb_detalle_orden';

    protected $primaryKey = 'idtb_detalle_orden';

    public $timestamps = false;

    protected $fillable = [

        'tb_ordenes_idtb_ordenes',
        'tb_articulo_idtb_articulo',
        'cantidad',
        'valor_unitario',
        'descripcion',

    ];

    protected $guarded = [

    ];
}
