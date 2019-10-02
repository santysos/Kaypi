<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table='tb_detalle_ingreso';

    protected $primaryKey='idtb_detalle_ingreso';

    public $timestamps=false;

    protected $fillable = [
    'tb_ingreso_idtb_ingreso',
    'tb_articulo_idtb_articulo',
    'cantidad',
    'precio_compra',
    'precio_venta',
    
    ];

    protected $guarded = [

    ];
}
