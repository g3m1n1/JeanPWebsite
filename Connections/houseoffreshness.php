<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
/*
$hostname_houseoffreshness = "localhost";
$database_houseoffreshness = "user_system";
$username_houseoffreshness = "root";
$password_houseoffreshness = "9894770";
$houseoffreshness = mysql_pconnect($hostname_houseoffreshness, $username_houseoffreshness, $password_houseoffreshness) or trigger_error(mysql_error(),E_USER_ERROR); 
 
 * THIS IS THE OLD VERSION, PDO VERSION BELOW.
 * PS: NO CLUE WHERE connection_php_mysql.html IS LOCATED
 */




// First, lets start an array with all the server settings.
$dbConf = array(
	'hostname' => 'localhost', 
	'database' => 'user_system',
	'username' => 'root',
	'password' => ''
	);

/*
What the following does is: 
try to make a new variable called $houseoffreshness and assign the database connection to it.
If it fails it "catch"-es the errors and writes it to error.txt.
This will generally make life a sh*t load easier.

*/
try { 
	$houseoffreshness = new PDO('mysql:host=localhost;dbname='.$dbConf['database'], $dbConf['username'], $dbConf['password']);
       
 } catch (Exception $e) {
       file_put_contents("error.txt", $e, FILE_APPEND);
 }
?>