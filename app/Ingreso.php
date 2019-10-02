<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='tb_ingreso';

    protected $primaryKey='idtb_ingreso';

    public $timestamps=false;

    protected $fillable = [
    'tb_proveedor_idtb_proveedor',
    'tipo_comprobante',
    'serie_comprobante',
    'num_comprobante',
    'created_at',
    'impuesto',
    'condicion',
    'sucursal',
    
    ];

    protected $guarded = [

    ];
}
