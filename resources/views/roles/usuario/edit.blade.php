@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Editar Usuario: 
        <span class="label label-primary">
                {{$usuario->name}}
        </span>
    </h1>
@stop

@section('content')
<div class="container-fluid">      
    {!!Form::model($usuario,['method'=>'PATCH','route'=>['usuario.update',$usuario->id]])!!}
    {!!Form::token()!!}

    <div class="row">
        <div class="panel ">
            <div class="panel-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
                    <div class="form-group col-lg-4">
                            <div class="form-group">
                            {!! Form::label('codigo', 'Departamento') !!}
                            {!! Form::select('idtb_departamentos',$departamentos,null,['required','id'=>'idtb_departamentos','class'=>'form-control','placeholder'=>'Selecione Departamento','onchange'=>'MostrarFact();'])!!}
                            </div>
                            <div class="form-group">
                            {!! Form::label('codigo', 'Tipo Empleado') !!}
                            {!! Form::select('idtb_tipo_empleados',$tipo_empleado,null,['required','id'=>'idtb_tipo_empleados','class'=>'form-control'])!!}
                            </div>
                            <div class="form-group" id="numfactura">
                            {!! Form::label('codigo', 'Sucursal') !!}
                            {!! Form::select('sucursal',$sucursal,null,['required','id'=>'sucursal','class'=>'form-control'])!!}
                            </div>
                            <div class="form-group">
                            {!! Form::label('codigo', 'Nombre') !!}
                            {!! Form::text('name',null,['class'=>'form-control','required','id'=>'name','placeholder'=>'Nombre y Apellido'])!!}
                            </div>
                            <div class="form-group">
                            {!! Form::label('codigo', 'E-mail') !!}
                            {!! Form::text('email',null,['class'=>'form-control','required','id'=>'email','placeholder'=>'Email...'])!!}
                            </div>
                            <div class="form-group">
                            {!! Form::label('codigo', 'Contraseña') !!}
                            {!! Form::password('password', ['class'=>'form-control','required','id'=>'password','placeholder'=>'Contraseña...']) !!}                               
                            </div>
                            <div class="form-group">
                            {!! Form::label('codigo', 'Confirmar Contraseña') !!}
                            {!! Form::password('password_confirmation', ['class'=>'form-control','required','id'=>'password_confirmation','placeholder'=>'Vuelva a escribir la contraseña...']) !!}                   
                            </div>
                        </div>

                <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
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
<script src="{{ asset('/js/selectdinamicodep.js') }}" type="text/javascript">
</script>
<script>$("#numfactura").hide();



function MostrarFact(){

datosprocesos =document.getElementById('idtb_departamentos').value;

console.log(datosprocesos);
procesoselecionado = $("#idtb_departamentos option:selected").text();

if(procesoselecionado.trim()=="Ventas"){
    $("#numfactura").show();
}
else
{
    $("#numfactura").hide();
}

 console.log(procesoselecionado);
}
</script>
    <script> console.log('Hi!'); </script>
@stop





