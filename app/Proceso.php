<?php

namespace Kaypi;

use Illuminate\Database\Eloquent\Model;
use DB;

class Proceso extends Model
{
    protected $table = 'tb_procesos';

    protected $primaryKey = 'idtb_procesos';

    public $timestamps = false;

    protected $fillable = [

        'tb_ordenes_idtb_ordenes',
        'tb_descripcion_procesos_idtb_descripcion_procesos',
        'created_at',
        'users_id_asignado',
        'users_id_asignador',
        'condicion',
        'num_factura',

    ];

    protected $guarded = [

    ];
    public static function despro($id)
    {
        return DescripcionProcesos::where('tb_departamentos_idtb_departamentos', '=', $id)
            ->where('condicion', '=', '1')
            ->get();

    }

    public static function OrdenProcesoDepartamento($id)
    {
        return DB::table('tb_procesos as pro')
            ->join('users as emp', 'emp.id', '=', 'pro.users_id_asignado')
            ->join('users as usr', 'usr.id', '=', 'pro.users_id_asignador')
            ->join('tb_descripcion_procesos as dpro', 'dpro.idtb_descripcion_procesos', '=', 'pro.tb_descripcion_procesos_idtb_descripcion_procesos')
            ->select('pro.idtb_procesos', 'pro.tb_ordenes_idtb_ordenes', 'pro.created_at', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador')
            ->where('pro.tb_descripcion_procesos_idtb_descripcion_procesos', '=', $id)
            ->where('pro.condicion', '=', '1')
            ->orderBy('pro.tb_ordenes_idtb_ordenes', 'desc')
            ->get();

    }
}
