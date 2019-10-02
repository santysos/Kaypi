<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-categoria">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Nueva Categoría</h4>
			</div>
			<div class="modal-body">
				
		{!!Form::open(array('url'=>'almacen/categoria','method'=>'POST','autocomplete'=>'off'))!!}
		{!!Form::token()!!}
		<div class="row">
			<div class="panel-body">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						{!! Form::label('nombre', 'Nombre de la Categoría') !!}
			            {!! Form::text('nombre', null, ['class' => 'form-control','required' => 'required','placeholder'=>'Zapatos, Ropa, Cables, Impresoras']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('descripcion', 'Descripción') !!}
			            {!! Form::text('descripcion', null, ['class' => 'form-control','placeholder'=>'Texto descriptivo de la nueva categoría a crear']) !!}
					</div>		
				</div>	
			</div>
		</div>	
	
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Confirmar</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}