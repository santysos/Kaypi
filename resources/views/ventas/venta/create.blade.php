@extends('adminlte::page')

@section('title', 'Nueva Venta')

@section('content_header')
<h1>Nueva Venta</h1>
@stop

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="panel ">
      <div class="panel-body">
        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
          <a href="" data-target="#modal-create" data-toggle="modal"><button class="btn btn btn-success">Nuevo
              Cliente</button></a>
          @include('ventas.venta.modalcliente')


          @if(count($errors)>0)
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{$error}}</li>
              @endforeach
            </ul>
          </div>
          @endif
        </div>

      </div>
    </div>
  </div>
</div>
{!!Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off'))!!}
{!!Form::token()!!}

<input type="hidden" name="users_id" id="users_id" required value="{{ Auth::user()->id }}">

<div class="container-fluid">
  <div class="row">
    <div class="panel ">
      <div class="panel-body">
        <input id="sucursal" name="sucursal" type="hidden" value="{{ Auth::user()->sucursal }}" />
        <div class="col-lg-6 col-sm-5 col-md-5 col-xs-12">
          <div class="form-group">
            {!! Form::label('categoria', 'Seleccione el Cliente') !!}
            <select tabindex="1" onchange="titulo_Cliente()" name="tb_cliente_idtb_cliente" id="tb_cliente_idtb_cliente"
              class="form-control selectpicker" data-live-search="true">
              @foreach($personas as $persona)
              <option value="{{$persona->idtb_cliente}}">{{$persona->cedcliente}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-lg-2 col-sm-3 col-md-3 col-xs-12">
          <div class="form-group">
            {!! Form::label('categoria', 'Comprobante') !!}
            <select name="tipo_comprobante" id="tipo_comprobante" class="form-control">

              <option value="Factura">Factura</option>

            </select>
          </div>

        </div>
        <!--<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12"><div class="form-group">
      {!! Form::label('codigo', 'Serie Comprobante') !!}
      <input type="text" name="serie_comprobante" value="{{old('serie_comprobante')}}" class="form-control" placeholder="Serie Comprobante..."></div>
    </div>-->
        @if(Auth::user()->tb_tipo_usuario_idtb_tipo_usuario==1)
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
          <div class="form-group">
            {!! Form::label('sucur', 'Sucursal') !!}
            <select required name="selectsucursal" id="selectsucursal" class="form-control required">
              <option value="" disabled selected>Seleccione la sucursal</option>
              <option value="1">Otavalo</option>
              <option value="2">Quito</option>
            </select>
          </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
          <div class="form-group">
            {!! Form::label('codigo', 'Num Comprobante') !!}
            <input type="number" name="num_comprobante" id="num_comprobante" required value="{{old('num_comprobante')}}"
              class="form-control" placeholder="Número de Comprobante...">
          </div>
        </div>
        @elseif(Auth::user()->sucursal==2)
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
          <div class="form-group">
            {!! Form::label('codigo', 'Num Comprobante') !!}
            <input type="number" name="num_comprobante" id="num_comprobante" required value="{{old('num_comprobante')}}"
              class="form-control" placeholder="Número de Comprobante...">
          </div>
        </div>
        @endif


        <div class="col-lg-1 col-sm-1 col-md-1 col-xs-12">
          <div class="form-group">
            <input type="checkbox" value="1" name="impuesto" id="impuesto" class="checkbox" disabled=""
              style="opacity:0; position:absolute; left:9999px;">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="panel ">
      <div class="panel-body">
        <div class="col-lg-5 col-sm-6 col-md-4 col-xs-12">
          <div class="form-group">
            {!! Form::label('codigo', 'Articulo') !!}
            <select tabindex="2" name="pidarticulo" id="pidarticulo" class="form-control selectpicker"
              data-live-search="true">
              <option value="" disabled selected>Buscar Articulo</option>
              @foreach($articulos as $articulo)
              <option value="{{$articulo->idtb_articulo}}">{{$articulo->articulo}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="col-lg-1 col-sm-6 col-md-2 col-xs-12">
          <div class="form-group">
            {!! Form::label('codigo', 'Stock') !!}
            <input type="" readonly name="pstock" id="pstock" class="form-control" placeholder="Stock">
            <input type="hidden" readonly name="piva" id="piva" class="form-control" placeholder="iva">
          </div>
        </div>
        <div class="col-lg-2 col-sm-3 col-md-2 col-xs-12">
          <div class="form-group">
            {!! Form::label('codigo', 'Cantidad') !!}
            <input type="number" tabindex="3" name="pcantidad" id="pcantidad" class="form-control"
              placeholder="Cantidad" value="1">
          </div>
        </div>
        <div class="col-lg-2 col-sm-3 col-md-2 col-xs-12">
          <div class="form-group">
            {!! Form::label('codigo', 'PVP') !!}
            {!!Form::select('pprecio_venta',['placeholder'=>'0.00'],null,['id'=>'pprecio_venta','class'=>'form-control'])!!}
            <input type="hidden" name="pprecio_venta1" id="pprecio_venta1" class="form-control"
              placeholder="Precio Venta">
            <input type="hidden" name="sub_total_0" id="sub_total_0" class="form-control" placeholder="sub_total_0">
            <input type="hidden" name="sub_total_12" id="sub_total_12" class="form-control" placeholder="sub_total_12">
          </div>
        </div>
        <div class="col-lg-1 col-sm-3 col-md-1 col-xs-12">
          <div class="form-group">
            {!! Form::label('codigo', 'Descuento') !!}
            <input type="number" name="pdescuento" id="pdescuento" class="form-control" placeholder="0" value="0">
          </div>
        </div>
        <div class="col-lg-1 col-sm-3 col-md-1 col-xs-12">
          <div class="form-group">
            {!! Form::label('opciones', 'Opciones') !!}
            <button tabindex="4" type="button" id="bt_add" class="btn btn-primary">Agregar</button>
          </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
          <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
            <thead style="background-color: #A9D0F5">
              <th>Opciones</th>
              <th>Iva</th>
              <th>Artículo</th>
              <th>Cantidad</th>
              <th>Precio Venta</th>
              <th>Descuento</th>
              <th>Subtotal</th>
            </thead>

            <tfoot>
              <tr>
                <th colspan="6">
                  <p align="right">Subtotal 0:</p>
                </th>
                <th>
                  <p align="right"><span id="subtotal0">$ 0.00</span> </p>
                </th>
              </tr>
              <tr>
                <th colspan="6">
                  <p align="right">Subtotal 12:</p>
                </th>
                <th>
                  <p align="right"><span id="subtotal12">$ 0.00</span></p>
                </th>
              </tr>
              <tr>
                <th colspan="6">
                  <p align="right">IVA(12%):</p>
                </th>
                <th>
                  <p align="right"><span id="total_impuesto">$ 0.00</span></p>
                </th>
              </tr>
              <tr>
                <th colspan="6">
                  <p align="right">TOTAL:</p>
                </th>
                <th>
                  <p align="right"><span align="right" id="total_pagar">$ 0.00</span><input type="hidden"
                      name="total_venta" id="total_venta"></p>
                </th>
              </tr>
            </tfoot>

            <tbody>

            </tbody>
          </table>

        </div>

        <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
          <div class="form-group">
            {!! Form::label('forma_de_pago', 'Forma de Pago') !!}
            <select name="forma_de_pago" id="forma_de_pago" class="form-control">
              <option value="Efectivo">Efectivo</option>
              <option value="Dinero Electronico">Dinero Electrónico</option>
              <option value="Tarjeta Credito">Tarjeta Crédito</option>
              <option value="Otros">Otros</option>
            </select>
          </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
          <div class="form-group">
            {!! Form::label('recibido', 'Recibido') !!}
            <input type="decimal" name="recibido" id="recibido" class="form-control" placeholder="0">
          </div>
        </div>
        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
          <div class="form-group">
            {!! Form::label('vuelto', 'Vuelto') !!}
            <input type="decimal" name="vuelto" id="vuelto" class="form-control" placeholder="0" readonly>
          </div>
        </div>
      </div>
    </div>



    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6" id="guardar">
      <div class="form-group">
        <input name="_token" value="{{ csrf_token() }}" type="hidden"></input>
        <button class="btn btn-primary" type="submit">Guardar</button>
        <button class="btn btn-danger" type="reset">Cancelar</button>
      </div>
    </div>
  </div>
</div>

{!!Form::close()!!}


@stop

@section('css')

<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap-select.min.css')}}" />
@stop

@section('js')

<script src="{{ asset('/js/bootstrap-select.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/selectpreciosventa.js') }}" type="text/javascript">
</script>
<script src="{{ asset('/js/seldinnumcomprobante.js') }}" type="text/javascript">
</script>

<script>
  $(document).ready(function(){                                                                                               
       marcarImpuesto();
      $('#bt_add').click(function(){
        agregar();
      });
    });
  
  function vueltos(consulta){
    if((consulta-total_pagar)<0){
      $("#vuelto").val("Dinero Insuficiente ");
  document.getElementById('vuelto').style.backgroundColor='#dd4b39';
  document.getElementById('vuelto').style.color='#ffffff';
    }
          else{
    $("#vuelto").val("$ " + (consulta-total_pagar).toFixed(2));
  document.getElementById('vuelto').style.backgroundColor='#00a65a';
  document.getElementById('vuelto').style.color='#ffffff';
    }
  }
  
  var cont=0;
  total=0;
  var stotal0=0;
  var stotal12=0;
  subtotal0=[];
  subtotal12=[];
  $("#guardar").hide();

 
  //comprobamos si se pulsa una tecla
  $("#recibido").keyup(function(e){                  
                //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#recibido").val();
      vueltos(consulta);
  });
  
  
  function marcarImpuesto()
    {
      tipo_comprobante=$("#tipo_comprobante option:selected").text();
      if (tipo_comprobante=='Factura')
      {
          $("#impuesto").prop("checked", true); 
          totales();
      }
      else
      {
          $("#impuesto").prop("checked", false);
          totales();
      }
    }
  
  
  function agregar(){
      iva = $("#piva").val()
      idarticulo = $("#pidarticulo").val()
      articulo = $("#pidarticulo option:selected").text();
      cantidad = $("#pcantidad").val();
      descuento = $("#pdescuento").val();
      precio_venta = $("#pprecio_venta").val();
      console.log(precio_venta);
      
      stock = $("#pstock").val();
  
      if(iva==1){
  
        if (idarticulo!="" && cantidad!="" && cantidad>0 && descuento!="" && (precio_venta!=null||precio_venta>0))
        {
          /*if(stock >= cantidad)
          {*/
            subtotal12[cont] = (cantidad*precio_venta-descuento);
            total=total+subtotal12[cont];
            stotal12 = stotal12 + subtotal12[cont];
            
  
            var fila = '<tr class="selected" id="fila'+cont+'"><td><button tabindex="1" type"button" class="btn btn-xs btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input value="1" name="ivacheck[]" id="ivacheck'+cont+'" type="checkbox" checked disabled></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td><input readonly type="hidden" name="precio_venta[]" value="'+parseFloat(precio_venta).toFixed(2)+'">'+parseFloat(precio_venta).toFixed(2)+'</td><td><input readonly type="hidden" name="descuento[]" value="'+parseFloat(descuento).toFixed(2)+'">'+parseFloat(descuento).toFixed(2)+'</td><td>'+parseFloat(subtotal12[cont]).toFixed(2)+'</td></tr>';
  
            cont++;
            stock=0;
            $("#subtotal12").html("$ "+ (stotal12/1.12).toFixed(2));
            $("#total_venta").val(total.toFixed(2));
            totales();
            evaluar();
  
            $('#detalles').append(fila);
            limpiar();
          /*}
          else
          {
            alert('La cantidad a vender supera el Stock en Inventario')
          }*/
          
        }
        else
          {
            alert('Revise los datos del Articulo')
          }
        }else
        {
          if (idarticulo!="" && cantidad!="" && cantidad>0 && descuento!="" && precio_venta!="")
        {
          /*if(stock >= cantidad)
          {*/
            subtotal0[cont] = (cantidad*precio_venta-descuento);
            total=total+subtotal0[cont];
            stotal0 = stotal0 + subtotal0[cont];
            
  
            var fila = '<tr class="selected" id="fila'+cont+'"><td><button tabindex="1" type"button" class="btn btn-xs btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input value="0" name="ivacheck[]" id="ivacheck'+cont+'" type="checkbox" disabled></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input readonly type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td><input readonly type="hidden" name="precio_venta[]" value="'+parseFloat(precio_venta).toFixed(2)+'">'+parseFloat(precio_venta).toFixed(2)+'</td><td><input readonly type="hidden" name="descuento[]" value="'+parseFloat(descuento).toFixed(2)+'">'+parseFloat(descuento).toFixed(2)+'</td><td>'+parseFloat(subtotal0[cont]).toFixed(2)+'</td></tr>';
  
            cont++;
            stock=0;
            $("#subtotal0").html("$ "+ stotal0.toFixed(2));
            $("#total_venta").val(total.toFixed(2));
            totales();
            evaluar();
  
            $('#detalles').append(fila);
            limpiar();
          /*}
          else
          {
            alert('La cantidad a vender supera el Stock en Inventario')
          }*/
          
        }
        else
          {
            alert('Revise los datos del Articulo')
          }
        }
  }
  
  
  function limpiar(){
  
      $("#pcantidad").val("1");
      $("#pprecio_venta").val("");
      $("#pdescuento").val("0");
      $("#vuelto").val("");
      $("#recibido").val("");
      stock=0;
      //cantidad=O;
    }
  
  function eliminar(index){
      
    var ivacheck = document.getElementById("ivacheck"+index);
  
    if(ivacheck.checked==1){
      total=total-subtotal12[index];
      stotal12 = stotal12 - subtotal12[index];
      $("#subtotal12").html("$ "+ stotal12.toFixed(2));
        $("#total_venta").val(total.toFixed(2));
        $("#fila" + index).remove();
      evaluar();
          totales();
    }
    else
    {
      total=total-subtotal0[index];
        stotal0 = stotal0- subtotal0[index];
      $("#subtotal0").html("$ "+ stotal0.toFixed(2));
        $("#total_venta").val(total.toFixed(2));
        $("#fila" + index).remove();
      evaluar();
          totales();
    }
  }
  
  
  function totales()
    {           
          //Calcumos el impuesto
          if ($("#impuesto").is(":checked"))
          {
              por_impuesto=12;
          }
          else
          {
              por_impuesto=0;   
          }
          $("#sub_total_0").val(stotal0);
        $("#sub_total_12").val(stotal12);
          total_impuesto=(stotal12/(1+(por_impuesto/100)))*por_impuesto/100;
          total_pagar=(stotal12/(1+(por_impuesto/100)))+total_impuesto+stotal0;
          $("#total_impuesto").html("$ " + total_impuesto.toFixed(2));
          $("#total_pagar").html("$ " + total_pagar.toFixed(2));       
    } 
  
  function evaluar()
    {
      if (total>=0)
      {
        $("#guardar").show();
      }
      else
      {
        $("#guardar").hide();
      }
    }

    function titulo_Cliente() {

      var combo = document.getElementById("tb_cliente_idtb_cliente");
    var selected = combo.options[combo.selectedIndex].text;
    document.title = selected;
  }
  
  titulo_Cliente();
</script>
@stop