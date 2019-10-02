<?php require_once('Connections/Conecta.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$variable=9;

if (isset($_GET['idOrder'])) {
  $variable = $_GET['idOrder'];
 
}


function NumeroVerificador($cadena){
  $cadena = strrev($cadena);
  $pivote = 2;
  $cantidadTotal = 0;

  $ar_claveacceso = str_split($cadena);
  foreach ($ar_claveacceso as $temporal){
    if ($pivote == 8)
    {
      $pivote = 2;
    }
    $temporal = $temporal * $pivote;
    $pivote++;
    $cantidadTotal = $cantidadTotal + $temporal;
  }
  $cantidadTotal = abs(11 - $cantidadTotal % 11);
  if($cantidadTotal == 10){
    $cantidadTotal = 1;
  }
  if($cantidadTotal == 11){
    $cantidadTotal = 0;
  }
  return  $cantidadTotal;
}



mysql_select_db($database_Conecta, $Conecta);
$query_orden = "SELECT * FROM ps_orders WHERE id_order=$variable";
$sql = mysql_query($query_orden, $Conecta) or die(mysql_error());
$row_orden = mysql_fetch_assoc($sql);
$totalRows_orden = mysql_num_rows($sql);


mysql_select_db($database_Conecta, $Conecta);
$query_datosEmisor = "SELECT * FROM fe_datos_ruc_emisor";
$datosEmisor = mysql_query($query_datosEmisor, $Conecta) or die(mysql_error());
$row_datosEmisor = mysql_fetch_assoc($datosEmisor);
$totalRows_datosEmisor = mysql_num_rows($datosEmisor);


$numpedido_datosComprador = $row_orden['reference'];

if (isset($_POST['numpedido'])) {
  $numpedido_datosComprador = $_POST['numpedido'];
}
mysql_select_db($database_Conecta, $Conecta);
$query_datosComprador = sprintf("SELECT ps_customer.lastname, ps_customer.email, ps_customer.firstname, ps_address.address1,ps_address.phone_mobile, ps_address.dni, ps_orders.total_products, ps_orders.total_discounts_tax_excl, ps_orders.total_paid_tax_incl FROM ps_customer, ps_address, ps_orders WHERE ps_orders.reference= %s and ps_customer.id_customer= ps_address.id_customer and ps_orders.id_address_invoice = ps_address.id_address", GetSQLValueString($numpedido_datosComprador, "text"));
$datosComprador = mysql_query($query_datosComprador, $Conecta) or die(mysql_error());
$row_datosComprador = mysql_fetch_assoc($datosComprador);
$totalRows_datosComprador = mysql_num_rows($datosComprador);

mysql_select_db($database_Conecta, $Conecta);
$query_selectemision = "SELECT * FROM `fe_puntos_emision`";
$selectemision = mysql_query($query_selectemision, $Conecta) or die(mysql_error());
$row_selectemision = mysql_fetch_assoc($selectemision);
$totalRows_selectemision = mysql_num_rows($selectemision);

mysql_select_db($database_Conecta, $Conecta);
$query_selectEstablecimientos = "SELECT * FROM `fe_establecimientos`";
$selectEstablecimientos = mysql_query($query_selectEstablecimientos, $Conecta) or die(mysql_error());
$row_selectEstablecimientos = mysql_fetch_assoc($selectEstablecimientos);
$totalRows_selectEstablecimientos = mysql_num_rows($selectEstablecimientos);



$maxRows_detallePedido = 100;
$pageNum_detallePedido = 0;
if (isset($_GET['pageNum_detallePedido'])) {
  $pageNum_detallePedido = $_GET['pageNum_detallePedido'];
}
$startRow_detallePedido = $pageNum_detallePedido * $maxRows_detallePedido;



$colname_detallePedido = $row_orden['invoice_number'];
if (isset($_POST['txtsecuencial'])) {
  $colname_detallePedido = $_POST['txtsecuencial'];
}

mysql_select_db($database_Conecta, $Conecta);
$query_detallePedido = sprintf("SELECT `product_quantity`,`product_reference`, `product_name`,`unit_price_tax_excl`,`total_price_tax_excl` FROM `ps_order_detail` WHERE `id_order_invoice`=%s", GetSQLValueString($colname_detallePedido, "int"));
$query_limit_detallePedido = sprintf("%s LIMIT %d, %d", $query_detallePedido, $startRow_detallePedido, $maxRows_detallePedido);
$detallePedido = mysql_query($query_limit_detallePedido, $Conecta) or die(mysql_error());
$row_detallePedido = mysql_fetch_assoc($detallePedido);

if (isset($_GET['totalRows_detallePedido'])) {
  $totalRows_detallePedido = $_GET['totalRows_detallePedido'];
} else {
  $all_detallePedido = mysql_query($query_detallePedido);
  $totalRows_detallePedido = mysql_num_rows($all_detallePedido);
}
$totalPages_detallePedido = ceil($totalRows_detallePedido/$maxRows_detallePedido)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>


<form id="form1" name="form1" method="post" action="">



    <?php 
    
    $rs=$row_datosEmisor['Razon_Social'];
    $nc=$row_datosEmisor['Nombre_Comercial'];
    $re=$row_datosEmisor['RUC'];
    
    
    $sec= rand(1,50);
    $sec= str_pad($sec, 9, '0', STR_PAD_LEFT);


    $dir=$row_datosEmisor['Direccion_Matriz'];
    $fecha=date("d"."/"."m"."/"."Y");
    $fechaclaveacceso=date("d"."m"."Y");
    $dires=$row_selectEstablecimientos['dir_establecimientos'];
    $comprador=$row_datosComprador['firstname'].' '.$row_datosComprador['lastname'];
    $email=$row_datosComprador['email'];
    $ruc=$row_datosComprador['dni'];
                
                $identi=1;
              
    if(strlen($ruc)==13){$identi=04;}
    else{$identi=05;}


    $dircomp=$row_datosComprador['address1'];
    $sinimp=$row_datosComprador['total_products'];
    $totaldes=$row_datosComprador['total_discounts_tax_excl'];
    $baseimp=$row_datosComprador['total_products'];
    $valor=$row_datosComprador['total_products']*0.12;
    $valor=round($valor,2);
    
    $imptotal=$row_datosComprador['total_paid_tax_incl'];
    $telefono=$row_datosComprador['phone_mobile'];
    
//Generador codigo de acceso
//fecha         22122015
//codDoc        01
//ruc vendedor  1002906426001
//ambiente      1
//serie         001001
//secuencial    000000001
//codigonume    12345678
//tipo emision  1
 
    $claveAcceso = $fechaclaveacceso."01".$re."1"."001001".$sec."12345678"."1";
    $claveAcceso = $claveAcceso.NumeroVerificador($claveAcceso);




    $i=0;
    $buffercentral="";
    $buffer2= Array();
    
    do { 
          $cantidad= $row_detallePedido['product_quantity']; 
          $codigo= $row_detallePedido['product_reference'];
          $descrip= $row_detallePedido['product_name']; 
          $pu= $row_detallePedido['unit_price_tax_excl'];
          $pu=round($pu,2);
     
          $ptotal= $row_detallePedido['total_price_tax_excl'];
          $ptotal=round($ptotal,2);
          $cantprod=$row_detallePedido['product_quantity'];
          $valorimp=$ptotal*0.12;
          $valorimp=round($valorimp,2);
    
    $buffer2[$i]='<detalle>
      <codigoPrincipal>'."$codigo".'</codigoPrincipal>
      <descripcion>'."$descrip".'</descripcion>
      <cantidad>'."$cantprod".'</cantidad>
      <precioUnitario>'."$pu".'</precioUnitario>
      <descuento>0.00</descuento>
      <precioTotalSinImpuesto>'."$ptotal".'</precioTotalSinImpuesto>
      <impuestos>
        <impuesto>
          <codigo>2</codigo>
          <codigoPorcentaje>2</codigoPorcentaje>
          <tarifa>12</tarifa>
          <baseImponible>'."$ptotal".'</baseImponible>
          <valor>'."$valorimp".'</valor>
        </impuesto>
      </impuestos>
    </detalle>'; 
  
  $buffercentral=$buffercentral.$buffer2[$i];
     
     $i++;
  
     } while ($row_detallePedido = mysql_fetch_assoc($detallePedido));
  
  $buffer='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<factura id="comprobante" version="1.0.0">
  <infoTributaria>
    <ambiente>1</ambiente>
    <tipoEmision>1</tipoEmision>
    <razonSocial>'."$rs".'</razonSocial>
    <nombreComercial>'."$nc".'</nombreComercial>
    <ruc>'."$re".'</ruc>
    <claveAcceso>'."$claveAcceso".'</claveAcceso>
    <codDoc>01</codDoc>
    <estab>001</estab>
    <ptoEmi>001</ptoEmi>
    <secuencial>'."$sec".'</secuencial>
    <dirMatriz>'."$dir".'</dirMatriz>
  </infoTributaria>
  <infoFactura>
    <fechaEmision>'."$fecha".'</fechaEmision>
    <dirEstablecimiento>'."$dires".'</dirEstablecimiento>
    <obligadoContabilidad>NO</obligadoContabilidad>
    <tipoIdentificacionComprador>0'."$identi".'</tipoIdentificacionComprador>
    <razonSocialComprador>'."$comprador".'</razonSocialComprador>
    <identificacionComprador>'."$ruc".'</identificacionComprador>
    <direccionComprador>'."$dircomp".'</direccionComprador>
    <totalSinImpuestos>'."$sinimp".'</totalSinImpuestos>
    <totalDescuento>'."$totaldes".'</totalDescuento>
    <totalConImpuestos>
      <totalImpuesto>
        <codigo>2</codigo>
        <codigoPorcentaje>2</codigoPorcentaje>
        <baseImponible>'."$baseimp".'</baseImponible>
        <tarifa>12</tarifa>
        <valor>'."$valor".'</valor>
      </totalImpuesto>
    </totalConImpuestos>
    <propina>0.00</propina>
    <importeTotal>'."$imptotal".'</importeTotal>
    <moneda>Dolar</moneda>
  </infoFactura>
  <detalles>';
  
  $buffer3='</detalles>
  <infoAdicional>
    <campoAdicional nombre="email">'."$email".'</campoAdicional>
    <campoAdicional nombre="telefono">'."$telefono".'</campoAdicional>
  </infoAdicional>
</factura>';
  

$buffertotal=$buffer.$buffercentral.$buffer3;

$buffertotal=  utf8_encode($buffertotal);
  
  $name_file= $claveAcceso.".xml";
  $file=fopen($name_file,"w+");
  fwrite($file,$buffertotal);
  fclose($file);

//Consumir el Web Service Para validacion del XML generado
 $file_array = file_get_contents("./".$claveAcceso.".xml",true);
  
  $wsdl = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantes?wsdl";
  $options = array('cache_wsdl' => WSDL_CACHE_NONE,'trace' => TRUE);
  $client = new SoapClient($wsdl, $options);
  $param = array(
   'xml' => $file_array
  );
  $ready = $client->validarComprobante($param);
  print_r($ready);

  
  ?>

</form>
</body>
</html>
<?php
mysql_free_result($datosEmisor);

mysql_free_result($datosComprador);

mysql_free_result($selectemision);

mysql_free_result($selectEstablecimientos);

mysql_free_result($detallePedido);
?>
<script>
if(confirm("Factura generada de forma exitosa")){
location.href="http://www.pekes.com.ec/adminsos";
}
</script>
