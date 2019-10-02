<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'tb_proveedor';

    protected $primaryKey = 'idtb_proveedor';

    public $timestamps = false;

    protected $fillable = [
        
        'nombre_comercial',
        'razon_social',
        'direccion',
        'ciudad',
        'telefono',
        'cedula_ruc',
        'email',
        
    ];
    
    public static function BuscarProveedor($id)
    {
        return Proveedor::where('nombre_comercial', 'LIKE', '%' . $id . '%')
            ->orwhere('razon_social', 'LIKE', '%' . $id . '%')
            ->orwhere('cedula_ruc', 'LIKE', '%' . $id . '%')
            ->first();
    }
    protected $guarded = [

    ];

}
