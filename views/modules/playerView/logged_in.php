<?php //include("config/lang/module.php");
include("gfunctions.php");

$arrayCount = count($gameServers);
require 'classes/steamauth/steamauth.php';
//$steamprofile['steamid']
if(isset($_SESSION['steamid']))
{
	require_once("config/carNames.php");
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (!$db_connection->set_charset("utf8")) {
		$db_connection->errors[] = $db_connection->error;
	}	
	

	
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
			<div class="nav notify-row pull-right" id="top_menu">
                <ul class="nav top-menu">
                    <li>
					<?php 

					?>
					</li>
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
				<?php 
					if(isset($_SESSION['steamid']))
					{
						require 'classes/steamauth/userInfo.php';
						$temp = "";
						$pGID = $steamprofile['steamid'];
						for ($i = 0; $i < 8; $i++) {
							$temp .= chr($pGID & 0xFF);
							$pGID >>= 8;
						}
						$pGID = md5('BE' . $temp);
				?>
					<p class="centered">
						<a href="profile.php">
						<img src="<?php echo $steamprofile['avatar']; ?>" class="img-circle" width="60">
						</a>
						</p>
					<h5 class="centered">
						<?php echo $steamprofile['personaname']; ?>
					</h5>
					<li>
						<a href="classes/steamauth/logout.php">
						<i class="fa fa-fw fa-power-off"></i><?php echo " " . $lang['navLogOut']; ?></a>
					</li>					
				<?php
						
					}
				?>
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
				<div class="col-lg-12">
					<h1 class="page-header">
						<?php echo $lang['player']; ?>
						<small><?php echo " " . $lang['editing']; ?></small>
					</h1>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-child fa-fw"></i><?php echo " " . $lang['player']; ?></h3>
					</div>
					<div class="panel-body">
							<?php
							$sql = 'SELECT * FROM `players` WHERE `playerid` ="' . $steamprofile['steamid'] . '";';
							$result_of_query = $db_connection->query($sql);
							if ($result_of_query->num_rows > 0) {
								while ($row = mysqli_fetch_assoc($result_of_query)) {
									$playersID = $row["playerid"];
									echo "<center>";
									echo "<h3>" . $lang['name'] . ": " . $row["name"] . "</h3>";
									echo "<h4>" . $lang['aliases'] . ": " . $row["aliases"] . "</h4>";
									echo "<h4>" . $lang['playerID'] . ": " . $steamprofile['steamid'] . "</h4>";
									echo "<h4>" . $lang['GUID'] . ": " . $pGID . "</h4>";
									echo "<h4>" . $lang['cash'] . ": " . $row["cash"] . "</h4>";
									echo "<h4>" . $lang['bank'] . ": " . $row["bankacc"] . "</h4>";
									echo "<h4>" . $lang['cop'] . ": " . $row['coplevel'] . "</h4>";
									echo "<h4>" . $lang['medic'] . ": " . $row['mediclevel'] . "</h4>";
									echo "<h4>" . $lang['admin'] . ": " . $row['adminlevel'] . "</h4>";
									echo "<h4>" . $lang['donator'] . ": " . $row['donatorlvl'] . "</h4>";
								}
							} else echo "<h1>".$lang['noPlayer']."<h1>";
							echo "</center>";
							?>
					</div>
				</div>
			</div>

			<div class='col-lg-8' style="float:right;">
				<?php
				$sql = 'SELECT * FROM `players` WHERE `playerID` ="' . $steamprofile['steamid'] . '";';
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) {
					if(isset($row["cop_licenses"])) {?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h3 class='panel-title'><i class='fa fa-taxi fa-fw'></i><?php echo " " . $lang['police']; ?>
							</h3>
						</div>
						<div class="panel-body">
							<div class="col-md-1"></div>
							<div class="col-md-4">
								<?php
									echo "<h4>" . $lang['cop'] . " " . $lang['licenses'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='cop_lic' name='cop_lic'>" . $row["cop_licenses"] . "</textarea>";
								?>
							</div>
							<div class="col-md-2"></div>
							<div class="col-md-4">
								<?php
									echo "<h4>" . $lang['cop'] . " " . $lang['gear'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='cop_gear' name='cop_gear'>" . $row["cop_gear"] . "</textarea>";
								?>
							</div>
						</div>
					</div>
					<?php } if(isset($row["civ_licenses"])) {?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h3 class='panel-title'><i class='fa fa-child fa-fw'></i><?php echo " " . $lang['civil']; ?>
							</h3>
						</div>
						<div class="panel-body">
							<div class="col-md-1"></div>
							<div class="col-md-4">
								<?php
									echo "<h4>" . $lang['civ'] . " " . $lang['licenses'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='civ_lic' name='civ_lic'>" . $row["civ_licenses"] . "</textarea>";
								?>
							</div>
							<div class="col-md-2"></div>
							<div class="col-md-4">
								<?php
									echo "<h4>" . $lang['civ'] . " " . $lang['gear'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='civ_gear' name='civ_gear'>" . $row["civ_gear"] . "</textarea>";
								?>
							</div>
						</div>
					</div>
					<?php } if(isset($row["med_licenses"])) {?>
					<div class='panel panel-default'>
						<div class='panel-heading'>
							<h3 class='panel-title'><i class='fa fa-ambulance fa-fw'></i><?php echo " " . $lang['medic']; ?>
							</h3>
						</div>
						<div class="panel-body">
							<div class="col-md-1"></div>
							<div class="col-md-4">
								<?php
									echo "<h4>" . $lang['medic'] . " " . $lang['licenses'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='med_lic' name='med_lic'>" . $row["med_licenses"] . "</textarea>";
								?>
							</div>
							<div class="col-md-2"></div>
							<div class="col-md-4">
								<?php
									echo "<h4>" . $lang['medic'] . " " . $lang['gear'] . ":</h4> <textarea readonly rows='5' style='width: 100%' id='med_gear' name='med_gear'>" . $row["med_gear"] . "</textarea>";
								?>
							</div>
						</div>
					</div>
					<?php 
					}
				}
				?>
			</div>
			<?php
			if (isset($_SESSION['steamid'])) {
				?>
				<div class="col-lg-4" style="float:left;">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><i
									class="fa fa-car fa-fw"></i><?php echo " " . $lang['vehicles'] . " " . $lang['quickLook']; ?>
							</h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								if (isset($_SESSION['steamid'])) {
									$sql = "SELECT * FROM `vehicles` WHERE `pid` = '" . $steamprofile['steamid'] . "' ORDER BY `id` DESC LIMIT 8";
									$result_of_query = $db_connection->query($sql);
									if ($result_of_query->num_rows > 0) {
										?>
										<table class="table table-bordered table-hover table-striped">
											<thead>
											<tr>
												<th><?php echo $lang['class']; ?></th>
												<th><?php echo $lang['type']; ?></th>
												<th><?php echo $lang['plate']; ?></th>
											</tr>
											</thead>
											<tbody>
											<?php
											while ($row = mysqli_fetch_assoc($result_of_query)) {
												$vehID = $row["id"];
												echo "<tr>";
												echo "<td>" . carName($row["classname"]) . "</td>";
												echo "<td>" . carType($row["type"],$lang) . "</td>";
												echo "<td>" . $row["plate"] . "</td>";
												echo "</tr>";
											};

											?>
											</tbody>
										</table>
										<?php 
									} else echo '<h1>No cars</h1>';
								} ?>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="col-lg-4">
				<?php
				if (isset($_SESSION['steamid'])) {
					?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><i
									class="fa fa-home fa-fw"></i><?php echo " " . $lang['houses'] . " " . $lang['quickLook']; ?>
							</h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<?php
								$sql = "SELECT `pos`,`id` FROM `houses` WHERE `pid` = '" . $steamprofile['steamid'] . "' ORDER BY `id` DESC LIMIT 8";
								$result_of_query = $db_connection->query($sql);
								if ($result_of_query->num_rows > 0) {
									?>
									<table class="table table-bordered table-hover table-striped">
										<thead>
										<tr>
											<th><?php echo $lang['position']; ?></th>
										</tr>
										</thead>
										<tbody>
										<?php
										while ($row = mysqli_fetch_assoc($result_of_query)) {
											echo "<tr>";
											echo "<td>" . $row["pos"] . "</td>";
											echo "</tr>";
										};
										?>
										</tbody>
									</table>
								<?php } else echo '<h1>'.$lang['noHouse'].'</h1>'; ?>
							</div>
						</div>
					</div>
				<?php
				}
				?>
			</div>
			<!-- /.row -->


			
			<?php
			if(isset($_SESSION['steamid']))
			{
				include("views/modules/playerView/logged_in.php");	
			}
			else
			{
				include("views/modules/playerView/not_logged_in.php");	
			}
			?>
			
          </section>
      </section>

  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
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
