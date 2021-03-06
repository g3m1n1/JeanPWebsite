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
$query_home = "SELECT * FROM users";
$home = mysql_query($query_home, $houseoffreshness) or die(mysql_error());
$row_home = mysql_fetch_assoc($home);
$totalRows_home = mysql_num_rows($home);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>The House of Freshness Barbershop</title>

    <!-- Bootstrap core CSS -->
    <!--external css-->
    <!-- Custom styles for this template -->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css">
    <link href="assets/css/bootstrap-1.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    body {
	background-color: #f2f2f2;
}
    </style>
    <link href="assets/css/style-1.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style-2.css" rel="stylesheet" type="text/css">
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
                      <a href="profile?Username=<?php echo $row_home['Username']; ?>" >
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

              <div class="row">
                  <div class="col-lg-9 main-chart">
                  
                  	<div class="row mtbox">
                  		<div class="col-md-2 col-sm-2 col-md-offset-1 box0">
                  			<div class="box1">
                            <div class="white-header">
									<h5>Status Likes</h5>
								</div>
					  			<h3>12</h3>
                  			</div>
					  			<p>How many people have liked your status.</p>
                  		</div>
                  		<div class="col-md-2 col-sm-2 box0">
                  			<div class="box1">
                            <div class="white-header">
									<h5>Photo Likes</h5>
								</div>
					  			<h3>9</h3>
                  			</div>
					  			<p>Poeple have liked your photo.</p>
                  		</div>
                  		<div class="col-md-2 col-sm-2 box0">
                  			<div class="box1">
                            <div class="white-header">
									<h5>Inbox</h5>
								</div>
					  			<h3>3</h3>
                  			</div>
					  			<p>New/Unread Inboxed messages.</p>
                  		</div>
                  		<div class="col-md-2 col-sm-2 box0">
                  			<div class="box1">
                            <div class="white-header">
									<h5>New Posts</h5>
								</div>
					  			<h3>12</h3>
                  			</div>
					  			<p>New status updates.</p>
                  		</div>
                  		<div class="col-md-2 col-sm-2 box0">
                  			<div class="box1">
                            <div class="white-header">
									<h5>New Friends</h5>
								</div>
					  			<h3>17</h3>
                  			</div>
					  			<p>People have added you. Accept/Deny their requests.</p>
                  		</div>
                  	
                  	</div><!-- /row mt -->	
                  
                      
                      <div class="row mt">
                      <!-- SERVER STATUS PANELS -->
                      <div class="col-md-4 mb">
                        <!-- WHITE PANEL - TOP USER -->
                        <div class="white-panel pn">
                          <div class="white-header">
                            <h5>User 1 Commented on your Picture</h5>
                          </div>
                          <p><img src="assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
                          <p><b>Zac Snider</b></p>
                          <div class="row">
                            <div class="col-md-6">
                              <p class="small mt">MEMBER SINCE</p>
                              <p>2012</p>
                            </div>
                            <div class="col-md-6">
                              <p class="small mt">TOTAL SPEND</p>
                              <p>$ 47,60</p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- /col-md-4--><!-- /col-md-4 -->
                      	
						<div class="col-md-4 mb">
							<!-- WHITE PANEL - TOP USER -->
							<div class="white-panel pn">
								<div class="white-header">
									<h5>User 2 liked  your Picture</h5>
								</div>
								<p><img src="assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
								<p><b>Zac Snider</b></p>
								<div class="row">
									<div class="col-md-6">
										<p class="small mt">MEMBER SINCE</p>
										<p>2012</p>
									</div>
									<div class="col-md-6">
										<p class="small mt">TOTAL SPEND</p>
										<p>$ 47,60</p>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4 mb">
						  <!-- WHITE PANEL - TOP USER -->
						  <div class="white-panel pn">
						    <div class="white-header">
						      <h5>User 3 Commented on your Picture</h5>
					        </div>
						    <p><img src="assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
						    <p><b>Zac Snider</b></p>
						    <div class="row">
						      <div class="col-md-6">
						        <p class="small mt">MEMBER SINCE</p>
						        <p>2012</p>
					          </div>
						      <div class="col-md-6">
						        <p class="small mt">TOTAL SPEND</p>
						        <p>$ 47,60</p>
					          </div>
					        </div>
					      </div>
					    </div>
						<div class="col-md-4 mb">
						  <!-- WHITE PANEL - TOP USER -->
						  <div class="white-panel pn">
						    <div class="white-header">
						      <h5>User 4 shared  your Picture</h5>
					        </div>
						    <p><img src="assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
						    <p><b>Zac Snider</b></p>
						    <div class="row">
						      <div class="col-md-6">
						        <p class="small mt">MEMBER SINCE</p>
						        <p>2012</p>
					          </div>
						      <div class="col-md-6">
						        <p class="small mt">TOTAL SPEND</p>
						        <p>$ 47,60</p>
					          </div>
					        </div>
					      </div>
					    </div>
						<div class="col-md-4 mb">
						  <!-- WHITE PANEL - TOP USER -->
						  <div class="white-panel pn">
						    <div class="white-header">
						      <h5>User 5 shared  your Picture</h5>
					        </div>
						    <p><img src="assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
						    <p><b>Zac Snider</b></p>
						    <div class="row">
						      <div class="col-md-6">
						        <p class="small mt">MEMBER SINCE</p>
						        <p>2012</p>
					          </div>
						      <div class="col-md-6">
						        <p class="small mt">TOTAL SPEND</p>
						        <p>$ 47,60</p>
					          </div>
					        </div>
					      </div>
					    </div>
						<div class="col-md-4 mb">
						  <!-- WHITE PANEL - TOP USER -->
						  <div class="white-panel pn">
						    <div class="white-header">
						      <h5>User 6 liked your Picture</h5>
					        </div>
						    <p><img src="assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
						    <p><b>Zac Snider</b></p>
						    <div class="row">
						      <div class="col-md-6">
						        <p class="small mt">MEMBER SINCE</p>
						        <p>2012</p>
					          </div>
						      <div class="col-md-6">
						        <p class="small mt">TOTAL SPEND</p>
						        <p>$ 47,60</p>
					          </div>
					        </div>
					      </div>
					    </div>
						<div class="col-md-4 mb">
						  <!-- WHITE PANEL - TOP USER -->
						  <div class="white-panel pn">
						    <div class="white-header">
						      <h5>User 7 Commented on your Picture</h5>
					        </div>
						    <p><img src="assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
						    <p><b>Zac Snider</b></p>
						    <div class="row">
						      <div class="col-md-6">
						        <p class="small mt">MEMBER SINCE</p>
						        <p>2012</p>
					          </div>
						      <div class="col-md-6">
						        <p class="small mt">TOTAL SPEND</p>
						        <p>$ 47,60</p>
					          </div>
					        </div>
					      </div>
					    </div>
						<div class="col-md-4 mb">
						  <!-- WHITE PANEL - TOP USER -->
						  <div class="white-panel pn">
						    <div class="white-header">
						      <h5>User 8 Commented on your Picture</h5>
					        </div>
						    <p><img src="assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
						    <p><b>Zac Snider</b></p>
						    <div class="row">
						      <div class="col-md-6">
						        <p class="small mt">MEMBER SINCE</p>
						        <p>2012</p>
					          </div>
						      <div class="col-md-6">
						        <p class="small mt">TOTAL SPEND</p>
						        <p>$ 47,60</p>
					          </div>
					        </div>
					      </div>
					    </div>
						<div class="col-md-4 mb">
						  <!-- WHITE PANEL - TOP USER -->
						  <div class="white-panel pn">
						    <div class="white-header">
						      <h5>User 9 shared your Picture</h5>
					        </div>
						    <p><img src="assets/img/ui-zac.jpg" class="img-circle" width="80"></p>
						    <p><b>Zac Snider</b></p>
						    <div class="row">
						      <div class="col-md-6">
						        <p class="small mt">MEMBER SINCE</p>
						        <p>2012</p>
					          </div>
						      <div class="col-md-6">
						        <p class="small mt">TOTAL SPEND</p>
						        <p>$ 47,60</p>
					          </div>
					        </div>
					      </div>
					    </div>
						<!-- /col-md-4 -->
                      	

                    </div><!-- /row --><!-- /row -->
                  </div><!-- /col-lg-9 END SECTION MIDDLE -->
                  
                  
      <!-- **********************************************************************************************************************************************************
      RIGHT SIDEBAR CONTENT
      *********************************************************************************************************************************************************** -->                  
                  
                  <div class="col-lg-3 ds">
                    <!--COMPLETED ACTIONS DONUTS CHART-->
						<h3>NOTIFICATIONS</h3>
                                        
                      <!-- First Action -->
                      <div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted>2 Minutes Ago</muted><br/>
                      		   <a href="#">James Brown</a> subscribed to your newsletter.<br/>
                      		</p>
                      	</div>
                      </div>
                      <!-- Second Action -->
                      <div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted>3 Hours Ago</muted><br/>
                      		   <a href="#">Diana Kennedy</a> purchased a year subscription.<br/>
                      		</p>
                      	</div>
                      </div>
                      <!-- Third Action -->
                      <div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted>7 Hours Ago</muted><br/>
                      		   <a href="#">Brandon Page</a> purchased a year subscription.<br/>
                      		</p>
                      	</div>
                      </div>
                      <!-- Fourth Action -->
                      <div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted>11 Hours Ago</muted><br/>
                      		   <a href="#">Mark Twain</a> commented your post.<br/>
                      		</p>
                      	</div>
                      </div>
                      <!-- Fifth Action -->
                      <div class="desc">
                      	<div class="thumb">
                      		<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                      	</div>
                      	<div class="details">
                      		<p><muted>18 Hours Ago</muted><br/>
                      		   <a href="#">Daniel Pratt</a> purchased a wallet in your store.<br/>
                      		</p>
                      	</div>
                      </div>

                       <!-- USERS ONLINE SECTION -->
						<h3>NEW MEMBERS</h3>
                      <!-- First Member -->
                      <div class="desc">
                      	<div class="thumb">
                      		<img class="img-circle" src="assets/img/ui-divya.jpg" width="35px" height="35px" align="">
                      	</div>
                      	<div class="details">
                      		<p><a href="#">DIVYA MANIAN</a><br/>
                      		   <muted>Available</muted>
                      		</p>
                      	</div>
                      </div>
                      <!-- Second Member -->
                      <div class="desc">
                      	<div class="thumb">
                      		<img class="img-circle" src="assets/img/ui-sherman.jpg" width="35px" height="35px" align="">
                      	</div>
                      	<div class="details">
                      		<p><a href="#">DJ SHERMAN</a><br/>
                      		   <muted>I am Busy</muted>
                      		</p>
                      	</div>
                      </div>
                      <!-- Third Member -->
                      <div class="desc">
                      	<div class="thumb">
                      		<img class="img-circle" src="assets/img/ui-danro.jpg" width="35px" height="35px" align="">
                      	</div>
                      	<div class="details">
                      		<p><a href="#">DAN ROGERS</a><br/>
                      		   <muted>Available</muted>
                      		</p>
                      	</div>
                      </div>
                      <!-- Fourth Member -->
                      <div class="desc">
                      	<div class="thumb">
                      		<img class="img-circle" src="assets/img/ui-zac.jpg" width="35px" height="35px" align="">
                      	</div>
                      	<div class="details">
                      		<p><a href="#">Zac Sniders</a><br/>
                      		   <muted>Available</muted>
                      		</p>
                      	</div>
                      </div>
                      <!-- Fifth Member -->
                      <div class="desc">
                      	<div class="thumb">
                      		<img class="img-circle" src="assets/img/ui-sam.jpg" width="35px" height="35px" align="">
                      	</div>
                      	<div class="details">
                      		<p><a href="#">Marcel Newman</a><br/>
                      		   <muted>Available</muted>
                      		</p>
                      	</div>
                      </div>

                        <!-- CALENDAR-->
                        <div id="calendar" class="mb">
                            <div class="panel green-panel no-margin">
                                <div class="panel-body">
                                    <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                                        <div class="arrow"></div>
                                        <h3 class="popover-title" style="disadding: none;"></h3>
                                        <div id="date-popover-content" class="popover-content"></div>
                                    </div>
                                    <div id="my-calendar"></div>
                                </div>
                            </div>
                        </div><!-- / calendar -->
                      
                  </div><!-- /col-lg-3 -->
              </div><! --/row -->
          </section>
      </section>

      <!--main content end-->
      <!--footer start--><!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->

  </body>
</html>
<?php
mysql_free_result($home);
?>
