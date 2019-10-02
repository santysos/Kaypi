<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table        ='tb_articulo';

    protected $primaryKey   ='idtb_articulo';

    public $timestamps=true;

    protected $fillable = [

    'tb_categoria_idtb_categoria',
    'codigo',
    'nombre',
    'iva',
    'stock',
    'descripcion',
    'imagen',
    'condicion',
    'created_at',
    'updated_at',
    'pvp',   
    'pvp1',   
    'pvp2',   
    'sucursal',
    
    ];

    protected $guarded = [

    ];
    public static function dprecios($id)
    {
        return Articulo::where('idtb_articulo', '=', $id)
            
        ->where('condicion', '=', '1')
            ->get();

    }
}
