<?php

namespace Kaypi\Http\Controllers;

use Carbon\Carbon;
use Kaypi\Departamento;
use Kaypi\DescripcionProcesos;
use Kaypi\Http\Requests\ProcesosFormRequest;
use Kaypi\Http\Requests\ProductosFormRequest;
use Kaypi\Http\Requests\AgregarProduccionFormRequest;
use Kaypi\Proceso;
use Kaypi\Productos;
use Kaypi\Servicios;
use Kaypi\Produccion;
use Kaypi\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class ProcesosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        function formatofecha($fecha)
        {
            if ($fecha != null) {
                setlocale(LC_TIME, "es_ES.UTF-8");

                return $fec = strftime("%a, %d %b %Y - %H:%M%p", strtotime($fecha));
            } else {
                return null;
            }

        }
        function diferenciafecha($fecha1, $fecha2)
        {

            $datetime1 = date_create($fecha1);
            $datetime2 = date_create($fecha2);

            $respuesta = date_diff($datetime1, $datetime2);

            if ($respuesta->y == 0 && $respuesta->m == 0 && $respuesta->d == 0 && $respuesta->h == 0 && $respuesta->i == 0 && $respuesta->s == 0) {
                $respuesta = '';

                return $respuesta;
            } elseif ($respuesta->y == 0 && $respuesta->m == 0 && $respuesta->d == 0 && $respuesta->h == 0 && $respuesta->i == 0) {
                $respuesta = $respuesta->s . 'seg';

                return $respuesta;
            } elseif ($respuesta->y == 0 && $respuesta->m == 0 && $respuesta->d == 0 && $respuesta->h == 0) {
                $respuesta = $respuesta->i . 'min ' . $respuesta->s . 'seg';

                return $respuesta;
            } elseif ($respuesta->y == 0 && $respuesta->m == 0 && $respuesta->d == 0) {
                $respuesta = $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';

                return $respuesta;
            } elseif ($respuesta->y == 0 && $respuesta->m == 0) {
                $respuesta = $respuesta->d . 'd ' . $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';

                return $respuesta;
            } elseif ($respuesta->y == 0) {
                $respuesta = $respuesta->m . 'me ' . $respuesta->d . 'd ' . $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';
                return $respuesta;
            } elseif ($respuesta->y >= 1) {
                $respuesta = $respuesta->y . 'añ ' .$respuesta->m . 'me ' . $respuesta->d . 'd ' . $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';
                return $respuesta;
            }
            return $respuesta;
        }

        $procesos = DB::table('tb_procesos as pro')
            ->join('users as emp', 'emp.id', '=', 'users_id_asignado')
            ->join('users as usr', 'usr.id', '=', 'users_id_asignador')
            ->join('tb_descripcion_procesos as dpro', 'dpro.idtb_descripcion_procesos', '=', 'pro.tb_descripcion_procesos_idtb_descripcion_procesos')
            ->join('tb_ordenes as ord','ord.idtb_ordenes','=','pro.tb_ordenes_idtb_ordenes')
            ->select('pro.idtb_procesos', 'pro.tb_ordenes_idtb_ordenes', 'pro.created_at', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'dpro.idtb_descripcion_procesos', 'pro.condicion')
            ->where('pro.tb_descripcion_procesos_idtb_descripcion_procesos', '!=', '18') //no selecciono los facturados
            ->where('pro.tb_descripcion_procesos_idtb_descripcion_procesos', '!=', '16') //no selecciono los facturados
            ->where('pro.tb_descripcion_procesos_idtb_descripcion_procesos', '!=', '9') //no selecciono los facturados
            ->where('ord.condicion', '=', '1')
            ->where('pro.condicion', '=', '1')
            ->orderby('pro.created_at', 'asc')
            ->get();

        $procesos->count             = 0;
        $procesos->ingresoventas     = 0;
        $procesos->sri               = 0;
        $procesos->quito             = 0;
        $procesos->disenador         = 0;
        $procesos->disenado          = 0;
        $procesos->ingresodiseno     = 0;
        $procesos->ingresoproduccion = 0;
        $procesos->impresion         = 0;
        $procesos->acabados          = 0;

        $retraso = date("Y-m-d H:i:s"); //se instancia la fecha y la hora actual

        foreach ($procesos as $key) {

            if ($key->idtb_descripcion_procesos == 1) {
                $procesos->ingresoventas++;
            } else if ($key->idtb_descripcion_procesos == 3) {
                $procesos->sri++;
            } else if ($key->idtb_descripcion_procesos == 7) {
                $procesos->quito++;
            } else if ($key->idtb_descripcion_procesos == 5) {
                $procesos->disenador++;
            } else if ($key->idtb_descripcion_procesos == 6) {
                $procesos->disenado++;
            } else if ($key->idtb_descripcion_procesos == 2) {
                $procesos->ingresodiseno++;
            } else if ($key->idtb_descripcion_procesos == 8) {
                $procesos->ingresoproduccion++;
            } else if ($key->idtb_descripcion_procesos == 14) {
                $procesos->impresion++;
            } else if ($key->idtb_descripcion_procesos == 15) {
                $procesos->acabados++;
            }

            $key->retraso = diferenciafecha($retraso, $key->created_at); //se obtiene la diferencia de fechas para calcular el retraso

            $key->created_at = formatofecha($key->created_at); //formato para humano fechas
            $procesos->count++;

        }
      //  dd($procesos);

        if ($request) {

            $departamentos = Departamento::where('condicion', '=', '1')->orderby('idtb_departamentos', 'asc')->pluck('departamento', 'idtb_departamentos');

            $enentrega = DB::table('tb_procesos as pro')
                ->join('users as emp', 'emp.id', '=', 'pro.users_id_asignado')
                ->join('users as usr', 'usr.id', '=', 'pro.users_id_asignador')
                ->join('tb_descripcion_procesos as dpro', 'dpro.idtb_descripcion_procesos', '=', 'pro.tb_descripcion_procesos_idtb_descripcion_procesos')
                ->select('pro.idtb_procesos', 'pro.tb_ordenes_idtb_ordenes', 'pro.created_at', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador')
                ->where('pro.tb_descripcion_procesos_idtb_descripcion_procesos', '=', '9')
                ->orwhere('pro.tb_descripcion_procesos_idtb_descripcion_procesos', '=', '16')
                ->where('pro.condicion', '=', '1')
                ->orderBy('pro.created_at', 'desc')
                ->get();

            $enentrega->count = 0;

            foreach ($enentrega as $key) {

                $enentrega->count++;
            }

            // dd($enentrega);

            $ordenes = DB::table('tb_ordenes as ord')
            ->join('users as emp', 'emp.id', '=', 'ord.users_id_asignador')
            ->join('users as age', 'age.id', '=', 'ord.users_id_asignado')
            ->join('tb_cliente as cli', 'cli.idtb_cliente', '=', 'ord.tb_cliente_idtb_cliente')
            ->join('tb_procesos as pro','pro.tb_ordenes_idtb_ordenes','=','ord.idtb_ordenes')
            ->join('tb_descripcion_procesos as despro','pro.tb_descripcion_procesos_idtb_descripcion_procesos','=','despro.idtb_descripcion_procesos')
            ->join('tb_departamentos as dep','dep.idtb_departamentos','=','despro.tb_departamentos_idtb_departamentos')
            ->select('dep.departamento','despro.descripcion_procesos','ord.idtb_ordenes', 'ord.fecha_inicio', 'ord.fecha_entrega', 'ord.total_venta', 'ord.impuesto', 'ord.abono', 'ord.observaciones', 'ord.condicion', 'emp.name as asignador', 'age.name as agente', 'cli.nombre_comercial')
            ->where('ord.condicion', '=', '1')
            ->where('pro.condicion', '=', '1')
            ->where('despro.condicion', '=', '1')
            ->where('dep.condicion', '=', '1')
            ->orderBy('ord.idtb_ordenes', 'desc')
            ->groupBy('ord.idtb_ordenes', 'ord.fecha_inicio', 'ord.fecha_entrega', 'ord.total_venta', 'ord.impuesto', 'ord.abono', 'ord.observaciones', 'ord.condicion', 'emp.name', 'cli.nombre_comercial', 'age.name', 'ord.users_id_asignador', 'ord.users_id_asignado')
            ->paginate(10);

        

            return view('ventas.procesos.index', ["ordenes"=>$ordenes, "departamentos" => $departamentos, "enentrega" => $enentrega, "procesos" => $procesos]);
        }
    }

    public function getDescripcionProcesos(Request $request, $id)
    {
        if ($request->ajax()) {
            $descprocesos = Proceso::despro($id);
            return response()->json($descprocesos);
        }
    }

    public function getProcesos(Request $request, $id)
    {

        if ($request->ajax()) {
            $procesos = Proceso::OrdenProcesoDepartamento($id);
            return response()->json($procesos);
        }
    }

    public function create()
    {
        $servicios = Servicios::where('condicion', '=', '1')->pluck('Servicio', 'id_tb_Servicios');

        return view('ventas.procesos.create', ["servicios" => $servicios]);
    }

    public function store(ProcesosFormRequest $request)
    {

        $proceso                           = new Proceso;
        $mytime                            = Carbon::now('America/Guayaquil');
        $proceso->created_at            = $mytime->toDateTimeString();
        $proceso->tb_ordenes_idtb_ordenes = $request->get('tb_ordenes_idtb_ordenes');

        $cont = 0;

        $colocar = Proceso::where('tb_ordenes_idtb_ordenes', '=', $proceso->tb_ordenes_idtb_ordenes)->get(); //seleciona todos los procesos
        //dd($colocar);

        //   $colocar = Proceso::all(); //seleciona todos los procesos

        foreach ($colocar as $colo) //recorre los procesos
        {
            $nuevo = Proceso::findOrFail($colo->idtb_procesos); //crea un nuevo Model proceso por cada fila de bdd

            if ($nuevo->tb_ordenes_idtb_ordenes == $proceso->tb_ordenes_idtb_ordenes) //comprueba que la nueva fila se igual a la orden a cambiar el proceso
            {
                $nuevo->condicion = 0;
                $nuevo->update();
            }
        }

        $proceso->tb_descripcion_procesos_idtb_descripcion_procesos = $request->get('idtb_descripcion_procesos');

        $proceso->users_id_asignado    = $request->get('asignado');
        $proceso->users_id_asignador   = $request->get('asignador');
        // $proceso->num_factura = $request->get('num_factura');

        $proceso->save();

        return Redirect::to('ventas/procesos/' . $proceso->tb_ordenes_idtb_ordenes);
    }

    public function show($id)
    {

        $procesos = DB::table('tb_procesos as pro')
            ->join('users as emp', 'emp.id', '=', 'pro.users_id_asignado')
            ->join('users as usr', 'usr.id', '=', 'pro.users_id_asignador')
            ->join('tb_ordenes as ord', 'ord.idtb_ordenes', '=', 'pro.tb_ordenes_idtb_ordenes')
            ->join('tb_descripcion_procesos as dpro', 'dpro.idtb_descripcion_procesos', '=', 'pro.tb_descripcion_procesos_idtb_descripcion_procesos')
            ->join('tb_departamentos as dep', 'dep.idtb_departamentos', '=', 'dpro.tb_departamentos_idtb_departamentos')
            ->select('pro.idtb_procesos', 'pro.idtb_procesos', 'pro.tb_ordenes_idtb_ordenes', 'pro.created_at', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'dep.departamento', 'dep.idtb_departamentos')
            ->where('pro.tb_ordenes_idtb_ordenes', '=', $id)
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
            ->where('pro.tb_ordenes_idtb_ordenes', '=', $id)
            ->where('ord.condicion', '=', '1')
            ->where('pro.condicion', '=', '1')
            ->get(1);

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
            $iddep = intval($dep->idtb_departamentos);
        }


        $usuariosdep = DB::table('users as us')
            ->join('tb_tipo_usuario as tip', 'tip.idtb_tipo_usuario', '=', 'us.tb_tipo_usuario_idtb_tipo_usuario')
            ->join('tb_departamentos as dep', 'dep.idtb_departamentos', '=', 'tip.tb_departamentos_idtb_departamentos')
            ->where('us.tb_tipo_usuario_idtb_tipo_usuario', '=', Auth::user()->tb_tipo_usuario_idtb_tipo_usuario)
            ->where('dep.idtb_departamentos', '=', $iddep)
            ->where('dep.condicion', '=', '1')
            ->select('us.id', 'us.name')
            ->get();

        $detalleorden = DB::table('tb_detalle_orden as do')
            ->join('tb_articulo as art', 'art.idtb_articulo', '=', 'do.tb_articulo_idtb_articulo')
            ->select('do.tb_articulo_idtb_articulo', 'do.cantidad', 'do.valor_unitario', 'do.idtb_detalle_orden', 'do.descripcion', 'art.nombre')
            ->where('do.tb_ordenes_idtb_ordenes', '=', $id)
            ->get();

        $sumaproduccion = DB::table('tb_items as prod')
            ->select(DB::raw('sum(prod.cantidad) as sumacantidad'), 'prod.tb_detalle_orden_idtb_detalle_orden', 'prod.tb_departamentos_idtb_departamentos')
            ->where('prod.tb_ordenes_idtb_ordenes', '=', $id)
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
            ->select('prod.cantidad', 'prod.tb_detalle_orden_idtb_detalle_orden', 'prod.fecha', 'emp.name', 'art.nombre', 'dep.departamento', 'dep.idtb_departamentos','prod.tb_departamentos_idtb_departamentos')
            ->where('prod.tb_ordenes_idtb_ordenes', '=', $id)
            ->orderBy('prod.tb_departamentos_idtb_departamentos')
            ->get();
        
      //  dd($produccion);

        return view("ventas.procesos.show", ["idorden"=>$idorden,"detalleorden" => $detalleorden, "produccion" => $produccion, "sumaproduccion" => $sumaproduccion, "procesos1" => $procesos1, "usuariosdep" => $usuariosdep, "iddep" => $iddep, "procesos" => $procesos, "listadoprocesos" => $listadoprocesos, "usuarios" => $usuarios]);
    }


    public function edit($id)
    {

        $producto = Productos::findOrFail($id);

        $servicio = Servicios::findOrFail($producto->id_tb_Servicios);

        return view("ventas.procesos.edit", ["producto" => $producto, "servicio" => $servicio]);
    }

    public function update(ProductosFormRequest $request, $id)
    {
        $producto            = Productos::findOrFail($id);
        $producto->Productos = $request->get('Productos');
        $producto->update();

        Session::flash('message', "El nombre del producto " . $producto->Productos . " fue Editado");

        return Redirect::to('departamento/procesos');
    }

    public function destroy($id)
    {

        $producto            = Productos::findOrFail($id);
        $producto->condicion = '0';
        $producto->update();

        Session::flash('message', "El producto " . $producto->Productos . " fue Eliminado");

        return Redirect::to('departamento/procesos');
    }
}
