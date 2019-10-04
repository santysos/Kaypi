<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Kaypi\Retencion;
use Kaypi\Proveedor;
use Kaypi\Impuestos;
use Kaypi\Http\Requests\RetencionFormRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Kaypi\DetalleRetencion;

class RetencionController extends Controller
{

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));

            $retenciones = Db::table('v_ele_retenciones')
                ->where('secuencial', 'LIKE', '%' . $query . '%')
                ->orwhere('razon_social', 'LIKE', '%' . $query . '%')
                ->orderBy('secuencial', 'desc')
                ->paginate(20);

            // dd($retenciones);

            return view('compras.retenciones.index', ['retenciones' => $retenciones, "searchText" => $query]);
        }
    }
    public function getProveedor(Request $request, $id)
    {
        if ($request->ajax()) {
            $clientes = Proveedor::BuscarProveedor($id);
            return response()->json($clientes);
        }
    }
    public function getImpuestos(Request $request, $id)
    {
        if ($request->ajax()) {
            $impuestos = Impuestos::impuestos_sri($id);

            return response()->json($impuestos);
        }
    }

    public function create()
    {
        $ultimo_num_retencion = Retencion::pluck('secuencial')->last();

        return view('compras.retenciones.create', compact('ultimo_num_retencion'));
    }
    public function store(RetencionFormRequest $request)
    {
        $establecimiento = "002";
        $punto_emision = "002";
        try {

            DB::beginTransaction();

            $retencion                = new Retencion;
            $retencion->codigo = "RET";
            $retencion->codigo_documento = "07";
            $retencion->direccion_establecimiento = $request->get('direccion_establecimiento');
            $retencion->documento = $request->get('documento');
            $retencion->establecimiento = $establecimiento;
            $retencion->punto_emision = $punto_emision;
            $retencion->fecha = $request->get('fecha');
            $retencion->id_contribuyente = 1;
            $numero_comprobante = $request->get('numero');

            $secuencial = $request->get('secuencial');
            $secuencial = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
            $retencion->secuencial = $secuencial;
            $retencion->numero = $establecimiento . $punto_emision . $secuencial;

            $mes_retencion = date("m", strtotime($retencion->fecha));
            $anio_retencion = date("Y", strtotime($retencion->fecha));
            $retencion->periodo_fiscal = $mes_retencion . "/" . $anio_retencion;

            $retencion->razon_social = $request->get('razon_social');
            $retencion->tipo_documento = "04";


            //en las siguientes variables se guardan los arreglos del detalle de cada producto.
            $idimpuesto              = $request->get('id_impuesto');
            $idporcentaje            = $request->get('id_porcentaje');
            $idporcentaje_valor      = $request->get('id_porcentaje_valor');
            $base_imponible          = $request->get('id_base_imponible');


            $cont = 0;

            while ($cont < count($idimpuesto)) {
                $detalle                                                        = new DetalleRetencion();
                $detalle->base_imponible               = $base_imponible[$cont];
                $detalle->codigo                       = "RET";
                $detalle->codigo_sri                   = $idporcentaje[$cont];
                $detalle->fecha_comprobante            = $retencion->fecha;
                $detalle->numero                       = $retencion->numero;
                $detalle->numero_comprobante           = $numero_comprobante;
                $detalle->porcentaje                   = $idporcentaje_valor[$cont];
                $detalle->tipo                         = $idimpuesto[$cont];
                $detalle->tipo_comprobante             = "01";
                $detalle->valor_retenido               = ($detalle->porcentaje / 100) * $detalle->base_imponible;

                //dd($detalle);
                $detalle->save();

                $cont = $cont + 1;
            }

            $retencion->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        Session::flash('message', "Retención #" . $secuencial . " creada Satisfactoriamente");

        return Redirect::to('compras/retenciones');
    }

    public function show($id)
    {
        $retenciones = Db::table('v_ele_retenciones')
            ->where('id', '=', $id)
            ->orderBy('secuencial', 'desc')
            ->first();
        $retenciones->total=0;
        $detalles_retenciones = DB::table('v_ele_retenciones_detalle as retdet')
            ->where('retdet.numero', '=', $retenciones->numero)
            ->get();

        //dd($detalles_retenciones);

        return view("compras.retenciones.show", ["retenciones" => $retenciones, "detalles_retenciones" => $detalles_retenciones]);
    }
}
