@extends('adminlte::page')

@section('title', 'Inventario')

@section('content_header')
    <h1>Inventario {{$tit_sucursal->nombre}}</h1>
@stop

@section('content')
<div class="container-fluid">
<div class="row">
<div class="panel">
		<div class="panel-body">
		<div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                <div class="form-group">
                    <h4>
					    <a href="articulo/create">
                            <button class="btn btn-sm btn-success">
                                Nuevo
                            </button>
                        </a>
                    </h4>
                </div>
            </div>
			<div class="col-lg-5 col-md-4 col-sm-4 col-xs-12">
				<div class="form-group">
				<h3>@include('almacen.articulo.search')</h3>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				@if(Session::has('message'))
				<p class="alert alert-info">
					{{Session::get('message')}}
				</p>
				@endif
			</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table id="example" class="table table-striped table-bordered table-condensed table-hover">
			<thead>
				<th>Código</th>
				<th>Nombre Producto</th>
				<th>Fecha Creación</th>
				<th>P.V.P</th>
				<th>IVA</th>
	            <th>Actualizado</th>
				<th>Categoria</th>
				<th>Stock</th>
				<th>Imagen</th>
				<th>Estado</th>
				<th>Opciones</th>
			</thead>
			@foreach ($articulos as $cat)
			@if($cat->condicion == '1')
			<tr>
				<td>{{ $cat->codigo}}</td>
				<td>{{ $cat->nombre}}</td>
				<td>{{ $cat->created_at}}</td>
				<td><span class="label label-primary">$ {{ $cat->pvp}}</span></td>
				<td>
				@if(($cat->iva)==1)
				<span class="label label-success">SI</span>
				@else
				<span class="label label-success">NO</span>
				@endif
				</td>

                <td>{{ $cat->updated_at}}</td>
                <td>{{ $cat->categoria}}</td>
				<td>
				@if(($cat->stock)>=0)
				{{ $cat->stock}}
				@else
				∞
				@endif
				</td>
				<td>
					<a href="{{asset('img/productos/'.$cat->imagen)}}" data-lightbox="roadtrip"><img src="{{asset('img/productos/'.$cat->imagen)}}" alt="{{$cat->nombre}}" height="50px" width="50px" class="img-thumbnail"></a>
				</td>
				<td>{{ $cat->condicion}}</td>
				<td>
					<a href="{{URL::action('ArticuloController@edit',$cat->idtb_articulo)}}"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>
					<a href="" data-target="#modal-delete-{{$cat->idtb_articulo}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
					</a>
				</td>
			</tr>
			@endif
			@include('almacen.articulo.modal')
		
			
			@endforeach

			</table>
		</div>
		{{$articulos->appends(Request::only(['searchText']))->render()}}
		
	</div>
</div>
</div>
</div>
</div>
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/lightbox.css')}}"/>  
@stop

@section('js')
<script src="{{ asset('/js/lightbox.js') }}" type="text/javascript">
</script>
@stop

