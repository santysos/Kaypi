<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modalasignarcliente-{{$cat->idtb_venta}}">
	{{Form::Open(array('action'=>array('VentaController@update',$cat->idtb_venta),'method'=>'patch'))}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Asignar Nuevo Cliente</h4>
			</div>
			<div class="modal-body">
				<div class="col-lg-7 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
			{!! Form::label('categoria', 'Seleccione el Cliente') !!}
            <select name="idtb_cliente" id="idtb_cliente" class="form-control selectpicker" data-live-search="true">
               	@foreach($personas as $persona)
					<option value="{{$persona->idtb_cliente}}">{{$persona->cedcliente}}</option>
               	@endforeach
            </select>
			</div>
		</div>	
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}
</div>