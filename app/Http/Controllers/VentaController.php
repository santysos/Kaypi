<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use Kaypi\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Kaypi\Http\Requests\VentaFormRequest;
use Kaypi\Http\Requests\CambiarClienteFormRequest;
use Kaypi\Venta;
use Kaypi\DetalleVenta;
use Kaypi\Articulo;
use Kaypi\TipoPago;
use DB;
use Kaypi\User;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Kaypi\Pagos;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getPrecios(Request $request, $id)
  {
    if ($request->ajax()) {
      $precios = Articulo::dprecios($id);
      return response()->json($precios);
    }
  }
  public function getPagos(Request $request, $id)
  {
    if ($request->ajax()) {
      $pagos = Pagos::dpagos($id);
      return response()->json($pagos);
    }
  }

  public function getNumComprobante(Request $request, $id)
  {
    if ($request->ajax()) {
      $numComp = Venta::dnumComp($id);

      return response()->json($numComp);
    }
  }



  public function index(Request $request)
  {
    if ($request) {
      $query = trim($request->get('searchText'));
      //comprueba que sea el usuario administrador
      if (Auth::user()->tb_tipo_usuario_idtb_tipo_usuario == 1) {

        $ventas = DB::table('tb_venta as v')
          ->join('tb_cliente as p', 'v.tb_cliente_idtb_cliente', '=', 'p.idtb_cliente')
          ->join('users as us', 'v.users_id', '=', 'us.id')
          ->select('v.numero','us.id', 'v.idtb_venta', 'v.created_at', 'p.idtb_cliente', 'p.razon_social', 'p.nombre_comercial', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.condicion', 'v.total_venta', 'us.name', 'v.users_id')
          ->where('v.condicion', '=', '1')
          ->where('v.num_comprobante', 'LIKE', '%' . $query . '%')
          ->orwhere('p.nombre_comercial', 'LIKE', '%' . $query . '%')
          ->orderBy('v.created_at', 'desc')
          ->groupBy('v.idtb_venta', 'v.created_at', 'p.razon_social', 'p.nombre_comercial', 'p.idtb_cliente', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.condicion', 'v.total_venta', 'us.name', 'us.id', 'v.users_id')
          ->paginate(20);

        $estado_fact_elec = DB::table('ele_documentos_electronicos as elec')
        ->join('tb_venta as v','elec.numero','=','v.numero')
        ->select('elec.estado','elec.numero')
        ->where('elec.codigo','=','FV')
        ->orderBy('elec.id','asc')
        ->get();  

       // dd($ventas);
        foreach($estado_fact_elec as $fact_elec)
        {
        foreach ($ventas as $venta) 
          {
            if($venta->numero==$fact_elec->numero)
            {
              $venta->estado = $fact_elec->estado;
            }elseif($venta->numero ==""||$venta->numero =="0")
            {
              $venta->estado = "NO ENVIADO";
            }
          }
        }

    //   dd($ventas);

        $tipo_pago = TipoPago::where('condicion', '=', '1')
          ->pluck('tipo_pago', 'idtb_tipo_pago');

        $suma_pagos = DB::table('tb_pagos as pa')
          ->select('pa.tb_venta_idtb_venta', DB::raw('sum(pa.valor) as total'))
          ->groupBy('pa.tb_venta_idtb_venta')
          ->get();
        /* El siguiente foereach suma todos los abonos realizados a cada factura para abtener los PAgos totales realizados en la factura */
        foreach ($ventas as $venta) {
          $venta->abono = 0;
          foreach ($suma_pagos as $suma_pago) {
            if ($venta->idtb_venta == $suma_pago->tb_venta_idtb_venta) {
              $venta->abono = $suma_pago->total;
              // dd((double)($venta->abono));
            }
            $venta->saldo = number_format($venta->total_venta - $venta->abono, 2);
          }
        }

        // dd($ventas);
        $personas = DB::table('tb_cliente')
          ->select(DB::raw('CONCAT(cedula_ruc," - ",nombre_comercial)AS cedcliente'), 'idtb_cliente')->get();
      } //para los usuarios que no son ADMINISTRADORES
      else {
        $ventas = DB::table('tb_venta as v')
          ->join('tb_cliente as p', 'v.tb_cliente_idtb_cliente', '=', 'p.idtb_cliente')
          ->join('users as us', 'v.users_id', '=', 'us.id')
          ->select('us.id', 'v.idtb_venta', 'v.created_at', 'p.idtb_cliente', 'p.razon_social', 'p.nombre_comercial', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.condicion', 'v.total_venta', 'us.name', 'v.users_id')
          ->where('v.condicion', '=', '1')
          ->where('v.sucursal', '=', Auth::user()->sucursal)
          ->where('p.nombre_comercial', 'LIKE', '%' . $query . '%')
          ->orderBy('v.created_at', 'desc')
          ->groupBy('v.idtb_venta', 'v.created_at', 'p.razon_social', 'p.nombre_comercial', 'p.idtb_cliente', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.condicion', 'v.total_venta', 'us.name', 'us.id', 'v.users_id')
          ->paginate(20);

        $tipo_pago = TipoPago::where('condicion', '=', '1')
          ->pluck('tipo_pago', 'idtb_tipo_pago');

        $suma_pagos = DB::table('tb_pagos as pa')
          ->select('pa.tb_venta_idtb_venta', DB::raw('sum(pa.valor) as total'))
          ->groupBy('pa.tb_venta_idtb_venta')
          ->get();

        foreach ($ventas as $venta) {
          $venta->abono = 0;
          foreach ($suma_pagos as $suma_pago) {
            if ($venta->idtb_venta == $suma_pago->tb_venta_idtb_venta) {
              $venta->abono = $suma_pago->total;
            }
            $venta->saldo = number_format($venta->total_venta - $venta->abono, 2);
          }
        }
        $personas = DB::table('tb_cliente')
          ->select(DB::raw('CONCAT(cedula_ruc," - ",nombre_comercial)AS cedcliente'), 'idtb_cliente')->get();
      }

      return view('ventas.venta.index', ["ventas" => $ventas, "personas" => $personas, 'suma_pagos' => $suma_pagos, 'tipo_pago' => $tipo_pago, "searchText" => $query]);
    }
  }
  public function create()
  {
    if (Auth::user()->tb_tipo_usuario_idtb_tipo_usuario == 1) {
      $personas = DB::table('tb_cliente')
        ->select(DB::raw('CONCAT(razon_social," - ",cedula_ruc)AS cedcliente'), 'idtb_cliente')
        ->get(); //para que el preveedor tambien sea cliente eliminar el where
      $articulos = DB::table('tb_articulo as art')
        ->select(DB::raw('CONCAT("COD: ",art.codigo," - ",art.nombre)AS articulo'), 'art.idtb_articulo', 'art.stock', 'art.pvp', 'art.iva')
        /*->select(DB::raw('CONCAT("COD: ",art.codigo," - ",art.nombre)AS articulo'),'art.idarticulo','art.stock', DB::raw('avg(di.precio_venta) as precio_promedio'))*/
        //esta calculando el precio promedio de todos los precios de venta ingresados, si si desea se puede calcular el precio de venta con el ultimo precio de compra. cambiando la consulta DB
        ->where('art.condicion', '=', '1')
        //->where('art.stock','>','0')
        ->groupBy('articulo', 'art.idtb_articulo', 'art.stock', 'art.pvp', 'art.iva')
        ->get();
    } else {
      $personas = DB::table('tb_cliente')
        ->select(DB::raw('CONCAT(razon_social," - ",cedula_ruc)AS cedcliente'), 'idtb_cliente')
        ->get(); //para que el preveedor tambien sea cliente eliminar el where
      $articulos = DB::table('tb_articulo as art')
        ->select(DB::raw('CONCAT("COD: ",art.codigo," - ",art.nombre)AS articulo'), 'art.idtb_articulo', 'art.stock', 'art.pvp', 'art.iva')
        /*->select(DB::raw('CONCAT("COD: ",art.codigo," - ",art.nombre)AS articulo'),'art.idarticulo','art.stock', DB::raw('avg(di.precio_venta) as precio_promedio'))*/
        //esta calculando el precio promedio de todos los precios de venta ingresados, si si desea se puede calcular el precio de venta con el ultimo precio de compra. cambiando la consulta DB
        ->where('art.condicion', '=', '1')
        ->where('art.sucursal', '=', Auth::user()->sucursal)
        //->where('art.stock','>','0')
        ->groupBy('articulo', 'art.idtb_articulo', 'art.stock', 'art.pvp', 'art.iva')
        ->get();
    }

    return view("ventas.venta.create", ["personas" => $personas, "articulos" => $articulos]);
  }

  public function store(VentaFormRequest $request)
  {
    function numero_completo_retencion($est, $pemi, $num)
    {
      $num_9 = str_pad($num, 9, "0", STR_PAD_LEFT);

      return $est . $pemi . $num_9;
    }
    $establecimiento_emisor = "002"; //establecimiento ingresado manualmente
    $punto_emision_emisor = "002"; //punto de emision ingresado manualmente
    try {
      DB::beginTransaction();
      $venta = new Venta;
      $venta->tb_cliente_idtb_cliente = $request->get('tb_cliente_idtb_cliente');
      $venta->users_id = $request->get('users_id');
      $venta->tipo_comprobante = $request->get('tipo_comprobante');
      //$venta->serie_comprobante=$request->get('serie_comprobante');

      //comprueba la sucursal por usuario
      if (Auth::user()->sucursal == 1) {
        //busca el ultimo numero del comprobante
        $num_comprobante = Venta::select('num_comprobante')
          ->where('sucursal', '=', "1")
          ->orderBy('num_comprobante', 'desc')
          ->first();
        //aumenta en 11 el ultimo numero de comprobante
        $venta->num_comprobante = $num_comprobante->num_comprobante + 1;
        // completa los 9 digitos del comprobante y agrega el num_establecimiento y el punto de venta del emisor
        $venta->numero = numero_completo_retencion($establecimiento_emisor, $punto_emision_emisor, $venta->num_comprobante);
      } 
      else {
        $venta->num_comprobante = $request->get('num_comprobante');
        $venta->numero = 0;
      }

      $venta->total_venta = $request->get('total_venta');
      $venta->sub_total_0 = $request->get('sub_total_0');
      $venta->sub_total_12 = $request->get('sub_total_12');
      $venta->forma_de_pago = $request->get('forma_de_pago');
      $venta->sucursal = $request->get('sucursal');

      $mytime = Carbon::now('America/Guayaquil');
      $venta->created_at  = $mytime->toDateTimeString();
      $venta->impuesto    = '12';
      $venta->condicion   = 1;
      $venta->save();

      $idarticulo = $request->get('idarticulo');
      $cantidad = $request->get('cantidad');
      $descuento = $request->get('descuento');
      $precio_venta = $request->get('precio_venta');

      $cont = 0;

      while ($cont < count($idarticulo)) {
        $detalle = new DetalleVenta();
        $detalle->tb_venta_idtb_venta           = $venta->idtb_venta;
        $detalle->tb_articulo_idtb_articulo     = $idarticulo[$cont];
        $detalle->cantidad                      = $cantidad[$cont];
        $detalle->descuento                     = $descuento[$cont];
        $detalle->precio_venta                  = $precio_venta[$cont];
        $detalle->save();

        $cont = $cont + 1;
      }

      DB::commit();
    } catch (\Exception $e) {
      DB::rollback();
    }

    return Redirect::to('ventas/venta');
  }
  public function show($id)
  {
    $venta = DB::table('tb_venta as v')
      ->join('tb_cliente as p', 'v.tb_cliente_idtb_cliente', '=', 'p.idtb_cliente')
      ->join('tb_detalle_venta as dv', 'v.idtb_venta', '=', 'dv.tb_venta_idtb_venta')
      ->select('v.idtb_venta', 'v.created_at', 'p.nombre_comercial', 'p.direccion', 'p.telefono', 'p.cedula_ruc', 'p.email', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.condicion', 'v.total_venta', 'v.sub_total_0', 'v.sub_total_12')
      ->where('v.idtb_venta', '=', $id)
      ->first();

    $detalles = DB::table('tb_detalle_venta as d')
      ->join('tb_articulo as a', 'd.tb_articulo_idtb_articulo', '=', 'a.idtb_articulo')
      ->select('a.nombre as articulo', 'd.cantidad', 'd.descuento', 'd.precio_venta', 'a.iva')
      ->where('d.tb_venta_idtb_venta', '=', $id)
      ->get();

    return view("ventas.venta.show", ["venta" => $venta, "detalles" => $detalles]);
  }

  public function update(CambiarClienteFormRequest $request, $id)
  {
    $venta = Venta::findOrFail($id);
    $venta->tb_cliente_idtb_cliente      =     $request->get('idtb_cliente');
    $venta->update();
    return Redirect::to('ventas/venta');
  }


  public function destroy($id)
  { /*
    //codigo para eliminar definitivamente de la base de datos
    $detalleventa = DB::table('detalle_venta')->where('idtb_venta', '=', $id)->delete();
    $venta = DB::table('venta')->where('idtb_venta', '=', $id)->delete();
    */
    $venta = Venta::findOrFail($id);
    $venta->condicion = 0;
    $venta->update();

    $detalleventa = DB::table('tb_detalle_venta as dv')
      ->select('dv.tb_venta_idtb_venta', 'dv.tb_articulo_idtb_articulo', 'dv.cantidad')
      ->where('dv.tb_venta_idtb_venta', '=', $venta->idtb_venta)
      ->get();
    // dd($detalleventa);

    foreach ($detalleventa as $detve) {
      $articulo = Articulo::findOrFail($detve->tb_articulo_idtb_articulo);
      $articulo->stock +=  $detve->cantidad;
      $articulo->update();
    }



    return Redirect::to('ventas/venta');
  }

  public function reportec($id)
  {

    $pdf = app('FPDF');
    //Obtengo los datos

    $venta = DB::table('tb_venta as v')
      ->join('tb_cliente as p', 'v.tb_cliente_idtb_cliente', '=', 'p.idtb_cliente')
      ->join('tb_detalle_venta as dv', 'v.idtb_venta', '=', 'dv.tb_venta_idtb_venta')
      ->select('v.idtb_venta', 'v.created_at', 'p.nombre_comercial', 'p.direccion', 'p.telefono', 'p.cedula_ruc', 'p.email', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.condicion', 'v.total_venta', 'v.sub_total_0', 'v.sub_total_12')
      ->where('v.idtb_venta', '=', $id)
      ->first();

    $detalles = DB::table('tb_detalle_venta as d')
      ->join('tb_articulo as a', 'd.tb_articulo_idtb_articulo', '=', 'a.idtb_articulo')
      ->select('a.nombre as articulo', 'd.cantidad', 'd.descuento', 'd.precio_venta', 'a.iva')
      ->where('d.tb_venta_idtb_venta', '=', $id)
      ->get();


    //Fpdf = new Fpdf('P','LETTER');
    $pdf->AddPage('P', 'LEGAL');
    $pdf->SetFont('Arial', 'B', 14);
    //Inicio con el reporte
    /*$pdf->SetXY(20,20);
       $pdf->Cell(0,0,utf8_decode($venta->tipo_comprobante));
       $pdf->SetXY(120,20);
       $pdf->Cell(0,0,utf8_decode($venta->tipo_comprobante));*/

    /*  $pdf->SetFont('Arial','B',22);
       //Inicio con el reporte
       $pdf->SetXY(170,40);
       $pdf->Cell(0,0,utf8_decode($venta->serie_comprobante."".$venta->num_comprobante));*/


    //****Datos COMPRADOR
    //***Parte Derecha
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(23, 25);
    $pdf->Cell(0, 0, utf8_decode($venta->nombre_comercial));
    $pdf->SetXY(23, 29);
    $pdf->Cell(0, 0, utf8_decode($venta->direccion));


    //***Parte Central
    $pdf->SetXY(120, 25);
    $pdf->Cell(0, 0, utf8_decode($venta->telefono));
    $pdf->SetXY(120, 29);
    $pdf->Cell(0, 0, utf8_decode($venta->cedula_ruc));


    //***Parte Derecha
    $pdf->SetXY(175, 25);
    $pdf->Cell(0, 0, substr($venta->created_at, 0, 10));




    //*********Datos COMPRADOR COPIA
    //***Parte Derecha
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(23, 171);
    $pdf->Cell(0, 0, utf8_decode($venta->nombre_comercial));
    $pdf->SetXY(23, 175);
    $pdf->Cell(0, 0, utf8_decode($venta->direccion));


    //***Parte Central
    $pdf->SetXY(120, 171);
    $pdf->Cell(0, 0, utf8_decode($venta->telefono));
    $pdf->SetXY(120, 175);
    $pdf->Cell(0, 0, utf8_decode($venta->cedula_ruc));


    //***Parte Derecha
    $pdf->SetXY(175, 171);
    $pdf->Cell(0, 0, substr($venta->created_at, 0, 10));





    $total = 0;

    //****Mostramos los detalles ORIGINAL
    $y = 39;
    foreach ($detalles as $det) {
      //comprobamos los articulos con iva
      if ($det->iva == 1) {
        $pdf->SetXY(9, $y);
        $pdf->MultiCell(40, 0, $det->cantidad);

        $pdf->SetXY(24, $y);
        $pdf->MultiCell(120, 0, utf8_decode($det->articulo));

        $pdf->SetXY(170, $y);
        $pdf->MultiCell(25, 0, sprintf("%0.2F", ((($det->precio_venta / (($venta->impuesto / 100) + 1)) - $det->descuento))));

        $pdf->SetXY(187, $y);
        $pdf->MultiCell(25, 0, sprintf("%0.2F", ((($det->precio_venta / (($venta->impuesto / 100) + 1)) - $det->descuento) * $det->cantidad)));

        $pdf->SetXY(197, $y);
        $pdf->MultiCell(25, 0, utf8_decode("*"));
      } else {
        $pdf->SetXY(9, $y);
        $pdf->MultiCell(40, 0, $det->cantidad);

        $pdf->SetXY(24, $y);
        $pdf->MultiCell(120, 0, utf8_decode($det->articulo));

        $pdf->SetXY(170, $y);
        $pdf->MultiCell(25, 0, sprintf("%0.2F", ((($det->precio_venta  - $det->descuento)))));

        $pdf->SetXY(187, $y);
        $pdf->MultiCell(25, 0, sprintf("%0.2F", ((($det->precio_venta - $det->descuento) * $det->cantidad))));

        $pdf->SetXY(197, $y);
        $pdf->MultiCell(25, 0, utf8_decode(""));
      }

      // $total=$total+(($det->precio_venta-$det->descuento) *$det->cantidad);
      $y = $y + 4;
    }



    //****Mostramos los detalles COPIA
    $y = 185;
    foreach ($detalles as $det) {
      //comprobamos los articulos con iva
      if ($det->iva == 1) {
        $pdf->SetXY(9, $y);
        $pdf->MultiCell(40, 0, $det->cantidad);

        $pdf->SetXY(23, $y);
        $pdf->MultiCell(120, 0, utf8_decode($det->articulo));

        $pdf->SetXY(169, $y);
        $pdf->MultiCell(25, 0, sprintf("%0.2F", ((($det->precio_venta / (($venta->impuesto / 100) + 1)) - $det->descuento))));

        $pdf->SetXY(187, $y);
        $pdf->MultiCell(25, 0, sprintf("%0.2F", ((($det->precio_venta / (($venta->impuesto / 100) + 1)) - $det->descuento) * $det->cantidad)));

        $pdf->SetXY(197, $y);
        $pdf->MultiCell(25, 0, utf8_decode("*"));
      } else {
        $pdf->SetXY(9, $y);
        $pdf->MultiCell(40, 0, $det->cantidad);

        $pdf->SetXY(23, $y);
        $pdf->MultiCell(120, 0, utf8_decode($det->articulo));

        $pdf->SetXY(169, $y);
        $pdf->MultiCell(25, 0, sprintf("%0.2F", ((($det->precio_venta  - $det->descuento)))));

        $pdf->SetXY(187, $y);
        $pdf->MultiCell(25, 0, sprintf("%0.2F", ((($det->precio_venta - $det->descuento) * $det->cantidad))));

        $pdf->SetXY(197, $y);
        $pdf->MultiCell(25, 0, utf8_decode(""));
      }

      // $total=$total+(($det->precio_venta-$det->descuento) *$det->cantidad);
      $y = $y + 4;
    }
    //--------------------------FORMA DE PAGO
    //-------------------------original
    //$pdf->SetXY(35,121);
    // $pdf->Cell(0,0,utf8_decode($venta->fdpago));
    //--------------------------valor forma de pago
    $pdf->SetXY(25, 137);
    $pdf->MultiCell(20, 0, "$. " . sprintf("%0.2F", $venta->total_venta));
    //-----------------------------COPIA
    //$pdf->SetXY(35,266);
    //$pdf->Cell(0,0,utf8_decode($venta->fdpago));
    //--------------------------valor forma de pago
    $pdf->SetXY(25, 282);
    $pdf->MultiCell(20, 0, "$. " . sprintf("%0.2F", $venta->total_venta));



    //------------------TOTALES
    $pdf->SetXY(184, 129);
    $pdf->MultiCell(20, 0, "$. " . sprintf("%0.2F", $venta->sub_total_0));
    $pdf->SetXY(184, 134);
    $pdf->MultiCell(20, 0, "$. " . sprintf("%0.2F", $venta->sub_total_12 / (1 + ($venta->impuesto / 100))));
    $pdf->SetXY(184, 139);
    $pdf->MultiCell(20, 0, "$. " . sprintf("%0.2F", $venta->sub_total_12 / (1 + ($venta->impuesto / 100)) * ($venta->impuesto / 100)));
    $pdf->SetXY(184, 144);
    $pdf->MultiCell(20, 0, "$. " . sprintf("%0.2F", $venta->total_venta));


    //------------------TOTALES-----------COPIA
    $pdf->SetXY(184, 275);
    $pdf->MultiCell(20, 0, "$. " . sprintf("%0.2F", $venta->sub_total_0));
    $pdf->SetXY(184, 280);
    $pdf->MultiCell(20, 0, "$. " . sprintf("%0.2F", $venta->sub_total_12 / (1 + ($venta->impuesto / 100))));
    $pdf->SetXY(184, 285);
    $pdf->MultiCell(20, 0, "$. " . sprintf("%0.2F", $venta->sub_total_12 / (1 + ($venta->impuesto / 100)) * ($venta->impuesto / 100)));
    $pdf->SetXY(184, 290);
    $pdf->MultiCell(20, 0, "$. " . sprintf("%0.2F", $venta->total_venta));

    $pdf->Output();
    exit;
  }
}
