<?php

namespace Kaypi\Http\Controllers;

use Illuminate\Http\Request;
use Kaypi\Http\Requests;
use Kaypi\User;
use Illuminate\Support\Facades\Redirect;
use Kaypi\Http\Requests\UsuarioFormRequest;
use Kaypi\Http\Requests\EditarUsuarioFormRequest;
use DB;
use Kaypi\Departamento;
use Kaypi\TipoEmpleado;
use Illuminate\Support\Facades\Session;


class UsuarioController extends Controller
{
    public function __construct(){
        
        $this->middleware('auth');
        
  }

  public function index (Request $request)
  {
     if ($request)
     {
         $query = trim($request->get('searchText'));

       $usuarios=DB::table('users as u')
         ->join('tb_tipo_usuario as tp','tp.idtb_tipo_usuario','=','u.tb_tipo_usuario_idtb_tipo_usuario')
         ->join('tb_sucursal as suc','u.sucursal','=','suc.idtb_sucursal')
         ->select('suc.nombre as sucursal','tp.nombre as tipousuario','u.id','u.tb_tipo_usuario_idtb_tipo_usuario','u.name','u.email')
         ->where('u.name','LIKE','%'.$query.'%')
         ->where('u.condicion','=','1')
         ->orderBy('tp.idtb_tipo_usuario','desc')
         ->paginate(20);

        return view('roles.usuario.index',["usuarios"=>$usuarios,"searchText"=>$query]);
     }

  }
  public function getTipoEmpleado(Request $request, $id)
  {
      if ($request->ajax()) {
          $tipo_empleado = TipoEmpleado::TipoEmpleados($id);
          return response()->json($tipo_empleado);
      }
  }
  public function create ()
  {
      $departamentos = Departamento::where('condicion', '=', '1')->orderby('idtb_departamentos', 'asc')->pluck('departamento', 'idtb_departamentos');
      $sucursal=DB::table('tb_sucursal')
      ->select('idtb_sucursal','nombre')
      ->pluck('nombre','idtb_sucursal');
      
      return view("roles.usuario.create", compact('departamentos'), compact('sucursal'));
  }

  public function store (UsuarioFormRequest $request)
  {
          $usuario                                              =  new User;
          $usuario-> name                                       = $request ->get ('name');
          $usuario-> email                                      = $request ->get ('email');
          $usuario-> sucursal                                   = $request ->get ('sucursal');
          $usuario-> tb_tipo_usuario_idtb_tipo_usuario          = $request ->get ('idtb_tipo_empleados');
          $usuario-> password                                   = bcrypt($request ->get ('password'));
          $usuario-> condicion                                  =1;

          $usuario-> save();

          return Redirect::to('roles/usuario');
  }

  public function edit ($id)
  {     $user =User::FindOrFail($id);
       
        $departamentos = Departamento::where('condicion', '=', '1')
        ->orderby('idtb_departamentos', 'asc')
        ->pluck('departamento', 'idtb_departamentos');

        $tipo_empleado = TipoEmpleado::where('condicion', '=', '1')
        ->pluck('nombre', 'idtb_tipo_usuario');

        $sucursal=DB::table('tb_sucursal')
            ->select('idtb_sucursal','nombre')
            ->pluck('nombre','idtb_sucursal');
    
    
      return view('roles.usuario.edit',["usuario"=>User::FindOrFail($id), "departamentos"=>$departamentos, "tipo_empleado"=>$tipo_empleado, "sucursal"=>$sucursal]);
  }

   public function update (EditarUsuarioFormRequest $request, $id)
  {
          $usuario                                              = User::FindOrFail($id);
          $usuario-> name                                       = $request ->get ('name');
          $usuario-> email                                      = $request ->get ('email');
          $usuario-> sucursal                                   = $request ->get ('sucursal');
          $usuario-> tb_tipo_usuario_idtb_tipo_usuario          = $request ->get ('idtb_tipo_empleados');
          $usuario-> password                                   = bcrypt($request ->get ('password'));

          $usuario-> update();

          return Redirect::to('roles/usuario');
  }
  public function destroy ($id)
  {
        $usuario                                              = User::FindOrFail($id);
        $usuario-> condicion                                  =0;
        $usuario-> update();    

        Session::flash('message', "El usuario " . $usuario->name. " fue Eliminado");
     
        return Redirect::to('roles/usuario');
  }
}
