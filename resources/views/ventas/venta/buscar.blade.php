@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
@foreach($persona as $cliente)
<h4>Listado de {{$cliente->razon_social}}</h4>
@endforeach
@stop

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="panel ">
			<div class="panel-body">
				@foreach($personas as $persona)@endforeach
                @foreach($suma_pagos as $suma_pago)@endforeach    
                <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box bg-aqua">
                                <span class="info-box-icon"><i class="ion-document-text"></i></span>
                    
                                <div class="info-box-content">
                                  <span class="info-box-text">{{$ventas->contador}} Facturas </span>
                                  <span class="info-box-number">{{$ventas->contador-$ventas->cont_fact_pagadas}} por cobrar</span>
                    
                                  <div class="progress">
                                    <div class="progress-bar" style="width: {{($ventas->cont_fact_pagadas*100)/$ventas->contador}}%"></div>
                                  </div>
                                  <span class="progress-description">
                                        {{$ventas->cont_fact_pagadas}} Pagada
                                      </span>
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="info-box bg-green">
                                <span class="info-box-icon"><i class="ion-cash"></i></span>
                                <div class="info-box-content">
                                  <span class="info-box-text">Total Abonos</span>
                                  <span class="info-box-number">${{$ventas->suma_abonos-$ventas->abonos}} de ${{$ventas->total_ventas_impagas}}</span>
                                  <div class="progress">
                                    <div class="progress-bar" style="width: {{(($ventas->suma_abonos-$ventas->abonos)*100)/$ventas->total_ventas_impagas}}%"></div>
                                  </div>
                                  <span class="progress-description">
                                        Saldo Total:  ${{$ventas->total_saldo}}
                                      </span>
                                </div>
                                <!-- /.info-box-content -->
                              </div>
                  </div>
      
                  <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box bg-yellow">
                        <span class="info-box-icon"><i class="ion-android-calendar"></i></span>
            
                        <div class="info-box-content">
                          <span class="info-box-text">Total Saldo</span>
                          <span class="info-box-number">${{$ventas->total_saldo}}</span>
            
                          <div class="progress">
                            <div class="progress-bar" style="width: {{$ventas->total_saldo}}%"></div>
                          </div>
                          <span class="progress-description">
                               {{$ventas->total_ventas_impagas}} 
                              </span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                  </div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
						<table class="table table-striped table-borderless table-condensed table-hover">
							<thead>
								<th>Id</th>
								<th>Fecha</th>
								<th>Cliente</th>
								<th>Factura</th>
								<th>Vendedor</th>
								<th>Total</th>
								<th>Abono - Saldo</th>
								<th>Opciones</th>
							</thead>
							@foreach ($ventas as $cat)
							<tr>

								<td>{{ $cat->idtb_venta}}</td>
								<td>{{ $cat->created_at}}</td>
								<td>{{ $cat->nombre_comercial}}
									</br>
									{{ $cat->razon_social}}
								</td>
								<td>{{ '#'.$cat->num_comprobante}}</td>
								<td>{{ $cat->name}}</td>
								<td>${{ $cat->total_venta}}</td>
								
								<td>
									@if ($cat->abono==$cat->total_venta)
									<font color="green" id="abono2">${{$cat->abono}} </font>
									</br>
									<font color="green">Pagado</font>
									@else
									<font color="black">${{$cat->abono}}</font> -
									<font color="red"> ${{$cat->saldo}}</font>
									</br>
									<a class="subraya" title="Agregar Pago" href=""
										data-target="#modal-create-pago-{{$cat->idtb_venta}}" data-toggle="modal">
										<font color="red">Parcial</font>
									</a>
									@endif
								</td>
								@if($cat->condicion=="0")
								<td>
									<span class="pull-center-container">
										<small class="label pull-center bg-red">Anulado</small>
									</span>
								</td>
								@elseif($cat->condicion=="1")
								<td>
									<span class="pull-right-container">
										<small class="label pull-center bg-blue">Facturado</small>
									</span>
								</td>
								@endif
								<td>

									<a title="Cambiar Cliente" href=""
										data-target="#modalasignarcliente-{{$cat->idtb_venta}}"
										data-toggle="modal"><button type="button" class="btn btn-warning btn-xs"><span
												class="glyphicon glyphicon-user" aria-hidden="true"></span></button></a>

									<a title="Detalle Venta"
										href="{{URL::action('VentaController@show',$cat->idtb_venta)}}"><button
											type="button" class="btn btn-primary btn-xs"><span
												class="glyphicon glyphicon-list-alt"
												aria-hidden="true"></span></button></a>
								@if($cat->condicion=="1")
									<a title="Imprimir" target="_blank"
										href="{{URL::action('VentaController@reportec',$cat->idtb_venta)}}"><button
											type="button" class="btn btn-success btn-xs"><span
												class="glyphicon glyphicon-print"
												aria-hidden="true"></span></button></a>

									<a title="Eliminar" href="" data-target="#modal-delete-{{$cat->idtb_venta}}"
										data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span
												class="glyphicon glyphicon-trash"
												aria-hidden="true"></span></button></a>
								@endif
								</td>
								<td>

								</td>
							</tr>

							@include('ventas.venta.modalasignarcliente')
							@include('ventas.venta.modal')
							@include('pagos.pago.modalpago')
							@endforeach
						</table>
					</div>{{$ventas->render()}}
                </div>
                
              
                              <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                  <thead style="background-color: #A9D0F5">
                                    <th>Id</th>
                                    <th>Tipo de Pago</th>
                                    <th>Fecha</th>
                                    <th>Notas</th>
                                    <th>Valor</th>
                      
                                  </thead>
                                  <tbody>
                                    @foreach($pagos as $pago)
                                    <tr>
                                      <td>{{$pago->idtb_pagos}}</td>
                                      <td>{{$pago->tipo_pago}}</td>
                                      <td>{{$pago->fecha_pago}} </td>
                                      <td>{{$pago->notas}}</td>
                                      <td>$ {{number_format($pago->valor,2)}}</td>
                                    </tr>
                                    @endforeach
                      
                                  </tbody>
                                  @foreach($suma_pagos as $suma_pago)
                                  @endforeach
                                  <tfoot>
                                    <tr>
                                      <th colspan="4">
                                        <p align="right">Total Abonos:</p>
                                      </th>
                                      <th>
                                        <p align="left"><span align="left" id="total_pagar">
                                                ${{number_format($ventas->suma_abonos,2)}}</span></p>
                                      </th>
                                    </tr>
                               
                                  </tfoot>
                      
                                </table>
                              </div>
                         
			</div>

		</div>
	</div>
</div>

@stop

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-datetimepicker.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('css/subrayado.css')}}" />
@stop

@section('js')
<script src="{{ asset('/js/selectpagos.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/moment.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/moment/locale/es.js') }}" type="text/javascript">
</script>

@stop