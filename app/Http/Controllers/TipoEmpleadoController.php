<?php

namespace Kaypi\Http\Controllers;

use DB;
use Kaypi\Departamento;
use Kaypi\Http\Requests\TipoEmpleadoFormRequest;
use Kaypi\TipoEmpleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TipoEmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $tipo_empleado = DB::table('tb_tipo_usuario as tiu')
                ->join('tb_departamentos as dep', 'tiu.tb_departamentos_idtb_departamentos', '=', 'dep.idtb_departamentos')
                ->where('tiu.condicion', '=', '1')
                ->get();

            return view('roles.empleados.index', ["tipo_empleado" => $tipo_empleado, "searchText" => $query]);
        }

    }

    public function create()
    {
        $departamentos = Departamento::where('condicion', '=', '1')->pluck('departamento', 'idtb_departamentos');

        return view('roles.empleados.create', ["departamentos" => $departamentos]);
    }

    public function store(TipoEmpleadoFormRequest $request)
    {
        $tipo_empleado                      = new TipoEmpleado;
        $tipo_empleado->tb_departamentos_idtb_departamentos = $request->get('departamentos');
        $tipo_empleado->nombre      = $request->get('nombre');
        $tipo_empleado->save();

        Session::flash('message', "El tipo de empleado " . $tipo_empleado->tipo_empleados . " fue creado Satisfactoriamente");

        return Redirect::to('roles/empleados');
    }

    public function show($id)
    {
        return view("roles.empleados.show", ["tipo_empleado" => TipoEmpleado::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("roles.empleados.edit", ["tipo_empleado" => TipoEmpleado::findOrFail($id)]);
    }

    public function update(TipoEmpleadoFormRequest $request, $id)
    {
        $tipo_empleado                 = TipoEmpleado::findOrFail($id);
        $tipo_empleado->nombre = $request->get('nombre');
        $tipo_empleado->update();

        Session::flash('message', "El nombre del tipo de empleado " . $tipo_empleado->nombre . " fue Editado");

        return Redirect::to('roles/empleados');

    }

    public function destroy($id)
    {
        $tipo_empleado            = TipoEmpleado::findOrFail($id);
        $tipo_empleado->condicion = '0';
        $tipo_empleado->update();

        Session::flash('message', "El tipo de empleado " . $tipo_empleado->nombre . " fue Eliminado");

        return Redirect::to('roles/empleados');

    }
}
