<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    protected $table = 'tb_tipo_pago';

    protected $primaryKey = 'idtb_tipo_pago';

    public $timestamps = false;

    protected $fillable = [
        
        'tipo_pago',
    ];
    protected $guarded = [

    ];
}
