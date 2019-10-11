@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
<h1>Listado Ventas</h1>
@stop

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="panel ">
			<div class="panel-body">
				@foreach($personas as $persona)@endforeach
				@foreach($suma_pagos as $suma_pago)@endforeach
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<div class="form-group">
						<a href="venta/create"><button class="btn btn-success btn-sm">Nuevo</button></a>
					</div>

				</div>
				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<h3>@include('ventas.venta.search')</h3>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-striped table-borderless table-condensed table-hover">
							<thead>

								<th>Id</th>
								<th>Fecha</th>
								<th>Cliente</th>
								<th>Factura</th>
								<th>Vendedor</th>
								<th>Total</th>
								<th>Abono - Saldo</th>
								<th>Estado</th>
								<th>Opciones</th>
							</thead>
							@foreach ($ventas as $cat)
							<tr>

								<td>{{ $cat->idtb_venta}}</td>
								<td>{{ $cat->created_at}}</td>
								<td>{{ $cat->nombre_comercial}}
									</br>
									{{ $cat->razon_social}}
								</td>
								<td>{{ '#'.$cat->num_comprobante}}</td>
								<td>{{ $cat->name}}</td>
								<td>${{ $cat->total_venta}}</td>

								<td>
									@if ($cat->abono==$cat->total_venta)
									<font color="green" id="abono2">${{$cat->abono}} </font>
									</br>
									<font color="green">Pagado</font>
									@else
									<font color="black">${{$cat->abono}}</font> -
									<font color="red"> ${{$cat->saldo}}</font>
									</br>

									<a class="subraya" title="Agregar Pago" href=""
										data-target="#modal-create-pago-{{$cat->idtb_venta}}" data-toggle="modal">
										<font color="red">Parcial</font>
									</a>


									@endif
								</td>
								@if(Auth::user()->sucursal == 1)

								<td>
									@foreach ($estado_fact_elec as $estado)
									@if($cat->numero==$estado->numero)
									@if($estado->estado=='AUTORIZADO')
									<span class="pull-right-container">
										<small class="label pull-center bg-green"><a target="_blank" style="color:#fff"; href="http://162.243.161.165:9090/rest/v1/pdf/codigo/FV/numero/{{$cat->numero}}">{{$estado->estado}}</a></small>
									</span>
									@elseif($estado->estado=="RECIBIDA")
									<span class="pull-right-container">
										<small class="label pull-center bg-yellow">{{$estado->estado}}</small>
									</span>
									@elseif($estado->estado=="DEVUELTA")
									<span class="pull-right-container">
										<small class="label pull-center bg-red">{{$estado->estado}}</small>
									</span>

									@endif
									@endif
									@endforeach

								</td>

								@else
								<td></td>
								@endif
								<td>
						
									<a target="_blank" title="Detalle Venta"
									href="{{URL::action('VentaController@show',$cat->idtb_venta)}}"><button
										type="button" class="btn btn-primary btn-xs"><span
											class="glyphicon glyphicon-list-alt"
											aria-hidden="true"></span></button></a>
							
									@if($cat->condicion=="1")
									<a title="Cambiar Cliente" href=""
										data-target="#modalasignarcliente-{{$cat->idtb_venta}}"
										data-toggle="modal"><button type="button" class="btn btn-warning btn-xs"><span
												class="glyphicon glyphicon-user" aria-hidden="true"></span></button></a>
									<a title="Imprimir" target="_blank"
										href="{{URL::action('VentaController@reportec',$cat->idtb_venta)}}"><button
											type="button" class="btn btn-success btn-xs"><span
												class="glyphicon glyphicon-print"
												aria-hidden="true"></span></button></a>

									<a title="Eliminar" href="" data-target="#modal-delete-{{$cat->idtb_venta}}"
										data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span
												class="glyphicon glyphicon-trash"
												aria-hidden="true"></span></button></a>
												@endif
								</td>
								<td>

								</td>
							</tr>

							@include('ventas.venta.modalasignarcliente')
							@include('ventas.venta.modal')
							@include('pagos.pago.modalpago')
							@endforeach
						</table>
					</div>{{$ventas->render()}}
				</div>
			</div>

		</div>
	</div>
</div>

@stop

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/subrayado.css')}}" />
@stop

@section('js')
<script src="{{ asset('/js/selectpagos.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/moment.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/moment/locale/es.js') }}" type="text/javascript">
</script>

@stop