<?php

namespace Kaypi\Http\Controllers;

use DB;
use Kaypi\Http\Requests\EditarProveedorFormRequest;
use Kaypi\Http\Requests\ProveedorFormRequest;
use Kaypi\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query    = trim($request->get('searchText'));
            $personas = DB::table('tb_proveedor')
                
                ->orwhere('nombre_comercial', 'LIKE', '%' . $query . '%')
                ->orwhere('razon_social', 'LIKE', '%' . $query . '%')
                ->orwhere('cedula_ruc', 'LIKE', '%' . $query . '%')
                ->where('condicion', '=', '1')
                ->orderBy('idtb_proveedor', 'desc')
                ->paginate(50);

            //return Datatables::of(DB::table('tb_proveedor'))->make(true);

            return view('compras.proveedor.index', ["personas" => $personas, "searchText" => $query]);
        }

    }

    public function create()
    {
        return view("compras.proveedor.create");
    }

    public function store(ProveedorFormRequest $request)
    {
        $persona                           = new Proveedor;
        
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

        Session::flash('message', "El proveedor " . $persona->nombre_comercial . " - " . $persona->razon_social . " se creo correctamente");

        return Redirect::to('compras/proveedor/create');

    }

    public function show($id)
    {
        return view("compras.proveedor.show", ["persona" => Proveedor::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view("compras.proveedor.edit", ["persona" => Proveedor::findOrFail($id)]);
    }

    public function update(EditarProveedorFormRequest $request, $id)
    {
        $persona                           = Proveedor::findOrFail($id);
        
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

        return Redirect::to('compras/proveedor');

    }

    public function destroy($id)
    {
        $persona            = Proveedor::findOrFail($id);
        $persona->condicion = '0';
        $persona->update();

        Session::flash('message', "El proveedor " . $persona->nombre_comercial . " fue Eliminado");

        return Redirect::to('compras/proveedor');

    }
}
