<?php

namespace Kaypi\Http\Controllers;

use Kaypi\Http\Requests\AgregarProduccionFormRequest;
use Kaypi\Produccion;
use Kaypi\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use DB;
use Illuminate\Support\Facades\Auth;

class ProduccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    { }


    public function store(AgregarProduccionFormRequest $request)
    {

       /* $departamento_usuario = DB::table('tb_tipo_usuario as tipo')
        ->join('tb_departamentos as dep','dep.idtb_departamentos','=','tipo.tb_departamentos_idtb_departamentos')
        ->select('dep.idtb_departamentos')
        ->where('tipo.idtb_tipo_usuario', '=', (Auth::user()->tb_tipo_usuario_idtb_tipo_usuario))
        ->first();*/

        $produccion = new Produccion;
        $mytime                                             = Carbon::now('America/Guayaquil');
        $produccion->fecha                                  = $mytime->toDateTimeString();
        $produccion->users_id                               = Auth::user()->id;

        $produccion->cantidad                               = $request->get('cantidad');
        $produccion->tb_detalle_orden_idtb_detalle_orden    = $request->get('tb_detalle_orden_idtb_detalle_orden');
        $produccion->tb_ordenes_idtb_ordenes                = $request->get('tb_ordenes_idtb_ordenes');
        $produccion->tb_departamentos_idtb_departamentos    = $request->get('tb_departamentos_idtb_departamentos');
        $norden                                             = $request->get('tb_ordenes_idtb_ordenes');
        $produccion->save();

        // dd($norden);
        Session::flash('message', "El Pago por el valor de  " . $produccion->cantidad . " se agrego correctamente");

        return Redirect::to("ventas/procesos/$norden");
    }

    public function show($id)
    { }

    public function edit($id)
    { }
}
