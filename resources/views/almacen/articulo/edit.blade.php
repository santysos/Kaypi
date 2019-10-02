@extends('adminlte::page')

@section('title', 'Editar Departamento')

@section('content_header')
<div class="container-fluid">
<div class="row">
		<div class="panel">
			<div class="panel-body">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<h4>Editar Producto: <span class="label label-primary">{{$articulo->nombre}}</span></h4>
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
		</div>
	</div>
</div>

{!!Form::model($articulo,['method'=>'PATCH','route'=>['articulo.update',$articulo->idtb_articulo],'files'=>'true'])!!}
{!!Form::token()!!}
<div class="row">
		<div class="panel">
			<div class="panel-body">
		<div class="col-lg-4 col-sm-6 col-md-6 col-xs-6">
		<div class="form-group">
			{!! Form::label('codigo', 'Código') !!}
			<input type="text" name="codigo" id="codigobar" required value="{{$articulo->codigo}}" class="form-control">
			{!! Form::label('categoria', 'Categoria') !!}
            <select name="idtb_categoria" id="" class="form-control selectpicker" data-live-search="true">
            	@foreach ($categorias as $cat)
            		@if($cat->idtb_categoria == $articulo->idtb_categoria)
            		<option value="{{$cat->idtb_categoria}}" selected>{{$cat->nombre}}</option>
            		@else
            		<option value="{{$cat->idtb_categoria}}">{{$cat->nombre}}</option>
            		@endif
            	@endforeach
            </select>
			{!! Form::label('nombre', 'Nombre Producto') !!}
            <input type="text" name="nombre" id="nombre1" required value="{{$articulo->nombre}}" class="form-control">
            {!! Form::label('pvp', 'P.V.P') !!}
            <div class="input-group">
            <div class="input-group-addon">$</div>
            <input type="decimal" name="pvp" required value="{{$articulo->pvp}}" class="form-control" placeholder="Precio de Venta...">
            </div>
            <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <input type="decimal" name="pvp1" id="pvp1"  value="{{$articulo->pvp1}}" class="form-control">
                    </div>
                    <div class="input-group">
                    <div class="input-group-addon">$</div>
                    <input type="decimal" name="pvp2" id="pvp2"  value="{{$articulo->pvp2}}" class="form-control">
                    </div>
            {!! Form::label('stock', 'Stock') !!}
			@if (($articulo->stock)>=0)
			<input type="text" name="stock" required value="{{$articulo->stock}}" class="form-control">
			@else
			<input type="text" name="stock" required value="0" class="form-control">
			@endif
			</div>
		</div>
		
		
		
		
		
		<div class="col-lg-4 col-sm-6 col-md-6 col-xs-6">
		<div class="form-group">
			{!! Form::label('descripcion', 'Código de Barras') !!}
			<div id="print">            
                        <div style="text-align:center;">
                            <input class="form-control input-sm" type="text" id="titcodbar" readonly align="center" style="text-align:center" >
                        </div>
                         <center>
                            <label id="titcodbar"></label>
                            <svg id="barcode"></svg>
                        </center>
                    </div>   
                    <button class="btn btn-info btn-block" onclick="imprimir()" type="button">Imprimir Codigos</button>  
		</div>
		</div>
		
		<div class="col-lg-4 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                             {!! Form::label('descripcion', 'Descripción') !!}
			<input type="text" name="descripcion" value="{{$articulo->descripcion}}" class="form-control" placeholder="Descripción del Articulo...">   
			{!! Form::label('descripcion', 'Imagen') !!}
			<input type="file" name="imagen" class="form-control"><br>
			@if (($articulo->imagen)!="")
				<img src="{{asset('img/productos/'.$articulo->imagen)}}" height="200px" width="200px" class="img-rounded img-responsive center-block">
			@endif
			<label>IVA</label>
			@if(($articulo->iva)=="1")
				<input type="checkbox" value="1" name="iva" id="iva" class="checkbox" checked>     
            @else 
                <input type="checkbox" name="iva" id="iva" class="checkbox" >
            @endif 
			
            </div>
               
        </div>
		<div class="col-lg-12 col-sm-6 col-md-6 col-xs-6"><div class="form-group">
			<div class="form-group">
		<button class="btn btn-primary" type="submit">Guardar</button>
		<button class="btn btn-danger" type="reset">Cancelar</button>
 
		</div></div>
		</div>
		<div class="col-lg-4 col-sm-6 col-md-6 col-xs-6"><div class="form-group">
		
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
<script src="{{asset('js/JsBarcode.all.min.js')}}"></script>
<script src="{{asset('js/jquery.PrintArea.js')}}"></script>

<script>
//comprobamos si se pulsa una tecla
$("#codigobar").keyup(function(e){                  
              //obtenemos el texto introducido en el campo de b��squeda
    consulta = $("#codigobar").val();
    generarBarcode(consulta);
});

$("#nombre1").keyup(function(e){                  
              //obtenemos el texto introducido en el campo de b��squeda
ponernombre();
});

function ponernombre(){
        document.getElementById('titcodbar').value = document.getElementById('nombre1').value;

}


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





generarBarcode();
ponernombre();</script>
@stop





