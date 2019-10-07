@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Listado de Clientes</h1>
@stop

@section('content')
<div class="container-fluid">
<div class="row">
    <div class="panel ">
        <div class="panel-body">
            <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                <div class="form-group">
                    <h4>
                        <a href="cliente/create">
                            <button class="btn btn-sm btn-success">
                                Nuevo
                            </button>
                        </a>
                    </h4>
                </div>
            </div>
            <div class="col-lg-5 col-md-3 col-sm-3 col-xs-12">
                <div class="form-group">
                    <h4 align="text-center">
                        @include('ventas.cliente.search')
                    </h4>
                </div>
            </div>
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
                                Nombre Comercial
                            </th>
                            <th>
                                Razón Social
                            </th>
                            <th>
                                Ced/Ruc
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Dirección
                            </th>
                            <th>
                                Telefono
                            </th>
                            <th>
                                Opciones
                            </th>
                        </thead>
                        @foreach ($personas as $cat)
                        <tr>
                            @if($cat->condicion==1)
                            <td>
                                {{ $cat->idtb_cliente}}
                            </td>
                            <td>
                                {{ $cat->nombre_comercial}}
                            </td>
                            <td>
                                {{ $cat->razon_social}}
                            </td>
                            <td>
                                {{ $cat->cedula_ruc}}
                            </td>
                            <td>
                                {{ $cat->email}}
                            </td>
                            <td>
                                {{ $cat->direccion}}
                            </td>
                            <td>
                                {{ $cat->telefono}}
                            </td>
                            <td>
                                @include('ventas.cliente.delete')
                            </td>
                            @endif
                        </tr>
                        
            @endforeach
                    </table>
                </div>
                {{$personas->render()}}
            </div>
        </div>
    </div>
</div>
</div>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi desde clientes'); </script>
@stop