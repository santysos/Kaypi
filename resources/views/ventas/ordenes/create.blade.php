@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Listado de Usuarios</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">
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
             
                        <div class="progress">
                            <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" class="progress-bar progress-bar-primary" role="progressbar" style="width: 100%">
                                <span class="">
                                    Datos Generales
                                </span>
                            </div>
                        </div>
                        {!!Form::Open(array('url'=>'ventas/ordenes','method'=>'POST','autocomplete'=>'off'))!!}
                        {!!Form::token()!!}
                        <input id="usuario" name="usuario" type="hidden" value="{{ Auth::user()->id }}"/>
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            {!!Form::text('Cliente',null,['id'=>'Cliente','class'=>'form-control','required' => 'required','placeholder'=>'Buscar Cliente'])!!}
                        </div>
                        
                        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    Entrega
                                </span>
                                {!!Form::text('fecha_entrega',null,['id'=>'fecha_entrega','required' => 'required','class'=>'form-control','placeholder'=>'Fecha de Entrega'])!!}
                            </div>
                        </div>
                    
                        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                            {!!Form::text('NombreComercial',null,['id'=>'NombreComercial','class'=>'form-control','required' => 'required','readonly','placeholder'=>'Nombre Comercial - Razon Social'])!!}
                        </div>
                        <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                            {!!Form::text('tb_cliente_idtb_cliente',null,['id'=>'tb_cliente_idtb_cliente','class'=>'form-control','readonly','placeholder'=>'Código Cliente'])!!}
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            {!!Form::text('Cedula_Ruc',null,['id'=>'Cedula_Ruc','class'=>'form-control','readonly','placeholder'=>'Ruc / Ced'])!!}
                        </div>
                        <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::text('Telefono',null,['id'=>'Telefono','class'=>'form-control','readonly','placeholder'=>'Telefono'])!!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::text('Email',null,['id'=>'Email','class'=>'form-control','readonly','placeholder'=>'Email'])!!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="progress">
                                <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" class="progress-bar progress-bar-primary" role="progressbar" style="width: 100%">
                                    <span class="">
                                        Detalles de la Orden
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-4 col-xs-12">  
                            <div class="form-group">
                              <select tabindex="2" name="servicios" id="servicios" class="form-control selectpicker" data-live-search="true">
                                              <option value="" disabled selected>Buscar Articulo</option>
                                        @foreach($articulos as $articulo)
                             <option value="{{$articulo->idtb_articulo}}">{{$articulo->articulo}}</option>
                                        @endforeach
                                    </select>
                            </div>
                          </div>
                          <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            {!!Form::number('Cantidad',null,['id'=>'Cantidad','class'=>'form-control','placeholder'=>'Cantidad'])!!}
                        </div>
                          <div class="col-lg-2 col-sm-3 col-md-2 col-xs-12">  
                            <div class="form-group">
                              {!!Form::select('pprecio_venta',['placeholder'=>'0.00'],null,['id'=>'pprecio_venta','onchange'=>'calcularValorTotal();','class'=>'form-control'])!!}
                            </div>
                          </div>
                        <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::number('valorto',null,['id'=>'valorto','class'=>'form-control ','placeholder'=>'Valor Total'])!!}
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                {!!Form::textarea('descripcionorden',null,['id'=>'descripcionorden','class'=>'form-control','placeholder'=>'Descripción','size' => '30x3','maxlength'=>'180'])!!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="form-group">
                                <button class="btn btn-info btn-xs btn-block" id="bt_add" type="button">
                                    Agregar
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
                        </div>
                        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                            <table class="table table-striped table-bordered table-condensed table-hover" id="detalles">
                                <thead style="background-color: #A9D0F5">
                                    <th colspan="2">
                                        Opciones
                                    </th>
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Productos
                                    </th>
                                    <th>
                                        Descripción
                                    </th>
                                    <th>
                                        Valor Unitario
                                    </th>
                                    <th>
                                        Valor Total
                                    </th>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="6">
                                            <p align="right">
                                                Subtotal:
                                            </p>
                                        </th>
                                        <th>
                                            <p align="right">
                                                <span id="Sub_Total">
                                                    $ 0.00
                                                </span>
                                                <input id="Sub_Total1" name="Sub_Total1" type="hidden"/>
                                            </p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="6">
                                            <p align="right">
                                                IVA 12%:
                                            </p>
                                        </th>
                                        <th>
                                            <p align="right">
                                                <span id="total_impuesto">
                                                    $ 0.00
                                                </span>
                                            </p>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="6">
                                            <p align="right">
                                                TOTAL:
                                            </p>
                                        </th>
                                        <th>
                                            <p align="right">
                                                <span align="right" id="total_pagar">
                                                    $ 0.00
                                                </span>
                                                <input id="total_venta" name="total_venta" type="hidden"/>
                                            </p>
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="box">
                                <div class="box box-default box-solid collapsed-box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            Observaciones
                                        </h3>
                                        <div class="box-tools pull-right">
                                            <!-- Collapse Button -->
                                            <button class="btn btn-box-tool" data-widget="collapse" type="button">
                                                <i class="fa fa-plus">
                                                </i>
                                            </button>
                                        </div>
                                        <!-- /.box-tools -->
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            {!!Form::textarea('observaciones',null,['id'=>'observaciones','class'=>'form-control','placeholder'=>'Observaciones de la Orden en General','size' => '30x3'])!!}
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                                <!-- /.box -->
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
                            <div class="form-group">
                                {!!Form::number('abono',null,['id'=>'abono','step'=>'0.01','class'=>'form-control','required'=>'required','placeholder'=>'Abono'])!!}
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
                            {!!Form::text('Saldo',null,['id'=>'Saldo','class'=>'form-control','readonly','placeholder'=>'Saldo'])!!}
                        </div>
                        <div class="col-lg-12 col-sm-6 col-md-6 col-xs-6" id="guardar">
                            <div class="form-group">
                                <input name="_token" type="hidden" value="{{csrf_token()}}"/>
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
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-select.min.css')}}"/>  
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}"/>  

@stop

@section('js')
<script src="{{ asset('/js/bootstrap-select.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/selectdinamico.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/buscaclientes.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/moment.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/moment/locale/es.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/selectdinamicoprecios.js') }}" type="text/javascript">
</script>
<script>
    function titulo(){      
    document.title = 'Nueva Orden | Ordenes'; }
titulo();
</script>
<script>
    $(document).ready(function() {
     evaluar();

        $('#bt_add').click(function(){
            agregar();
        });

        $('#fecha_entrega').datetimepicker({

        daysOfWeekDisabled: [0, 7],
        sideBySide: true,
        locale: 'es',
        format: 'DD-MM-YYYY  HH:mm'
        });
    });

    subtotal=[];
    cont=0;
    total=0;
    $("#guardar").hide();

    $("#abono").keyup(function(e){                      
    consulta = $("#abono").val();
    if(consulta!="")
        CalculaAbono(consulta);
    else{
        $("#Saldo").val("Ingrese El Abono");
    }

    });
    


    

function agregar(){

idservicios = $("#servicios option:selected").val();
servicios = $("#servicios option:selected").text();
cantidad = $("#Cantidad").val();    

valortotal = $("#valorto").val();
calcularValorTotal();
descripcion = $("#descripcionorden").val();

console.log(idservicios+servicios+" "+total);


if (idservicios!="" &&descripcion!="" && cantidad!="" && cantidad>0 && valortotal!="")
{
    
        subtotal[cont] = (cantidad*valortotal);
        total=total+subtotal[cont];

        var fila = '<tr class="selected" id="fila'+cont+'"><td colspan="2" ><button tabindex="1" type"button" class="btn btn-xs btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input readonly type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td><input readonly type="hidden" name="idservicios[]" value="'+idservicios+'">'+servicios+'</td><td><input readonly type="hidden" name="descripcion[]" value="'+descripcion+'">'+descripcion+'</td><td><input readonly type="hidden" name="valortotal[]" value="'+parseFloat(valortotal).toFixed(6)+'">'+parseFloat(valortotal).toFixed(2)+'</td><td>'+parseFloat(subtotal[cont]).toFixed(2)+'</td></tr>';

        cont++;
        
        $("#Sub_Total").html("$ "+ total);
        $("#total_venta").val(total.toFixed(2));
        totales();
        evaluar();

        $('#detalles').append(fila);
        limpiar();

    
}
else
    {
        alert('Revise los datos del Articulo')
    }
}

function calcularValorTotal(){
console.log("hola desde valortotla");
    cantidad = $("#Cantidad").val();
    precio = $("#pprecio_venta option:selected").val();  
    console.log(precio+cantidad);
    if(cantidad>0){
       
        $("#valorto").val(precio);
    }   
    
}
function totales()
  {
        $("#Sub_Total").html("$ " + (total).toFixed(2));
        $("#total_venta").val((total).toFixed(2));
        
        total_impuesto= (total*0.12) ;
        total_pagar=(total)+total_impuesto;
        $("#total_impuesto").html("$ " + total_impuesto.toFixed(2));
        $("#total_pagar").html("$ " + total_pagar.toFixed(2));
        
  }
function evaluar()
    {
        if (total>0)
        {
            $("#guardar").show();
        }
        else
        {
            $("#guardar").hide();
        }
    }
function limpiar()
    {
        $("#Cantidad").val("1");
        $("#valorto").val("");
        $("#descripcionorden").val("");
        
        stock=0;
    }
function eliminar(index)
    {
        total=total-subtotal[index];
        $("#Sub_Total").html("$ "+ total);
        $("#total_venta").val(total.toFixed(2));
        $("#fila" + index).remove();
        evaluar();
        totales();
    }
function CalculaAbono(consulta)
    {

        if((total_pagar-consulta)<0)
            {
                $("#Saldo").val("El Abono Supera el Total");
                document.getElementById('Saldo').style.backgroundColor='#dd4b39';
                document.getElementById('Saldo').style.color='#ffffff';
            }
        else{   console.log(total_pagar);
            
                $("#Saldo").val("$ " + (total_pagar-consulta).toFixed(2));
                document.getElementById('Saldo').style.backgroundColor='#00a65a';
                document.getElementById('Saldo').style.color='#ffffff';
            }   


    }
</script>
@stop







