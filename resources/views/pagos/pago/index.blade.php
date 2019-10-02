@extends('adminlte::page')

@section('title', 'Tipo de Pagos')

@section('content_header')
    <h1>Tipo de Pagos</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">
                <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group">
                        <h4>
                            <a href="/ventas/venta">
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
                        @include('pagos.pago.search')
                        </h4>
                    </div>
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
                                    Cliente
                                </th>
                                <th>
                                    Tipo de Pago
                                </th>
                                <th>
                                    # Factura
                                </th>
                                <th>
                                    Valor
                                </th>
                                <th>
                                    Notas
                                </th>
                                <th>
                                    Fecha
                                </th>
                                <th>
                                    Opciones
                                </th>
                            </thead>
                            @foreach ($pagos as $cat)
                          
                            <tr>

                                <td>
                                    {{ $cat->idtb_pagos}}
                                </td>
                                <td>
                                    {{ $cat->nombre_comercial}}
                                </td>
                                <td>
                                   {{ $cat->tipo_pago}}
                                </td>
                                <td>
                                        <a href="/pagos/pago/{{ $cat->tb_venta_idtb_venta}}">{{ $cat->tb_venta_idtb_venta}}</a>   
                                </td>
                                <td>
                                    {{ $cat->valor}}
                                </td> 
                                <td>
                                    {{ $cat->notas}}
                                </td>
                                <td>
                                    {{ $cat->fecha_pago}}
                                </td>
                                <td>
                                    <a href="{{URL::action('PagosController@edit',$cat->idtb_pagos)}}"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>
                                    <a href="" data-target="#modal-delete-{{$cat->idtb_pagos}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></a>
                                </td>
                     
                            </tr>
                    
                            @include('pagos.pago.modal')
                            @endforeach  
                        </table>
                    </div>
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
    <script> console.log('Hi desde pagos'); </script>
@stop