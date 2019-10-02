@extends('adminlte::page')

@section('title', '')

@section('content_header')
    <h1>Listado de Ordenes</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">
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
            @foreach ($procesos1 as $pro) @endforeach

                    <div class="callout callout-success col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        Orden # {{$orden->idtb_ordenes}} - {{$pro->descripcion_procesos}}
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <pre><label><b>Cliente:</b></label>    {!!Form::label('',"   ".$cliente->nombre_comercial)!!}<br/><label><b>Contacto:</b></label>      {!!Form::label('',$cliente->razon_social)!!}<br/><label><b>Cedula/Ruc:</b></label>    {!!Form::label('',$cliente->cedula_ruc)!!}</pre>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <pre><label><b>Email:</b></label>         <a>{!!Form::label('',$cliente->email )!!}</a><br/><label><b>Codigo:</b></label>        {!!Form::label('',$cliente->idtb_cliente)!!}<br/><label><b>Dirección:</b></label>     {!!Form::label('',$cliente->direccion)!!}</pre>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-solid box-info" data-widget="box-widget">
                            <div class="box-header centrar-texto" id="FInicio">
                                Inicio: {{$orden->fecha_inicio}}
                            </div>
                        </div>
                    </div>
                
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-solid box-info" data-widget="box-widget">
                            <div class="box-header centrar-texto" id="FEntrega">
                                Entrega: {{$orden->fecha_entrega}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-condensed table-hover ">
                                <thead style="background-color: #A9D0F5">
                                    <td>
                                        Cant.
                                    </td>
                                    <td>
                                        Productos
                                    </td>
                                    <td>
                                        Descripcion
                                    </td>
                                    <td>
                                        Valor Unitario
                                    </td>
                                    <td>
                                        Sub Total
                                    </td>
                                </thead>
                                @foreach ($detalleorden as $cat)
                                <tr>
                                    <td>
                                        {{$cat->cantidad}}
                                    </td>
                                    <td>
                                        {{$cat->nombre}}
                                    </td>
                                    <td>
                                        {{$cat->descripcion}}
                                    </td>
                                    <td>
                                        $  {{$cat->valor_unitario}}
                                    </td>
                                    <td>
                                        $  {{number_format($cat->valor_unitario*$cat->cantidad,2)}}
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-condensed table-hover ">
                                <thead>
                                    <td width="20%">
                                        <b>
                                            Subtotal:
                                        </b>
                                        $ {{number_format($orden->total_venta,2)}}
                                    </td>
                                    <td width="20%">
                                        <b>
                                            Iva:
                                        </b>
                                        $ {{number_format($orden->total_venta*0.12,2)}}
                                    </td>
                                    <td width="20%">
                                        <b>
                                            Valor Total:
                                        </b>
                                        $ {{number_format($orden->total_venta+($orden->total_venta*0.12),2)}}
                                    </td>
                                    <td width="20%">
                                        <b>
                                            Abono:
                                        </b>
                                        $ {{$orden->abono}}
                                    </td>
                                    <td width="20%">
                                        <b>
                                            Saldo:
                                        </b>
                                        $ {{number_format($orden->total_venta+($orden->total_venta*0.12)-$orden->abono,2)}}
                                    </td>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="box box-solid box-info" data-widget="box-widget">
                            <div class="box-header">
                                {{$orden->observaciones}}
                                <h3 class="box-title">
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h4>
                                    {{$agente->asignado}}
                                </h4>
                                <p>
                                    {{$agente->finicio}}
                                </p>
                                <h4>
                                    {{$agente->calculofechas}}
                                </h4>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-cart">
                                </i>
                            </div>
                            <a class="small-box-footer">
                                Agente Vendedor
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h4>
                                    {{$disenador->asignado}}
                                </h4>
                                <p>
                                    {{$disenador->finicio}}
                                </p>
                                <h4>
                                    {{$disenador->calculofechas}}
                                </h4>
                            </div>
                            <div class="icon">
                                <i class="fa fa-optin-monster">
                                </i>
                            </div>
                            <a class="small-box-footer">
                                Diseñador
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h4>
                                    {{$impresor->asignado}}
                                </h4>
                                <p>
                                    {{$impresor->finicio}}
                                </p>
                                <h4>
                                    {{$impresor->calculofechas}}
                                </h4>
                            </div>
                            <div class="icon">
                                <i class="fa fa-print">
                                </i>
                            </div>
                            <a class="small-box-footer">
                                Impresor
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h4>
                                    {{$artefinalista->asignado}}
                                </h4>
                                <p>
                                    {{$artefinalista->finicio}}
                                </p>
                                <h4>
                                    {{$artefinalista->calculofechas}}
                                </h4>
                            </div>
                            <div class="icon">
                                <i class="fa fa-puzzle-piece">
                                </i>
                            </div>
                            <a class="small-box-footer">
                                Arte Finalista
                            </a>
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
<script src="{{ asset('/js/moment-with-locales.js') }}" type="text/javascript">
</script>
<script>
    function titulo(){      
    document.title = 'Orden # '+{{$orden->idtb_ordenes}}+' | Ordenes'; }
titulo();
</script>
@stop








