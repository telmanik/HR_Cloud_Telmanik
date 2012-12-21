<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_hrcloud = "localhost";
$database_hrcloud = "hrcloud";
$username_hrcloud = "root";
$password_hrcloud = "";
$hrcloud = mysql_pconnect($hostname_hrcloud, $username_hrcloud, $password_hrcloud) or trigger_error(mysql_error(),E_USER_ERROR); 
?>