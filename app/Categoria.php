<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table='tb_categoria';

    protected $primaryKey='idtb_categoria';

    public $timestamps=false;

    protected $fillable = [
    'nombre',
    'descripcion',
    'condicion',
    
    ];

    protected $guarded = [

    ];
}
