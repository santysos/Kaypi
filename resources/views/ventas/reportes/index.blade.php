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
                <div class="col-lg-12 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <h4>
                            Reporte de Ventas del
                            <strong>
                                {{$f1->format('F j, Y')}}
                            </strong>
                            al
                            <strong>
                                {{$f2->format('F j, Y')}}
                            </strong>
                        </h4>
                        {!!
                        Form::open(array('url'=>'ventas/reportes','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
                        <div class="col-md-4">
                            Fecha de Inicio
                            <div class="form-group">
                                <div class="input-group date" id="s1">
                                    <input class="form-control" name="s1" type="text" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            Fecha Final
                            <div class="form-group">
                                <div class="input-group date" id="s2">
                                    <input class="form-control" name="s2" type="text" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar">
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            .
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">
                                    Buscar
                                </button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="panel ">
            <div class="panel-body">
                <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-yellow">
                            <div class="inner">
                                <h3>${{$ventas->sumatotal}}</h3>
                                <p>Ventas KAYPI</p>
                                <h6># de Ventas - {{$ventas->contador}}</h6>
                                <h6>Efectivo | {{$ventas->contefectivo}} | ${{$ventas->sumaefectivo}}</h6>
                                <h6>Tarjeta | {{$ventas->conttarjeta}} | ${{$ventas->sumatarjeta}}</h6>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">KAYPI</a>
                        </div>
                    </div>

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>${{$ventas->sumatotal1}}</h3>
                            <p>Ventas Otavalo</p>
                            <h6># de Ventas - {{$ventas->contador1}}</h6>
                            <h6>Efectivo | {{$ventas->contefectivo1}} | ${{$ventas->sumaefectivo1}}</h6>
                            <h6>Tarjeta | {{$ventas->conttarjeta1}} | ${{$ventas->sumatarjeta1}}</h6>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="#" class="small-box-footer">Sucursal Otavalo </a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>${{$ventas->sumatotal2}}</h3>
                                <p>Ventas Quito</p>
                                <h6># de Ventas - {{$ventas->contador2}}</h6>
                                <h6>Efectivo | {{$ventas->contefectivo2}} | ${{$ventas->sumaefectivo2}}</h6>
                                <h6>Tarjeta | {{$ventas->conttarjeta2}} | ${{$ventas->sumatarjeta2}}</h6>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">Sucursal Quito </a>
                        </div>
                    </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed table-hover" id="example">
                            <thead>
                                <th>
                                    #
                                </th>
                                <th>
                                    Vendedor
                                </th>
                                <th>
                                    Tipo de Doc.
                                </th>
                                <th>
                                    Valor
                                </th>
                                <th>
                                    Forma de Pago
                                </th>
                                <th>
                                    Fecha
                                </th>
                            </thead>
                            @foreach ($ventas as $cat)
                            <tr>
                                <td>
                                    {{ $cat->idtb_venta}}
                                </td>
                                <td>
                                    {{ $cat->name}}
                                </td>
                                <td>
                                    {{ $cat->tipo_comprobante}}
                                </td>
                                <td>
                                    {{ $cat->total_venta}}
                                </td>
                                <td>
                                    {{ $cat->forma_de_pago}}
                                </td>
                                <td>
                                    {{ $cat->created_at}}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}" />

@stop

@section('js')
<script src="{{asset('js/moment.js')}}"></script>
<script src="{{asset('moment/locale/es.js')}}"></script>
<script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
    $('#example').DataTable( {
       "order": [[ 0, "desc" ]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
        }
    } );
} );
    $(function () {

        $('#s1').datetimepicker({

            locale: 'es',
            format: 'DD-MM-YYYY',
            defaultDate: "{{$f1}}",       
                });
        $('#s2').datetimepicker({
            
            locale: 'es',
            format: 'DD-MM-YYYY',
            defaultDate: "{{$f2}}",
            
            useCurrent: false //Important! See issue #1075
        });
        $("#s1").on("dp.change", function (e) {
            $('#s2').data("DateTimePicker").minDate(e.date);
        });
        $("#s2").on("dp.change", function (e) {
            $('#s1').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>
@stop