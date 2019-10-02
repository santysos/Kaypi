<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'tb_servicios';

    protected $primaryKey = 'idtb_Servicios';

    public $timestamps = false;

    protected $fillable = [

        'servicio',

    ];

    protected $guarded = [

    ];
}
