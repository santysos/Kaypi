<?php

namespace Kaypi\Http\Controllers;

use DB;
use Kaypi\Http\Requests\EditarClienteFormRequest;
use Kaypi\Http\Requests\ClienteFormRequest;
use Kaypi\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query    = trim($request->get('searchText'));
            $personas = DB::table('tb_cliente')
                
                ->orwhere('nombre_comercial', 'LIKE', '%' . $query . '%')
                ->orwhere('razon_social', 'LIKE', '%' . $query . '%')
                ->orwhere('cedula_ruc', 'LIKE', '%' . $query . '%')
                ->where('condicion', '=', '1')
                ->orderBy('idtb_cliente', 'desc')
                ->paginate(50);

            //return Datatables::of(DB::table('tb_cliente'))->make(true);

            return view('ventas.cliente.index', ["personas" => $personas, "searchText" => $query]);
        }

    }

    public function create()
    {
        return view("ventas.cliente.create");
    }

    public function store(ClienteFormRequest $request)
    {
        $persona                           = new Persona;
        
        $persona->nombre_comercial = $request->get('nombre_comercial');
        $persona->razon_social    = $request->get('razon_social');
        $persona->direccion                = $request->get('direccion');
        $persona->ciudad                   = $request->get('ciudad');
        $persona->telefono                 = $request->get('telefono');
        $persona->email                    = $request->get('email');
        $persona->pais                    = $request->get('pais');
        $persona->cedula_ruc               = $request->get('cedula_ruc');
        $persona->condicion                = 1;
        $persona->save();

        Session::flash('message', "El cliente " . $persona->nombre_comercial . " - " . $persona->razon_social . " se creo correctamente");

        return Redirect::to('ventas/venta/create');

    }

    public function show($id)
    {
        return view("ventas.cliente.show", ["persona" => Persona::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("ventas.cliente.edit", ["persona" => Persona::findOrFail($id)]);
    }

    public function update(EditarClienteFormRequest $request, $id)
    {
        $persona                           = Persona::findOrFail($id);
        
        $persona->nombre_comercial = $request->get('nombre_comercial');
        $persona->razon_social    = $request->get('razon_social');
        $persona->direccion                = $request->get('direccion');
        $persona->ciudad                   = $request->get('ciudad');
        $persona->telefono                 = $request->get('telefono');
        $persona->email                    = $request->get('email');
        $persona->pais                    = $request->get('pais');
        $persona->cedula_ruc               = $request->get('cedula_ruc');
        $persona->update();

        Session::flash('message', "Los Datos de " . $persona->nombre_comercial . " - " . $persona->razon_social . " se editaron correctamente");

        return Redirect::to('ventas/cliente');

    }

    public function destroy($id)
    {
        $persona            = Persona::findOrFail($id);
        $persona->condicion = '0';
        $persona->update();

        Session::flash('message', "El cliente " . $persona->nombre_comercial . " fue Eliminado");

        return Redirect::to('ventas/cliente');

    }
}
