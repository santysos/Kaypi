<?php

namespace Kaypi\Http\Controllers;

use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportesController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {

            $f1 = new Carbon($request->get('s1'));
            $f2 = new Carbon($request->get('s2'));

            $f2->addHours(23);
            $f2->addMinutes(59);
            if (Auth::user()->tb_tipo_usuario_idtb_tipo_usuario == 1) {
                $ventas = DB::table('tb_venta as v')
                    ->join('users as u', 'u.id', '=', 'v.users_id')
                    ->select('v.idtb_venta', 'v.tipo_comprobante', 'v.total_venta', 'v.forma_de_pago', 'v.sucursal', 'v.created_at', 'u.name')
                    ->where('v.condicion', '=', '1')
                    ->whereBetween('v.created_at', [$f1, $f2])
                    ->get();

                
                $ventas->contador            = 0;
                $ventas->conttarjeta         = 0;
                $ventas->contefectivo        = 0;
                $ventas->sumatotal           = 0;
                $ventas->sumaefectivo        = 0;
                $ventas->sumatarjeta         = 0;

                $ventas->contador1           = 0;
                $ventas->conttarjeta1        = 0;
                $ventas->contefectivo1       = 0;
                $ventas->sumatotal1          = 0;
                $ventas->sumaefectivo1       = 0;
                $ventas->sumatarjeta1        = 0;

                $ventas->contador2           = 0;
                $ventas->conttarjeta2        = 0;
                $ventas->contefectivo2       = 0;
                $ventas->sumatotal2          = 0;
                $ventas->sumaefectivo2       = 0;
                $ventas->sumatarjeta2        = 0;


                foreach ($ventas as $key) {
                    $ventas->sumatotal += $key->total_venta;
                    $ventas->contador++;
                    if ($key->forma_de_pago == 'Efectivo') {
                        $ventas->contefectivo++;
                        $ventas->sumaefectivo += $key->total_venta;
                    }
                    if ($key->forma_de_pago == 'Tarjeta Credito') {
                        $ventas->conttarjeta++;
                        $ventas->sumatarjeta += $key->total_venta;
                    }

                    if ($key->sucursal == 1) { //1=otavalo 
                        $ventas->sumatotal1 += $key->total_venta;
                        $ventas->contador1++;
                        if ($key->forma_de_pago == 'Efectivo') {
                            $ventas->contefectivo1++;
                            $ventas->sumaefectivo1 += $key->total_venta;
                        }
                        if ($key->forma_de_pago == 'Tarjeta Credito') {
                            $ventas->conttarjeta1++;
                            $ventas->sumatarjeta1 += $key->total_venta;
                        }
                    } elseif ($key->sucursal == 2) //2=quito
                    {
                        $ventas->sumatotal2 += $key->total_venta;
                        $ventas->contador2++;
                        if ($key->forma_de_pago == 'Efectivo') {
                            $ventas->contefectivo2++;
                            $ventas->sumaefectivo2 += $key->total_venta;
                        }
                        if ($key->forma_de_pago == 'Tarjeta Credito') {
                            $ventas->conttarjeta2++;
                            $ventas->sumatarjeta2 += $key->total_venta;
                        }
                    }
                }
            }
            //dd($ventas);

            return view('ventas.reportes.index', ["ventas" => $ventas, "f1" => $f1, "f2" => $f2]);
        }
    }

    public function create()
    { }

    public function store(UsuarioFormRequest $request)
    {

        return Redirect::to('roles / usuario');
    }

    public function edit($id)
    {
        return view('roles . usuario . edit', ["usuario" => User::FindOrFail($id)]);
    }

    public function update(UsuarioEditFormRequest $request, $id)
    {
        $usuario              = User::FindOrFail($id);
        $usuario->name        = $request->get('name');
        $usuario->email       = $request->get('email');
        $usuario->tipoUsuario = $request->get('tipoUsuario');

        $usuario->password = bcrypt($request->get('password'));

        $usuario->update();

        return Redirect::to('roles / usuario');
    }
    public function destroy($id)
    {
        $usuario = DB::table('users')->where('id', ' = ', $id)->delete();

        return Redirect::to('roles / usuario');
    }
}
