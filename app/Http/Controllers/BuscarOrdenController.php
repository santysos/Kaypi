<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Kaypi\DescripcionProcesos;
use Kaypi\User;
use Illuminate\Support\Facades\Auth;



class BuscarOrdenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));


            $procesos = DB::table('tb_procesos as pro')
                ->join('users as emp', 'emp.id', '=', 'pro.users_id_asignado')
                ->join('users as usr', 'usr.id', '=', 'pro.users_id_asignador')
                ->join('tb_ordenes as ord', 'ord.idtb_ordenes', '=', 'pro.tb_ordenes_idtb_ordenes')
                ->join('tb_descripcion_procesos as dpro', 'dpro.idtb_descripcion_procesos', '=', 'pro.tb_descripcion_procesos_idtb_descripcion_procesos')
                ->join('tb_departamentos as dep', 'dep.idtb_departamentos', '=', 'dpro.tb_departamentos_idtb_departamentos')
                ->select('pro.idtb_procesos', 'pro.idtb_procesos', 'pro.tb_ordenes_idtb_ordenes', 'pro.created_at', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'dep.departamento', 'dep.idtb_departamentos')
                ->where('pro.tb_ordenes_idtb_ordenes', '=', $query)
                ->where('ord.condicion', '=', '1')
                ->orderby('pro.created_at', 'asc')
                ->get();


            //selecciona el proceso en donde se encuentra la orden
            $procesos1 = DB::table('tb_procesos as pro')
                ->join('users as emp', 'emp.id', '=', 'pro.users_id_asignado')
                ->join('users as usr', 'usr.id', '=', 'pro.users_id_asignador')
                ->join('tb_ordenes as ord', 'ord.idtb_ordenes', '=', 'pro.tb_ordenes_idtb_ordenes')
                ->join('tb_descripcion_procesos as dpro', 'dpro.idtb_descripcion_procesos', '=', 'pro.tb_descripcion_procesos_idtb_descripcion_procesos')
                ->select('pro.idtb_procesos', 'pro.idtb_procesos', 'pro.tb_ordenes_idtb_ordenes', 'pro.created_at', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'dpro.idtb_descripcion_procesos')
                ->where('pro.tb_ordenes_idtb_ordenes', '=', $query)
                ->where('ord.condicion', '=', '1')
                ->where('pro.condicion', '=', '1')
                ->get(1);

            //    dd($procesos1);    
            $idorden = 0;

            if ($procesos1 != null) {
                foreach ($procesos1 as $pro)
                    $idorden = $pro->tb_ordenes_idtb_ordenes;
            }


            $listadoprocesos = DescripcionProcesos::where('condicion', '=', '1')->get();


            $usuarios = User::where('condicion', '=', '1')->get();

            $departamento = DB::table('users as us')
                ->join('tb_tipo_usuario as tip', 'tip.idtb_tipo_usuario', '=', 'us.tb_tipo_usuario_idtb_tipo_usuario')
                ->join('tb_departamentos as dep', 'dep.idtb_departamentos', '=', 'tip.tb_departamentos_idtb_departamentos')
                ->where('us.tb_tipo_usuario_idtb_tipo_usuario', '=', Auth::user()->tb_tipo_usuario_idtb_tipo_usuario)
                ->where('us.id', '=', Auth::user()->id)
                ->where('dep.condicion', '=', '1')
                ->select('dep.idtb_departamentos')
                ->get();

            foreach ($departamento as $dep) {
                $requestdep = intval($dep->idtb_departamentos);
            }


            $usuariosdep = DB::table('users as us')
                ->join('tb_tipo_usuario as tip', 'tip.idtb_tipo_usuario', '=', 'us.tb_tipo_usuario_idtb_tipo_usuario')
                ->join('tb_departamentos as dep', 'dep.idtb_departamentos', '=', 'tip.tb_departamentos_idtb_departamentos')
                ->where('us.tb_tipo_usuario_idtb_tipo_usuario', '=', Auth::user()->tb_tipo_usuario_idtb_tipo_usuario)
                ->where('dep.idtb_departamentos', '=', $requestdep)
                ->where('dep.condicion', '=', '1')
                ->select('us.id', 'us.name')
                ->get();

            $detalleorden = DB::table('tb_detalle_orden as do')
                ->join('tb_articulo as art', 'art.idtb_articulo', '=', 'do.tb_articulo_idtb_articulo')
                ->select('do.tb_articulo_idtb_articulo', 'do.cantidad', 'do.valor_unitario', 'do.idtb_detalle_orden', 'do.descripcion', 'art.nombre')
                ->where('do.tb_ordenes_idtb_ordenes', '=', $query)
                ->get();

            $sumaproduccion = DB::table('tb_items as prod')
                ->select(DB::raw('sum(prod.cantidad) as sumacantidad'), 'prod.tb_detalle_orden_idtb_detalle_orden', 'prod.tb_departamentos_idtb_departamentos')
                ->where('prod.tb_ordenes_idtb_ordenes', '=', $query)
                ->groupBy('prod.tb_detalle_orden_idtb_detalle_orden', 'prod.tb_departamentos_idtb_departamentos')
                ->get();


            // dd($sumaproduccion);

            foreach ($detalleorden as $det) {
                $det->suma_pro = 0; //produccion
                $det->suma_con = 0; //Confeccion
                $det->suma_eti = 0; //Etiquetado
                $det->suma_emp = 0; //Empaquetado

                foreach ($sumaproduccion as $suma) {
                    if ($det->idtb_detalle_orden == $suma->tb_detalle_orden_idtb_detalle_orden) {
                        if ($suma->tb_departamentos_idtb_departamentos == 4) //Produccion
                            $det->suma_pro = $suma->sumacantidad;

                        if ($suma->tb_departamentos_idtb_departamentos == 5) //Confeccion
                            $det->suma_con = $suma->sumacantidad;

                        if ($suma->tb_departamentos_idtb_departamentos == 6) //Etiquetado
                            $det->suma_eti = $suma->sumacantidad;

                        if ($suma->tb_departamentos_idtb_departamentos == 7) //Empaquetado
                            $det->suma_emp = $suma->sumacantidad;
                    }
                }
            }

            //dd($detalleorden);

            $produccion = DB::table('tb_items as prod')
                ->join('users as emp', 'emp.id', '=', 'prod.users_id')
                ->join('tb_detalle_orden as do', 'do.idtb_detalle_orden', '=', 'prod.tb_detalle_orden_idtb_detalle_orden')
                ->join('tb_tipo_usuario as t_usu', 't_usu.idtb_tipo_usuario', '=', 'emp.tb_tipo_usuario_idtb_tipo_usuario')
                ->join('tb_articulo as art', 'art.idtb_articulo', '=', 'do.tb_articulo_idtb_articulo')
                ->join('tb_departamentos as dep', 'dep.idtb_departamentos', '=', 't_usu.tb_departamentos_idtb_departamentos')
                ->select('prod.cantidad', 'prod.tb_detalle_orden_idtb_detalle_orden', 'prod.fecha', 'emp.name', 'art.nombre', 'dep.departamento', 'dep.idtb_departamentos', 'prod.tb_departamentos_idtb_departamentos')
                ->where('prod.tb_ordenes_idtb_ordenes', '=', $query)
                ->orderBy('prod.tb_departamentos_idtb_departamentos')
                ->get();

            //  dd($produccion);

            return view("ventas.procesos.show", ["idorden" => $idorden, "detalleorden" => $detalleorden, "produccion" => $produccion, "sumaproduccion" => $sumaproduccion, "procesos1" => $procesos1, "usuariosdep" => $usuariosdep, "iddep" => $requestdep, "procesos" => $procesos, "listadoprocesos" => $listadoprocesos, "usuarios" => $usuarios]);
        }
    }
}
