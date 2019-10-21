@extends('adminlte::page')

@section('title', 'Prueba')

@section('content_header')
<h1>PRUEBA SELECT</h1>
@stop

@section('content')
<div class="container-fluid">
  <div class="row">
      <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" >
          <div class="form-group">
              {!! Form::label('codigo', 'Articulo') !!}
              <select id="articulos" name="articulos" class="form-control" >
                <option value='0'>-- Select user --</option>

              </select>
      
            </div>
      </div>



@stop

@section('css')

<link href="{{asset('css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

@stop

@section('js')
</script>
<script src="{{ asset('/js/ajax-articulos.js') }}" type="text/javascript">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>


  
@stop