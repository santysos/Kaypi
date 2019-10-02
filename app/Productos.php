<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'tb_descripcion_servicios';

    protected $primaryKey = 'idtb_descripcion_servicios';

    public $timestamps = false;

    protected $fillable = [

        'tb_servicios_idtb_servicios',
        'productos',

    ];

    protected $guarded = [

    ];

    public static function dese($id)
    {
        return Productos::where('tb_servicios_idtb_servicios', '=', $id)
            ->where('condicion', '=', '1')
            ->get();

    }
}
