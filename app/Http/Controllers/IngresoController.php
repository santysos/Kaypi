<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Kaypi\Http\Requests\IngresoFormRequest;
use Kaypi\Ingreso;
use Kaypi\DetalleIngreso;
use Kaypi\Articulo;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use DB;

class IngresoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $query = trim($request->get('searchText'));
            $ingresos = DB::table('tb_ingreso as i')
                ->join('tb_proveedor as p', 'i.tb_proveedor_idtb_proveedor', '=', 'p.idtb_proveedor')
                ->join('tb_detalle_ingreso as di', 'i.idtb_ingreso', '=', 'di.tb_ingreso_idtb_ingreso')
                ->select('i.idtb_ingreso', 'i.created_at', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.condicion', DB::raw('sum(di.cantidad*di.precio_compra)as total'), 'p.razon_social', 'p.nombre_comercial')
                ->where('i.num_comprobante', 'LIKE', '%' . $query . '%')
                ->orderBy('i.idtb_ingreso', 'desc')
                ->groupBy('i.idtb_ingreso', 'i.created_at', 'p.razon_social', 'p.nombre_comercial', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.condicion')
                ->paginate(10);

            return view('compras.ingreso.index', ["ingresos" => $ingresos, "searchText" => $query]);
        }
    }
    public function create()
    {
        $personas = DB::table('tb_proveedor')->get();

        $articulos = DB::table('tb_articulo as art')
            ->select(DB::raw('CONCAT(art.codigo," ",art.nombre)AS articulo'), 'art.idtb_articulo')
            ->where('art.condicion', '=', '1')
            ->get();

        return view("compras.ingreso.create", ["personas" => $personas, "articulos" => $articulos]);
    }

    public function store(IngresoFormRequest $request)
    {
        try{
        DB::beginTransaction();
        $ingreso = new Ingreso;
        $ingreso->tb_proveedor_idtb_proveedor = $request->get('idproveedor');
        $ingreso->tipo_comprobante            = $request->get('tipo_comprobante');
        $ingreso->serie_comprobante           = $request->get('serie_comprobante');
        $ingreso->num_comprobante             = $request->get('num_comprobante');
        $mytime = Carbon::now('America/Guayaquil');
        $ingreso->created_at                  = $mytime->toDateTimeString();
        $ingreso->impuesto                    = '12';
        $ingreso->condicion                      = 1;
        $ingreso->save();


        $idarticulo = $request->get('idarticulo');
        $cantidad = $request->get('cantidad');
        $precio_compra = $request->get('precio_compra');
        $precio_venta = $request->get('precio_venta');

        $cont = 0;


        while ($cont < count($idarticulo)) {
            $detalle = new DetalleIngreso();
            $detalle->tb_ingreso_idtb_ingreso         = $ingreso->idtb_ingreso;
            $detalle->tb_articulo_idtb_articulo       = $idarticulo[$cont];
            $detalle->cantidad                        = $cantidad[$cont];
            $detalle->precio_compra                   = $precio_compra[$cont];
            $detalle->precio_venta                    = $precio_venta[$cont];
            $detalle->save();


            $cont = $cont + 1;
        }


        DB::commit();

        }catch(\Exception $e)
      {
         DB::rollback();
      }

        return Redirect::to('compras/ingreso');
    }
    public function show($id)
    {
        $ingreso = DB::table('tb_ingreso as i')
            ->join('tb_proveedor as p', 'i.tb_proveedor_idtb_proveedor', '=', 'p.idtb_proveedor')
            ->join('tb_detalle_ingreso as di', 'di.tb_ingreso_idtb_ingreso', '=', 'i.idtb_ingreso')
            ->select('p.telefono', 'p.nombre_comercial','p.razon_social', 'p.email', 'p.direccion', 'i.idtb_ingreso', 'i.created_at', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.condicion', DB::raw('sum(di.cantidad*di.precio_compra)as total'))
            ->where('di.tb_ingreso_idtb_ingreso', '=', $id)
            ->groupBy('p.telefono', 'p.email', 'p.direccion','p.razon_social', 'i.idtb_ingreso', 'i.created_at', 'p.nombre_comercial', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.condicion')
            ->first();

         //   dd($ingreso);

        $detalles = DB::table('tb_detalle_ingreso as di')
            ->join('tb_articulo as a', 'di.tb_articulo_idtb_articulo', '=', 'a.idtb_articulo')
            ->select('a.nombre as articulo', 'di.cantidad', 'di.precio_compra', 'di.precio_venta')
            ->where('di.tb_ingreso_idtb_ingreso', '=', $id)

            ->get();

        return view("compras.ingreso.show", ["ingreso" => $ingreso, "detalles" => $detalles]);
    }


    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->Estado = 0;
        $ingreso->update();

        return Redirect::to('compras/ingreso');
    }
}
