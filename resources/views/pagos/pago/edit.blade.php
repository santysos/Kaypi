@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
<h1>Editar Pago: 
    <span class="label label-primary">
        {{$pago->idtb_pagos}}
    </span>
</h1>
@stop

@section('content')  
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
<div class="container-fluid">
{!!Form::model($tipo_pago,['method'=>'PATCH','route'=>['pago.update', $pago->idtb_pagos]])!!}
{!!Form::token()!!}
<div class="row">
<div class="panel ">
<div class="panel-body">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!!Form::label('cliente','Cliente') !!}          
                    {!!Form::text('cliente',$persona->nombre_comercial,['id'=>'cliente','class'=>'form-control','placeholder'=>'Nombre del Cliente','readonly'])!!}
                    {!!Form::hidden('tb_cliente_idtb_cliente',$persona->idtb_cliente,['id'=>'tb_cliente_idtb_cliente','class'=>'form-control'])!!}
                </div>                        
                <div class="form-group input-group">
                    <span class="input-group-addon" id="basic-addon1">
                        Fecha: 
                    </span>
                          
                    
                    {!! Form::date('fecha_pago', \Carbon\Carbon::now(), ['class'=>'form-control','id'=>'fecha_pago']) !!}
                               
                </div>
                <div class="form-group">
                    {!!Form::select('tipo_pago',$tipo_pago,$pago->tb_tipo_pago_idtb_tipo_pago,['id'=>'tipo_pago','class'=>'form-control','placeholder'=>'Tipo de pago','required'])!!}
                    
                    
                </div>
                <div class="form-group">
                    {!!Form::text('notas',$pago->notas,['id'=>'notas','class'=>'form-control','placeholder'=>'Notas','required'])!!}
                </div>
                <div class="callout callout-info">
                    <h5>Venta # {{ $pago->tb_venta_idtb_venta}} - Valor: ${{$venta->total_venta}}</h5>
                    <input type="text" name="tb_venta_idtb_venta" class="form-control hidden " id="tb_venta_idtb_venta" value={{$pago->tb_venta_idtb_venta}}>   
                    <input type="text" name="total_venta" class="form-control hidden" id="total_venta" value={{$venta->total_venta}}>                    
                </div>
                <div class="form-group input-group">
                    <span class="input-group-addon" id="basic-addon1">
                        Valor:
                    </span>
                    {!!Form::number('valor', $pago->valor, ['min' => '0.01','step'=>'any','max' => $venta->total_venta, 'class' => 'form-control','id'=>'valor']) !!}         
                </div>                 
        </div>
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
<div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
    <div class="btn-group mr-2" role="group" aria-label="First group">
        <button class="btn btn-primary" type="submit">
            Guardar
        </button>
    </div>        
    <button class="btn btn-danger" type="reset">
            Cancelar
    </button>
</div>
</div>
</div>
</div>
</div>
</div>
{!!Form::close()!!}

@stop

@section('css')
  
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop

