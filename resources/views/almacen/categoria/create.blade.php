@extends('adminlte::page')

@section('title', 'Nuevo Departamento')

@section('content_header')
    <h1>Crear nueva categoría</h1>
@stop

@section('content')


<div class="container-fluid">
      
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		
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
		

		{!!Form::open
		(array('url'=>'almacen/categoria','method'=>'POST','autocomplete'=>'off'))!!}
		{!!Form::token()!!}
		<div class="row">
		<div class="panel">
		<div class="panel-body">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<div class="form-group">
			{!! Form::label('nombre', 'Nombre de la Categoria') !!}
            {!! Form::text('nombre', null, ['class' => 'form-control','required' => 'required']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('descripcion', 'Descripción') !!}
            {!! Form::text('descripcion', null, ['class' => 'form-control' ]) !!}
		</div>
		
		

		<div class="form-group">
		<button class="btn btn-primary" type="submit">Guardar</button>
		<button class="btn btn-danger" type="reset">Cancelar</button>
		</div>

		{!!Form::close()!!}

	</div>	
	</div>
	
	</div>	
	</div>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop





