<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class DescripcionProcesos extends Model
{
    protected $table = 'tb_descripcion_procesos';

    protected $primaryKey = 'idtb_descripcion_procesos';

    public $timestamps = false;

    protected $fillable = [

        'descripcion_procesos',
        'tb_departamentos_idtb_departamentos',
        'condicion',

    ];

    protected $guarded = [

    ];
}
