@extends('adminlte::page')

@section('title', 'Listado de Tipos de Empleado')

@section('content_header')
    <h1>Listado de Usuarios</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">
                {!!Form::open(array('url'=>'roles/empleados','method'=>'POST','autocomplete'=>'off'))!!}
                {!!Form::token()!!}
      
                    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                        <h4>
                            Nuevo Tipo de Empleado
                        </h4>
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
                        <hr>
                        </hr>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                            {!!Form::select('departamentos',$departamentos,null,['id'=>'departamentos','required' => 'required','class'=>'form-control','placeholder'=>'Selecione el Departamento'])!!}
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                            {!!Form::text('nombre',null,['class'=>'form-control','placeholder'=>'Tipo de empleado'])!!}
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-6 col-md-6 col-xs-6">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">
                                Guardar
                            </button>
                            <button class="btn btn-danger" type="reset">
                                Cancelar
                            </button>
                        </div>
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







