{!! Form::open(array('url'=>'ventas/ordenes','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
<div class="form-group">
    <div class="input-group col-lg-12">
        <input class="form-control" name="searchText" placeholder="Buscar..." type="text" value="{{$searchText}}">
            <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">
                    Buscar
                </button>
            </span>
        </input>
    </div>
</div>
{{Form::close()}}
