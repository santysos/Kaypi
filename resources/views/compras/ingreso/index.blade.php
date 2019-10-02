@extends('adminlte::page')

@section('title', 'Compras')

@section('content_header')
<h1>Compras</h1>
@stop

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="panel ">
			<div class="panel-body">
				<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
					<div class="form-group">
						<a href="ingreso/create"><button class="btn btn-success">Nuevo</button></a>
					</div>
				</div>

				<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<h3>@include('compras.ingreso.search')</h3>
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-condensed table-hover">
							<thead>
								<th>Id</th>
								<th>Fecha</th>
								<th>Proveedor</th>
								<th>Comprobante</th>
								<th>Impuesto</th>
								<th>Total</th>
								<th>Estado</th>
								<th>Opciones</th>
							</thead>
							@foreach ($ingresos as $cat)
							<tr>
								<td>{{ $cat->idtb_ingreso}}</td>
								<td>{{ $cat->created_at}}</td>
								<td>{{ $cat->nombre_comercial}}</td>
								<td>{{ $cat->tipo_comprobante.': '.'#'.$cat->num_comprobante}}</td>
								<td>{{ $cat->impuesto}}</td>
								<td>$ {{ $cat->total}}</td>
								<td>{{ $cat->condicion}}</td>
								<td>
									<a href="{{URL::action('IngresoController@show',$cat->idtb_ingreso)}}"><button
											type="button" class="btn btn-primary btn-xs"><span
												class="glyphicon glyphicon-list-alt"
												aria-hidden="true"></span></button></a>
									<a href="" data-target="#modal-delete-{{$cat->idtb_ingreso}}"
										data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span
												class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
									</a>
								</td>
							</tr>
							@include('compras.ingreso.modal')
							@endforeach
						</table>
					</div>
					{{$ingresos->render()}}
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