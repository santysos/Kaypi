@extends('adminlte::page')

@section('title', 'Nuevo Departamento')

@section('content_header')
    <h1>Departamentos</h1>
@stop

@section('content')

{!!Form::open(array('url'=>'departamentos/departamento','method'=>'POST','autocomplete'=>'off'))!!}
{!!Form::token()!!}
<div class="container-fluid">
<div class="row">
    <div class="panel">
        <div class="panel-body">
            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
            <h4>Nuevo Departamento</h4>
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
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                    {!!Form::text('departamento',null,['class'=>'form-control','placeholder'=>'Ventas, Producción, Diseño'])!!}
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
{!!Form::close()!!}
</div>
@stop

@section('css')
    
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop





