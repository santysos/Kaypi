@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Listado de Usuarios</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group">
                        <h3><a href="usuario/create"><button class="btn btn-success">Nuevo</button></a></h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <h3> <p class="text-right">@include('roles.usuario.search')</p></h3>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                           
                            <th>Sucursal</th>
                            <th>Rol</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Opciones</th>
                        </thead>
                        @foreach ($usuarios as $cat)
                        <tr>
                            @if ($cat->id!=1)
                           
                            <td>{{ $cat->sucursal}}</td>
                            <td>{{ $cat->tipousuario}}</td>
                            <td>{{ $cat->name}}</td>
                            <td>{{ $cat->email}}</td>
                            <td>
                                @if ($cat->tb_tipo_usuario_idtb_tipo_usuario!=1)
                                <a href="{{URL::action('UsuarioController@edit',$cat->id)}}"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>
                                <a href="" data-target="#modal-delete-{{$cat->id}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></a>
                                @endif
                            </td>
                            @endif
                        </tr>
                        @include('roles.usuario.modal')
                        @endforeach
                        </table>
                    </div>
                    {{$usuarios->render()}}
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

