<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class TipoEmpleado extends Model
{
    protected $table = 'tb_tipo_usuario';

    protected $primaryKey = 'idtb_tipo_usuario';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'tb_departamentos_idtb_departamentos',

    ];

    protected $guarded = [

    ];

    public static function TipoEmpleados($id)
    {
        return TipoEmpleado::where('tb_departamentos_idtb_departamentos', '=', $id)
            ->where('condicion', '=', '1')
            ->get();

    }
}
