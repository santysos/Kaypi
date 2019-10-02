<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_Conecta = "localhost";
$database_Conecta = "pekesc5_pekes";
$username_Conecta = "pekesc5_sos";
$password_Conecta = "santyto1984";
$Conecta = mysql_pconnect($hostname_Conecta, $username_Conecta, $password_Conecta) or trigger_error(mysql_error(),E_USER_ERROR); 
?>