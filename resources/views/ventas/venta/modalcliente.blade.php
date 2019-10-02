<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-create">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title">Nuevo Cliente</h4>
			</div>
			<div class="modal-body">
				{!!Form::open(array('url'=>'ventas/cliente','method'=>'POST','autocomplete'=>'off'))!!}
				{!!Form::token()!!}

				<div class="row">
					<div class="panel-body">
						<div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
							<div class="form-group">
								{!! Form::label('codigo', 'Número Cédula Ruc') !!}
								<input type="number" name="cedula_ruc" required value="{{old('cedula_ruc')}}"
									class="form-control" placeholder="Número documento...">
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
							<div class="form-group">
								{!! Form::label('nombre', 'Nombre Completo Cliente') !!}
								<input type="text" name="razon_social" required value="{{old('razon_social')}}"
									class="form-control" placeholder="Razón Social">
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
							<div class="form-group">
								{!! Form::label('nombre', 'Nombre Comercial') !!}
								<input type="text" name="nombre_comercial" required value="{{old('nombre_comercial')}}"
									class="form-control" placeholder="Empresa">
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
							<div class="form-group">
								{!! Form::label('stock', 'Teléfono') !!}
								{!! Form::text('telefono', null, ['class' => 'form-control','placeholder'=>'Teléfono...'
								]) !!}
							</div>
						</div>
						<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
							<div class="form-group">
								{!! Form::label('descripcion', 'Email') !!}
								{!! Form::email('email', 'notiene@email.com', ['class' => 'form-control' , 'required' =>
								'required','placeholder'=>'Email...']) !!}

							</div>
						</div>
						<div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
							<div class="form-group">
								{!! Form::label('direccion', 'Dirección') !!}
								<input type="text" name="direccion" value="{{old('direccion')}}" class="form-control"
									placeholder="Dirección del cliente...">
							</div>
						</div>

					</div>
				</div>

			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-primary">Guardar</button>
				<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>
{!!Form::close()!!}