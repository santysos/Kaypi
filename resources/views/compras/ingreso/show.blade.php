@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
<h1>Listado de Proveedores</h1>
@stop

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="panel ">
			<div class="panel-body">
				<div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						{!! Form::label('categoria', 'Proveedor') !!}
						<p>{{$ingreso->razon_social}}</p>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						{!! Form::label('categoria', 'Doc') !!}
						<p>{{ $ingreso->tipo_comprobante.': #'.$ingreso->num_comprobante}}</p>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						{!! Form::label('categoria', 'Dirección') !!}
						<p>{{$ingreso->direccion}}</p>
					</div>
				</div>
				<div class="col-lg-2 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						{!! Form::label('categoria', 'Email') !!}
						<p>{{ $ingreso->email}}</p>
					</div>
				</div>
				<div class="col-lg-1 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						{!! Form::label('categoria', 'Teléfono') !!}
						<p>{{$ingreso->telefono}}</p>
					</div>
				</div>
				<div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						{!! Form::label('codigo', 'Num Comprobante') !!}
						<p>{{ $ingreso->tipo_comprobante.': #'.$ingreso->num_comprobante}}</p>
					</div>
				</div>


				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color: #A9D0F5">
							<th>Cantidad</th>
							<th>Artículo</th>
							<th>Precio Compra</th>
							<th>Precio Compra IVA</th>
							<th>Precio Venta</th>
							<th>Subtotal</th>
						</thead>
						<tbody>
							@foreach($detalles as $det)

							<tr>
								<td>{{$det->cantidad}}</td>
								<td>{{$det->articulo}}</td>
								<td>$ {{$det->precio_compra}}</td>
								<td>$ {{number_format((($det->precio_compra * 0.12)+$det->precio_compra),2)}}</td>
								<td>$ {{$det->precio_venta}}</td>
								<td>$ {{number_format($det->cantidad*$det->precio_compra,2)}}</td>
							</tr>
							@endforeach

						</tbody>
						<tfoot>

						
							<tr>
								<th colspan="5">
									<p align="right">TOTAL:</p>
								</th>
								<th>
									<p align="right"><span align="right" id="total_pagar">
										$ {{number_format($ingreso->total,2)}}</span></p>
								</th>
							</tr>
							<th>
								
							</th>
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