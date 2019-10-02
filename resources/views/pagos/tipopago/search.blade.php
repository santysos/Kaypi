{!! Form::open(array('url'=>'pagos/tipopago','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
<div class="form-group">
<div class="input-group col-lg-12">
	<input type="text" class="form-control" name="searchText" placeholder="Buscar..." value="{{$searchText}}">
	<span class="input-group-btn">
		<button type="submit" class="btn btn-primary">Buscar</button>
	</span>
</div>
</div>

{{Form::close()}}