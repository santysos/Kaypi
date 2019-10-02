{{Form::Open(['route'=>['procesos.destroy',$cat->idtb_descripcion_procesos],'method'=>'delete'])}}
<a href="{{URL::action('DescripcionProcesosController@edit',$cat->idtb_descripcion_procesos)}}">
    <button class="btn btn-success btn-xs" type="button">
        <span aria-hidden="true" class="glyphicon glyphicon-pencil">
        </span>
    </button>
</a>
<button class="btn btn-danger btn-xs" onclick="return confirm('Seguro que desea Eliminar?')" type="submit">
    <span aria-hidden="true" class="glyphicon glyphicon-trash">
    </span>
</button>
{{Form::Close()}}
