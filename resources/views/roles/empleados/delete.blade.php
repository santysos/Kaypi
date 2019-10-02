
<a href="{{URL::action('TipoEmpleadoController@edit',$cat->idtb_tipo_usuario)}}">
    <button class="btn btn-success btn-xs" type="button">
        <span aria-hidden="true" class="glyphicon glyphicon-pencil">
        </span>
    </button>
</a>
{{Form::Open(['route'=>['empleados.destroy',$cat->idtb_tipo_usuario],'method'=>'delete'])}}
<button class="btn btn-danger btn-xs" onclick="return confirm('Seguro que desea Eliminar?')" type="submit">
    <span aria-hidden="true" class="glyphicon glyphicon-trash">
    </span>
</button>
{{Form::Close()}}
