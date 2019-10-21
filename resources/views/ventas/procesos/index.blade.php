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
                <div class="col-lg-8 col-md-9 col-sm-9 col-xs-12">
                    <div class="form-group">
                        <h4>
                            Cambio de Estado Proceso Orden
                        </h4>
                    </div>
                </div>
                <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <div class="input-group col-lg-12">
                            <input class="form-control" id="norden" name="norden"
                                placeholder="Número de Orden" type="number" value="">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" id="boton" type="submit">
                                    Buscar
                                </button>
                            </span>
                            </input>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-blue">
                            <i class="fa fa-gears">
                            </i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                Ordenes en proceso
                            </span>
                            <span class="info-box-number">
                                {{$procesos->count}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua">
                            <i class="fa fa-shopping-cart">
                            </i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                Ventas
                            </span>
                            <span class="info-box-number">
                                {{$procesos->ingresoventas+$procesos->sri+$procesos->quito}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green">
                            <i class="fa fa-optin-monster">
                            </i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                Diseño
                            </span>
                            <span class="info-box-number">
                                {{$procesos->disenador+$procesos->disenado+$procesos->ingresodiseno}}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow">
                            <i class="fa fa-print">
                            </i>
                        </span>
                        <div class="info-box-content">
                            <span class="info-box-text">
                                Produccion
                            </span>
                            <span class="info-box-number">
                                {{$procesos->ingresoproduccion+$procesos->impresion+$procesos->acabados }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="example">
                            <thead>
                                <th>
                                    # Orden
                                </th>
                                <th>
                                    Cliente
                                </th>
                                <th>
                                    Fecha Creación
                                </th>
                                <th>
                                    Fecha Entrega
                                </th>
                                <th>
                                    Agente
                                </th>
                                <th>
                                    Total
                                </th>
                                <th>
                                    Opciones
                                </th>
                            </thead>
                            @foreach ($ordenes as $cat)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$cat->idtb_ordenes)}}"
                                        target="_blank">
                                        {{$cat->idtb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{ $cat->nombre_comercial}}
                                </td>
                                <td>
                                    {{ $cat->fecha_inicio}}
                                </td>
                                <td>
                                    {{ $cat->fecha_entrega}}
                                </td>
                                <td>
                                    {{ $cat->asignador}}
                                </td>
                                <td>
                                    {{ $cat->total_venta}}
                                </td>
                                <td>
                                    <a href="{{URL::action('OrdenesController@show',$cat->idtb_ordenes)}}">
                                        <button class="btn btn-primary btn-xs" type="button">
                                            <span aria-hidden="true" class="glyphicon glyphicon-list-alt">
                                            </span>
                                        </button>
                                    </a>
                                    <a href="{{URL::action('ImprimirController@reportec',$cat->idtb_ordenes)}}"
                                        target="_blank">
                                        <button class="btn btn-success btn-xs" type="button">
                                            <span aria-hidden="true" class="glyphicon glyphicon-print">
                                            </span>
                                        </button>
                                    </a>
                                    @if((Auth::user()->id)==1||(Auth::user()->id)==3)
                                    <a href="{{URL::action('OrdenesController@borrarorden',$cat->idtb_ordenes)}}">
                                        <button class="btn btn-danger btn-xs"
                                            onclick="return confirm('Seguro que desea Eliminar?')" type="submit">
                                            <span aria-hidden="true" class="glyphicon glyphicon-trash">
                                            </span>
                                        </button>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">

    </div>
    <div class="row">

    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="callout callout-info">
            Ventas
        </div>
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Ingreso En Ventas
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title="{{$procesos->ingresoventas}} Ordenes"
                        data-toggle="tooltip" title="">
                        {{$procesos->ingresoventas}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                            @if($pro->idtb_descripcion_procesos == 1)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_idtb_ordenes)}}"
                                        target="_blank">
                                        {{$pro->tb_ordenes_idtb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->created_at}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- box.footer-->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Esperando Autorizacion SRI
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title=" {{$procesos->sri}} Ordenes"
                        data-toggle="tooltip" title="">
                        {{$procesos->sri}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                            @if($pro->idtb_descripcion_procesos == 3)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_idtb_ordenes)}}"
                                        target="_blank">
                                        {{$pro->tb_ordenes_idtb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->created_at}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- box.footer-->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Ordenes enviadas a Quito
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title=" {{$procesos->quito}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->quito}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                            @if($pro->idtb_descripcion_procesos == 7)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_idtb_ordenes)}}"
                                        target="_blank">
                                        {{$pro->tb_ordenes_idtb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->created_at}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
    </div>
    <!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
    <div class="col-md-6">
        <div class="callout callout-success">
            Diseño
        </div>
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Ordenes Sin Asignar Diseñador
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title=" {{$procesos->ingresodiseno}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->ingresodiseno}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                            @if($pro->idtb_descripcion_procesos == 2)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_idtb_ordenes)}}"
                                        target="_blank">
                                        {{$pro->tb_ordenes_idtb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->created_at}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- box.footer-->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Diseño en Proceso
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title="{{$procesos->disenador}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->disenador}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                            @if($pro->idtb_descripcion_procesos == 5)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_idtb_ordenes)}}"
                                        target="_blank">
                                        {{$pro->tb_ordenes_idtb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->created_at}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- box.footer-->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Diseñadas en espera de Aprobación
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title=" {{$procesos->disenado}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->disenado}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                            @if($pro->idtb_descripcion_procesos == 6)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_idtb_ordenes)}}"
                                        target="_blank">
                                        {{$pro->tb_ordenes_idtb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->created_at}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
    </div>
    <!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
    <div class="col-md-6">
        <div class="callout callout-warning">
            Producción
        </div>
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Ingreso a Producción
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title="{{$procesos->ingresoproduccion}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->ingresoproduccion}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                            @if($pro->idtb_descripcion_procesos == 8)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_idtb_ordenes)}}"
                                        target="_blank">
                                        {{$pro->tb_ordenes_idtb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->created_at}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- box.footer-->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    En Proceso de Impresión
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title=" {{$procesos->impresion}}
 Ordenes" data-toggle="tooltip" title="">
                        {{$procesos->impresion}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                            @if($pro->idtb_descripcion_procesos == 14)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_idtb_ordenes)}}"
                                        target="_blank">
                                        {{$pro->tb_ordenes_idtb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->created_at}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
        <!-- box.footer-->
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    Ordenes en Acabados Finales
                </h3>
                <div class="box-tools pull-right">
                    <span class="badge badge bg-aqua" data-original-title="{{$procesos->acabados}} Ordenes"
                        data-toggle="tooltip" title="">
                        {{$procesos->acabados}}
                    </span>
                    <button class="btn btn-box-tool" data-widget="collapse" type="button">
                        <i class="fa fa-plus">
                        </i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table no-margin">
                        <thead>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Ingreso
                                </th>
                                <th>
                                    Asignado por
                                </th>
                                <th>
                                    Retraso
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($procesos as $pro)
                            @if($pro->idtb_descripcion_procesos == 15)
                            <tr>
                                <td>
                                    <a href="{{URL::action('ProcesosController@show',$pro->tb_ordenes_idtb_ordenes)}}"
                                        target="_blank">
                                        {{$pro->tb_ordenes_idtb_ordenes}}
                                    </a>
                                </td>
                                <td>
                                    {{$pro->created_at}}
                                </td>
                                <td>
                                    <span class="label label-success">
                                        {{$pro->asignado}}
                                    </span>
                                </td>
                                <td>
                                    {{$pro->retraso}}
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
        </div>
    </div>
</div>
<!-- idasmimdsvkjsf vsndk jnsdkfnsdjk fskdjfnskjdfsjd,fnsdjf,ns ,dfsjd,fsdnfjdb,,,nsd, z,k/.box-footer -->
@stop

@section('css')

@stop

@section('js')
<script src="{{ asset('/js/moment-with-locales.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/selectdinamico-procesos.js') }}" type="text/javascript">
</script>
<script>
    $("#norden").keyup(function(e){                      
           consulta = $("#norden").val();
            console.log(consulta);
        });
    
    $('#boton').click(function(){
    location.href='procesos/'+consulta;
            });
</script>
@stop