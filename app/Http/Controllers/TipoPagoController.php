<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Kaypi\Http\Requests\TipoPagoFormRequest;
use Kaypi\TipoPago;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class TipoPagoController extends Controller
{
    public function __construct(){
        
        $this->middleware('auth');
        
  }

    public function index (Request $request)
  {
     if ($request)
     {
         $query = trim($request->get('searchText'));

       $tipo_pago=DB::table('tb_tipo_pago as tp')
         ->where('tp.condicion','=','1')
         ->orderBy('idtb_tipo_pago','desc')
         ->get();

        return view('pagos.tipopago.index',["tipo_pago"=>$tipo_pago,"searchText"=>$query]);
     }

  }

  public function create ()
  {
      return view("pagos.tipopago.create");
  }

  public function store (TipoPagoFormRequest $request)
  {
          $tipo_pago                =  new TipoPago;
          $tipo_pago-> tipo_pago    = $request ->get ('tipo_pago');
          $tipo_pago-> condicion    =1;
          $tipo_pago-> save();

          return Redirect::to('pagos/tipopago');
  }

  public function edit ($id)
  {
          return view('pagos.tipopago.edit',["tipo_pago"=>TipoPago::FindOrFail($id)]);
  }

   public function update (TipoPagoFormRequest $request, $id)
  {
        $tipo_pago                = TipoPago::FindOrFail($id);
        $tipo_pago-> tipo_pago    = $request ->get ('tipo_pago');
        $tipo_pago-> condicion    =1;
        $tipo_pago-> update();

        Session::flash('message', "El Tipo de Pago " . $tipo_pago->tipo_pago . " fue Editado");

        return Redirect::to('pagos/tipopago');
  }
  public function destroy ($id)
  {
        $tipo_pago                                              = TipoPago::FindOrFail($id);
        $tipo_pago-> condicion                                  =0;
        $tipo_pago-> update();    

        Session::flash('message', "El Tipo de Pago " . $tipo_pago->tipo_pago . " fue Eliminado");
     
        return Redirect::to('pagos/tipopago');
  }
}
