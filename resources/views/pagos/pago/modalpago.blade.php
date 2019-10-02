<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-create-pago-{{$cat->idtb_venta}}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Agregar Pago</h4>
			</div>
			<div class="modal-body">
				{!!Form::open(array('url'=>'pagos/pago','method'=>'POST','autocomplete'=>'off'))!!}
				{!!Form::token()!!}
                <div class="row">			
                    <div class="panel-body">
                        <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                {!!Form::label('cliente','Cliente') !!}          
                                {!!Form::text('cliente',$cat->nombre_comercial,['id'=>'cliente','class'=>'form-control','placeholder'=>'Nombre del Cliente','readonly'])!!}
                                {!!Form::hidden('tb_cliente_idtb_cliente',$cat->idtb_cliente,['id'=>'tb_cliente_idtb_cliente','class'=>'form-control'])!!}
                            </div>                        
                            <div class="form-group input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    Fecha: 
                                </span>
                                {!! Form::date('fecha_pago', \Carbon\Carbon::now(), ['class'=>'form-control','id'=>'fecha_pago']) !!}                                
                            </div>
                            <div class="form-group">
                                {!!Form::select('tipo_pago',$tipo_pago,old('tipo_pago'),['id'=>'tipo_pago','class'=>'form-control','placeholder'=>'Tipo de pago','required'])!!}
                            </div>
                            <div class="form-group">
                                {!!Form::text('notas',null,['id'=>'notas','class'=>'form-control','placeholder'=>'Notas','required'])!!}
                            </div>
                            <div class="callout callout-info">
                                <h5>Venta # {{ $cat->idtb_venta}} - Valor: ${{ $cat->total_venta}} - Abono: ${{$cat->abono}} - Saldo:$ {{$cat->total_venta-$cat->abono}}</h5>
                                <input type="text" name="tb_venta_idtb_venta" class="form-control hidden " id="tb_venta_idtb_venta" value={{$cat->idtb_venta}}>   
                                <input type="text" name="total_venta" class="form-control hidden" id="total_venta" value={{$cat->total_venta}}>                    
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" id="basic-addon1">
                                    Valor:
                                </span>
                                {!!Form::number('valor', '0.00', ['min' => '0.01','step'=>'any','max' => $cat->total_venta-$cat->abono, 'class' => 'form-control','id'=>'valor']) !!}         
                            </div>                 
                    </div>
                </div>
            </div>		
            <div class="modal-footer">
                <button type="submit" id="btnGuardar" class="btn btn-primary">Guardar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
		</div>
	</div>
</div>
{!!Form::close()!!}