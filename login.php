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

mysql_select_db($database_houseoffreshness, $houseoffreshness);
$query_Login = "SELECT * FROM users";
$Login = mysql_query($query_Login, $houseoffreshness) or die(mysql_error());
$row_Login = mysql_fetch_assoc($Login);
$totalRows_Login = mysql_num_rows($Login);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "home";
  $MM_redirectLoginFailed = "login";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_houseoffreshness, $houseoffreshness);
  
  $LoginRS__query=sprintf("SELECT Username, Password FROM users WHERE Username=%s AND Password= BINARY%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $houseoffreshness) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Login Form</title>
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<link href="assets/css/style-1.css" rel="stylesheet" type="text/css">
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>House of Freshness</h1>
<form METHOD="POST" name="login_form" action="<?php echo $loginFormAction; ?>">
  <p>
    <label>Username:</label>
    <br>
  <input name="username" type="text" autofocus required id="username" placeholder="Username..." title="Your Username" autocomplete="off" /><br /><br />
  <label>Password:</label>
  <br>
  <input name="password" type="password" autofocus required id="password" placeholder="Password..." title="Password" autocomplete="off" /><br /><br />
  <input name="login" type="submit" id="login" title="Login" value="Login" formvalidate>
  </p>
</form>
    </div>

    <div class="login-help">
      <h2>Don't have an account? <a href="register">Register</a></h2>
    </div>
    <div class="login-help">
      <h2>Forgot your password? <a href="forgot_password">Click here to reset it</a></h2>
    </div>
</section>
</body>
</html>
<?php
mysql_free_result($Login);
?>
