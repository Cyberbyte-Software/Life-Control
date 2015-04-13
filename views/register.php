<?php 
include("config/lang/module.php");

// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Life Control</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <script src="assets/js/chart-master/Chart.js"></script>
    
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
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.php" class="logo"><b>Life Control</b></a>
            <!--logo end-->
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
              
              	  <p class="centered"><a href="profile.html"><img src="<?php echo $_SESSION['user_profile']; ?>" class="img-circle" width="60"></a></p>
					<h5 class="centered">
						<?php echo $_SESSION['user_name']; ?>
					</h5>

					<li>
						<a href="index.php">
							<i class="fa fa-dashboard"></i>
							<span><?php echo $lang['navDashboard']; ?></span>
						</a>
					</li>					
					
					<li>
						<a href="players.php">
							<i class="fa fa-fw fa-child "></i>
							<span><?php echo $lang['players']; ?></span>
						</a>
					</li>

					<?php
						if ($_SESSION['user_level'] >= 2) 
						{
                    ?>
                    <li>
                        <a href="vehicles.php">
							<i class="fa fa-fw fa-car"></i>
							<span><?php echo $lang['vehicles'];?></span>
						</a>
                    </li>
                    <li>
                        <a href="houses.php">
							<i class="fa fa-fw fa-home"></i>
							<span><?php echo $lang['houses'];?></span>
						</a>
                    </li>
                    <li>
                        <a href="gangs.php">
							<i class="fa fa-fw fa-sitemap"></i>
							<span><?php echo $lang['gangs'];?></span>
						</a>
                    </li>
						<?php
							if (alits_life_4 == TRUE) {
						?>
						<li>
							<a href="wanted.php"><i class="fa fa-fw fa-list-ul"></i><?php echo " " . $lang['wanted'];?>
							</a>
						</li>
                    <?php
							}
						}
                    ?>
					<?php
						
						?>                 
					<?php
						if ($_SESSION['user_level'] >= 3) {
					?>
							<li class="sub-menu">
							  <a href="javascript:;" >
								  <i class="fa fa-cogs"></i>
								  <span>Admin</span>
							  </a>
							  <ul class="sub">
								  <li><a  href="admin.php"><?php echo $lang['navAdmin'];?></a></li>
								  <li><a  href="register.php"><?php echo $lang['navNewUser'];?></a></li>
							  </ul>
							</li>							
					<?php
					}
					?>
					<li>
						<a href="index.php?logout"><i
								class="fa fa-fw fa-power-off"></i><?php echo " " . $lang['navLogOut']; ?></a>
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
			<?php
				if (isset($registration)) 
				{
					if ($registration->errors) {
						foreach ($registration->errors as $error) {
							echo "<div class='row'>";
							echo "<div class='col-lg-12'>";
							echo "<div class='alert alert-danger alert-dismissable'>";
							echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
							echo "<i class='fa fa-info-circle'></i> " . $error;
							echo "</div>";
							echo "</div>";
							echo "</div>";
						}
					}
					if ($registration->messages) {
						foreach ($registration->messages as $message) {
							echo "<div class='row'>";
							echo "<div class='col-lg-12'>";
							echo "<div class='alert alert-danger alert-dismissable'>";
							echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
							echo "<i class='fa fa-info-circle'></i> " . $message;
							echo "</div>";
							echo "</div>";
							echo "</div>";
						}
					}
				}		
			?>
			
			<div id="login-page">
				<div class="col-lg-1 container">
					<h4> Dave: </h4>
					<img src="assets/img/ui-dave.jpg">
					<h4> Joe: </h4>
					<img src="assets/img/ui-joe.jpg">
					<h4> Sam: </h4>
					<img src="assets/img/ui-sam.jpg">
				</div>

				<div class="col-lg-10 container">				
					<form class="" method="post" action="register.php" name="registerform">
						<h2 class="form-login-heading">New User</h2>
						<div class="login-wrap">
							<p>Username:</p>
							<input id="login_input_username" type="text" class="form-control" placeholder="Username (only letters and numbers, 2 to 64 characters)" autofocus pattern="[a-zA-Z0-9]{2,64}" name="user_name" required>
							<br>
							<p>Player ID:</p>
							<input id="player_id" class="form-control" placeholder="PlayerID" type="text" name="player_id" required/>			
							<br>
							<p>Email Address:</p>
							<input id="login_input_email" placeholder="User's email" class=" form-control" type="email" name="user_email" required/>		
							<br>
							<p>Password:</p>
							<input id="login_input_password_new" placeholder="Password (min. 6 characters)" class=" form-control login_input" type="password"
										   name="user_password_new" pattern=".{6,}" required autocomplete="off"/>
							<br>
							<p>Repeat password:</p>
							<input id="login_input_password_repeat" placeholder="Repeat password" class=" form-control login_input" type="password"
										   name="user_password_repeat" pattern=".{6,}" required autocomplete="off"/>
							<br>
							<p>Profile Picture:</p>
							<select class=" form-control" name="profile_pic">
								<option value="assets/img/ui-dave.jpg">Dave</option>
								<option value="assets/img/ui-sam.jpg">Sam</option>
								<option value="assets/img/ui-joe.jpg">Joe</option>
								<option value="assets/img/ui-kerry.jpg">Kerry</option>
								<option value="assets/img/ui-jess.jpg">Jess</option>
								<option value="assets/img/ui-connie.jpg">Connie</option>
							</select>	
							<br>
							<p>Rank:</p>
							<select class="form-control" name="user_lvl">
								<option value="1">Support</option>
								<option value="2">Moderator</option>
								<option value="3">Administrator</option>
							</select>	
							<br>
							<input type="submit" class="btn btn-theme btn-block" name="register" value="Add New User"/>		
							<hr>		
						</div>
					</form>
				</div>
				<div class="col-lg-1 container">
					<h4> Kerry: </h4>
					<img src="assets/img/ui-kerry.jpg">
					<h4> Jess: </h4>
					<img src="assets/img/ui-jess.jpg">
					<h4> Connie: </h4>
					<img src="assets/img/ui-connie.jpg">
				</div>	
			</div>
          </section>
      </section>

  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jquery.sparkline.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>
    
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>

    <!--script for this page-->
    <script src="assets/js/sparkline-chart.js"></script>    
	<script src="assets/js/zabuto_calendar.js"></script>	
	
  </body>
</html>
