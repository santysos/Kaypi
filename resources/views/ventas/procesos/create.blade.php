<link href="{{ asset('/css/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@extends ('adminlte::layouts.app')
@section ('contenido')
<div class="row">
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
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="progress">
                <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" class="progress-bar progress-bar-primary" role="progressbar" style="width: 100%">
                    <span class="">
                        Datos Generales
                    </span>
                </div>
            </div>
            {!!Form::Open(array('url'=>'ventas/ordenes','method'=>'POST','autocomplete'=>'off'))!!}
            {!!Form::token()!!}
            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                {!!Form::text('Cliente',null,['id'=>'Cliente','class'=>'form-control','required' => 'required','placeholder'=>'Buscar Cliente'])!!}
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                {!!Form::select('agentes',$agentes,null,['id'=>'agentes','required' => 'required','class'=>'form-control','placeholder'=>'Agentes'])!!}
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group input-group">
                    <span class="input-group-addon" id="basic-addon1">
                        Entrega
                    </span>
                    {!!Form::text('Fecha_de_Entrega',null,['id'=>'Fecha_de_Entrega','required' => 'required','class'=>'form-control','placeholder'=>'Fecha de Entrega'])!!}
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group input-group">
                    <span class="input-group-addon" id="basic-addon1">
                        Rev Diseño
                    </span>
                    {!!Form::text('Revision_de_Diseno',null,['id'=>'Revision_de_Diseno','class'=>'form-control','placeholder'=>'Fecha de Revision de Diseño'])!!}
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                {!!Form::text('NombreComercial',null,['id'=>'NombreComercial','class'=>'form-control','required' => 'required','readonly','placeholder'=>'Nombre Comercial - Razon Social'])!!}
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                {!!Form::text('CodigoCliente',null,['id'=>'CodigoCliente','class'=>'form-control','readonly','placeholder'=>'Codigo Cliente'])!!}
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                {!!Form::text('Cedula_Ruc',null,['id'=>'Cedula_Ruc','class'=>'form-control','readonly','placeholder'=>'Ruc / Ced'])!!}
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
            <div class="col-lg-12">
                <div class="progress">
                    <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="40" class="progress-bar progress-bar-primary" role="progressbar" style="width: 100%">
                        <span class="">
                            Detalles de la Orden
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                {!!Form::select('servicios',$servicios,null,['id'=>'servicios','class'=>'form-control','placeholder'=>'Servicios'])!!}
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                {!!Form::select('descripcionservicios',['placeholder'=>'Descripción Servicios'],null,['id'=>'descripcionservicios','class'=>'form-control'])!!}
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                {!!Form::number('Cantidad',null,['id'=>'Cantidad','class'=>'form-control','placeholder'=>'Cantidad'])!!}
            </div>
            <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    {!!Form::number('valorto',null,['id'=>'valorto','class'=>'form-control','placeholder'=>'Valor Total'])!!}
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    {!!Form::textarea('descripcionorden',null,['id'=>'descripcionorden','class'=>'form-control','placeholder'=>'Descripción','size' => '30x2'])!!}
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
                        <th>
                            Opciones
                        </th>
                        <th>
                            Cantidad
                        </th>
                        <th>
                            Servicios
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
                                {!!Form::textarea('Observaciones',null,['id'=>'Observaciones','class'=>'form-control','placeholder'=>'Observaciones de la Orden en General','size' => '30x3'])!!}
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
                <div class="form-group">
                    <input class="form-control" id="Abono" name="Abono" placeholder="Abono" required="" type="decimal" value="{{old('Abono')}}">
                    </input>
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
        </div>
    </div>
    {!!Form::close()!!}
</div>
@push ('scripts')


@endpush
@endsection
