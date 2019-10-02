<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table='tb_detalle_venta';

    protected $primaryKey='idtb_detalle_venta';

    public $timestamps=false;

    protected $fillable = [
    
    'cantidad',
    'precio_venta',
    'descuento',
    'tb_articulo_idtb_articulo',
    'tb_venta_idtb_venta',

    ];

    protected $guarded = [

    ];
}
