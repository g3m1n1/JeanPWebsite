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

mysql_select_db($database_houseoffreshness, $houseoffreshness);
$query_Friends = "SELECT * FROM users";
$Friends = mysql_query($query_Friends, $houseoffreshness) or die(mysql_error());
$row_Friends = mysql_fetch_assoc($Friends);
$totalRows_Friends = mysql_num_rows($Friends);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>The House of Freshness Barbershop - Friends</title>

    <!-- Bootstrap core CSS -->
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <link href="assets/css/bootstrap-1.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style-2.css" rel="stylesheet" type="text/css">

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
      ****************************************************************************************************************************************************      <!--header start-->
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
                      <a class="active" href="home">
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
                      <a href="profile" >
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
          <section class="wrapper site-min-height">
          	<h3><i class="fa fa-angle-right"></i> Your Friends</h3>
          	<div class="row mt">
          		<div class="col-lg-12">
          		
					<! -- 1st ROW OF PANELS -->
					<div class="row">
						<!-- TWITTER PANEL --><!-- /col-md-4 --><!-- /col-md-4 --><!-- /col-md-4 -->
					</div><! --/END 1ST ROW OF PANELS -->
					
					<! -- 2ND ROW OF PANELS -->
					<div class="row">
						<! -- TODO PANEL --><! --/col-md-4 -->
						
						<! -- PROFILE 01 PANEL -->
						<div class="col-lg-4 col-md-4 col-sm-4 mb">
							<div class="content-panel pn">
								<div id="profile-01">
									<h3>Sharon Holmes</h3>
								</div>
								<div class="profile-01 centered">
									<p>FRIENDS</p>
								</div>
								<div class="centered">
									<h6>153 FRIENDS</h6>
								</div>
							</div><! --/content-panel -->
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 mb">
							<div class="content-panel pn">
								<div id="profile-01">
									<h3>Jacob Rece</h3>
								</div>
								<div class="profile-01 centered">
									<p>FOLLOWING</p>
								</div>
								<div class="centered">
									<h6>345 FRIENDS</h6>
								</div>
							</div><! --/content-panel -->
						</div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
							<div class="content-panel pn">
								<div id="profile-01">
									<h3>Sharon Villiniard</h3>
								</div>
								<div class="profile-01 centered">
									<p>FOLLOWING</p>
								</div>
								<div class="centered">
									<h6>50 FRIENDS</h6>
								</div>
							</div><! --/content-panel -->
						</div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
							<div class="content-panel pn">
								<div id="profile-01">
									<h3>Rachel Deck</h3>
								</div>
								<div class="profile-01 centered">
									<p>FRIENDS</p>
								</div>
								<div class="centered">
									<h6>239 FRIENDS</h6>
								</div>
							</div><! --/content-panel -->
						</div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
							<div class="content-panel pn">
								<div id="profile-01">
									<h3>Christopher Diaz</h3>
								</div>
								<div class="profile-01 centered">
									<p>FRIENDS</p>
								</div>
								<div class="centered">
									<h6>75 FRIENDS</h6>
								</div>
							</div><! --/content-panel -->
						</div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
							<div class="content-panel pn">
								<div id="profile-01">
									<h3>Mayra Henderson</h3>
								</div>
								<div class="profile-01 centered">
									<p>FOLLOWING</p>
								</div>
								<div class="centered">
									<h6>53 FRIENDS</h6>
								</div>
							</div><! --/content-panel -->
						</div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
							<div class="content-panel pn">
								<div id="profile-01">
									<h3>Guilard Rodo</h3>
								</div>
								<div class="profile-01 centered">
									<p>FOLLOWING</p>
								</div>
								<div class="centered">
									<h6>500 FRIENDS - MAX  FRIENDS REACHED</h6>
								</div>
							</div><! --/content-panel -->
						</div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
							<div class="content-panel pn">
								<div id="profile-01">
									<h3>Rund&nbsp;Mundo</h3>
								</div>
								<div class="profile-01 centered">
									<p>FRIENDS</p>
								</div>
								<div class="centered">
									<h6>278 FRIENDS</h6>
								</div>
							</div><! --/content-panel -->
						</div>
                        <div class="col-lg-4 col-md-4 col-sm-4 mb">
							<div class="content-panel pn">
								<div id="profile-01">
									<h3>Miles Freeze</h3>
								</div>
								<div class="profile-01 centered">
									<p>FRIENDS</p>
								</div>
								<div class="centered">
									<h6>123 FRIENDS</h6>
								</div>
							</div><! --/content-panel -->
						</div>
					  </div>
						<! --/col-md-4 -->
						
						<! -- PROFILE 02 PANEL --><!--/ col-md-4 -->
					</div><! --/END 2ND ROW OF PANELS -->
					
				<! -- 3RD ROW OF PANELS --></div>
          	</div>
			
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
  </section>
  </body>
</html>
<?php
mysql_free_result($Friends);
?>
