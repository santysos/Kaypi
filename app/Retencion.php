<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Retencion extends Model
{
    protected $table='v_ele_retenciones';

    protected $primaryKey='id';

    public $timestamps=false;

    protected $fillable = [
  
    'codigo',
    'codigo_documento',
    'direccion_establecimiento',
    'documento',
    'establecimiento',
    'fecha',
    'id_contribuyente',
    'numero',
    'periodo_fiscal',
    'punto_emision',
    'razon_social',
    'secuencial',
    'tipo_documento',
    
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
