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

mysql_select_db($database_Conecta, $Conecta);
$query_pagados = "SELECT * FROM ps_orders where invoice_number<>0";
$pagados = mysql_query($query_pagados, $Conecta) or die(mysql_error());
$row_pagados = mysql_fetch_assoc($pagados);
$totalRows_pagados = mysql_num_rows($pagados);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>

<header>
  <div class="container text-center"><img src="http://www.pekes.com.ec/img/logo-1.jpg?1427487260" width="386" height="139" alt="logo"> <br></div>
</header>

  <div class="container col-xs-12 col-md-3 col-lg-12 col-sm-12">
     <h1 class="text-center">Pedidos Pago Aceptado</h1>
            <table width="50%" border="1" align="center" cellpadding="0" cellspacing="0" class="table table-condensed table-bordered table-hover">
  <tr class="active info">                                        
    <th class="text-center"># Orden</th>
    <th class="text-center">Referencia</th>
    <th class="text-center">Nombre</th>
    <th class="text-center">Valor total</th>
    <th class="text-center">Numero de Factura</th>
    <th class="text-center">XML</th>
  </tr>
  <?php $cont=1; do { 
  
  $idU= $row_pagados['id_customer'];

  
  mysql_select_db($database_Conecta, $Conecta);
$query_usuario = "SELECT * FROM ps_customer WHERE id_customer = $idU";
$usuario = mysql_query($query_usuario, $Conecta) or die(mysql_error());
$row_usuario = mysql_fetch_assoc($usuario);
$totalRows_usuario = mysql_num_rows($usuario);
  ?>
    <tr>
      <td><div align="center"><?php echo $row_pagados['id_order']; ?></div></td>
      <td><div align="center"><?php echo $row_pagados['reference']; ?></div></td>
      <td><div align="center"><?php echo $row_usuario['firstname'];  echo " ".$row_usuario['lastname'];?></div></td>
      <td><div align="center"><?php echo $row_pagados['total_paid']; ?></div></td>
      <td><div align="center"><?php echo $row_pagados['invoice_number']; ?></div></td>
      <td><a   href="index.php?idOrder= <?php echo $row_pagados['id_order']; ?>" ><p align="center"><img src="buscar.png" width="38" height="38"></p> </a> </td>
    </tr>
    <?php } while ($row_pagados = mysql_fetch_assoc($pagados)); ?>
</table>
  </div>



<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script> 
</body>
</html>
<?php
mysql_free_result($pagados);

mysql_free_result($usuario);
?>
