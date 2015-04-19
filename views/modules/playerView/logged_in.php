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
						<a>
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
			<!-- /.row -->
			<?php
				$sql = 'SELECT * FROM `players` WHERE `playerid` ="' . $_SESSION['steamid'] . '";';
				$result_of_query = $db_connection->query($sql);
				if ($result_of_query->num_rows > 0) {
					while ($row = mysqli_fetch_assoc($result_of_query)) {	
			?>
			<div class="col-md-3" style="float:left;  padding-top:20px;">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h2 class="panel-title"><i class="fa fa-child fa-fw"></i><?php echo $row["name"]; ?></h2>
					</div>
					<div class="panel-body">
						<?php 
							$get_skin_civ = $row['civ_gear'];
							if($get_skin_civ == "\"[]\"") {
								$get_skin_civ = "U_C_Poloshirt_stripped";
							}
							else{
								$get_skin_civ = substr($get_skin_civ,3);
								$get_skin_civ = substr ($get_skin_civ,0,strpos ($get_skin_civ, "`"));
								if(empty($get_skin_civ)){
									$get_skin_civ = "U_C_Poloshirt_stripped";
								}
							}				
						?>
						<center><img src="assets/img/uniform/<?php echo $get_skin_civ;?>.jpg" />
							<?php
									$playersID = $_SESSION['steamid'];
									
									echo "<h4>" . $lang['aliases'] . ": " . $row["aliases"] . "</h4>";
									echo "<h4>" . $lang['uid'] . ": " . $row["uid"]. "</h4>";
									echo "<h4>" . $lang['playerID'] . ": " . $_SESSION['steamid'] . "</h4>";
									echo "<h4>" . $lang['GUID'] . ": " . $pGID . "</h4>";
									?>
										<span class="fa fa-2x fa-money">
											<h4> <?php echo $lang['cash'].": ".$row["cash"];  ?> </h4>
										</span>
										<span style="padding-left:15px;" class="fa fa-2x fa-bank">
											<h4> <?php echo $lang['bank'].": ".$row["bankacc"];  ?> </h4>
										</span>							
									<?php
									if ($row["arrested"] !== false)
									{
										echo "<h4><span class='label label-success'>".$lang["not"]." ".$lang["arrested"]."</span> ";
									}
									else
									{
										echo "<h4><span class='label label-danger'>".$lang["arrested"]."</span> ";				
									}
									
									if ($row["blacklist"] !== false)
									{
										echo " <span class='label label-success'>".$lang["not"]." ".$lang["blacklisted"]."</span></h4>";						
									}
									else
									{
										echo " <span class='label label-danger'>".$lang["blacklisted"]."</span></h4>";	
									}
							?>
							<?php				
								}
							} else echo "<h1>".$lang['noPlayer']."<h1>";
							echo "</center>";
							?>
					</div>
				</div>
			</div>
			
			<div class="col-md-9" style="float:right; padding-top:20px;">
				<?php
					$sql = 'SELECT * FROM `players` WHERE `playerid` ="' . $_SESSION['steamid'] . '";';
					$result_of_query = $db_connection->query($sql);
					while ($row = mysqli_fetch_assoc($result_of_query)) 
					{
				?>
				<div class="row mtbox">
					<div class="col-md-2 col-sm-2 col-md-offset-1 box0">
						<div class="box1">
							<span class="fa fa-3x fa-taxi"></span>
							<h3> <?php echo $lang['police'].": ".$row["coplevel"];  ?> </h3>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 box0">
						<div class="box1">
							<span class="fa fa-3x fa-ambulance"></span>
							<h3> <?php echo $lang['medic'].": ".$row["mediclevel"];  ?> </h3>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 box0">
						<div class="box1">
							<span class="fa fa-3x fa-usd"></span>
							<h3> <?php echo $lang['donator'].": ".$row["donatorlvl"];  ?> </h3>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 box0">
						<div class="box1">
							<span class="fa fa-3x fa-group"></span>
							<h3> <?php echo $lang['admin'].": ".$row["adminlevel"];  ?> </h3>
						</div>
					</div>
					<div class="col-md-2 col-sm-2 box0">
						<div class="box1">
							<a href="http://steamcommunity.com/profiles/<?php echo $_SESSION['steamid']; ?>"><span class="fa fa-3x fa-steam"></span></a>
							<h3>Steam</h3>
						</div>
					</div>
				</div>
				<?php
					}
				?>		
				
				<div class="panel panel-default" style="float:left; width:100%; margin:0 auto;">
					<ul id="myTab" class="nav nav-tabs">
						<li class="dropdown active">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $lang['licenses'];?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#civ_lic" data-toggle="tab"><?php echo $lang['civ'];?></a></li>
								<li><a href="#medic_lic" data-toggle="tab"><?php echo $lang['medic'];?></a></li>
								<li><a href="#police_lic" data-toggle="tab"><?php echo $lang['police'];?></a></li>
							</ul>
						</li>			
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $lang['inventory'];?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="#civ_inv" data-toggle="tab"><?php echo $lang['civ'];?></a></li>
								<li><a href="#medic_inv" data-toggle="tab"><?php echo $lang['medic'];?></a></li>
								<li><a href="#police_inv" data-toggle="tab"><?php echo $lang['police'];?></a></li>
							</ul>
						</li>
						<li><a href="#house" data-toggle="tab"><?php echo $lang['houses'];?></a></li>
						<li><a href="#veh" data-toggle="tab"><?php echo $lang['vehicles'];?></a></li>
					</ul>
					<div id="myTabContent" class="tab-content">		
						<div class="tab-pane fade in active well" id="civ_lic">
								<h4 style="centred"><?php echo $lang['civ']." ".$lang['licenses'];?> </h4>
								<?php
									$sql = 'SELECT * FROM `players` WHERE `playerid` ="' . $_SESSION['steamid'] . '";';
									$result_of_query = $db_connection->query($sql);
									while ($row = mysqli_fetch_assoc($result_of_query)) 
									{
										$civ_licenses = array();
										$civ_licenses = explode("],[", $row["civ_licenses"]);
										$civ_licenses = str_replace("]]\"","",$civ_licenses);
										$civ_licenses = str_replace("\"[[","",$civ_licenses);
										$civ_licenses = str_replace("`","",$civ_licenses);
			   
										for ( $x = 0; $x < count ($civ_licenses); $x++){
											if(strpos($civ_licenses[$x], "1")!==false){
												echo "<span class='label label-success' style='margin-right:3px; line-height:2;'>".substr($civ_licenses[$x],0,-2)."</span>";    
											}
											else{
												echo "<span class='label label-default' style='margin-right:3px; line-height:2;'>".substr($civ_licenses[$x],0,-2)."</span> "; 
											}
										}						
									}
								?>
						</div>
						<div class="tab-pane well fade" id="medic_lic">
							<h4 style="centred"><?php echo $lang['medic']." ".$lang['licenses'];?> </h4>
							<?php
								$sql = 'SELECT * FROM `players` WHERE `playerid` ="' . $_SESSION['steamid'] . '";';
								$result_of_query = $db_connection->query($sql);
								while ($row = mysqli_fetch_assoc($result_of_query)) 
								{
									$med_licenses = array();
									$med_licenses = explode("],[", $row["med_licenses"]);
									$med_licenses = str_replace("]]\"","",$med_licenses);
									$med_licenses = str_replace("\"[[","",$med_licenses);
									$med_licenses = str_replace("`","",$med_licenses);
		   
									for ( $x = 0; $x < count ($med_licenses); $x++){
										if(strpos($med_licenses[$x], "1")!==false){
											echo "<span class='label label-success' style='margin-right:3px; line-height:2;'>".substr($med_licenses[$x],0,-2)."</span> ";    
										}
										else{
											echo "<span class='label label-default' style='margin-right:3px; line-height:2;'>".substr($med_licenses[$x],0,-2)."</span> "; 
										}
									}						
								}
							?>
						</div>	
						<div class="tab-pane well fade" id="police_lic">
							<h4 style="centred"><?php echo $lang['police']." ".$lang['licenses'];?> </h4>
							<?php
								$sql = 'SELECT * FROM `players` WHERE `playerid` ="' . $_SESSION['steamid'] . '";';
								$result_of_query = $db_connection->query($sql);
								while ($row = mysqli_fetch_assoc($result_of_query)) 
								{
									$cop_licenses = array();
									$cop_licenses = explode("],[", $row["cop_licenses"]);
									$cop_licenses = str_replace("]]\"","",$cop_licenses);
									$cop_licenses = str_replace("\"[[","",$cop_licenses);
									$cop_licenses = str_replace("`","",$cop_licenses);
		   
									for ( $x = 0; $x < count ($cop_licenses); $x++){
										if(strpos($cop_licenses[$x], "1")!==false){
											echo "<span class='label label-success' style='margin-right:3px; line-height:2;'>".substr($cop_licenses[$x],0,-2)."</span> ";    
										}
										else{
											echo "<span class='label label-default' style='margin-right:3px; line-height:2;'>".substr($cop_licenses[$x],0,-2)."</span> "; 
										}
									}						
								}
							?>
						</div>				
						<div class="tab-pane fade" id="house">
							<div class="table-responsive">
								<?php
								$sql = "SELECT `pos`,`id` FROM `houses` WHERE `pid` = '" . $_SESSION['steamid'] . "' ORDER BY `id` DESC LIMIT 8";
								$result_of_query = $db_connection->query($sql);
								if ($result_of_query->num_rows > 0) 
								{
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
										<?php 
									} else echo '<h1>No Houses</h1>';
								?>
							</div>
						</div>			  
						<div class="tab-pane fade" id="veh">
							<div class="table-responsive">
								<?php
									$sql = "SELECT * FROM `vehicles` WHERE `pid` = '" . $_SESSION['steamid'] . "' ORDER BY `id` DESC LIMIT 8";
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
									} else echo '<h1>No Cars</h1>';
								?>
							</div>
						</div>
						<div class="tab-pane fade well" id="civ_inv">
								<h4 style="centred"><?php echo $lang['civ']." ".$lang['gear'];?> </h4>
								<?php
									$sql = 'SELECT * FROM `players` WHERE `playerid` ="' . $_SESSION['steamid'] . '";';
									$result_of_query = $db_connection->query($sql);
									while ($row = mysqli_fetch_assoc($result_of_query)) 
									{
										echo "<textarea class='form-control' readonly rows='5' style='width: 100%' id='civ_gear' name='civ_gear'>" . $row["civ_gear"] . "</textarea>";						
									}							
								?>					
						</div>
						<div class="tab-pane fade well" id="police_inv">
								<h4 style="centred"><?php echo $lang['police']." ".$lang['gear'];?> </h4>
								<?php
									$sql = 'SELECT * FROM `players` WHERE `playerid` ="' . $_SESSION['steamid'] . '";';
									$result_of_query = $db_connection->query($sql);
									while ($row = mysqli_fetch_assoc($result_of_query)) 
									{
										echo "<textarea class='form-control' readonly rows='5' style='width: 100%' id='civ_gear' name='cop_gear'>" . $row["cop_gear"] . "</textarea>";							
									}							
								?>				
						</div>
						<div class="tab-pane fade well" id="medic_inv">
								<h4 style="centred"><?php echo $lang['medic']." ".$lang['gear'];?> </h4>
								<?php
									$sql = 'SELECT * FROM `players` WHERE `playerid` ="' . $_SESSION['steamid'] . '";';
									$result_of_query = $db_connection->query($sql);
									while ($row = mysqli_fetch_assoc($result_of_query)) 
									{
										echo "<textarea class='form-control' readonly rows='5' style='width: 100%' id='civ_gear' name='med_gear'>" . $row["med_gear"] . "</textarea>";								
									}							
								?>					
						</div>					
					</div>
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
