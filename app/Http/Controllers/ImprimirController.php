<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ImprimirController extends Controller
{
    public function reportec($id)
    {
        $pdf = app('FPDF');
        //Obtengo los datos

        $orden = DB::table('tb_ordenes as ord')
            ->join('tb_cliente as cli', 'ord.tb_cliente_idtb_cliente', '=', 'cli.idtb_cliente')
            ->join('users as us', 'us.id', '=', 'ord.users_id_asignado')
            ->select('ord.idtb_ordenes', 'ord.fecha_inicio', 'ord.fecha_entrega', 'ord.total_venta', 'ord.impuesto', 'ord.abono', 'ord.observaciones', 'cli.idtb_cliente', 'cli.nombre_comercial', 'cli.razon_social', 'cli.cedula_ruc', 'cli.email', 'us.name', 'cli.telefono')
            ->where('ord.idtb_ordenes', '=', $id)
            ->first();

            $detalles = DB::table('tb_detalle_orden as do')
            ->join('tb_articulo as art', 'art.idtb_articulo', '=', 'do.tb_articulo_idtb_articulo')
            ->select('art.nombre', 'do.cantidad', 'do.valor_unitario', 'do.descripcion')
            ->where('do.tb_ordenes_idtb_ordenes', '=', $id)
            ->orderby('do.idtb_detalle_orden', 'desc')
            ->get();





        //Fpdf = new Fpdf();
        $pdf->AddPage('P', 'A4');

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetXY(195, 9);
        $pdf->Cell(0, 0, utf8_decode($orden->idtb_ordenes));

        //****Datos COMPRADOR

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(23, 14);
        $pdf->Cell(0, 0, utf8_decode($orden->nombre_comercial));
        $pdf->SetXY(23, 19);
        $pdf->Cell(0, 0, utf8_decode($orden->razon_social));
        $pdf->SetXY(23, 24);
        $pdf->Cell(0, 0, utf8_decode($orden->cedula_ruc));

        //***Seccion CENTRAL
        $pdf->SetXY(119, 14);
        $pdf->Cell(0, 0, utf8_decode($orden->email));
        $pdf->SetXY(119, 19);
        $pdf->Cell(0, 0, utf8_decode($orden->telefono));
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(119, 24);
        $pdf->Cell(0, 0, utf8_decode($orden->idtb_cliente));

        //**********Seccion Izquierda
        $pdf->SetXY(186, 15);
        $pdf->Cell(0, 0, utf8_decode($orden->name));

        $total = 0;

        //****Mostramos los detalles
        $y = 33;

        foreach ($detalles as $det) {
            $pdf->SetFont('Arial', 'B', 10);

            $pdf->SetXY(3, $y);
            $pdf->MultiCell(10, 3, $det->cantidad);

            $pdf->SetXY(14, $y);
            $pdf->MultiCell(25, 3, utf8_decode($det->nombre));

            $pdf->SetXY(66, $y);
            $pdf->MultiCell(111, 3, utf8_decode($det->descripcion));

            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetXY(180, $y);
            $pdf->MultiCell(25, 3, number_format($det->valor_unitario, 2, '.', ','));

            $pdf->SetXY(198, $y);
            $pdf->MultiCell(25, 3, number_format(($det->valor_unitario * $det->cantidad), 2, '.', ','));

            $total = $total + (($det->valor_unitario) * $det->cantidad);
            $y     = $y + 9;
        }

        //$pdf->SetFont('Arial', 'B', 14);

        //OBSERVACIONES
        $pdf->SetXY(25, 112);
        $pdf->MultiCell(150, 3, utf8_decode($orden->observaciones));

        setlocale(LC_TIME, "es_ES");

        //FECHAS DE LA ORDEN
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(2, 135);
        $pdf->Cell(0, 0, strftime("%A, %e de %b de %G - %R", strtotime($orden->fecha_inicio)));
        $pdf->SetXY(108, 135);
        $pdf->Cell(0, 0, strftime("%A, %e de %b de %G - %R", strtotime($orden->fecha_entrega)));

        //ABONO y SALDO
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(193, 130);
        $pdf->MultiCell(20, 0, "$" . number_format($orden->abono, 2, '.', ','));
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(193, 136);
        $pdf->MultiCell(20, 0, "$" . number_format((($orden->total_venta + ($orden->total_venta * 0.12)) - $orden->abono), 2, '.', ','));

        //------------------TOTALES
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(198, 110);
        $pdf->MultiCell(20, 0, "" . number_format($orden->total_venta, 2, '.', ','));
        $pdf->SetXY(198, 116);
        $pdf->MultiCell(20, 0, "" . number_format(($orden->total_venta * 0.12), 2, '.', ','));
        $pdf->SetXY(198, 121);
        $pdf->MultiCell(20, 0, "" . number_format($orden->total_venta + ($orden->total_venta * 0.12), 2, '.', ','));

        $pdf->Output();
        exit;
    }
}
