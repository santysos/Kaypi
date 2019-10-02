@extends('adminlte::page')

@section('title', 'Ingreso Compras')

@section('content_header')
<h1>Ingreso Compras</h1>
@stop

@section('content')
<div class="container-fluid">
	<div class="row">
	  <div class="panel ">
		<div class="panel-body">
			<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
				<h5><a href="" data-target="#modal-create" data-toggle="modal">
				<button class="btn btn-sm btn-success">Nuevo Proveedor</button>
				</a>
				</h5>@include('compras.ingreso.modalproveedor')
				@if(count($errors)>0)
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
						@endforeach
					</ul>
				</div>
				@endif
			</div>					
		</div>
	</div>
</div>
	{!!Form::open(array('url'=>'compras/ingreso','method'=>'POST','autocomplete'=>'off'))!!}
	{!!Form::token()!!}

<div class="row">
<div class="panel">
<div class="panel-body">
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		<div class="form-group">
		{!! Form::label('categoria', 'Proveedor ') !!}
					
		<select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
			   @foreach($personas as $persona)
				<option value="{{$persona->idtb_proveedor}}">{{$persona->nombre_comercial}}</option>
			   @endforeach
		</select>
		</div>
	</div>
	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
		<div class="form-group">
		{!! Form::label('categoria', 'Tipo de Comprobante') !!}
		<select name="tipo_comprobante" id="" class="form-control">
			   <option value="Nota de Venta">Nota de Venta</option>
			<option value="Factura">Factura</option>
			<option value="Factura">Ticket</option>
		</select>
		</div>
	</div>
	<!--<div class="col-lg-2 col-sm-6 col-md-6 col-xs-12"><div class="form-group">
		{!! Form::label('codigo', 'Serie Comprobante') !!}
		<input type="text" name="serie_comprobante" value="{{old('serie_comprobante')}}" class="form-control" placeholder="Serie Comprobante..."></div>
	</div>-->
	<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12"><div class="form-group">
		{!! Form::label('codigo', 'Num Comprobante') !!}
		<input type="number" name="num_comprobante" required value="{{old('num_comprobante')}}" class="form-control" placeholder="Número de Comprobante..."></div>
	</div>
</div>
</div>
</div>


<div class="row">

<div class="panel">
<div class="panel-body">
	<div class="col-lg-5 col-sm-5 col-md-4 col-xs-12">	
		<div class="form-group">
			{!! Form::label('codigo', 'Articulo') !!}
			<select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true">
				   @foreach($articulos as $articulo)
					<option value="{{$articulo->idtb_articulo}}">{{$articulo->articulo}}</option>
				   @endforeach
			</select>
		</div>
	</div>
	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
		<div class="form-group">
			{!! Form::label('codigo', 'Cantidad') !!}
			<input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="Cantidad" value="1">
		</div>
	</div>
	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
		<div class="form-group">
			{!! Form::label('codigo', 'Precio Compra') !!}
			<input type="number" name="pprecio_compra" id="pprecio_compra" class="form-control" placeholder="Precio Compra" value="0.00">
		</div>
	</div>
	<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">	
		<div class="form-group">
			{!! Form::label('codigo', 'Precio Venta') !!}
			<input type="number" name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="Precio Venta">
		</div>
	</div>
	<div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">	
		<div class="form-group">
		{!! Form::label('opciones', 'Opciones') !!}
			<button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
		</div>
	</div>
	<div class="col-lg-12 col-sm-6 col-md-12 col-xs-12">	
		<table id="detalles" class="table table-striped table-bordered table-condensed table-hover" >
			<thead style="background-color: #A9D0F5">
				<th>Opciones</th>
				<th>Artículo</th>
				<th>Cantidad</th>
				<th>Precio Compra</th>
				<th>Precio Venta</th>
				<th>Subtotal</th>
			</thead>
			<tfoot>
				<th><h4>TOTAL</h4></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th><h4 id="total">$/ 0.00</h4></th>
			</tfoot>
			<tbody>
				
			</tbody>
		</table>
	</div>
</div>
</div>

	
	
	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" id="guardar">
		<div class="form-group">
			<input  name="_token" value="{{ csrf_token() }}" type="hidden"></input>
			<button class="btn btn-primary" type="submit">Guardar</button>
			<button class="btn btn-danger" type="reset">Cancelar</button>
		</div>
	</div>
</div>
</div>
{!!Form::close()!!}

@stop

@section('css')

@stop

@section('js')
<script>
	$(document).ready(function(){
		$('#bt_add').click(function(){
			agregar();
		});
	});

var cont=0;
total=0;
subtotal=[];
$("#guardar").hide();

function agregar(){
		idarticulo = $("#pidarticulo").val();
		articulo = $("#pidarticulo option:selected").text();
		cantidad = $("#pcantidad").val();
		precio_compra = $("#pprecio_compra").val();
		precio_venta = $("#pprecio_venta").val();

		if (idarticulo!="" && cantidad!="" && cantidad>0 && precio_compra!="" && precio_venta!="")
		{
			subtotal[cont] = (cantidad*precio_compra);
			total=total+subtotal[cont];

			var fila = '<tr class="selected" id="fila'+cont+'"><td><button type"button" class="btn btn-xs btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input  name="cantidad[]"  type="hidden" readonly value="'+cantidad+'">'+cantidad+'</td><td><input readonly type="hidden" name="precio_compra[]" value="'+parseFloat(precio_compra).toFixed(2)+'">'+parseFloat(precio_compra).toFixed(2)+'</td><td><input readonly type="hidden" name="precio_venta[]" value="'+parseFloat(precio_venta).toFixed(2)+'">'+parseFloat(precio_venta).toFixed(2)+'</td><td>'+parseFloat(subtotal[cont]).toFixed(2)+'</td></tr>';

			cont++;
			limpiar();
			$("#total").html("$ "+ total);
			evaluar();
			$('#detalles').append(fila);
		}
}

function limpiar(){
		$("#pcantidad").val("1");
		$("#pprecio_venta").val("");
		$("#pprecio_compra").val("");
	}

	function evaluar()
	{
		if (total>=0)
		{
			$("#guardar").show();
		}
		else
		{
			$("#guardar").hide();
		}
	}
	
	function eliminar(index){

		total=total-subtotal[index];
		$("#total").html("$ "+ total);
		$("#fila" + index).remove();
		evaluar();
	}
</script>
@stop