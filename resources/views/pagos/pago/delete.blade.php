<a href="{{URL::action('PagosController@edit',$cat->idtb_pagos)}}">
    <button class="btn btn-success btn-xs" type="button">
        <span aria-hidden="true" class="glyphicon glyphicon-pencil">
        </span>
    </button>
</a>
<a href="" data-target="#modal-delete-{{$cat->idtb_pagos}}" data-toggle="modal"><button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></a>


