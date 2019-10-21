<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use Kaypi\Articulo;

class PruebasController extends Controller
{
    public function getArticulos(Request $request)
  {
    if ($request->ajax()) {
        $query = trim($request->get('q'));

      return Articulo::where('nombre', 'LIKE', '%' . $query . '%')->paginate(10);
    }
  }
  public function index(Request $request)
  {
    if ($request) {
      $query = trim($request->get('searchText'));

      return view('pruebas.index', [ "searchText" => $query]);
    }
  }
}
