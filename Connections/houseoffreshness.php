<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_houseoffreshness = "localhost";
$database_houseoffreshness = "user_system";
$username_houseoffreshness = "root";
$password_houseoffreshness = "9894770";
$houseoffreshness = mysql_pconnect($hostname_houseoffreshness, $username_houseoffreshness, $password_houseoffreshness) or trigger_error(mysql_error(),E_USER_ERROR); 
?>