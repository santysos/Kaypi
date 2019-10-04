@extends('adminlte::page')

@section('title', 'Venta')

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
           <p>{{$venta->nombre_comercial}}</p>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
      {!! Form::label('categoria', 'Doc') !!}
           <p>{{': #'.$venta->cedula_ruc}}</p>
      </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
      {!! Form::label('categoria', 'Dirección') !!}
           <p>{{$venta->direccion}}</p>
      </div>
    </div>
    <div class="col-lg-2 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
      {!! Form::label('categoria', 'Email') !!}
           <p>{{ $venta->email}}</p>
      </div>
    </div>
    <div class="col-lg-1 col-sm-6 col-md-6 col-xs-12">
      <div class="form-group">
      {!! Form::label('categoria', 'Teléfono') !!}
           <p>{{$venta->telefono}}</p>
      </div>
    </div>


    <!-- <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12"><div class="form-group">
      {!! Form::label('codigo', 'Serie Comprobante') !!}
      <p>{{$venta->serie_comprobante}}</p>
      </div>
    </div> -->
    <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12"><div class="form-group">
      {!! Form::label('codigo', 'Num Comprobante') !!}
      <p>{{ $venta->tipo_comprobante.': #'.$venta->num_comprobante}}</p></div>
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
        <table id="detalles" class="table table-striped table-bordered table-condensed table-hover" >
          <thead style="background-color: #A9D0F5">
            <th>IVA</th>
            <th>Cantidad</th>
            <th>Artículo</th>
            <th>Precio Venta</th>
            <th>Descuento</th>
            <th>Subtotal</th>
          </thead>
          <tbody>
            @foreach($detalles as $det)
  
            <tr>
            @if($det->iva==1)
              <td><input type="checkbox" checked disabled></td>
            @else
              <td><input type="checkbox" disabled></td>
            @endif
              <td>{{$det->cantidad}}</td>
              <td>{{$det->articulo}}</td>
              <td>$ {{$det->precio_venta}}</td>
              <td>$ {{$det->descuento}}</td>
              <td>$ {{number_format($det->cantidad*$det->precio_venta-$det->descuento,2)}}</td>
            </tr>
            @endforeach
            
          </tbody>
          <tfoot>
                              <tr>
                                  <th  colspan="5"><p align="right">Subtotal 0:</p></th>
                                  <th><p align="right"><span id="total">${{number_format($venta->sub_total_0,2)}}</span>
                                  <input type="hidden" name="total_venta" id="total_venta"></p></th>
                              </tr>
                              <tr>
                                  <th  colspan="5"><p align="right">Subtotal 12:</p></th>
                                  <th><p align="right"><span id="total">${{number_format($venta->sub_total_12/(1+($venta->impuesto/100)),2)}}</span>
                                  <input type="hidden" name="total_venta" id="total_venta"></p></th>
                              </tr>
                              <tr>
                                  <th colspan="5"><p align="right">IVA(12%):</p></th>
                                  <th><p align="right"><span id="total_impuesto">
                                  ${{number_format(($venta->impuesto/100)*($venta->sub_total_12/(1+($venta->impuesto/100))),2)}}</span></p></th>
                              </tr>
                              <tr>
                                  <th  colspan="5"><p align="right">TOTAL:</p></th>
                                  <th><p align="right"><span align="right" id="total_pagar">
                                  ${{number_format($venta->total_venta,2)}}</span></p></th>
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
    <script> console.log('Hola desde el servidor '); </script>
@stop




