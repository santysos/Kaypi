@extends('adminlte::page')

@section('title', 'Procesos')

@section('content_header')
    <h1>Editar Procesos</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel">
		    <div class="panel-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h4>
                        Editar tipo de empleado:
                        <span class="label label-primary">
                            {{$tipo_empleado->nombre}}
                        </span>
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
                </div>
                {!!Form::model($tipo_empleado,['method'=>'PATCH','route'=>['empleados.update', $tipo_empleado->idtb_tipo_usuario]])!!}
                {!!Form::token()!!}
              
                            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group">
                                    {!! Form::label('categoria', 'Tipo Empleado') !!}
                                {!!Form::text('nombre',$tipo_empleado->nombre,['class'=>'form-control','id'=>'nombre','placeholder'=>'Tipo'])!!}
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
                
                {!!Form::close()!!}
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



