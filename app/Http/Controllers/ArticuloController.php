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
use Illuminate\Support\Facades\Session;



class ArticuloController extends Controller
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
               ->orwhere('a.codigo', 'LIKE', '%' . $query . '%')
               ->orderBy('idtb_articulo', 'desc')
               ->groupBy('a.idtb_articulo', 'a.iva', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre', 'a.descripcion', 'a.imagen', 'a.condicion', 'a.created_at', 'a.updated_at', 'a.pvp')
               ->paginate(20);
         } else {
            $articulos = DB::table('tb_articulo as a')
               ->join('tb_categoria as c', 'a.tb_categoria_idtb_categoria', '=', 'c.idtb_categoria')
               ->select('a.idtb_articulo', 'a.iva', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.condicion', 'a.created_at', 'a.updated_at', 'a.pvp')
               ->where('a.nombre', 'LIKE', '%' . $query . '%')
               ->where('a.codigo', 'LIKE', '%' . $query . '%')
               ->where('a.sucursal', '=', Auth::user()->sucursal)
               ->orderBy('idtb_articulo', 'desc')
               ->groupBy('a.idtb_articulo', 'a.iva', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre', 'a.descripcion', 'a.imagen', 'a.condicion', 'a.created_at', 'a.updated_at', 'a.pvp')
               ->paginate(20);
         }

         return view('almacen.articulo.index', ["articulos" => $articulos, "searchText" => $query]);
      }
   }
   public function create()
   {
      $categorias = Categoria::pluck('nombre', 'idtb_categoria');
      $sucursal = DB::table('tb_sucursal as suc')->pluck('nombre', 'idtb_sucursal');

      return view("almacen.articulo.create", compact('categorias'), compact('sucursal'));
   }

   public function store(ArticuloFormRequest $request)
   {
      $articulo = new Articulo;
      $articulo->tb_categoria_idtb_categoria  = $request->get('idtb_categoria');
      $articulo->codigo                       = $request->get('codigo');
      $articulo->nombre                       = $request->get('nombre');
      $articulo->stock                        = $request->get('stock');
      $articulo->descripcion                  = $request->get('descripcion');
      $articulo->pvp                          = $request->get('pvp');
      $articulo->pvp1                         = $request->get('pvp1');
      $articulo->pvp2                         = $request->get('pvp2');
      if (Auth::user()->tb_tipo_usuario_idtb_tipo_usuario == 1) {
         $articulo->sucursal                     = $request->get('sucursalselect');
      } else {
         $articulo->sucursal                     = $request->get('sucursal');
      }
      if ($request->get('iva') != null)
         $articulo->iva                          = 1;
      else {
         $articulo->iva                          = 0;
      }
      $articulo->condicion                    = 1;
      /* Codigo para llenar TIMESTAMP
        $mytime = Carbon::now('America/Guayaquil');
        $articulo->created_at                   =$mytime->toDateTimeString();
        $articulo->updated_at                   =$mytime->toDateTimeString();
        */
      if (Input::hasFile('imagen')) {
         $file = Input::file('imagen');
         $file->move(public_path() . '/img/productos/', $file->getClientOriginalName());
         $articulo->imagen = $file->getClientOriginalName();
      }

      $articulo->save();

      return Redirect::to('almacen/articulo');
   }
   public function show($id)
   {
      return view("almacen.articulo.show", ["articulo" => Articulo::findOrFail($id)]);
   }

   public function edit($id)
   {
      $articulo = Articulo::findOrFail($id);
      $categorias = DB::table('tb_categoria')->where('condicion', '=', '1')->get();


      return view("almacen.articulo.edit", ["articulo" => $articulo, "categorias" => $categorias]);
   }

   public function update(EditarArticuloFormRequest $request, $id)
   {
      $articulo = Articulo::findOrFail($id);
      $articulo->tb_categoria_idtb_categoria  = $request->get('idtb_categoria');
      $articulo->codigo                       = $request->get('codigo');
      $articulo->nombre                       = $request->get('nombre');
      $articulo->stock                        = $request->get('stock');
      $articulo->pvp                          = $request->get('pvp');
      $articulo->pvp1                         = $request->get('pvp1');
      $articulo->pvp2                         = $request->get('pvp2');
      $articulo->iva                          = $request->get('iva');
      $articulo->descripcion                  = $request->get('descripcion');

      $articulo->condicion                    = 1;

      $mytime = Carbon::now('America/Guayaquil');
      $articulo->updated_at = $mytime->toDateTimeString();


      if (Input::hasFile('imagen')) {
         $file = Input::file('imagen');
         $file->move(public_path() . '/img/productos/', $file->getClientOriginalName());
         $articulo->imagen = $file->getClientOriginalName();
      }
      $articulo->update();


      return Redirect::to('almacen/articulo');
   }
   public function destroy($id)
   {
      $articulo = Articulo::findOrFail($id);
      $sucursal = $articulo->sucursal;
      $articulo->condicion     = 0;
      $articulo->update();

      Session::flash('message', "El articulo - " . $articulo->nombre. " - fue eliminado");

      if($sucursal==1)
      return Redirect::to('almacen/articulo1');
      if($sucursal==2)
      return Redirect::to('almacen/articulo2');
   }
   public function reportes()
   {
      $pdf = app('FPDF');
      //Obtenemos los registros
      $registros = DB::table('tb_articulo as a')
         ->join('tb_categoria as c', 'a.tb_categoria_idtb_categoria', '=', 'c.idtb_categoria')
         ->select('a.idtb_articulo', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.condicion', 'a.pvp')
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
