<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    protected $table = 'tb_items';

    protected $primaryKey = 'idtb_items';

    public $timestamps = false;

    protected $fillable = [
        
        'fecha',
        'cantidad',
        'users_id',
        'tb_detalle_orden_idtb_detalle_orden',
        'tb_ordenes_idtb_ordenes',

    ];
    protected $guarded = [

    ];
}
