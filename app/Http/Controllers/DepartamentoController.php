<?php

namespace Kaypi\Http\Controllers;

use DB;
use Kaypi\Departamento;
use Kaypi\Http\Requests\DepartamentoFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;



class DepartamentoController extends Controller
{    
    
    /*
    |--------------------------------------------------------------------------
    | Departamento Controller
    |--------------------------------------------------------------------------
    |   Este controlador es responsable de listar, crear, editar y borrar los datos de la tabla tb_departamentos
    |   
    |   Gestiona los datos a traves de los diferentes metodos descritos a continuación: 
    | 
    |
    */


    public function __construct()
    {
        $this->middleware('auth');
    }
    /*
    |--------------------------------------------------------------------------
    |   Metodo Index
    |--------------------------------------------------------------------------
    |   Realiza una busqueda en la tabla departamentos y seleciona el 'id' y el 'departamento' 
    |   con un condicional que contenga lo ingresado por teclado
    |   mientras la condicion sea = 1
    |   pagina el resultado en grupos de 10
    |
    |
    */  
    public function index(Request $request)
    {
        if ($request) {
            $query        = trim($request->get('searchText'));
            $departamento = DB::table('tb_departamentos')
                ->select('idtb_departamentos', 'departamento')
                ->where('departamento', 'LIKE', '%' . $query . '%')
                ->where('condicion', '=', '1')
                ->paginate(10);

            return view('departamentos.departamento.index', ["departamento" => $departamento, "searchText" => $query]);
        }

    }

    public function create()
    {
        return view("departamentos.departamento.create");
    }

    public function store(DepartamentoFormRequest $request)
    {
        $departamento                = new Departamento;
        $departamento->departamento = $request->get('departamento');
        $departamento->condicion = 1;
        $departamento->save();

        return Redirect::to('departamentos/departamento');
    }

    public function show($id)
    {
        return view("departamentos.departamento.show", ["departamento" => Departamento::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("departamentos.departamento.edit", ["departamento" => Departamento::findOrFail($id)]);
    }

    public function update(DepartamentoFormRequest $request, $id)
    {
        $departamento                = Departamento::findOrFail($id);
        $departamento->departamento = $request->get('departamento');
        $departamento->update();

        Session::flash('message', "El nombre del departamento " . $departamento->departamento . " fue Editado");

        return Redirect::to('departamentos/departamento');

    }

    public function destroy($id)
    {
        $departamento            = Departamento::findOrFail($id);
        $departamento->condicion = '0';
        $departamento->update();

        Session::flash('message', "El departamento " . $departamento->departamento . " fue Eliminado");

        return Redirect::to('departamentos/departamento');

    }
}
