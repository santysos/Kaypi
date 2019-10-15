<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table        = 'tb_articulo';

    protected $primaryKey   = 'idtb_articulo';

    public $timestamps = true;

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

    protected $guarded = [];

    public static function dprecios($id)
    {
        return Articulo::where('idtb_articulo', '=', $id)
            ->where('condicion', '=', '1')
            ->get();
    }
    public static function sel_articulos($id)
    {
        if (Auth::user()->tb_tipo_usuario_idtb_tipo_usuario == 1) {

            $articulos = DB::table('tb_articulo as art')
                ->select(DB::raw('CONCAT("COD: ",art.codigo," - ",art.nombre)AS articulo'), 'art.idtb_articulo', 'art.stock', 'art.pvp', 'art.iva')
                ->where('art.nombre', 'LIKE', '%' . $id . '%')
                ->orwhere('art.codigo', 'LIKE', '%' . $id . '%')
                ->where('art.condicion', '=', '1')
                ->groupBy('articulo', 'art.idtb_articulo', 'art.stock', 'art.pvp', 'art.iva')
                ->paginate(10);
                
            return $articulos;
        } 
        else {
           
            $articulos = DB::table('tb_articulo as art')
                ->select(DB::raw('CONCAT("COD: ",art.codigo," - ",art.nombre)AS articulo'), 'art.idtb_articulo', 'art.stock', 'art.pvp', 'art.iva')
                /*->select(DB::raw('CONCAT("COD: ",art.codigo," - ",art.nombre)AS articulo'),'art.idarticulo','art.stock', DB::raw('avg(di.precio_venta) as precio_promedio'))*/
                //esta calculando el precio promedio de todos los precios de venta ingresados, si si desea se puede calcular el precio de venta con el ultimo precio de compra. cambiando la consulta DB
                ->where('art.condicion', '=', '1')
                ->where('art.sucursal', '=', Auth::user()->sucursal)
                ->where('art.nombre', 'LIKE', '%' . $id . '%')
                ->orwhere('art.codigo', 'LIKE', '%' . $id . '%')
                //->where('art.stock','>','0')
                ->groupBy('articulo', 'art.idtb_articulo', 'art.stock', 'art.pvp', 'art.iva')
                ->paginate(10);
                
        return $articulos;
        }
    
    }
}
