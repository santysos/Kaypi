@extends('adminlte::page')

@section('title', 'Retenciones')

@section('content_header')
    <h1>Listado de Retenciones</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">
            
                <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group">
                        <h4>
                            <a href="retenciones/create">
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
                            @include('compras.retenciones.search')
                        </h4>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @if(Session::has('message'))
                    <p class="alert alert-info">
                        {{Session::get('message')}}
                    </p>
                    @endif
                    @if(count($errors)>0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>
                                {{$error}}
                            </li>
                            @endforeach
                        </ul>
                    </div>
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
                                    Razón Social
                                </th>
                                <th>
                                    Ced/Ruc
                                </th>
                                <th>
                                    Fecha
                                </th>
                                <th>
                                    Periodo Fiscal
                                </th>
                                <th>
                                    Opciones
                                </th>
                            </thead>
                            @foreach ($retenciones as $cat)
                            <tr>
                                <td>
                                    {{ $cat->secuencial}}
                                </td>
                                <td>
                                    {{ $cat->razon_social}}
                                </td>
                                <td>
                                    {{ $cat->documento}}
                                </td>
                                <td>
                                    {{ $cat->fecha}}
                                </td>
                                <td>
                                    {{ $cat->periodo_fiscal}}
                                </td>
                                <td>
                                    <a href="{{URL::action('RetencionController@show',$cat->id)}}">
                                        <button class="btn btn-primary btn-xs" type="button">
                                            <span aria-hidden="true" class="glyphicon glyphicon-list-alt">
                                            </span>
                                        </button>
                                    </a>
                                    <a href="" data-target="#modal-delete-{{$cat->id}}"
										data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span
												class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
									</a>
                                </td>
                            </tr>
                            
                @endforeach
                        </table>
                    </div>
                    {{$retenciones->render()}}
                </div>
                     
            
            </div>
        </div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')


    

@stop







