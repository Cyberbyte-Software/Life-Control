<?php //include("config/lang/module.php");
include("gfunctions.php");

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
              
              	  <p class="centered"><a href="profile.php"><img src="<?php echo 'assets/img/profile/'.$_SESSION['user_profile'].'.jpg'; ?>" class="img-circle" width="60"></a></p>
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
                    <li>
                        <a href="profile.php">
							<i class="fa fa-fw fa-user"></i>
							<span><?php echo $lang['navProfile'];?></span>
						</a>
                    </li>
					<?php
						
						?>                 
					<?php
						if ($_SESSION['user_level'] >= 3) {
					?>
							<li class="sub-menu">
							  <a href="javascript:;" >
								  <i class="fa fa-cogs"></i>
								  <span><?php echo $lang['navAdmin'];?></span>
							  </a>
							  <ul class="sub">
								  <li><a  href="staff.php"><?php echo $lang['staff'];?></a></li>
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
				<?php include($page) ?>
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
	
	<?php if ($page == "views/logged_in.php") { ?>
		<script type="text/javascript">
			$(document).ready(function () {
			var unique_id = $.gritter.add({
				// (string | mandatory) the heading of the notification
				title: 'Welcome to Life Control!',
				// (string | mandatory) the text inside the notification
				text: 'Please Report Any Bugs/Feature Requests to Cammygames<br> Version : v2.3',
				// (string | optional) the image to display on the left
				image: 'assets/img/profile/2.jpg',
				// (bool | optional) if you want it to fade out on its own or just sit there
				sticky: true,
				// (int | optional) the time you want it to be alive for before fading out
				time: '',
				// (string | optional) the class name you want to apply to that specific message
				class_name: 'my-sticky-class'
			});

			return false;
			});
		</script>	
	<?php } ?>
  </body>
</html>
