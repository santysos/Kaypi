@extends('adminlte::page')

@section('title', 'Retención')

@section('content_header')
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">

                <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('categoria', 'Cliente') !!}
                        <p>{{$retenciones->razon_social}}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('categoria', 'Doc') !!}
                        <p>{{': #'.$retenciones->documento}}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('categoria', 'Dirección') !!}
                        <p>{{$retenciones->direccion_establecimiento}}</p>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('categoria', 'Fecha') !!}
                        <p>{{ $retenciones->fecha}}</p>
                    </div>
                </div>
                <div class="col-lg-1 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('categoria', 'Email') !!}
                        <p>{{$retenciones->fecha}}</p>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                        {!! Form::label('codigo', 'Num Comprobante') !!}
                        <p>{{ ': #'.$retenciones->numero}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color: #A9D0F5">
                            <th>Comprobante</th>
                            <th>Número</th>
                            <th>Fecha Emisión</th>
                            <th>Ej. Fiscal</th>
                            <th>Codigo</th>
                            <th>Base Imponible</th>
                            <th>Impuesto</th>
                            <th>Porcentaje %</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                            @foreach($detalles_retenciones as $det)

                            <tr>


                                <td>FACTURA</td>
                                <td>{{$det->numero_comprobante}}</td>
                                <td>{{$det->fecha_comprobante}}</td>
                                <td>{{$retenciones->periodo_fiscal}}</td>
                                <td>{{$det->codigo_sri}}</td>
                                <td>{{$det->base_imponible}}</td>
                                @if($det->tipo == 1)
                                <td>RENTA</td>
                                @elseif ($det->tipo == 2)
                                <td>IVA</td>
                                @elseif($det->tipo == 3 )
                                <td>ISD</td>
                                @endif
                                <td>{{$det->porcentaje}}</td>
                                <td>{{$det->valor_retenido}}</td>
                                <td style="display:none;">{{$retenciones->total+= $det->valor_retenido}}
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="8">
                                    <p align="right">TOTAL:</p>
                                </th>
                                <th>
                                    <p align="right"><span align="right" id="total_pagar">
                                            ${{number_format($retenciones->total,2)}}</span></p>
                                </th>
                            </tr>

                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')

@stop

@section('js')
<script>
    console.log('Hola desde el servidor '); 
</script>
@stop