@extends('adminlte::page')

@section('title', 'Nuevo Cliente')

@section('content_header')

    <h1>Nuevo Pago </h1>

@stop

@section('content')

{!!Form::open(array('url'=>'pagos/pago','method'=>'POST','autocomplete'=>'off'))!!}
{!!Form::token()!!}
<div class="container-fluid">
    <div class="row">
        <div class="panel">
            <div class="panel-body">
            
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}
</div>
@stop

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}"/>  
@stop

@section('js')
<script src="{{ asset('/js/moment.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/moment/locale/es.js') }}" type="text/javascript">
</script>
<script>  
    $(document).ready(function() {
        $('#fecha_entrega').datetimepicker({
            daysOfWeekDisabled: [0, 7],
            sideBySide: true,
            locale: 'es',
            format: 'DD-MM-YYYY  HH:mm'
            });
        });
</script>
@stop


