<?php require_once('Connections/houseoffreshness.php'); ?>
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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="register.php";
  $loginUsername = $_POST['username'];
  $LoginRS__query = sprintf("SELECT Username FROM users WHERE Username=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_houseoffreshness, $houseoffreshness);
  $LoginRS=mysql_query($LoginRS__query, $houseoffreshness) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "register_form")) {
  $insertSQL = sprintf("INSERT INTO users (Fname, Lname, Email, Telephone, Username, Password) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['telephone'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_houseoffreshness, $houseoffreshness);
  $Result1 = mysql_query($insertSQL, $houseoffreshness) or die(mysql_error());

  $insertGoTo = "login";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_houseoffreshness, $houseoffreshness);
$query_Registerees = "SELECT * FROM users";
$Registerees = mysql_query($query_Registerees, $houseoffreshness) or die(mysql_error());
$row_Registerees = mysql_fetch_assoc($Registerees);
$totalRows_Registerees = mysql_num_rows($Registerees);
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Register Form</title>
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link href="assets/css/style-1.css" rel="stylesheet" type="text/css">
</head>
<body>
<section class="container">
<div class="login">
<h1>House of Freshness - Register Form</h1>
<form method="POST" name="register_form" action="<?php echo $editFormAction; ?>">
<label>First Name*:</label><br>
<input name="fname" type="text" autofocus required id="fname" placeholder="First Name..." title="Your First Name" autocomplete="off" /><br /><br />
<label>Last Name*:</label>
<br>
<input name="lname" type="text" autofocus required id="lname" placeholder="Last Name..." title="Your Last Name" autocomplete="off" /><br /><br />
<label>Email Address*:</label>
<br>
<input name="email" type="email" autofocus required id="email" placeholder="Email Address..." title="Your Email Address" autocomplete="off" /><br /><br />
<label>Telephone Number*:</label>
<br>
<input name="telephone" type="tel" autofocus required id="telephone" placeholder="Telephone Number..." title="Your Telephone Number" autocomplete="off" /><br /><br />
<label>Username*:</label><br>
<input name="username" type="text" autofocus required id="username" placeholder="Username..." title="Your Username" autocomplete="off" /><br /><br>
<label for="password">Password*:</label>
<input name="password" type="password" autofocus required="required" id="password" placeholder="Password..." title="Your Password" autocomplete="off">
<br />
<br />
<input name="register" type="submit" id="register" title="Register" value="Register" formvalidate>
<input type="hidden" name="MM_insert" value="register_form">
</form>
  </div>

    <div class="login-help">
      <h1>Already have an account? <a href="login">Login</a>.</h1></div>
</section>
</body>
</html>
<?php
mysql_free_result($Registerees);
?>
