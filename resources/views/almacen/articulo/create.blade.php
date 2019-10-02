@extends('adminlte::page')

@section('title', 'Nuevo Producto')

@section('content_header')
    <h1>Nuevo Producto</h1>
@stop

@section('content')
<div class="container-fluid">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3><a href="" data-target="#modal-categoria" data-toggle="modal"><button class="btn btn btn-success">Nueva Categoría</button></a></h3> 
        @include('almacen.articulo.modalcategoria')
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
{!!Form::open(array('url'=>'almacen/articulo','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
{!!Form::token()!!}
<div class="row">
	<div class="panel">
	    <div class="panel-body">
            <div class="col-lg-4 col-sm-6 col-md-6 col-xs-6">             
                <div class="form-group">
                        <input id="sucursal" name="sucursal" type="hidden" value="{{ Auth::user()->sucursal }}"/>
                    {!! Form::open(['method'=> 'GET','action'=>'ArticuloController@create']) !!}
                        {!! Form::label('categoria', 'Categoría') !!}
                        {!! Form::select('idtb_categoria', $categorias, null, ['class'=>'form-control','placeholder' => 'Seleccione una Categoría','required' =>'required']) !!}
                    {!! Form::close() !!}
                    @if(Auth::user()->tb_tipo_usuario_idtb_tipo_usuario==1)
                    {!! Form::label('sucursal', 'Sucursal') !!}
                    {!! Form::select('sucursalselect', $sucursal, null, ['class'=>'form-control','placeholder' => 'Seleccione Sucursal','required']) !!}
                    @endif
                    {!! Form::label('nombre', 'Nombre Artículo') !!}
                    {!! Form::text('nombre',null,['class'=>'form-control','required','id'=>'nombre1','placeholder'=>'Nombre del Artículo'])!!}              
                    
                    {!! Form::label('codigo', 'Código') !!}
                    {!! Form::text('codigo',null,['class'=>'form-control','required','id'=>'codigobar','placeholder'=>'Código del artículo...'])!!}
                    
                    {!! Form::label('pvp', 'P.V.P') !!}
                    <div class="input-group">
                        <div class="input-group-addon">$</div>
                        {!! Form::number('pvp',null,['class'=>'form-control','required','id'=>'pvp','step'=>'any'])!!}
                    </div>
                    
                    {!! Form::label('pvp', 'P. Mayorista') !!}
                    <div class="input-group">
                        <div class="input-group-addon">$</div>
                        {!! Form::number('pvp1',null,['class'=>'form-control','required','id'=>'pvp1','step'=>'any'])!!}
                    </div>

                    {!! Form::label('pvp', 'P. Costo') !!}
                    <div class="input-group">
                        <div class="input-group-addon">$</div>
                        {!! Form::number('pvp2',null,['class'=>'form-control','required','id'=>'pvp2','step'=>'any'])!!}
                    </div>

                    {!! Form::label('stock', 'Stock') !!}
                    {!! Form::number('stock',null,['class'=>'form-control','required','placeholder'=>'Stock...'])!!}
                </div>
            </div>
        <div class="col-lg-4 col-sm-6 col-md-6 col-xs-6">
            <label>Código de Barras</label>
                 <div id="print">            
                    <div style="text-align:center;">
                        {!! Form::text('titcodbar',null,['class'=>'form-control input-sm','required','id'=>'titcodbar','readonly','style'=>'text-align:center'])!!}
                    </div>
                    <center>
                            <label id="titcodbar"></label>
                            <svg id="barcode"></svg>
                    </center>
                </div>
            <button class="btn btn-info btn-block" onclick="imprimir()" type="button">Imprimir Codigos</button>            
        </div>
        <div class="col-lg-4 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                {!! Form::label('descripcion', 'Descripción') !!}
                {!! Form::text('descripcion',null,['class'=>'form-control','id'=>'nombre1','placeholder'=>'Descripción del Articulo...']) !!}

                {!! Form::label('imagen', 'Imagen') !!}
                {!! Form::file('imagen', ['class'=>'form-control']) !!}
             
                {!! Form::label('iva1', 'IVA') !!}
                {!! Form::checkbox('iva', '1',true, ['class'=>'checkbox','id'=>'iva']) !!}                
            </div>
        </div>
			
		
		<div class="col-lg-12 col-sm-6 col-md-6 col-xs-6">
			<div class="form-group">
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Guardar</button>
                    <button class="btn btn-danger" type="reset">Cancelar</button>
				</div>
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
<script src="{{asset('js/JsBarcode.all.min.js')}}"></script>
<script src="{{asset('js/jquery.PrintArea.js')}}"></script>

<script>
//valida que el valor ingresado sea letra o numero
function filterNonAphaNumeric(str) {
    let code, i, len,result='';
  
    for (i = 0, len = str.length; i < len; i++) {
      code = str.charCodeAt(i);
      if ((code > 47 && code < 58) || // numeric (0-9)
          (code > 64 && code < 91) || // upper alpha (A-Z)
          (code > 96 && code < 123))
          { // lower alpha (a-z)
        result+=str.charAt(i);
      }
    }
    return result;
  };
  //cambia a mayusculas luego de presionar y valida con la funcion filterNonAphaNumeric()
  function onKeyUpHandler(event) {
    let value=this.value.toUpperCase();
    if (value) {
      this.value=filterNonAphaNumeric(value)
    }
  }

  let input = document.getElementById('codigobar');
  input.addEventListener('keyup',onKeyUpHandler);

 

//comprobamos si se pulsa una tecla
$("#codigobar").keyup(function(e){                  
              //obtenemos el texto introducido en el campo de búsqueda
    consulta = $("#codigobar").val();
    generarBarcode(consulta);
});

$("#nombre1").keyup(function(e){                  
              //obtenemos el texto introducido en el campo de búsqueda
    document.getElementById('titcodbar').value = document.getElementById('nombre1').value;

});

function generarBarcode()
{   
    codigo=$("#codigobar").val();
    JsBarcode("#barcode", codigo, {
    height: 30,
    width: 1.1,
    fontSize: 12
    });

}
$('#liAlmacen').addClass("treeview active");
$('#liArticulos').addClass("active");


//Código para imprimir el svg
function imprimir()
{
    $("#print").printArea();
}



</script>
@stop





