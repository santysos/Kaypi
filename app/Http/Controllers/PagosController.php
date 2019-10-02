<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use DB;
use Kaypi\Http\Requests\PagosFormRequest;
use Kaypi\Http\Requests\EditarPagoFormRequest;
use Kaypi\TipoPago;
use Kaypi\Venta;
use Kaypi\Pagos;
use Kaypi\Persona;

class PagosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query    = trim($request->get('searchText'));

            $pagos = DB::table('tb_pagos as pa')
                ->join('tb_cliente as cli', 'cli.idtb_cliente', '=', 'pa.tb_cliente_idtb_cliente')
                ->join('tb_tipo_pago as tp', 'tp.idtb_tipo_pago', '=', 'pa.tb_tipo_pago_idtb_tipo_pago')
                ->join('tb_venta as ve', 've.idtb_venta', '=', 'pa.tb_venta_idtb_venta')
                ->select('cli.nombre_comercial', 'tp.tipo_pago', 'pa.notas', 'pa.valor', 'pa.idtb_pagos', 'pa.fecha_pago', 'pa.valor', 'pa.tb_venta_idtb_venta')
                ->where('pa.condicion', '=', '1')
                ->where('pa.tb_venta_idtb_venta', 'like', '%' . $query . '%')
                ->orderBy('pa.idtb_pagos', 'desc')
                ->paginate(50);

            $suma_pagos = DB::table('tb_pagos as pa')
                ->select('pa.tb_venta_idtb_venta', DB::raw('sum(pa.valor) as total'))
                ->groupBy('pa.tb_venta_idtb_venta')
                ->get();

            //  dd($suma_pagos);

            return view('pagos.pago.index', ["pagos" => $pagos, 'suma_pagos' => $suma_pagos, "searchText" => $query]);
        }
    }

    public function create()
    {
        $tipo_pago = TipoPago::where('condicion', '=', '1')
            ->pluck('tipo_pago', 'idtb_tipo_pago');

        return view("pagos.pago.create", compact('tipo_pago'));
    }

    public function store(PagosFormRequest $request)
    {
        $pago = new Pagos;

        $formatoBDD                             = date("Y-m-d H:i:s", strtotime($request->get('fecha_pago')));
        $pago->fecha_pago                       = $formatoBDD;
        $pago->notas                            = $request->get('notas');
        $pago->valor                            = $request->get('valor');
        $pago->tb_tipo_pago_idtb_tipo_pago      = $request->get('tipo_pago');
        $pago->tb_cliente_idtb_cliente          = $request->get('tb_cliente_idtb_cliente');
        $pago->tb_venta_idtb_venta              = $request->get('tb_venta_idtb_venta');
        $pago->condicion                        = 1;
        $pago->save();

        Session::flash('message', "El Pago por el valor de  " . $pago->valor . " se agrego correctamente");

        return Redirect::to('pagos/pago');
    }

    public function show($id)
    {
        $pagos = DB::table('tb_pagos as pa')
            ->join('tb_cliente as cli', 'cli.idtb_cliente', '=', 'pa.tb_cliente_idtb_cliente')
            ->join('tb_tipo_pago as tp', 'tp.idtb_tipo_pago', '=', 'pa.tb_tipo_pago_idtb_tipo_pago')
            ->join('tb_venta as ve', 've.idtb_venta', '=', 'pa.tb_venta_idtb_venta')
            ->select('cli.nombre_comercial', 'tp.tipo_pago', 'pa.notas', 'pa.valor', 'pa.idtb_pagos', 'pa.fecha_pago', 'pa.valor', 'pa.tb_venta_idtb_venta')
            ->where('pa.condicion', '=', '1')
            ->where('pa.tb_venta_idtb_venta', '=', $id)
            ->orderBy('pa.tb_venta_idtb_venta', 'desc')
            ->paginate(50);

        $suma_pagos = DB::table('tb_pagos as pa')
            ->select('pa.tb_venta_idtb_venta', DB::raw('sum(pa.valor) as total'))
            ->where('pa.tb_venta_idtb_venta', '=', $id)
            ->groupBy('pa.tb_venta_idtb_venta')
            ->get();
        //dd($pagos);

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
        return view("pagos.pago.show", ["venta" => $venta, "detalles" => $detalles, "pagos" => $pagos, "suma_pagos" => $suma_pagos]);
    }

    public function edit($id)
    {
        $tipo_pago = TipoPago::where('condicion', '=', '1')
            ->pluck('tipo_pago', 'idtb_tipo_pago');
        $pago = Pagos::findOrFail($id);
        $cliente = Persona::findOrFail($pago->tb_cliente_idtb_cliente);
        $venta = Venta::findOrFail($pago->tb_venta_idtb_venta);

        return view("pagos.pago.edit", ["pago" => $pago, 'tipo_pago' => $tipo_pago, 'persona' => $cliente, 'venta' => $venta]);
    }

    public function update(EditarPagoFormRequest $request, $id)
    {
        $pago                                   = Pagos::findOrFail($id);
        $formatoBDD                             = date("Y-m-d H:i:s", strtotime($request->get('fecha_pago')));
        $pago->fecha_pago                       = $formatoBDD;
        $pago->notas                            = $request->get('notas');
        $pago->valor                            = $request->get('valor');
        $pago->tb_tipo_pago_idtb_tipo_pago      = $request->get('tipo_pago');
        $pago->tb_cliente_idtb_cliente          = $request->get('tb_cliente_idtb_cliente');
        $pago->tb_venta_idtb_venta              = $request->get('tb_venta_idtb_venta');
        $pago->condicion                        = 1;
        $pago->update();

        Session::flash('message', "El pago #" . $pago->idtb_pagos  . " se editó correctamente");

        return Redirect::to('pagos/pago');
    }

    public function destroy($id)
    {
        $pago            = Pagos::findOrFail($id);
        $pago->condicion = '0';
        $pago->update();

        Session::flash('message', "El pago #" . $pago->idtb_pagos . " fue Eliminado");

        return Redirect::to('pagos/pago');
    }
}
