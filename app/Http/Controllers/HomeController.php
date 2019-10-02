<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use Kaypi\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Kaypi\Http\Requests\IngresoFormRequest;
use Kaypi\Ingreso;
use Kaypi\DetalleIngreso;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ventas=DB::table('tb_venta as v')
        ->join('tb_cliente as p', 'v.tb_cliente_idtb_cliente','=','p.idtb_cliente')
        ->select('v.idtb_venta','v.created_at','p.nombre_comercial','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.condicion','total_venta')
        ->groupBy('v.idtb_venta','v.created_at','p.nombre_comercial','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.condicion','total_venta')
        ->orderBy('v.created_at','desc')
        ->paginate(10);

        $articulos=DB::table('tb_articulo as a')
        ->join('tb_categoria as c','a.tb_categoria_idtb_categoria','=','c.idtb_categoria')
        ->select('a.idtb_articulo','a.nombre','a.codigo','a.stock','a.descripcion','a.imagen','a.condicion','a.created_at','a.updated_at','c.nombre as categoria')
        ->orderBy('a.idtb_articulo','desc')
        ->paginate(4);

        $persona = DB::table('tb_cliente')
        ->select('nombre_comercial','idtb_cliente','email')
        ->orderBy('idtb_cliente','desc')
        ->first();
        
        $mes = Carbon::now('America/Guayaquil')->month;
        $ano = Carbon::now('America/Guayaquil')->year;

        $ventassumadas = DB::table('tb_venta')
        ->whereMonth('created_at', $mes)
        ->whereYear('created_at', $ano)
        ->where('condicion','=','1')
        ->sum('total_venta');

        $comprassumadas = DB::table('tb_ingreso as i')
        ->join('tb_detalle_ingreso as di','i.idtb_ingreso','=','di.tb_ingreso_idtb_ingreso')
        ->whereMonth('created_at', $mes)
        ->where('condicion','=','1')
        ->select('di.cantidad','di.precio_compra',DB::raw('di.cantidad*precio_compra as total'))
        ->groupBy('di.cantidad','di.precio_compra')
        ->get();

        $masvendidos = DB::table('tb_detalle_venta as dv')
        ->join('tb_articulo as ar','ar.idtb_articulo','=','dv.tb_articulo_idtb_articulo')
        ->select('dv.tb_articulo_idtb_articulo','ar.nombre', DB::raw('COUNT( dv.tb_articulo_idtb_articulo) as mejores'))
        ->groupBy('dv.tb_articulo_idtb_articulo','ar.nombre')
        ->having('dv.tb_articulo_idtb_articulo','>=',1)
        ->orderBy('mejores','desc')
        ->paginate(10);
        //->get();

        $mejoresclientes = DB::table('tb_venta as v')
        ->join('tb_cliente as p','p.idtb_cliente','=','v.tb_cliente_idtb_cliente')
        ->select('v.tb_cliente_idtb_cliente','p.nombre_comercial', DB::raw('COUNT(v.tb_cliente_idtb_cliente) as mejores'), DB::raw('SUM(v.total_venta) as sumventas'))
        ->where('v.condicion','=','1')
        ->groupBy('v.tb_cliente_idtb_cliente','p.nombre_comercial')
        ->having('v.tb_cliente_idtb_cliente','>=',1)
        ->orderBy('mejores','desc')
        ->paginate(10);


        if($mes ==1){$mes = "Enero";}elseif ($mes==2) {$mes = "Febrero";}elseif ($mes==3) {$mes = "Marzo";}elseif ($mes==4) {$mes = "Abril";}elseif ($mes==5) {$mes = "Mayo";}elseif ($mes==6) {$mes = "Junio";}elseif ($mes==7) {$mes = "Julio";}elseif ($mes==8) {$mes = "Agosto";}elseif ($mes==9) {$mes = "Septiembre";}elseif ($mes==10) {$mes = "Octubre";}elseif ($mes==11) {$mes = "Noviembre";}elseif ($mes==12) {$mes = "Diciembre";}


        $comprasmes=DB::select('SELECT monthname(i.created_at) as mes, sum(di.cantidad*di.precio_compra) as totalmes from tb_ingreso i inner join tb_detalle_ingreso di on i.idtb_ingreso=di.tb_ingreso_idtb_ingreso where i.condicion="1" group by monthname(i.created_at) order by month(i.created_at) asc limit 12');

        $ventasmes=DB::select('SELECT monthname(v.created_at) as mes, sum(v.total_venta) as totalmes from tb_venta v where v.condicion="1" group by monthname(v.created_at) order by month(v.created_at) desc limit 12');

        $ventasdia=DB::select('SELECT date(v.created_at) as dia, sum(v.total_venta) as totaldia from tb_venta v where v.condicion="1" group by dia order by(dia) desc limit 15');

        $productosvendidos=DB::select('SELECT a.nombre as articulo, sum(dv.cantidad) as cantidad from tb_articulo a inner join tb_detalle_venta dv on a.idtb_articulo = dv.tb_articulo_idtb_articulo inner join tb_venta v on dv.tb_venta_idtb_venta = v.idtb_venta where v.condicion="1" and year(v.created_at)=year(curdate()) group by a.nombre order by sum(dv.cantidad) desc limit 10');


        $totales=DB::select('SELECT (select ifnull(sum(di.cantidad*di.precio_compra),0) from tb_ingreso i inner join tb_detalle_ingreso di on i.idtb_ingreso=di.tb_ingreso_idtb_ingreso where DATE(i.created_at)=curdate() and i.condicion="A") as totalingreso, (select ifnull(sum(v.total_venta),0) from tb_venta v where DATE(v.created_at)=curdate() and v.condicion="A") as totalventa');


         return view('home',["ventas"=>$ventas, "persona"=>$persona, "articulos"=>$articulos, "ventassumadas"=>$ventassumadas, "mes"=>$mes, "comprassumadas"=>$comprassumadas, "masvendidos"=>$masvendidos, "mejoresclientes"=>$mejoresclientes,"comprasmes"=>$comprasmes,"ventasmes"=>$ventasmes,"ventasdia"=>$ventasdia,"productosvendidos"=>$productosvendidos,"totales"=>$totales]);
      
    }
}
