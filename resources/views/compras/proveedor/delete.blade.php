<a href="{{URL::action('ProveedorController@edit',$cat->idtb_proveedor)}}">
    <button class="btn btn-success btn-xs" type="button">
        <span aria-hidden="true" class="glyphicon glyphicon-pencil">
        </span>
    </button>
</a>
<a href="" data-target="#modal-delete-{{$cat->idtb_proveedor}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></a>
@include('compras.proveedor.modal')

