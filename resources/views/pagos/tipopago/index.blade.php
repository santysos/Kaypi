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
                            <a href="tipopago/create">
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
                        @include('pagos.tipopago.search')
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
                                    Tipo de Pago
                                </th>
                                <th>
                                    Opciones
                                </th>
                            </thead>
                            @foreach ($tipo_pago as $cat)
                            <tr>
                                <td>
                                    {{ $cat->idtb_tipo_pago}}
                                </td>
                                <td>
                                    {{ $cat->tipo_pago}}
                                </td>
                                <td>
                                    @if($cat->idtb_tipo_pago!=1)
                                    
                                    <a href="{{URL::action('TipoPagoController@edit',$cat->idtb_tipo_pago)}}"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>
                                    <a href="" data-target="#modal-delete-{{$cat->idtb_tipo_pago}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></a>
                                   
                                    @endif
                                </td>
                            </tr>
                            @include('pagos.tipopago.modal')
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
    <script> console.log('Hi desde clientes'); </script>
@stop