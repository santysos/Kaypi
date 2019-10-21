<?php

namespace Kaypi\Http\Controllers;

use Carbon\Carbon;
use DB;
use Kaypi\DetalleOrden;
use Kaypi\Http\Requests\OrdenesFormRequest;
use Kaypi\Ordenes;
use Kaypi\Persona;
use Kaypi\Proceso;
use Kaypi\Productos;
use Kaypi\Servicios;
use Kaypi\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OrdenesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $ordenes = DB::table('tb_ordenes as ord')
                ->join('users as emp', 'emp.id', '=', 'ord.users_id_asignador')
                ->join('users as age', 'age.id', '=', 'ord.users_id_asignado')
                ->join('tb_cliente as cli', 'cli.idtb_cliente', '=', 'ord.tb_cliente_idtb_cliente')
                ->select('ord.idtb_ordenes', 'ord.fecha_inicio', 'ord.fecha_entrega', 'ord.total_venta', 'ord.impuesto', 'ord.abono', 'ord.observaciones', 'ord.condicion', 'emp.name as asignador', 'age.name as agente', 'cli.nombre_comercial')
                ->where('cli.nombre_comercial', 'LIKE', '%' . $query . '%')
                ->where('ord.condicion', '=', '1')
                ->orwhere('ord.idtb_ordenes', '=', $query)
                ->orderBy('ord.idtb_ordenes', 'desc')
                ->groupBy('ord.idtb_ordenes', 'ord.fecha_inicio', 'ord.fecha_entrega', 'ord.total_venta', 'ord.impuesto', 'ord.abono', 'ord.observaciones', 'ord.condicion', 'emp.name', 'cli.nombre_comercial', 'age.name', 'users_id_asignador', 'users_id_asignado')
                ->paginate(20);

            return view('ventas.ordenes.index', ["ordenes" => $ordenes, "searchText" => $query]);
        }
    }
    

    public function getDescripcionServicios(Request $request, $id){
        if ($request->ajax()) {
            $descserv = Productos::dese($id);
          
            return response()->json($descserv);
        }
    }

    public function getClientes(Request $request, $id){
        if ($request->ajax()) {
            $clientes = Persona::BuscarCliente($id);
            return response()->json($clientes);
        }
    }
    public function getClientesS2(Request $request){

        if ($request->ajax()) {
            $clientes = Persona::BuscarCliente($request->term);
            return response()->json($clientes);

        }
    }
    public function create()
    {
      //  $agentes = User::where('id_tb_tipo_empleados', '=', '2')->pluck('name', 'id'); //selecionar el id de agentes de ventas

      $articulos=DB::table('tb_articulo as art')
      //->join('detalle_ingreso as di', 'art.idarticulo','=','di.idarticulo')
      ->select(DB::raw('CONCAT("COD: ",art.codigo," - ",art.nombre)AS articulo'),'art.idtb_articulo','art.stock', 'art.pvp','art.iva')
      /*->select(DB::raw('CONCAT("COD: ",art.codigo," - ",art.nombre)AS articulo'),'art.idarticulo','art.stock', DB::raw('avg(di.precio_venta) as precio_promedio'))*/
      //esta calculando el precio promedio de todos los precios de venta ingresados, si si desea se puede calcular el precio de venta con el ultimo precio de compra. cambiando la consulta DB
      ->where('art.condicion','=','1')
      //->where('art.stock','>','0')
      ->groupBy('articulo','art.idtb_articulo','art.stock','art.pvp','art.iva')
      ->get();

        $servicios = Servicios::where('condicion', '=', '1')->pluck('servicio', 'idtb_Servicios');

        $ordenes = Ordenes::pluck('idtb_ordenes')->last();

        return view('ventas.ordenes.create', compact('servicios', 'ordenes','articulos'));
    }

    public function store(OrdenesFormRequest $request)
    {
     //   try {

            DB::beginTransaction();

            $orden                = new Ordenes;
            $orden->idtb_ordenes = $request->get('idtb_ordenes'); 

           
            $mytime                 = Carbon::now('America/Guayaquil');
            $orden->fecha_inicio = $mytime->toDateTimeString();

            $tiempo                  = new Carbon($request->get('fecha_entrega'));
            $orden->fecha_entrega = $tiempo->toDateTimeString();

            $orden->total_venta   = $request->get('total_venta');
            $orden->observaciones = $request->get('observaciones');
            $orden->tb_cliente_idtb_cliente = $request->get('tb_cliente_idtb_cliente');
            $orden->condicion     = '1';
            $orden->users_id_asignado        = $request->get('usuario');
            $orden->users_id_asignador     = $request->get('usuario');

            $orden->impuesto   = '12';
            $orden->abono = $request->get('abono');
            $orden->save();
            

            //en las siguientes variables se guardan los arreglos del detalle de cada producto.
            $idservicios = $request->get('idservicios');
            $Cantidad                    = $request->get('cantidad');
            $Valor_Unitario              = $request->get('valortotal');
            $Descripcion                 = $request->get('descripcion');

            $cont = 0;

            while ($cont < count($idservicios)) {
                $detalle                                                        = new DetalleOrden();
                $detalle->tb_ordenes_idtb_ordenes                               = $orden->idtb_ordenes;
                $detalle->tb_articulo_idtb_articulo                             = $idservicios[$cont];
                $detalle->cantidad                                              = $Cantidad[$cont];
                $detalle->valor_unitario                                        = $Valor_Unitario[$cont];
                $detalle->descripcion                                           = $Descripcion[$cont];
                //dd($detalle);
                $detalle->save();

                $cont = $cont + 1;
            }
      

            $proceso                                                            = new Proceso();
            $proceso->tb_ordenes_idtb_ordenes                                   = $orden->idtb_ordenes;
            $mytime                                                             = Carbon::now('America/Guayaquil');
            $proceso->created_at                                                = $mytime->toDateTimeString();
            $proceso->tb_descripcion_procesos_idtb_descripcion_procesos         = '1';
            $proceso->users_id_asignador                                        = $request->get('usuario');
            $proceso->users_id_asignado                                         = $orden->users_id_asignado;
            $proceso->condicion                                                 =1;  
            $proceso->save();
         

            DB::commit();
/*
        } catch (\Exception $e) {
            DB::rollback();
        }*/

        Session::flash('message', "Orden #" . $orden->idtb_ordenes . " creada Satisfactoriamente");

        return Redirect::to('ventas/ordenes');
    }

    public function show($id)
    {
        function formatofecha($fecha)
        {
            if ($fecha != null) {
                setlocale(LC_TIME, "es_ES.UTF-8");

                return $fec = strftime("%A, %d de %B de %Y - %H:%M%p", strtotime($fecha));
            } else {
                return null;
            }

        }

        function consultaasignados($id, $idtipoempleado)
        {
            $vart = DB::table('tb_procesos as pro')
                ->join('users as emp', 'emp.id', '=', 'pro.users_id_asignado')
                ->join('tb_ordenes as ord', 'ord.idtb_ordenes', '=', 'pro.tb_ordenes_idtb_ordenes')
                ->select('pro.idtb_procesos', 'pro.created_at', 'emp.name as asignado', 'emp.name as asignador')
                ->where('ord.condicion', '=', '1')
                ->where('pro.tb_ordenes_idtb_ordenes', '=', $id)
                ->where('pro.tb_descripcion_procesos_idtb_descripcion_procesos', '=', $idtipoempleado)
                ->orderBy('created_at', 'desc')
                ->first();

            if (isset($vart)) {
                $next = Proceso::select('created_at', 'idtb_procesos', 'users_id_asignado')
                    ->where('tb_ordenes_idtb_ordenes', '=', $id)
                    ->where('idtb_procesos', '>=', $vart->idtb_procesos)
                    ->limit('2')
                    ->get();

                $next->finicio = formatofecha($next[0]->created_at);

                if (count($next) >= 2) {

                    $next->calculofechas = diferenciafecha($next[0]->created_at, $next[1]->created_at); //tiempo que se demoro en el proceso
                } else {

                    $next->calculofechas = diferenciafecha($next[0]->created_at, $next[0]->created_at);
                }

                $next->asignado = $vart->asignado;

                return $next;

            } else {

                $next = Proceso::select('created_at', 'idtb_procesos', 'users_id_asignado')
                    ->where('tb_ordenes_idtb_ordenes', '=', $id)
                    ->limit('1')
                    ->get();
                $next->finicio          = '';
                $next[0]->created_at = '';

                $next->calculofechas = '';
                $next->asignado      = 'No asignado';

                return $next;

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
                $respuesta = $respuesta->y . 'a��� ' .$respuesta->m . 'me ' . $respuesta->d . 'd ' . $respuesta->h . 'ho ' . $respuesta->i . 'min ' . $respuesta->s . 'seg';
                return $respuesta;
            }
            return $respuesta;
        }

        $orden = Ordenes::findOrFail($id);

        $orden->fecha_inicio    = formatofecha($orden->fecha_inicio);
        $orden->fecha_entrega   = formatofecha($orden->fecha_entrega);
       

     //   dd($orden->fecha_inicio);

        $cliente = Persona::findOrFail($orden->tb_cliente_idtb_cliente);

        $detalleorden = DB::table('tb_detalle_orden as do')
            ->join('tb_articulo as art', 'art.idtb_articulo', '=', 'do.tb_articulo_idtb_articulo')
            ->select('do.tb_articulo_idtb_articulo', 'do.cantidad', 'do.valor_unitario', 'do.descripcion', 'art.nombre')
            ->where('do.tb_ordenes_idtb_ordenes', '=', $id)
            ->get();

            
        //selecciona el proceso en donde se encuentra la orden
        $procesos1 = DB::table('tb_procesos as pro')
            ->join('users as emp', 'emp.id', '=', 'pro.users_id_asignado')
            ->join('users as usr', 'usr.id', '=', 'pro.users_id_asignador')
            ->join('tb_descripcion_procesos as dpro', 'dpro.idtb_descripcion_procesos', '=', 'pro.tb_descripcion_procesos_idtb_descripcion_procesos')
            ->select('pro.idtb_procesos', 'pro.tb_ordenes_idtb_ordenes', 'pro.created_at', 'emp.name as asignado', 'dpro.descripcion_procesos', 'usr.name as asignador', 'dpro.idtb_descripcion_procesos')
            ->where('pro.tb_ordenes_idtb_ordenes', '=', $id)
            ->where('pro.condicion', '=', '1')
            ->get();
        //dd($procesos1);
        
        $agente = consultaasignados($id, 1); //comprueba que el agente asignado

        $disenador = consultaasignados($id, 5); //comprueba que el diseñador asignado

        $impresor = consultaasignados($id, 12); //comprueba que el impresor asignado

        $artefinalista = consultaasignados($id, 13); //comprueba que el arte finalista asignado

        return view("ventas.ordenes.show", ["artefinalista" => $artefinalista, "impresor" => $impresor, "disenador" => $disenador, "orden" => $orden, "cliente" => $cliente, "detalleorden" => $detalleorden, "agente" => $agente, "procesos1" => $procesos1]);
    }

    public function edit($id)
    {
        return view("ventas.ordenes.edit", ["ordenes" => Ordenes::findOrFail($id)]);
    }

    public function update(OrdenesFormRequest $request, $id)
    {
        $ordenes          = Ordenes::findOrFail($id);
        $ordenes->ordenes = $request->get('ordenes');
        $ordenes->update();

        return Redirect::to('ventas/ordenes');
    }

    public function destroy($id)
    {
        $ordenes            = Ordenes::findOrFail($id);
        $ordenes->condicion = '0';
        $ordenes->update();

        return Redirect::to('ventas/ordenes');

    }
    public function borrarorden($id)
    {
        $ordenes            = Ordenes::findOrFail($id);
        $ordenes->condicion = '0';
        $ordenes->update();

        return Redirect::to('ventas/ordenes');

    }
}
