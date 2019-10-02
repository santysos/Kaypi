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
                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
                    <h4>
                        Editar Proceso:
                        <span class="label label-primary">
                            {{$proceso->descripcion_procesos}}
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
{!!Form::model($proceso,['method'=>'PATCH','route'=>['procesos.update', $proceso->idtb_descripcion_procesos]])!!}
{!!Form::token()!!}
                <div class="row">       
                    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
                        <div class="form-group">
                            {!!Form::text('Servicio',$departamento->departamentos,['class'=>'form-control','readonly','id'=>'Servicio','placeholder'=>'Servicio'])!!}
                        </div>
                        <div class="form-group">
                            {!!Form::text('descripcion_procesos',$proceso->descripcion_procesos,['class'=>'form-control','required'=>'required','placeholder'=>'Proceso'])!!}
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                        
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
</div>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hola desde el servidor '); </script>
@stop




