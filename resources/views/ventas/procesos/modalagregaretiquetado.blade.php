<!-- Modal -->
<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1"
    id="modalagregaretiquetado-{{$dt->idtb_detalle_orden}}">

    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Agregar Producción</h4>
            </div>
            <div class="modal-body">
                {!!Form::open(array('url'=>'ventas/produccion','method'=>'POST','autocomplete'=>'off'))!!}
                {!!Form::token()!!}
                <div class="form-group">

                    <label for="usr">Realizado: {{$dt->suma_eti}}<br>
                        Faltante: {{$dt->cantidad-$dt->suma_eti}}<br>
                        {{$dt->nombre}}
                    </label>
                    @if(Auth::user()->tb_tipo_usuario_idtb_tipo_usuario==1)
                    {!!Form::number('cantidad', null, ['max' => $dt->cantidad-$dt->suma_con, 'class' =>
                    'form-control','id'=>'cantidad','placeholder'=>'0','required'=>'required']) !!}
                    @else
                    {!!Form::number('cantidad', null, ['min' => '0','max' => $dt->cantidad-$dt->suma_con, 'class' =>
                    'form-control','id'=>'cantidad','placeholder'=>'0','required'=>'required']) !!}
                    @endif
                   
                    {!!Form::hidden('tb_detalle_orden_idtb_detalle_orden',$dt->idtb_detalle_orden,['id'=>'tb_detalle_orden_idtb_detalle_orden','class'=>'form-control','placeholder'=>'Cantidad'])!!}
                    {!!Form::hidden('tb_ordenes_idtb_ordenes',$idorden,['id'=>'tb_ordenes_idtb_ordenes','class'=>'form-control'])!!}
                    {!!Form::hidden('tb_departamentos_idtb_departamentos',6,['class'=>'form-control'])!!}
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </div>
        </div>

    </div>
</div>
{{Form::Close()}}