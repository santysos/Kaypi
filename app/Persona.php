<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'tb_cliente';

    protected $primaryKey = 'idtb_cliente';

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
    protected $guarded = [

    ];
    public static function BuscarCliente($id)
    {
        return Persona::where('nombre_comercial', 'LIKE', '%' . $id . '%')
            ->orwhere('razon_social', 'LIKE', '%' . $id . '%')
            ->orwhere('cedula_ruc', 'LIKE', '%' . $id . '%')
            ->first();
    }
}
