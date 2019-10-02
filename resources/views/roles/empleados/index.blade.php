@extends('adminlte::page')

@section('title', 'Listado de Tipos de Empleado')

@section('content_header')
    <h1>Listado de Usuarios</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">
                <div class="col-lg-12 col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group">
                        <h4>
                            Tipos de Empleados --
                            <a href="empleados/create">
                                <button class="btn btn-sm btn-success">
                                    Nuevo
                                </button>
                            </a>
                        </h4>
                    </div>
                    <hr>
                    </hr>
                </div>
                <hr>
                </hr>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @if(Session::has('message'))
                    <p class="alert alert-info">
                        {{Session::get('message')}}
                    </p>
                    @endif
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="example">
                            <thead>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Departamento
                                </th>
                                <th>
                                    Tipo Empleado
                                </th>
                                <th>
                                    Opciones
                                </th>
                            </thead>
                            @foreach ($tipo_empleado as $cat)
                            <tr>
                                <td>
                                    {{ $cat->idtb_tipo_usuario}}
                                </td>
                                <td>
                                    {{ $cat->departamento}}
                                </td>
                                <td>
                                    {{ $cat->nombre}}
                                </td>
                                <td>
                                @if($cat->idtb_tipo_usuario!= 1)
                                <a href="{{URL::action('TipoEmpleadoController@edit',$cat->idtb_tipo_usuario)}}"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>
                                <a href="" data-target="#modal-delete-{{$cat->idtb_tipo_usuario}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                                </a>
                             
                                @endif
                                </td>
                            
                            </tr>
                            @include('roles.empleados.modal')
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hola desde el servidor '); </script>
@stop





