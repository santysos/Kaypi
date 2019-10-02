@extends('adminlte::page')

@section('title', 'Editar Departamento')

@section('content_header')
    <h1>Editar Departamento: 
        <span class="label label-primary">
            {{$departamento->departamento}}
        </span>
    </h1>
@stop

@section('content')
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
<div class="container-fluid">
    {!!Form::model($departamento,['method'=>'PATCH','route'=>['departamento.update', $departamento->idtb_departamentos]])!!}
    {!!Form::token()!!}
        <div class="row">
            <div class="panel ">
                <div class="panel-body">
                    <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                            {!! Form::label('categoria', 'Tipo Empleado') !!}
                            {!!Form::text('departamento',$departamento->departamento,['class'=>'form-control','id'=>'departamento','placeholder'=>'Tipo'])!!}
                        </div>
                    </div>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        <button class="btn btn-primary" type="submit">
                            Guardar
                        </button>
                    </div>        
                    <button class="btn btn-danger" type="reset">
                            Cancelar
                    </button>
                </div>
            </div>
                </div>
            </div>
        </div>
</div>
{!!Form::close()!!}
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop





