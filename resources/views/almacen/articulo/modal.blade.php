
<div class="modal fade" id="modal-delete-{{$cat->idtb_articulo}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
{{Form::Open(array('action'=>array('ArticuloController@destroy',$cat->idtb_articulo),'method'=>'delete'))}}
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
                <h4 class="modal-title">
                    Eliminar Artículo
                </h4>
            </div>
            <div class="modal-body">
                <p>
                    Confirme si desea Eliminar el Artículo
                </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal" type="button">
                    Cerrar
                </button>
                <button class="btn btn-primary" type="submit">
                    Confirmar
                </button>
            </div>
        </div>
    </div>
    {{Form::Close()}}
</div>      



