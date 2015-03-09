<?php require_once('Connections/houseoffreshness.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update-status")) {
  $updateSQL = sprintf("UPDATE users SET Fname=%s, Lname=%s, Email=%s, Telephone=%s, Username=%s, Password=%s WHERE UserID=%s",
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['telephone'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['UserID'], "int"));

  mysql_select_db($database_houseoffreshness, $houseoffreshness);
  $Result1 = mysql_query($updateSQL, $houseoffreshness) or die(mysql_error());

  $updateGoTo = "profile";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_update = "-1";
if (isset($_GET['Username'])) {
  $colname_update = $_GET['Username'];
}
mysql_select_db($database_houseoffreshness, $houseoffreshness);
$query_update = sprintf("SELECT * FROM users WHERE Username = %s", GetSQLValueString($colname_update, "text"));
$update = mysql_query($query_update, $houseoffreshness) or die(mysql_error());
$row_update = mysql_fetch_assoc($update);
$totalRows_update = mysql_num_rows($update);

$colname_Update = "-1";
if (isset($_GET['Username'])) {
  $colname_Update = $_GET['Username'];
}
mysql_select_db($database_houseoffreshness, $houseoffreshness);
$query_Update = sprintf("SELECT * FROM users WHERE Username = %s", GetSQLValueString($colname_Update, "text"));
$Update = mysql_query($query_Update, $houseoffreshness) or die(mysql_error());
$row_Update = mysql_fetch_assoc($Update);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>The House of Freshness Barbershop - Profile</title>

    <!-- Bootstrap core CSS -->
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/bootstrap-1.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style-2.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style-1.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    body,td,th {
	font-family: Raleway, sans-serif;
}
body {
	background-color: #f2f2f2;
}
    </style>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
            <!--header start-->
      <header class="header black-bg"><!--logo start-->
            <a href="home" class="logo"><b>House of freshness</b></a>
            <!--logo end-->
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><a class="logout" href="logout">Logout</a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
              	  <p class="centered"><a href="/profile"><img src="assets/img/ui-sam.jpg" width="112" height="105" class="img-circle"></a></p>
              	  <h5 class="centered">Jean Paul Francois</h5>
              	  	
                  <li class="mt">
                      <a href="home">
                          <i class="fa fa-dashboard"></i>
                          <span>Home</span></a>
                  </li>
                  
                  <li class="sub-menu">
                      <a href="feed">
                          <i class="fa fa-book"></i>
                          <span>Feed</span></a>
                  </li>

                  <li class="sub-menu">
                      <a href="messages" >
                          <i class="fa fa-desktop"></i>
                          <span>Messages</span></a>
                  </li>

                  <li class="sub-menu">
                      <a href="friends" >
                          <i class="fa fa-cogs"></i>
                          <span>Friends</span></a>
                  </li>
                  <li class="sub-menu">
                      <a href="appointments" >
                          <i class="fa fa-tasks"></i>
                          <span>Appointments</span></a>
                  </li>
                  <li class="sub-menu">
                      <a class="active" href="profile" >
                          <i class="fa fa-th"></i>
                          <span>Profile</span></a>
                  </li>
                  <li class="sub-menu">
                      <a href="users" >
                          <i class=" fa fa-bar-chart-o"></i>
                          <span>Users</span></a>
                  </li>
                  
                  <li class="sub-menu">
                      <a href="store" >
                          <span>Store</span></a>
                  </li>

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">
      		<div class="row mt">
      			<div class="col-lg-6 col-md-6 col-sm-12">
      				<! -- BASIC BUTTONS -->
      				<div class="showback">
      					<h4><i class="fa fa-angle-right"></i> User Sign In Information</h4><br>
                        
                        <form action="<?php echo $editFormAction; ?>" method="POST" name="update-status" id="">
                        <table width="362" border="0">
  <tbody>
    <tr>
      <th width="145" scope="col">First Name:</th>
      <th width="210" scope="col"><input name="fname" type="text" autofocus required id="fname" title="fname" autocomplete="off" value="<?php echo $row_update['Fname']; ?>"></th>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">Last Name:</th>
      <td><input name="lname" type="text" autofocus required id="lname" title="lname" autocomplete="off" value="<?php echo $row_update['Lname']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">Email Address:</th>
      <td><input name="email" type="email" autofocus required id="email" title="email" autocomplete="off" value="<?php echo $row_update['Email']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">Telephone Number:</th>
      <td><input name="telephone" type="tel" autofocus required id="telephone" title="telephone" autocomplete="off" value="<?php echo $row_update['Telephone']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">Username:</th>
      <td><input name="username" type="text" autofocus required id="username" title="username" autocomplete="off" value="<?php echo $row_update['Username']; ?>"></td>
    </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <th scope="row">Password:</th>
      <td><input name="password" type="password" autofocus required id="password" title="password" autocomplete="off" value="<?php echo $row_update['Password']; ?>"></td>
    </tr>
    <tr>
      <th height="28" colspan="2" scope="row"><div align="right">
        <input name="UserID" type="hidden" id="UserID" value="<?php echo $row_update['UserID']; ?>">
      </div></th>
      </tr>
    <tr>
      <th scope="row">&nbsp;</th>
      <th rowspan="3" scope="row"><table width="220" border="0" align="right">
        <tbody>
          <tr>
            <th scope="col"><input name="update" type="submit" id="update" title="update" value="Update"></th>
          </tr>
        </tbody>
      </table></th>
    </tr>
    </tbody>
</table>
                        <input type="hidden" name="MM_update" value="update-status">
                      </form>

                        
   				  </div><!-- /showback -->
      				
      				<! -- BUTTONS ROUND<input type="hidden" name="MM_update" value="update-status">
<div class="showback">
      					<h4><i class="fa fa-angle-right"></i> About</h4>
                        <p>Coming Soon</p>
      				</div><!-- /showback -->
      				
      				<! -- THEME BUTTONS -->
      				<div class="showback">
      					<h4><i class="fa fa-angle-right"></i> Friends</h4>
                        <form name="friends-show" action=""></form>
                        <p>Coming Soon</p>
      				</div><!-- /showback -->
      				
      				<! -- BUTTONS GROUP -->
      				<div class="showback">
      					<h4><i class="fa fa-angle-right"></i> Photos</h4>
                        <form name="user-photos" action=""></form>      				<p>Coming Soon</p>
      				</div><!-- /showback -->
   			  </div><!--/col-lg-6 -->
      			
      			
      			<div class="col-lg-6 col-md-6 col-sm-12">
      				<! -- BUTTONS SIZES -->
      				<div class="showback">
      					<h4><i class="fa fa-angle-right"></i> Your Timeline</h4>
						<p>
						  Your timeline will display here
						</p>      		
                        <p>Coming Soon</p>			
      				</div><!-- /showback -->
      			</div><!-- /col-lg-6 -->
      			
      		</div><!--/ row -->
          </section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start--><!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>
<?php
mysql_free_result($update);

?>
mysql_free_result($Profile);