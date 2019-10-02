<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $table = 'tb_departamentos';

    protected $primaryKey = 'idtb_departamentos';

    public $timestamps = false;

    protected $fillable = [

        'departamento',

    ];

    protected $guarded = [

    ];
}
