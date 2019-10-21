@extends('adminlte::page')

@section('title', 'Procesos')

@section('content_header')
<h1>Listado de Procesos</h1>
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

                {!!Form::open(array('url'=>'ventas/procesos','method'=>'POST','autocomplete'=>'off'))!!}
                {!!Form::token()!!}

              
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                            @foreach($procesos1 as $proceso)
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h2>
                                    Orden # {{$proceso->tb_ordenes_idtb_ordenes}}

                                </h2>
                                <p>
                                    {{$proceso->descripcion_procesos}}
                                </p>
                                <p id="fecha">
                                    {{$proceso->created_at}}
                                </p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-shopping-cart">
                                </i>
                            </div>
                            <a class="small-box-footer">
                                Modificado por: {{$proceso->asignador}}
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group" id="selectores">
                        <select class="form-control" id="idtb_descripcion_procesos" name="idtb_descripcion_procesos"
                            onchange="MostrarFact();" required="">
                            <option disabled="" selected="" value="">
                                Enviar Orden a
                            </option>
                            @foreach($listadoprocesos as $listadoproceso)
                            @foreach($procesos1 as $pro)
                            @if($listadoproceso->tb_departamentos_idtb_departamentos == $iddep||$iddep==1)
                            @if($listadoproceso->idtb_descripcion_procesos!=$pro->idtb_descripcion_procesos)
                            <option value="{{$listadoproceso->idtb_descripcion_procesos}}">
                                {{$listadoproceso->descripcion_procesos}}
                            </option>
                            @endif
                            @endif
                            @endforeach
                            @endforeach
                        </select>
                    </div>

                    @if($iddep!=4)
                    <!--ID de ventas -->
                    @if(Auth::user()->tb_tipo_usuario_idtb_tipo_usuario==1)
                    <div class="form-group" id="selectores1">
                        <select class="form-control" id="asignado" name="asignado" required="">
                            <option disabled="" selected="" value="">
                                Asignar Empleado
                            </option>
                            @foreach($usuarios as $usuario)

                            <option value="{{$usuario->id}}">{{$usuario->name}}</option>

                            @endforeach
                        </select>
                    </div>
                    @else
                    <div class="form-group" id="selectores1">
                        <select class="form-control" id="asignado" name="asignado" required="">
                            <option disabled="" selected="" value="">
                                Asignar Empleado
                            </option>
                            @foreach($usuariosdep as $usuariodep)

                            <option value="{{$usuariodep->id}}">{{$usuariodep->name}}</option>

                            @endforeach
                        </select>
                    </div>
                    @endif
                    @else
                    <input id="asignado" name="asignado" type="hidden" value="{{Auth::user()->id}}">
                    </input>
                    @endif
                    <div class="form-group" id="numfactura">
                        {!!Form::number('num_factura',null,['id'=>'num_factura','class'=>'form-control','placeholder'=>'Número
                        de Factura'])!!}
                    </div>
                    <div class="form-group" id="selectores2">
                        {!!Form::submit('Enviar',['class'=>'form-control btn btn-primary'])!!}
                    </div>
                </div>
                <input id="asignador" name="asignador" type="hidden" value="{{Auth::user()->id}}">
                </input>
                <input id="tb_ordenes_idtb_ordenes" name="tb_ordenes_idtb_ordenes" type="hidden"
                    value="{{$idorden}}">
                </input>
                <div class="col-lg-8 col-sm-12 col-md-12 col-xs-12">
                    <table class="table table-striped table-bordered table-condensed table-hover" id="tablaprocesos">
                        <thead style="background-color: #A9D0F5">
                            <th>
                                Departamento
                            </th>
                            <th>
                                Proceso
                            </th>
                            <th>
                                Fecha
                            </th>
                            <th>
                                Empleado
                            </th>
                            <th>
                                Asignado por
                            </th>
                            <th>
                                Opciones
                            </th>
                        </thead>
                        @foreach($procesos as $pro)
                        <tbody>
                            <td>
                                @if($pro->idtb_departamentos==1)
                                <span class="label label-info">
                                    {{$pro->departamento}}
                                </span>
                                @elseif($pro->idtb_departamentos==2)
                                <span class="label label-info">
                                    {{$pro->departamento}}
                                </span>
                                @elseif($pro->idtb_departamentos==3)
                                <span class="label label-warning">
                                    {{$pro->departamento}}
                                </span>
                                @elseif($pro->idtb_departamentos==4)
                                <span class="label label-success">
                                    {{$pro->departamento}}
                                </span>
                                @elseif($pro->idtb_departamentos==5)
                                <span class="label label-danger">
                                    {{$pro->departamento}}
                                </span>
                                @endif
                            </td>
                            <td>
                                {{$pro->descripcion_procesos}}
                            </td>
                            <td id="fechas">
                                {{$pro->created_at}}
                            </td>
                            <td>
                                {{$pro->asignado}}
                            </td>
                            <td>
                                {{$pro->asignador}}
                            </td>
                            <td>
                                @if ($pro->descripcion_procesos=='Producción')
                                hola
                                @endif
                            </td>
                        </tbody>
                        @endforeach
                    </table>

                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="panel ">
            <div class="panel-body">
                <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                    <div class="box box-warning box-solid collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Producción</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-striped table-bordered table-condensed table-hover"
                                id="tablaprocesos">
                                <thead style="background-color: #A9D0F5">
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Articulo
                                    </th>
                                    <th>
                                        Realizado
                                    </th>
                                    <th>
                                        Faltante
                                    </th>
                                    <th>%</th>
                                    <th>
                                        Opciones
                                    </th>
                                </thead>

                                @foreach ($detalleorden as $dt)

                                <tbody>

                                    <tr>
                                        <td>
                                            {{$dt->cantidad}}
                                        </td>
                                        <td>
                                            {{$dt->nombre}}
                                        </td>
                                        <td>
                                            {{$dt->suma_pro}}

                                        </td>
                                        <td>
                                            {{$dt->cantidad-$dt->suma_pro}}
                                        </td>
                                        <td>
                                            <span class="pull-right badge bg-red">{{(100* $dt->suma_pro)/$dt->cantidad}}
                                                %</span>
                                        </td>
                                        <td>
                                            <a title="Agregar Producción" href=""
                                                data-target="#modalagregarproduccion-{{$dt->idtb_detalle_orden}}"
                                                data-toggle="modal"><button type="button"
                                                    class="btn btn-success btn-xs"><span
                                                        class="glyphicon glyphicon-plus"
                                                        aria-hidden="true"></span></button></a>
                                        </td>
                                    </tr>

                                </tbody>

                                @include('ventas.procesos.modalagregarproduccion')

                                @endforeach

                            </table>
                            <hr>
                            <table class="table table-striped table-bordered table-condensed table-hover"
                                id="tablaprocesos">
                                <thead style="background-color: #A9D0F5">
                                    <th>
                                        Cantidad
                                    </th>

                                    <th>
                                        Artículo
                                    </th>

                                    <th>
                                        Agregado Por
                                    </th>
                                    <th>
                                        Departamento
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                </thead>
                                @foreach ($produccion as $prod)
                                @if($prod->tb_departamentos_idtb_departamentos==4)
                                <tbody>

                                    <td>
                                        {{$prod->cantidad}}
                                    </td>


                                    <td>
                                        {{$prod->nombre}}
                                    </td>

                                    <td>
                                        {{$prod->name}}
                                    </td>
                                    <td>
                                        @if($prod->idtb_departamentos==1)
                                        <span class="label label-info">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==2)
                                        <span class="label label-info">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==3)
                                        <span class="label label-warning">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==4)
                                        <span class="label label-success">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==5)
                                        <span class="label label-danger">
                                            {{$prod->departamento}}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$prod->fecha}}
                                    </td>

                                </tbody>
                                @endif


                                @endforeach

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                    <div class="box box-success box-solid collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Confección </h3>
                            <div class="box-tools pull-right">
                             
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-striped table-bordered table-condensed table-hover"
                                id="tablaprocesos">
                                <thead style="background-color: #A9D0F5">
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Articulo
                                    </th>
                                    <th>
                                        Realizado
                                    </th>
                                    <th>
                                        Faltante
                                    </th>
                                    <th>%</th>
                                    <th>
                                        Opciones
                                    </th>
                                </thead>

                                @foreach ($detalleorden as $dt)

                                <tbody>

                                    <tr>
                                        <td>
                                            {{$dt->cantidad}}
                                        </td>
                                        <td>
                                            {{$dt->nombre}}
                                        </td>
                                        <td>
                                            {{$dt->suma_con}}
                                        </td>
                                        <td>
                                            {{$dt->cantidad-$dt->suma_con}}
                                        </td>
                                        <td>
                                            <span class="pull-right badge bg-red">{{(100* $dt->suma_con)/$dt->cantidad}}
                                                %</span>
                                        </td>
                                        <td>
                                            <a title="Agregar Producción" href=""
                                                data-target="#modalagregarconfeccion-{{$dt->idtb_detalle_orden}}"
                                                data-toggle="modal"><button type="button"
                                                    class="btn btn-success btn-xs"><span
                                                        class="glyphicon glyphicon-plus"
                                                        aria-hidden="true"></span></button></a>
                                        </td>
                                    </tr>

                                </tbody>

                                @include('ventas.procesos.modalagregarconfeccion')

                                @endforeach

                            </table>
                            <hr>
                            <table class="table table-striped table-bordered table-condensed table-hover"
                                id="tablaprocesos">
                                <thead style="background-color: #A9D0F5">
                                    <th>
                                        Cantidad
                                    </th>

                                    <th>
                                        Artículo
                                    </th>

                                    <th>
                                        Agregado Por
                                    </th>
                                    <th>
                                        Departamento
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                </thead>
                                @foreach ($produccion as $prod)
                                @if($prod->tb_departamentos_idtb_departamentos==5)
                                <tbody>

                                    <td>
                                        {{$prod->cantidad}}
                                    </td>


                                    <td>
                                        {{$prod->nombre}}
                                    </td>

                                    <td>
                                        {{$prod->name}}
                                    </td>
                                    <td>
                                        @if($prod->idtb_departamentos==1)
                                        <span class="label label-info">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==2)
                                        <span class="label label-info">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==3)
                                        <span class="label label-warning">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==4)
                                        <span class="label label-success">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==5)
                                        <span class="label label-danger">
                                            {{$prod->departamento}}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$prod->fecha}}
                                    </td>
                                </tbody>

                                @endif

                                @endforeach

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                    <div class="box box-danger box-solid collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Etiquetado</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-striped table-bordered table-condensed table-hover"
                                id="tablaprocesos">
                                <thead style="background-color: #A9D0F5">
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Articulo
                                    </th>
                                    <th>
                                        Realizado
                                    </th>
                                    <th>
                                        Faltante
                                    </th>
                                    <th>%</th>
                                    <th>
                                        Opciones
                                    </th>
                                </thead>

                                @foreach ($detalleorden as $dt)

                                <tbody>

                                    <tr>
                                        <td>
                                            {{$dt->cantidad}}
                                        </td>
                                        <td>
                                            {{$dt->nombre}}
                                        </td>
                                        <td>
                                            {{$dt->suma_eti}}
                                        </td>
                                        <td>
                                            {{$dt->cantidad-$dt->suma_eti}}
                                        </td>
                                        <td>
                                            <span class="pull-right badge bg-red">{{(100* $dt->suma_eti)/$dt->cantidad}}
                                                %</span>
                                        </td>
                                        <td>
                                            <a title="Agregar Producción" href=""
                                                data-target="#modalagregaretiquetado-{{$dt->idtb_detalle_orden}}"
                                                data-toggle="modal"><button type="button"
                                                    class="btn btn-success btn-xs"><span
                                                        class="glyphicon glyphicon-plus"
                                                        aria-hidden="true"></span></button></a>
                                        </td>
                                    </tr>

                                </tbody>

                                @include('ventas.procesos.modalagregaretiquetado')

                                @endforeach

                            </table>
                            <hr>
                            <table class="table table-striped table-bordered table-condensed table-hover"
                                id="tablaprocesos">
                                <thead style="background-color: #A9D0F5">
                                    <th>
                                        Cantidad
                                    </th>

                                    <th>
                                        Artículo
                                    </th>

                                    <th>
                                        Agregado Por
                                    </th>
                                    <th>
                                        Departamento
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                </thead>
                                @foreach ($produccion as $prod)
                                @if($prod->tb_departamentos_idtb_departamentos==6)
                                <tbody>

                                    <td>
                                        {{$prod->cantidad}}
                                    </td>


                                    <td>
                                        {{$prod->nombre}}
                                    </td>

                                    <td>
                                        {{$prod->name}}
                                    </td>
                                    <td>
                                        @if($prod->idtb_departamentos==1)
                                        <span class="label label-info">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==2)
                                        <span class="label label-info">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==3)
                                        <span class="label label-warning">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==4)
                                        <span class="label label-success">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==5)
                                        <span class="label label-danger">
                                            {{$prod->departamento}}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$prod->fecha}}
                                    </td>
                                </tbody>
                                @endif


                                @endforeach

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                    <div class="box box-info box-solid collapsed-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Empaquetado</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table class="table table-striped table-bordered table-condensed table-hover"
                                id="tablaprocesos">
                                <thead style="background-color: #A9D0F5">
                                    <th>
                                        Cantidad
                                    </th>
                                    <th>
                                        Articulo
                                    </th>
                                    <th>
                                        Realizado
                                    </th>
                                    <th>
                                        Faltante
                                    </th>
                                    <th>%</th>
                                    <th>
                                        Opciones
                                    </th>
                                </thead>

                                @foreach ($detalleorden as $dt)

                                <tbody>

                                    <tr>
                                        <td>
                                            {{$dt->cantidad}}
                                        </td>
                                        <td>
                                            {{$dt->nombre}}
                                        </td>
                                        <td>
                                            {{$dt->suma_emp}}
                                        </td>
                                        <td>
                                            {{$dt->cantidad-$dt->suma_emp}}
                                        </td>
                                        <td>
                                            <span class="pull-right badge bg-red">{{(100* $dt->suma_emp)/$dt->cantidad}}
                                                %</span>
                                        </td>
                                        <td>
                                            <a title="Agregar Producción" href=""
                                                data-target="#modalagregarempaquetado-{{$dt->idtb_detalle_orden}}"
                                                data-toggle="modal"><button type="button"
                                                    class="btn btn-success btn-xs"><span
                                                        class="glyphicon glyphicon-plus"
                                                        aria-hidden="true"></span></button></a>
                                        </td>
                                    </tr>

                                </tbody>

                                @include('ventas.procesos.modalagregarempaquetado')

                                @endforeach

                            </table>
                            <hr>
                            <table class="table table-striped table-bordered table-condensed table-hover"
                                id="tablaprocesos">
                                <thead style="background-color: #A9D0F5">
                                    <th>
                                        Cantidad
                                    </th>

                                    <th>
                                        Artículo
                                    </th>

                                    <th>
                                        Agregado Por
                                    </th>
                                    <th>
                                        Departamento
                                    </th>
                                    <th>
                                        Fecha
                                    </th>
                                </thead>
                                @foreach ($produccion as $prod)
                                @if($prod->tb_departamentos_idtb_departamentos==7)
                                <tbody>

                                    <td>
                                        {{$prod->cantidad}}
                                    </td>


                                    <td>
                                        {{$prod->nombre}}
                                    </td>

                                    <td>
                                        {{$prod->name}}
                                    </td>
                                    <td>
                                        @if($prod->idtb_departamentos==1)
                                        <span class="label label-info">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==2)
                                        <span class="label label-info">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==3)
                                        <span class="label label-warning">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==4)
                                        <span class="label label-success">
                                            {{$prod->departamento}}
                                        </span>
                                        @elseif($prod->idtb_departamentos==5)
                                        <span class="label label-danger">
                                            {{$prod->departamento}}
                                        </span>
                                        @endif
                                    </td>
                                    <td>
                                        {{$prod->fecha}}
                                    </td>
                                </tbody>
                                @endif


                                @endforeach

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>



            </div>
        </div>
    </div>
</div>

@stop

@section('css')

@stop

@section('js')
<script src="{{ asset('/js/moment-with-locales.js') }}" type="text/javascript">
</script>
<script>
    function titulo(){      
    document.title = 'Proceso Orden # '+{{$idorden}}+' | Procesos'; }
titulo();
</script>
<script>
    moment.locale('es');
    @foreach($procesos1 as $proceso)
    var formatofecha = '{{$proceso->created_at}}'; 
    @endforeach
    $("#fecha").html("El "+ moment(formatofecha).format('LLLL'));
     
$("#numfactura").hide();
@foreach($procesos1 as $proceso)
var compruebafactura = '{{$proceso->descripcion_procesos}}';
@endforeach
if(compruebafactura=="Facturado")
{
    $("#selectores").hide();
        $("#selectores1").hide();
            $("#selectores2").hide();
}
else{
    $("#selectores").show();
        $("#selectores1").show();
            $("#selectores2").show();
}
console.log(compruebafactura);
    
function MostrarFact(){
    datosprocesos =document.getElementById('idtb_descripcion_procesos').value;
    procesoselecionado = $("#idtb_descripcion_procesos option:selected").text();
    if(procesoselecionado.trim()=="Facturado"){
        $("#numfactura").show();
    }
    else
    {
        $("#numfactura").hide();
    }
     console.log(procesoselecionado);
}
</script>
@stop