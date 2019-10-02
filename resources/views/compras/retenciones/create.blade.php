@extends('adminlte::page')

@section('title', 'Nueva Retención | Retenciones')

@section('content_header')
<h1>Nueva Retención</h1>
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
                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="40"
                        class="progress-bar progress-bar-primary" role="progressbar" style="width: 100%">
                        <span class="">
                            Datos Generales
                        </span>
                    </div>
                </div>
                {!!Form::Open(array('url'=>'compras/retenciones','method'=>'POST','autocomplete'=>'off'))!!}
                {!!Form::token()!!}
                <input id="usuario" name="usuario" type="hidden" value="{{ Auth::user()->id }}"/>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    {!!Form::text('Cliente',null,['id'=>'Cliente','class'=>'form-control','required' =>
                    'required','placeholder'=>'Buscar Proveedor'])!!}
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group input-group">
                        <span class="input-group-addon" id="basic-addon1">
                            Fecha:
                        </span>
                        {!!Form::text('fecha',null,['id'=>'fecha','required' =>
                        'required','class'=>'form-control','placeholder'=>'Fecha de Entrega'])!!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                    {!!Form::text('numero',null,['id'=>'numero','class'=>'form-control','required' =>
                    'required','placeholder'=>'Número Comprobante de Venta'])!!}
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                        {!!Form::text('secuencial',$ultimo_num_retencion+1,['readonly','id'=>'secuencial','class'=>'form-control','required' =>
                        'required','placeholder'=>'Secuencial'])!!}
                    </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                    {!!Form::hidden('razon_social',null,['id'=>'razon_social','class'=>'form-control','required' =>
                    'required','readonly','placeholder'=>'Nombre Comercial - Razon Social'])!!}
                    {!!Form::text('razon_social_comercial',null,['id'=>'razon_social_comercial','class'=>'form-control','required' =>
                    'required','readonly','placeholder'=>'Nombre Comercial - Razon Social'])!!}
                </div>
                <div class="col-lg-1 col-md-12 col-sm-12 col-xs-12">
                    {!!Form::text('tb_cliente_idtb_cliente',null,['id'=>'tb_cliente_idtb_cliente','class'=>'form-control','readonly','placeholder'=>'Código
                    Cliente'])!!}
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                    {!!Form::text('documento',null,['id'=>'documento','class'=>'form-control','readonly','placeholder'=>'Ruc / Ced'])!!}
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        {!!Form::text('Telefono',null,['id'=>'Telefono','class'=>'form-control','readonly','placeholder'=>'Telefono'])!!}
                    </div>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        {!!Form::text('Email',null,['id'=>'Email','class'=>'form-control','readonly','placeholder'=>'Email'])!!}
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        {!!Form::text('direccion_establecimiento',null,['id'=>'direccion_establecimiento','readonly','class'=>'form-control','required'
                        => 'required','placeholder'=>'Dirección'])!!}
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="progress">
                        <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="40"
                            class="progress-bar progress-bar-primary" role="progressbar" style="width: 100%">
                            <span class="">
                                Detalles de la Retención
                            </span>
                        </div>
                    </div>
                </div>

                
                <div class="col-lg-4 col-sm-3 col-md-2 col-xs-12">
                    <div class="form-group">
                        {!!Form::select('impuesto',['placeholder'=>'Impuesto','1' => 'RENTA', '2' => 'IVA','6' => 'ISD'],null,['id'=>'impuesto','onchange'=>'calcularValorTotal();','class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="col-lg-4 col-sm-3 col-md-2 col-xs-12">
                    <div class="form-group">
                        {!!Form::select('porcentaje',['placeholder'=>'Porcentaje %'],null,['id'=>'porcentaje','onchange'=>'calcularValorTotal();','class'=>'form-control'])!!}
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        {!!Form::number('base_imponible',null,['id'=>'base_imponible','class'=>'form-control','placeholder'=>'Base Imponible'])!!}
                </div>
     
                <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6">
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
                                Impuesto
                            </th>
                            <th>
                                Porcentaje                                </th>
                            <th>
                                    Base Imponible
                                </th>
                           
                            <th>
                                Valor Total
                            </th>
                        </thead>
                        <tfoot>
                            
                            <tr>
                                <th colspan="5">
                                    <p align="right">
                                        TOTAL RETENCIÓN:
                                    </p>
                                </th>
                                <th>
                                    <p align="right">
                                        <span align="right" id="total_pagar">
                                            $ 0.00
                                        </span>
                                        <input id="total_venta" name="total_venta" type="hidden" />
                                    </p>
                                </th>
                            </tr>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                </div>
             
                <div class="col-lg-12 col-sm-6 col-md-6 col-xs-6" id="guardar">
                    <div class="form-group">
                        <input name="_token" type="hidden" value="{{csrf_token()}}" />
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
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-select.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}" />

@stop

@section('js')
<script src="{{ asset('/js/bootstrap-select.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/sel_din_impuesto_retenciones.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/buscaclienteretenciones.js') }}" type="text/javascript">
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

        $('#fecha').datetimepicker({

        daysOfWeekDisabled: [0, 7],
        sideBySide: true,
        locale: 'es',
        format: 'YYYY-MM-DD'
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

idimpuesto = $("#impuesto option:selected").val();
impuesto = $("#impuesto option:selected").text();
idporcentaje = $("#porcentaje option:selected").val();
porcentaje = $("#porcentaje option:selected").text();
base_imponible = $("#base_imponible").val();    

calcularValorTotal();

console.log(idimpuesto+impuesto+" "+total);


if (idimpuesto!="" && base_imponible!="" && base_imponible>0.01)
{
        elporcentaje = porcentaje /100;
        total_impuesto= elporcentaje*base_imponible;
        console.log(total_impuesto);

        subtotal[cont] = (total_impuesto);
        console.log(subtotal[cont]+"hola1");
        total=total+subtotal[cont];
        console.log(total);

        var fila = '<tr class="selected" id="fila'+cont+'"><td colspan="2" ><button tabindex="1" type"button" class="btn btn-xs btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input readonly type="hidden" name="id_impuesto[]" value="'+idimpuesto+'">'+impuesto+'</td><td><input readonly type="hidden" name="id_porcentaje[]" value="'+idporcentaje+'">'+porcentaje+'<input readonly type="hidden" name="id_porcentaje_valor[]" value="'+porcentaje+'"></td><td><input readonly type="hidden" name="id_base_imponible[]" value="'+base_imponible+'">'+parseFloat(base_imponible).toFixed(2)+'</td><td><input readonly type="hidden" name="valortotal[]" value="'+parseFloat(total_impuesto).toFixed(6)+'">'+parseFloat(total_impuesto).toFixed(2)+'</td></tr>';

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
    base_imponible = $("#base_imponible").val();
    precio = $("#pprecio_venta option:selected").val();  
    if(base_imponible>0){
       
        $("#valorto").val(precio);
    }   
    
}
function totales()
  {
   
        $("#total_venta").val((total).toFixed(2));
        
        total_impuesto= (total) ;
        total_pagar=(total);
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
        $("#base_imponible").val("");
        $("#porcentaje").val("");
        $("#impuesto").val("");
        
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

</script>
@stop