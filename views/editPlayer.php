<?php
require_once("config/carNames.php");
require_once("config/license.php");

$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET["ID"])) 
{
    $uID = $_GET["ID"];

    $temp = "";
    $pGID = $uID;
    for ($i = 0; $i < 8; $i++) {
        $temp .= chr($pGID & 0xFF);
        $pGID >>= 8;
    }
    $pGID = md5('BE' . $temp);

    $sql = "SELECT `playerid` FROM `players` WHERE `uid` = '" . $uID . "'";
    $result_of_query = $db_connection->query($sql);
    while ($row = mysqli_fetch_assoc($result_of_query)) {
        $pID = $row["playerid"];
    }  
	if (isset($_POST["editType"])) 
	{
		switch ($_POST["editType"])
		{
			case "civ_licenses":
				$civ_licenses_value = mysql_real_escape_string($_POST["civ_licenses_value"]);	
				$update = "UPDATE players SET civ_licenses = '".$civ_licenses_value."' WHERE uid = '".$uID."' ";
				if (!$db_connection->connect_errno) 
				{
					$result_of_query = $db_connection->query($update);
				} 
				else 
				{
					$this->errors[] = "Database connection problem.";
				}				
				break;
			case "cop_licenses":
				$cop_licenses_value = mysql_real_escape_string($_POST["cop_licenses_value"]);	
				$update = "UPDATE players SET cop_licenses = '".$cop_licenses_value."' WHERE uid = '".$uID."' ";				
				if (!$db_connection->connect_errno) 
				{
					$result_of_query = $db_connection->query($update);
				} 
				else 
				{
					$this->errors[] = "Database connection problem.";
				}				
				break;
			case "med_licenses":
				$med_licenses_value = mysql_real_escape_string($_POST["med_licenses_value"]);	
				$update = "UPDATE players SET med_licenses = '".$med_licenses_value."' WHERE uid = '".$uID."' ";					
				if (!$db_connection->connect_errno) 
				{
					$result_of_query = $db_connection->query($update);
				} 
				else 
				{
					$this->errors[] = "Database connection problem.";
				}				
				break;
			case "civ_inv":
				$civ_gear_value = mysql_real_escape_string($_POST["civ_inv_value"]);	
				$update = "UPDATE players SET civ_gear = '".$civ_gear_value."' WHERE uid = '".$uID."' ";
				if (!$db_connection->connect_errno) 
				{
					$result_of_query = $db_connection->query($update);
				} 
				else 
				{
					$this->errors[] = "Database connection problem.";
				}				
				break;
			case "cop_inv":
				$cop_gear_value = mysql_real_escape_string($_POST["cop_inv_value"]);	
				$update = "UPDATE players SET cop_gear = '".$cop_gear_value."' WHERE uid = '".$uID."' ";
				if (!$db_connection->connect_errno) 
				{
					$result_of_query = $db_connection->query($update);
				} 
				else 
				{
					$this->errors[] = "Database connection problem.";
				}				
				break;
			case "med_inv":
				$med_gear_value = mysql_real_escape_string($_POST["med_inv_value"]);	
				$update = "UPDATE players SET med_gear = '".$med_gear_value."' WHERE uid = '".$uID."' ";
				if (!$db_connection->connect_errno) 
				{
					$result_of_query = $db_connection->query($update);
				} 
				else 
				{
					$this->errors[] = "Database connection problem.";
				}					
				break;
			case "player_edit":
				switch ($_SESSION['user_level'])
				{
					case 1:
						$coplevel = intval($_POST["player_coplvl"]);
						$mediclevel = intval($_POST["player_medlvl"]);			
						$update = "UPDATE players SET coplevel = '".$coplevel."', mediclevel = '".$mediclevel."' WHERE uid = '".$uID."' ";	
						if (!$db_connection->connect_errno) 
						{
							$result_of_query = $db_connection->query($update);
						} 
						else 
						{
							$this->errors[] = "Database connection problem.";
						}							
						break;
					case 2:
						$coplevel = intval($_POST["player_coplvl"]);
						$mediclevel = intval($_POST["player_medlvl"]);
						$donatorlvl = intval($_POST["player_donlvl"]);
						$cash = mysql_real_escape_string($_POST["player_cash"]);
						$bankacc = mysql_real_escape_string($_POST["player_bank"]);
						$arrested = intval($_POST["player_arrest"]);
						$blacklist = intval($_POST["player_blacklist"]);						
						$update = "UPDATE players SET coplevel = '".$coplevel."', mediclevel = '".$mediclevel."', donatorlvl = '".$donatorlvl."', cash = '".$cash."', bankacc = '".$bankacc."', arrested = '".$arrested."', blacklist = '".$blacklist."' WHERE uid = '".$uID."' ";				
						if (!$db_connection->connect_errno) 
						{
							$result_of_query = $db_connection->query($update);
						} 
						else 
						{
							$this->errors[] = "Database connection problem.";
						}							
						break;
					case 3:
						$coplevel = intval($_POST["player_coplvl"]);
						$mediclevel = intval($_POST["player_medlvl"]);
						$donatorlvl = intval($_POST["player_donlvl"]);
						$adminlevel = intval($_POST["player_adminlvl"]);
						$cash = mysql_real_escape_string($_POST["player_cash"]);
						$bankacc = mysql_real_escape_string($_POST["player_bank"]);
						$arrested = intval($_POST["player_arrest"]);
						$blacklist = intval($_POST["player_blacklist"]);						
						$update = "UPDATE players SET coplevel = '".$coplevel."', mediclevel = '".$mediclevel."', donatorlvl = '".$donatorlvl."', adminlevel = '".$adminlevel."', cash = '".$cash."', bankacc = '".$bankacc."', arrested = '".$arrested."', blacklist = '".$blacklist."' WHERE uid = '".$uID."' ";	
						if (!$db_connection->connect_errno) 
						{
							$result_of_query = $db_connection->query($update);
						} 
						else 
						{
							$this->errors[] = "Database connection problem.";
						}						
						break;
				}
				break;					
		}
	}

?>

    <!-- /.row -->
	<?php
		$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
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
                            $playersID = $row["playerid"];
                            
                            echo "<h4>" . $lang['aliases'] . ": " . $row["aliases"] . "</h4>";
							echo "<h4>" . $lang['uid'] . ": " . $row["uid"]. "</h4>";
                            echo "<h4>" . $lang['playerID'] . ": " . $pID . "</h4>";
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
						<a data-toggle="modal" href="#edit_player" class="btn btn-primary btn-xs" style="float: right;">
							<i class="fa fa-pencil"></i>
						</a>
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
			$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
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
					<a href="http://steamcommunity.com/profiles/<?php echo $row["playerid"]; ?>" target="_blank"><span class="fa fa-3x fa-steam"></span></a>
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
				<?php if($_SESSION['user_level'] >= P_VIEW_VEHICLES) echo'<li><a href="#veh" data-toggle="tab">'. $lang['vehicles'] .'</a></li>' ?>
			</ul>
			<div id="myTabContent" class="tab-content">		
				<div class="tab-pane fade in active well" id="civ_lic">
						<h4 style="centred"><?php echo $lang['civ']." ".$lang['licenses'];?> </h4>
						<?php
							$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
							$result_of_query = $db_connection->query($sql);
							while ($row = mysqli_fetch_assoc($result_of_query)) 
							{
								$civ_licenses = array();
								$civ_licenses = explode("],[", $row["civ_licenses"]);
								$civ_licenses = str_replace("]]\"","",$civ_licenses);
								$civ_licenses = str_replace("\"[[","",$civ_licenses);
								$civ_licenses = str_replace("`","",$civ_licenses);
	   
								for ( $x = 0; $x < count ($civ_licenses); $x++){
                                    $lic = substr($civ_licenses[$x],0,-2);
									if(strpos($civ_licenses[$x], "1")!==false){
										echo "<span class='label label-success' style='margin-right:3px; line-height:2;'>".licName($lic,$license)."</span>";
									}
									else{
										echo "<span class='label label-default' style='margin-right:3px; line-height:2;'>".licName($lic,$license)."</span> ";
									}
								}						
							}
						?>
						<a data-toggle="modal" href="#edit_civ_licenses" class="btn btn-primary btn-xs" style="float: right;">
							<i class="fa fa-pencil"></i>
						</a>
				</div>
				<div class="tab-pane well fade" id="medic_lic">
					<h4 style="centred"><?php echo $lang['medic']." ".$lang['licenses'];?> </h4>
					<?php
						$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
						$result_of_query = $db_connection->query($sql);
						while ($row = mysqli_fetch_assoc($result_of_query)) 
						{
							$med_licenses = array();
							$med_licenses = explode("],[", $row["med_licenses"]);
							$med_licenses = str_replace("]]\"","",$med_licenses);
							$med_licenses = str_replace("\"[[","",$med_licenses);
							$med_licenses = str_replace("`","",$med_licenses);
   
							for ( $x = 0; $x < count ($med_licenses); $x++){
                                $lic = substr($med_licenses[$x],0,-2);
								if(strpos($med_licenses[$x], "1")!==false){
									echo "<span class='label label-success' style='margin-right:3px; line-height:2;'>".licName($lic,$license)."</span> ";
								}
								else{
									echo "<span class='label label-default' style='margin-right:3px; line-height:2;'>".licName($lic,$license)."</span> ";
								}
							}						
						}
					?>
					<a data-toggle="modal" href="#edit_med_licenses" class="btn btn-primary btn-xs" style="float: right;">
						<i class="fa fa-pencil"></i>
					</a>
				</div>	
				<div class="tab-pane well fade" id="police_lic">
					<h4 style="centred"><?php echo $lang['police']." ".$lang['licenses'];?> </h4>
					<?php
						$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
						$result_of_query = $db_connection->query($sql);
						while ($row = mysqli_fetch_assoc($result_of_query)) 
						{
							$cop_licenses = array();
							$cop_licenses = explode("],[", $row["cop_licenses"]);
							$cop_licenses = str_replace("]]\"","",$cop_licenses);
							$cop_licenses = str_replace("\"[[","",$cop_licenses);
							$cop_licenses = str_replace("`","",$cop_licenses);
   
							for ( $x = 0; $x < count ($cop_licenses); $x++){
                                $lic = substr($cop_licenses[$x],0,-2);
								if(strpos($cop_licenses[$x], "1")!==false){
									echo "<span class='label label-success' style='margin-right:3px; line-height:2;'>".licName($lic,$license)."</span> ";
								}
								else{
									echo "<span class='label label-default' style='margin-right:3px; line-height:2;'>".licName($lic,$license)."</span> ";
								}
							}						
						}
					?>
					<a data-toggle="modal" href="#edit_cop_licenses" class="btn btn-primary btn-xs" style="float: right;">
						<i class="fa fa-pencil"></i>
					</a>
				</div>				
				<div class="tab-pane fade" id="house">
					<div class="table-responsive">
						<?php
						$sql = "SELECT `pos`,`id` FROM `houses` WHERE `pid` = '" . $pID . "' ORDER BY `id` DESC LIMIT 8";
						$result_of_query = $db_connection->query($sql);
						if ($result_of_query->num_rows > 0) {
							?>
							<table class="table table-bordered table-hover table-striped">
								<thead>
								<tr>
									<th><?php echo $lang['position']; ?></th>
									<th><?php echo $lang['edit']; ?></th>
								</tr>
								</thead>
								<tbody>
								<?php
								while ($row = mysqli_fetch_assoc($result_of_query)) {
									echo "<tr>";
									echo "<td>" . $row["pos"] . "</td>";
									echo "<td><a class='btn btn-primary btn-xs' href='editHouse.php?ID=" . $row["id"] . "'>";
									echo "<i class='fa fa-pencil'></i></a></td>";
									echo "</tr>";
								};
								?>
								</tbody>
							</table>
						<?php echo '<a class="fa fa-caret-right fa-2x" style="float: right; padding-right:15px;" href="houses.php?ID=' . $pID . '"> More</a>'; } else echo $lang['noHouse'] ?>
					</div>
				</div>			  
				<div class="tab-pane fade" id="veh">
					<div class="table-responsive">
						<?php
						if ($_SESSION['user_level'] >= P_VIEW_VEHICLES) {
							$sql = "SELECT * FROM `vehicles` WHERE `pid` = '" . $pID . "' ORDER BY `id` DESC LIMIT 8";
							$result_of_query = $db_connection->query($sql);
							if ($result_of_query->num_rows > 0) {
								?>
								<table class="table table-bordered table-hover table-striped">
									<thead>
									<tr>
										<th><?php echo $lang['class']; ?></th>
										<th><?php echo $lang['type']; ?></th>
										<th><?php echo $lang['plate']; ?></th>
										<?php if ($_SESSION['user_level'] >= P_EDIT_VEHICLES) echo "<th>". $lang['edit'] ."</th>"; ?>
									</tr>
									</thead>
									<tbody>
									<?php
                                    if ($_SESSION['user_level'] >= P_EDIT_VEHICLES) {
									while ($row = mysqli_fetch_assoc($result_of_query)) {
										$vehID = $row["id"];
										echo "<tr>";
										echo "<td>" . carName($row["classname"]) . "</td>";
										echo "<td>" . carType($row["type"],$lang) . "</td>";
										echo "<td>" . $row["plate"] . "</td>";
										echo "<td><a class='btn btn-primary btn-xs' href='editVeh.php?ID=" . $row["id"] . "'>";
										echo "<i class='fa fa-pencil'></i></a></td>";
										echo "</tr>";
									};
                                    } else {
                                        while ($row = mysqli_fetch_assoc($result_of_query)) {
                                            $vehID = $row["id"];
                                            echo "<tr>";
                                            echo "<td>" . carName($row["classname"]) . "</td>";
                                            echo "<td>" . carType($row["type"],$lang) . "</td>";
                                            echo "<td>" . $row["plate"] . "</td>";
                                            echo "</tr>";
                                    }; }

									?>
									</tbody>
								</table>
								<?php echo '<a class="fa fa-caret-right fa-2x" style="float: right; padding-right:15px;" href="vehicles.php?ID=' . $pID . '"> More</a>';
							} else echo '<h1>No cars</h1>';
						} ?>
					</div>
				</div>
				<div class="tab-pane fade well" id="civ_inv">
						<h4 style="centred"><?php echo $lang['civ']." ".$lang['gear'];?> </h4>
						<?php
							$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
							$result_of_query = $db_connection->query($sql);
							while ($row = mysqli_fetch_assoc($result_of_query)) 
							{
								echo "<textarea class='form-control' readonly rows='5' style='width: 100%' id='civ_gear' name='civ_gear'>" . $row["civ_gear"] . "</textarea>";						
							}							
						?>
						<br>
					<a data-toggle="modal" href="#edit_civ_inv" class="btn btn-primary btn-xs" style="float: right;">
						<i class="fa fa-pencil"></i>
					</a>
						<br>					
				</div>
				<div class="tab-pane fade well" id="police_inv">
						<h4 style="centred"><?php echo $lang['police']." ".$lang['gear'];?> </h4>
						<?php
							$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
							$result_of_query = $db_connection->query($sql);
							while ($row = mysqli_fetch_assoc($result_of_query)) 
							{
								echo "<textarea class='form-control' readonly rows='5' style='width: 100%' id='civ_gear' name='cop_gear'>" . $row["cop_gear"] . "</textarea>";							
							}							
						?>
						<br>
					<a data-toggle="modal" href="#edit_cop_inv" class="btn btn-primary btn-xs" style="float: right;">
						<i class="fa fa-pencil"></i>
					</a>
						<br>					
				</div>
				<div class="tab-pane fade well" id="medic_inv">
						<h4 style="centred"><?php echo $lang['medic']." ".$lang['gear'];?> </h4>
						<?php
							$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
							$result_of_query = $db_connection->query($sql);
							while ($row = mysqli_fetch_assoc($result_of_query)) 
							{
								echo "<textarea class='form-control' readonly rows='5' style='width: 100%' id='civ_gear' name='med_gear'>" . $row["med_gear"] . "</textarea>";								
							}							
						?>
						<br>
					<a data-toggle="modal" href="#edit_med_inv" class="btn btn-primary btn-xs" style="float: right;">
						<i class="fa fa-pencil"></i>
					</a>
					<br>
				</div>					
			</div>
		</div>
	</div>	

	<div class="col-md-9" style="float:right; padding-top:20px;">
		<?php
			$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
			$result_of_query = $db_connection->query($sql);
			while ($row = mysqli_fetch_assoc($result_of_query)) 
			{
				if (sql_smartPhone == TRUE && $_SESSION['user_level'] >= P_ACCESS_SQL_PHONE)
				{
					include("views/modules/sqlSmartPhone/module.php");
				}
			}
        ?>	
	</div>
	
<div class="modal fade" id="edit_civ_licenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Civ Licenses</h4>
            </div>
			<?php 
				$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) 			
				{
			?>
            <form method="post" action="editPlayer.php?ID=<?php echo $row['uid'];?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="editType" value="civ_licenses" />
                        <div class="row">
                            <textarea class="form-control" rows="10" name="civ_licenses_value"><?php echo $row['civ_licenses'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit"><?php echo $lang['subChange']; ?></button>
                </div>
            </form>
			<?php
				}
			?>
        </div>
    </div>
</div>
    if
<div class="modal fade" id="edit_cop_licenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Cop Licenses</h4>
            </div>
			<?php 
				$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) 			
				{
			?>
            <form method="post" action="editPlayer.php?ID=<?php echo $row['uid'];?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="editType" value="cop_licenses" />
                        <div class="row">
                            <textarea class="form-control" rows="10" name="cop_licenses_value"><?php echo $row['cop_licenses'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit"><?php echo $lang['subChange']; ?></button>
                </div>
            </form>
			<?php
				}
			?>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_med_licenses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Medic Licenses</h4>
            </div>
			<?php 
				$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) 			
				{
			?>
            <form method="post" action="editPlayer.php?ID=<?php echo $row['uid'];?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="editType" value="med_licenses" />
                        <div class="row">
                            <textarea class="form-control" rows="10" name="med_licenses_value"><?php echo $row['med_licenses'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit"><?php echo $lang['subChange']; ?></button>
                </div>
            </form>
			<?php
				}
			?>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_med_inv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Medic Licenses</h4>
            </div>
			<?php 
				$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) 			
				{
			?>
            <form method="post" action="editPlayer.php?ID=<?php echo $row['uid'];?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="editType" value="med_inv" />
                        <div class="row">
                            <textarea class="form-control" rows="10" name="med_inv_value"><?php echo $row['med_gear'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit"><?php echo $lang['subChange']; ?></button>
                </div>
            </form>
			<?php
				}
			?>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_civ_inv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Medic Licenses</h4>
            </div>
			<?php 
				$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) 			
				{
			?>
            <form method="post" action="editPlayer.php?ID=<?php echo $row['uid'];?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="editType" value="civ_inv" />
                        <div class="row">
                            <textarea class="form-control" rows="10" name="civ_inv_value"><?php echo $row['med_gear'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit"><?php echo $lang['subChange']; ?></button>
                </div>
            </form>
			<?php
				}
			?>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_cop_inv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Medic Licenses</h4>
            </div>
			<?php 
				$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) 			
				{
			?>
            <form method="post" action="editPlayer.php?ID=<?php echo $row['uid'];?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="editType" value="cop_inv" />
                        <div class="row">
                            <textarea class="form-control" rows="10" name="cop_inv_value"><?php echo $row['cop_gear'];?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit"><?php echo $lang['subChange']; ?></button>
                </div>
            </form>
			<?php
				}
			?>
        </div>
    </div>
</div>
<div class="modal fade" id="edit_player" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span class="glyphicon glyphicon-pencil"></span> Edit Player</h4>
            </div>
			<?php 
				$sql = 'SELECT * FROM `players` WHERE `uid` ="' . $uID . '";';
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) 			
				{
			?>
			
            <form method="post" action="editPlayer.php?ID=<?php echo $row['uid'];?>" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="editType" value="player_edit" />
                        <div class="row">
							<center>
								<?php
									if ($_SESSION['user_level'] >= P_EDIT_PLAYER)
									{
										echo "<h4>" . $lang['cash'] . ":    <input id='player_cash' name='player_cash' type='number' value='" . $row["cash"] . "'>";
										echo "<h4>" . $lang['bank'] . ":    <input id='player_bank' name='player_bank' type='number' value='" . $row["bankacc"] . "'>";
									}
									echo "<h4>" . $lang['cop'] . ": ";
									echo "<select id='player_coplvl' name='player_coplvl'>";
									for ($lvl = 0; $lvl <= lvlcop; $lvl++) {
										echo '<option value="' . $lvl . '"' . select($lvl, $row['coplevel']) . '>' . $lvl . '</option>';
									}
									echo "</select>";
									echo "<h4>" . $lang['medic'] . ": ";
									echo "<select id='player_medlvl' name='player_medlvl'>";
									for ($lvl = 0; $lvl <= lvlmed; $lvl++) {
										echo '<option value="' . $lvl . '"' . select($lvl, $row['mediclevel']) . '>' . $lvl . '</option>';
									}
									echo "</select>";
									if ($_SESSION['user_level'] >= P_EDIT_ADMINS) {
										echo "<h4>" . $lang['admin'] . ": ";
										echo "<select id='player_adminlvl' name='player_adminlvl'>";
										for ($lvl = 1; $lvl <= lvladmin; $lvl++) {
											echo '<option value="' . $lvl . '"' . select($lvl, $row['adminlevel']) . '>' . $lvl . '</option>';
										}
										echo "</select>";
										echo "<h4>" . $lang['blacklisted'] . ": "; //TODO: Yes or no option
										echo "<select id='player_blacklist' name='player_blacklist'>";
                                        echo '<option value="1"' . select('1', $row['blacklist']) . '>Yes</option>';
                                        echo '<option value="0"' . select('0', $row['blacklist']) . '>No</option>';
                                        echo "</select>";
									}
									if ($_SESSION['user_level'] >= P_EDIT_PLAYER)
									{
                                        echo "<h4>" . $lang['arrested'] . ": ";
                                        echo "<select id='player_arrest' name='player_arrest'>";
                                        echo '<option value="1"' . select('1', $row['arrested']) . '>Yes</option>';
                                        echo '<option value="0"' . select('0', $row['arrested']) . '>No</option>';
                                        echo "</select>";
										echo "<h4>" . $lang['donator'] . ": ";
										echo "<select id='player_donlvl' name='player_donlvl'>";
										for ($lvl = 0; $lvl <= lvldonator; $lvl++) {
											echo '<option value="' . $lvl . '"' . select($lvl, $row['donatorlvl']) . '>' . $lvl . '</option>';
										}
										echo "</select>";
									}					
								?>
							</center>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" type="reset">Close</button>
                    <button class="btn btn-primary" type="submit"><?php echo $lang['subChange']; ?></button>
                </div>
            </form>
			<?php
				}
			?>
        </div>
    </div>
</div>
<?php
} else {
    include("views/errors/noID.php");
}
?>