
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php
  // Llamada al WebService
  $client = new SoapClient("https://celcer.sri.gob.ec/comprobantes-electronicos-ws/RecepcionComprobantes?wsdl");
  $result = $client->GetCountries();
  $xml = $result->GetCountriesResult;

  // procesar xml
  $xml = simplexml_load_string($xml);
  foreach($xml->Table as $table) 
  {
    $output .= "<p>$table->Name</p>";
  }
  print_r($output);
?>
</body>
</html>