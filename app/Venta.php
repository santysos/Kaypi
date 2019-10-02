<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='tb_venta';

    protected $primaryKey='idtb_venta';

    public $timestamps=false;

    protected $fillable = [
  
    'tipo_comprobante',
    'serie_comprobante',
    'num_comprobante',
    'created_at',
    'impuesto',
    'total_venta',
    'sub_total_0',
    'sub_total_12',
    'condicion',
    'forma_de_pago',
    'tb_cliente_idtb_cliente',
    'users_id',
    
    ];

    protected $guarded = [

    ];

    public static function dnumComp($id)
    {
        return Venta::select('num_comprobante')
        ->where('sucursal', '=', $id)
        ->orderBy('num_comprobante','desc')
        ->first();

    }
}
