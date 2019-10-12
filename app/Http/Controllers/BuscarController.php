<?php

namespace Kaypi\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kaypi\Venta;
use Kaypi\DetalleVenta;
use Kaypi\Articulo;
use Kaypi\TipoPago;

class BuscarController extends Controller
{
    public function index(Request $request)
  {
    if ($request) {
      $query = trim($request->get('searchText'));
   
      $persona = DB::table('tb_cliente as cli')
      ->select('cli.idtb_cliente','cli.razon_social')
      ->where('cli.condicion', '=', '1')
      ->where('cli.razon_social', 'LIKE', '%' . $query . '%')
      ->orwhere('cli.nombre_comercial', 'LIKE', '%' . $query . '%')
      ->get(); 

      $personas = DB::table('tb_cliente')
      ->select(DB::raw('CONCAT(cedula_ruc," - ",nombre_comercial)AS cedcliente'), 'idtb_cliente')->get();

        $ventas = DB::table('tb_venta as v')
          ->join('tb_cliente as p', 'v.tb_cliente_idtb_cliente', '=', 'p.idtb_cliente')
          ->join('users as us', 'v.users_id', '=', 'us.id')
          ->select('v.numero','us.id', 'v.idtb_venta', 'v.created_at', 'p.idtb_cliente', 'p.razon_social', 'p.nombre_comercial', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.condicion', 'v.total_venta', 'us.name', 'v.users_id')
          ->where('v.condicion', '=', '1')
          ->where('p.razon_social', 'LIKE', '%' . $query . '%')
          ->orwhere('p.nombre_comercial', 'LIKE', '%' . $query . '%')
          ->orderBy('v.created_at', 'desc')
          ->groupBy('v.idtb_venta', 'v.created_at', 'p.razon_social', 'p.nombre_comercial', 'p.idtb_cliente', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.condicion', 'v.total_venta', 'us.name', 'us.id', 'v.users_id')
          ->paginate(20);
        
          $estado_fact_elec = DB::table('ele_documentos_electronicos as elec')
          ->join('tb_venta as v', 'elec.numero', '=', 'v.numero')
          ->select('elec.estado', 'elec.numero')
          ->where('elec.codigo', '=', 'FV')
          ->orderBy('elec.numero', 'asc')
          ->get();
      //   dd($ventas);

        $tipo_pago = TipoPago::where('condicion', '=', '1')
          ->pluck('tipo_pago', 'idtb_tipo_pago');

        $suma_pagos = DB::table('tb_pagos as pa')
          ->select('pa.tb_venta_idtb_venta', DB::raw('sum(pa.valor) as total'))
          ->groupBy('pa.tb_venta_idtb_venta')
          ->get();

         //dd($suma_pagos);
      $ventas->contador=0;
      $ventas->suma_abonos=0;
      $ventas->total_saldo=0;
      $ventas->cont_fact_pagadas=0;
      $ventas->abonos=0;
      $ventas->total_ventas_impagas=0;

         /* El siguiente foereach suma todos los abonos realizados a cada factura para abtener los PAgos totales realizados en la factura */
        foreach ($ventas as $venta) {
          $venta->abono = 0;
          
          foreach ($suma_pagos as $suma_pago) {
            if ($venta->idtb_venta == $suma_pago->tb_venta_idtb_venta) {
              //suma total de abonos de todas las facturas
                $ventas->suma_abonos += $suma_pago->total;   
              $venta->abono = $suma_pago->total;            
            }
            $venta->saldo = number_format($venta->total_venta - $venta->abono, 2);
           
          }
          //Suma total de Saldo de todas las facturas
          $ventas->total_saldo += $venta->saldo;
          //contador de facturas
          $ventas->contador++;
          //comprueba las facturas PAGADAS y aumenta el contador
          if($venta->abono==$venta->total_venta)
          {
           $ventas->cont_fact_pagadas++;
           $ventas->abonos += $venta->abono; 
           $ventas->total_ventas_impagas -= $venta->total_venta; 
          }
          $ventas->total_ventas_impagas += $venta->total_venta; 
        }

        // dd($ventas);

        $pagos = DB::table('tb_pagos as pa')
        ->join('tb_cliente as cli', 'cli.idtb_cliente', '=', 'pa.tb_cliente_idtb_cliente')
        ->join('tb_tipo_pago as tp', 'tp.idtb_tipo_pago', '=', 'pa.tb_tipo_pago_idtb_tipo_pago')
        ->join('tb_venta as ve', 've.idtb_venta', '=', 'pa.tb_venta_idtb_venta')
        ->select('cli.nombre_comercial', 'tp.tipo_pago', 'pa.notas', 'pa.valor', 'pa.idtb_pagos', 'pa.fecha_pago', 'pa.valor', 'pa.tb_venta_idtb_venta')
        ->where('pa.condicion', '=', '1')
        ->where('cli.razon_social', 'LIKE', '%' . $query . '%')
        ->orwhere('cli.nombre_comercial', 'LIKE', '%' . $query . '%')
        ->orderBy('pa.idtb_pagos', 'desc')
        ->paginate(50);

   
       
      } 
      return view('ventas.venta.buscar', ["estado_fact_elec" => $estado_fact_elec,"pagos"=>$pagos,"ventas" => $ventas, "personas" => $personas,"persona" => $persona, 'suma_pagos' => $suma_pagos, 'tipo_pago' => $tipo_pago, "searchText" => $query]);
    }
  
}
