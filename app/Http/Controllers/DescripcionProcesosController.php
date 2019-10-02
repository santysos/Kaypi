<?php

namespace Kaypi\Http\Controllers;

use DB;
use Kaypi\Departamento;
use Kaypi\DescripcionProcesos;
use Kaypi\Http\Requests\DescripcionProcesosFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DescripcionProcesosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query   = trim($request->get('searchText'));
            $proceso = DB::table('tb_descripcion_procesos as pro')
                ->join('tb_departamentos as ser', 'pro.tb_departamentos_idtb_departamentos', '=', 'ser.idtb_departamentos')
                ->select('pro.idtb_descripcion_procesos', 'pro.descripcion_procesos', 'pro.tb_departamentos_idtb_departamentos', 'ser.departamento')
                ->where('pro.condicion', '=', '1')
                ->where('pro.tb_departamentos_idtb_departamentos', '!=', '1') //elimina de la busqueda el depoartamento principal
                ->where('pro.descripcion_procesos', 'LIKE', '%' . $query . '%')
                ->where('ser.departamento', 'LIKE', '%' . $query . '%')
                ->orderBy('ser.departamento', 'desc')
                ->paginate(25);

            return view('departamentos.procesos.index', ["proceso" => $proceso, "searchText" => $query]);
        }

    }

    public function create()
    {
        $departamentos = Departamento::where('condicion', '=', '1')->where('idtb_departamentos', '!=', '1')->pluck('Departamento', 'idtb_departamentos');

        return view('departamentos.procesos.create', ["departamentos" => $departamentos]);
    }

    public function store(DescripcionProcesosFormRequest $request)
    {
        $proceso                       = new DescripcionProcesos;
        $proceso->tb_departamentos_idtb_departamentos  = $request->get('idtb_departamentos');
        $proceso->descripcion_procesos = $request->get('descripcion_procesos');
        $proceso->condicion = '1';
        $proceso->save();

        return Redirect::to('departamentos/procesos');
    }

    public function show($id)
    {
        return view("departamentos.procesos.show", ["procesos" => DescripcionProcesos::findOrFail($id)]);
    }

    public function edit($id)
    {
        
        $proceso = DescripcionProcesos::findOrFail($id);
       // dd($proceso);
        $departamento = Departamento::findOrFail($proceso->tb_departamentos_idtb_departamentos);
       

        return view("departamentos.procesos.edit", ["proceso" => $proceso, "departamento" => $departamento]);
    }

    public function update(DescripcionProcesosFormRequest $request, $id)
    {
        $proceso                       = DescripcionProcesos::findOrFail($id);
        $proceso->descripcion_procesos = $request->get('descripcion_procesos');
        $proceso->update();

        Session::flash('message', "El nombre del proceso " . $proceso->descripcion_procesos . " fue Editado");

        return Redirect::to('departamentos/procesos');

    }

    public function destroy($id)
    {

        $proceso            = DescripcionProcesos::findOrFail($id);
        $proceso->condicion = '0';
        $proceso->update();

        Session::flash('message', "El proceso " . $proceso->descripcion_procesos . " fue Eliminado");

        return Redirect::to('departamentos/procesos');

    }
}
