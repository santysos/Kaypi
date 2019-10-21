<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use Kaypi\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Kaypi\Http\Requests\ArticuloFormRequest;
use Kaypi\Http\Requests\EditarArticuloFormRequest;
use Kaypi\Articulo;
use Kaypi\Categoria;
use Auth;
use Carbon\Carbon;
use DB;

class Articulo2Controller extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }
 
    public function index(Request $request)
    {
       if ($request) {
          $query = trim($request->get('searchText'));
 
          if (Auth::user()->tb_tipo_usuario_idtb_tipo_usuario == 1) {
             $articulos = DB::table('tb_articulo as a')
             ->join('tb_categoria as c', 'a.tb_categoria_idtb_categoria', '=', 'c.idtb_categoria')
             ->select('a.idtb_articulo', 'a.iva', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.condicion', 'a.created_at', 'a.updated_at', 'a.pvp')
             ->where('a.nombre', 'LIKE', '%' . $query . '%')
             ->where('a.codigo', 'LIKE', '%' . $query . '%')
             ->where('a.sucursal', '=', 2)
             ->orderBy('idtb_articulo', 'desc')
             ->groupBy('a.idtb_articulo', 'a.iva', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre', 'a.descripcion', 'a.imagen', 'a.condicion', 'a.created_at', 'a.updated_at', 'a.pvp')
             ->paginate(20);

             $tit_sucursal = db::table('tb_sucursal')
             ->select('nombre')
             ->where('idtb_sucursal','=',2)
             ->first();
          }
 
          return view('almacen.articulo.index', ["tit_sucursal"=>$tit_sucursal,"articulos" => $articulos, "searchText" => $query]);
       }
    }
    public function reportes()
   {
      $pdf = app('FPDF');
      //Obtenemos los registros
      $registros = DB::table('tb_articulo as a')
         ->join('tb_categoria as c', 'a.tb_categoria_idtb_categoria', '=', 'c.idtb_categoria')
         ->select('a.idtb_articulo','a.sucursal', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.condicion', 'a.pvp')
         ->where('a.sucursal','=','2')
         ->where('a.condicion','=','1')
         ->orderBy('a.nombre', 'asc')
         ->get();

      //$pdf=new Fpdf();
      $pdf->AddPage();
      $pdf->SetTextColor(35, 56, 113);
      $pdf->SetFont('Arial', 'B', 11);
      $pdf->Cell(0, 10, utf8_decode("Listado Artículos"), 0, "", "C");
      $pdf->Ln();
      $pdf->Ln();
      $pdf->SetTextColor(0, 0, 0);  // Establece el color del texto 
      $pdf->SetFillColor(206, 246, 245); // establece el color del fondo de la celda 
      $pdf->SetFont('Arial', 'B', 10);
      //El ancho de las columnas debe de sumar promedio 190        
      $pdf->cell(10, 8, utf8_decode("#"), 1, "", "L", true);
      $pdf->cell(30, 8, utf8_decode("Código"), 1, "", "L", true);
      $pdf->cell(70, 8, utf8_decode("Nombre"), 1, "", "L", true);
      $pdf->cell(37, 8, utf8_decode("Categoría"), 1, "", "L", true);
      $pdf->cell(13, 8, utf8_decode("Stock"), 1, "", "L", true);
      $pdf->cell(17, 8, utf8_decode("P.V.P"), 1, "", "L", true);
      $pdf->cell(20, 8, utf8_decode("Total"), 1, "", "L", true);

      $pdf->Ln();
      $pdf->SetTextColor(0, 0, 0);  // Establece el color del texto 
      $pdf->SetFillColor(255, 255, 255); // establece el color del fondo de la celda
      $pdf->SetFont("Arial", "", 9);

      $sumapreciocompra = 0;
      $sumastock = 0;
      $cont = 0;
      $cont++;
      foreach ($registros as $reg) {
         if ($reg->stock >= 0) {
            $pdf->cell(10, 6, utf8_decode($cont), 1, "", "L", true);
            $pdf->cell(30, 6, utf8_decode($reg->codigo), 1, "", "L", true);
            $pdf->cell(70, 6, utf8_decode($reg->nombre), 1, "", "L", true);
            $pdf->cell(37, 6, utf8_decode($reg->categoria), 1, "", "L", true);
            $pdf->cell(13, 6, utf8_decode($reg->stock), 1, "", "L", true);
            $pdf->cell(17, 6, utf8_decode('$ ' . $reg->pvp), 1, "", "L", true);
            $pdf->cell(20, 6, utf8_decode('$ ' . $reg->pvp * $reg->stock), 1, "", "L", true);
            $pdf->Ln();

            $sumapreciocompra += ($reg->pvp * $reg->stock);
            $sumastock += ($reg->stock);
         } else {
            $pdf->cell(10, 6, utf8_decode($cont), 1, "", "L", true);
            $pdf->cell(30, 6, utf8_decode($reg->codigo), 1, "", "L", true);
            $pdf->cell(70, 6, utf8_decode($reg->nombre), 1, "", "L", true);
            $pdf->cell(37, 6, utf8_decode($reg->categoria), 1, "", "L", true);
            $pdf->cell(13, 6, utf8_decode('----'), 1, "", "L", true);
            $pdf->cell(17, 6, utf8_decode('$ ' . $reg->pvp), 1, "", "L", true);
            $pdf->cell(20, 6, utf8_decode('0.00'), 1, "", "L", true);
            $pdf->Ln();
         }
         $cont++;
      }
      //linea final de suma de valores
      $pdf->Ln();
      $pdf->Ln();
      $pdf->cell(30, 6, utf8_decode('TOTAL'), 1, "", "L", true);
      $pdf->cell(70, 6, utf8_decode(''), 1, "", "L", true);
      $pdf->cell(37, 6, utf8_decode(''), 1, "", "L", true);
      $pdf->cell(17, 6, utf8_decode($sumastock), 1, "", "L", true);
      $pdf->cell(17, 6, utf8_decode('$ ' . $reg->pvp), 1, "", "L", true);
      $pdf->cell(21, 6, utf8_decode('$ ' . $sumapreciocompra), 1, "", "L", true);
      $pdf->Ln();

      $pdf->Output();
      exit;
   }
}
