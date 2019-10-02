@extends('adminlte::page')

@section('title', 'Categorías')

@section('content_header')
    <h1>Listado de Categorías</h1>
@stop

@section('content')
<div class="container-fluid">
<div class="row">
<div class="panel">
		<div class="panel-body">
        <div class="col-lg-7 col-md-9 col-sm-9 col-xs-12">
                <div class="form-group">
                    <h4>                        
                        <a href="categoria/create">
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
                    @include('almacen.categoria.search')
                    </h4>
                </div>
            </div>
            <hr>
            </hr>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
			<thead>
				<th>Id</th>
				<th>Nombre Categoria</th>
				<th>Descripcion</th>
				<th>Condicion</th>
				<th>Opciones</th>
			</thead>
			@foreach ($categorias as $cat)
			<tr>
				<td>{{ $cat->idtb_categoria}}</td>
				<td>{{ $cat->nombre}}</td>
				<td>{{ $cat->descripcion}}</td>
				<td>{{ $cat->condicion}}</td>
				<td>
					<a href="{{URL::action('CategoriaController@edit',$cat->idtb_categoria)}}"><button type="button" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>
					<a href="" data-target="#modal-delete-{{$cat->idtb_categoria}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
					</a>
				</td>
			</tr>
			@include('almacen.categoria.modal')
			@endforeach
			</table>
		</div>
		{{$categorias->render()}}
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

