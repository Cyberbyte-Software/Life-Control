<?php
	include("config/lang/module.php");

	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["playerId"]))
	{
		$pId = $_POST["playerId"];		
	}
	else
	{
		echo "<center><h1 style='color:red'>".$lang['idNotSet']."</h1></center>";
	}

	// change character set to utf8 and check it
	if (!$db_connection->set_charset("utf8")) {
		$db_connection->errors[] = $db_connection->error;
	}
	
	$pGID = "";
	
	$playersID = $_POST["playerId"];	
	$temp = '';

	for ($i = 0; $i < 8; $i++) {
		$temp .= chr($playersID & 0xFF);
		$playersID >>= 8;
	}

	$return = md5('BE' . $temp);
	$pGID = $return;

	
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Life Control</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <?php include("views/sidebar.php"); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           <?php echo $lang['player'];?><small><?php echo " ". $lang['editing'];?></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-wrench"></i><?php echo $lang['player']." ".$lang['editor'];?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
					<div class="col-lg-4">
						<?php 
							if ($_SESSION['user_level'] >= 2)
							{
						?>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><i class="fa fa-home fa-fw"></i><?php echo " ". $lang['houses']." ".$lang['quickLook'];?></h3>
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover table-striped">
											<thead>
												<tr>
													<th><?php echo $lang['position'];?></th>
													<th><?php echo $lang['edit'];?></th>
												</tr>
											</thead>
											<tbody>
												<?php
													if (!$db_connection->connect_errno) 
													{
														$sql = "SELECT `pos`,`id` FROM `houses` WHERE `pid` = '".$pId."' ORDER BY `id` DESC LIMIT 10";
														$result_of_query = $db_connection->query($sql);
														while($row = mysqli_fetch_assoc($result_of_query)) 
														{

															$temp = '';

															for ($i = 0; $i < 8; $i++) {
																$temp .= chr($playersID & 0xFF);
																$playersID >>= 8;
															}

															$return = md5('BE' . $temp);
															$pGID = $return;
															
															$hID = $row["id"];
															echo "<tr>";
																echo "<td>".$row["pos"]."</td>";
																echo "<td><form method='post' action='editHouse.php' name='PlayerEdit'>";
																echo "<input id='hID' type='hidden' name='hID' value='".$hID."'>";
																echo "<input class='btn btn-sm btn-primary'  type='submit'  name='editH' value='".$lang['edit']."'>";
																echo "</form></td>";
															echo "</tr>";
														};
													} 
													else 
													{
														$this->errors[] = "Database connection problem.";
													}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						<?php
							}
						?>
                    </div>
					<div class="col-lg-4" style="float:right;">
						<?php 
							if ($_SESSION['user_level'] >= 2)
							{
						?>
								<div class="panel panel-default">
									<div class="panel-heading">
										<h3 class="panel-title"><i class="fa fa-car fa-fw"></i><?php echo " ". $lang['vehicles']." ".$lang['quickLook'];?></h3>
									</div>
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-bordered table-hover table-striped">
												<thead>
													<tr>
														<th><?php echo $lang['class'];?></th>
														<th><?php echo $lang['type'];?></th>
														<th><?php echo $lang['plate'];?></th>
														<th><?php echo $lang['edit'];?></th>
													</tr>
												</thead>
												<tbody>
													<?php
														if ($_SESSION['user_level'] >= 2)
														{
															if (!$db_connection->connect_errno) 
															{
																$sql = "SELECT * FROM `vehicles` WHERE `pid` = '".$pId."' ORDER BY `id` DESC LIMIT 10";
																$result_of_query = $db_connection->query($sql);
																while($row = mysqli_fetch_assoc($result_of_query)) 
																{
																	$vehID = $row["id"];
																	echo "<tr>";
																		echo "<td>".$row["classname"]."</td>";
																		echo "<td>".$row["type"]."</td>";
																		echo "<td>".$row["plate"]."</td>";
																		echo "<td><form method='post' action='editVeh.php' name='PlayerEdit'>";
																		echo "<input id='vehID' type='hidden' name='vehID' value='".$vehID."'>";
																		echo "<input class='btn btn-sm btn-primary'  type='submit'  name='editVeh' value='".$lang['edit']."'>";
																		echo "</form></td>";
																	echo "</tr>";
																};
															} 
															else 
															{
																$this->errors[] = "Database connection problem.";
															}
														}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
						<?php
							}
						?>
                    </div>
                    <div class="col-md-4"style="float:left;">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-child fa-fw"></i><?php echo " ". $lang['player'];?></h3>
                            </div>
                            <div class="panel-body">
								<form method="post" action="edit-action.php" name="editform">
									<?php
										if (!$db_connection->connect_errno) 
										{
											$sql = 'SELECT * FROM `players` WHERE `playerid` ="'.$pId.'";';
											$result_of_query = $db_connection->query($sql);
											if ($result_of_query->num_rows > 0)
											{
												while($row = mysqli_fetch_assoc($result_of_query)) 
												{
													$playersID = $row["playerid"];
													echo "<center>";
														echo "<h3>".$lang['name'].": ".$row["name"]."</h3>";
														echo "<h4>".$lang['aliases'].": ".$row["aliases"]."</h4>";
														echo "<h4>".$lang['playerID'].": ".$playersID."</h4>";
														echo "<h4>".$lang['GUID'].": ".$pGID."</h4>";
														if ($_SESSION['user_level'] >= 2)
														{
															echo "<h4>".$lang['cash'].":    <input id='player_cash' name='player_cash' type='text' value='".$row["cash"]."'></td><br/>";
															echo "<h4>".$lang['bank'].":    <input id='player_bank' name='player_bank' type='text' value='".$row["bankacc"]."'></td><br/>";
														}
														else 
														{
															echo "<input id='player_cash' type='hidden' name='player_cash' value='".$row["cash"]."'>";
															echo "<input id='player_bank' type='hidden' name='player_bank' value='".$row["bankacc"]."'>";
															echo "<h4>".$lang['cash'].": ".$row["cash"]."</h4>";
															echo "<h4>".$lang['bank'].": ".$row["bankacc"]."</h4>";														
														}
														echo "<h4>".$lang['cop'].": ";
														echo "<select id='player_coplvl' name='player_coplvl'>";
															echo '<option value="0"';
																if($row['coplevel']==0){echo ' selected';}
															echo '>0</option>';	
															echo '<option value="1"';
																if($row['coplevel']==1){echo ' selected';}
															echo '>1</option>';	
															echo '<option value="2"';
																if($row['coplevel']==2){echo ' selected';}
															echo '>2</option>';
															echo '<option value="3"';
																if($row['coplevel']==3){echo ' selected';}
															echo '>3</option>';
															echo '<option value="4"';
																if($row['coplevel']==4){echo ' selected';}
															echo '>4</option>';
															echo '<option value="5"';
																if($row['coplevel']==5){echo ' selected';}
															echo '>5</option>';
															echo '<option value="6"';
																if($row['coplevel']==6){echo ' selected';}
															echo '>6</option>';
															echo '<option value="7"';
																if($row['coplevel']==7){echo ' selected';}
															echo '>7</option></h4>';
														echo "</select>";
														echo "<h4>".$lang['medic'].": ";
														echo "<select id='player_medlvl' name='player_medlvl'>";
															echo '<option value="0"';
																if($row['mediclevel']==0){echo ' selected';}
															echo '>0</option>';	
															echo '<option value="1"';
																if($row['mediclevel']==1){echo ' selected';}
															echo '>1</option>';	
															echo '<option value="2"';
																if($row['mediclevel']==2){echo ' selected';}
															echo '>2</option>';
															echo '<option value="3"';
																if($row['mediclevel']==3){echo ' selected';}
															echo '>3</option>';
															echo '<option value="4"';
																if($row['mediclevel']==4){echo ' selected';}
															echo '>4</option>';
															echo '<option value="5"';
																if($row['mediclevel']==5){echo ' selected';}
															echo '>5</option>';
														echo "</select>";
														if ($_SESSION['user_level'] >= 3)
														{
															echo "<h4>".$lang['admin'].": ";
															echo "<select id='player_adminlvl' name='player_adminlvl'>";
																echo '<option value="0"';
																	if($row['adminlevel']==0){echo ' selected';}
																echo '>0</option>';	
																echo '<option value="1"';
																	if($row['adminlevel']==1){echo ' selected';}
																echo '>1</option>';	
																echo '<option value="2"';
																	if($row['adminlevel']==2){echo ' selected';}
																echo '>2</option>';
																echo '<option value="3"';
																	if($row['adminlevel']==3){echo ' selected';}
																echo '>3</option>';
															echo "</select>";
														}
														else 
														{
															echo "<input id='player_adminlvl' type='hidden' name='player_adminlvl' value='".$row["adminlevel"]."'>";
															echo "<h4>".$lang['admin'].": ".$row["adminlevel"]."</h4>";
														}
														if ($_SESSION['user_level'] >= 2)
														{
															echo "<h4>".$lang['donator'].": ";
															echo "<select id='player_donlvl' name='player_donlvl'>";
																echo '<option value="0"';
																	if($row['donatorlvl']==0){echo ' selected';}
																echo '>0</option>';	
																echo '<option value="1"';
																	if($row['donatorlvl']==1){echo ' selected';}
																echo '>1</option>';	
																echo '<option value="2"';
																	if($row['donatorlvl']==2){echo ' selected';}
																echo '>2</option>';
																echo '<option value="3"';
																	if($row['donatorlvl']==3){echo ' selected';}
																echo '>3</option>';
																echo '<option value="4"';
																	if($row['donatorlvl']==4){echo ' selected';}
																echo '>4</option>';
																echo '<option value="5"';
																	if($row['donatorlvl']==5){echo ' selected';}
																echo '>5</option>';
															echo "</select>";
														}
														else 
														{
															echo "<input id='player_donlvl' type='hidden' name='player_donlvl' value='".$row["donatorlvl"]."'>";
															echo "<h4>".$lang['donator'].": ".$row['donatorlvl']."</h4>";														
														}
													echo "</center>";
									?>
							</div>		
						</div>
					</div>
					<div class='col-lg-12'>
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<h3 class='panel-title'><i class='fa fa-taxi fa-fw'></i><?php echo " ". $lang['police'];?></h3>
							</div>
							<div class="panel-body">
								<div class="col-md-4" style="padding-left:250px;">
									<?php
										if ($_SESSION['user_level'] >= 2)
										{
											echo "<h4>".$lang['cop']." ".$lang['licenses']."</h4> <textarea id='cop_lic' name='cop_lic' cols='70' rows='5'>".$row["cop_licenses"]."</textarea>";
										}
										else 
										{
											echo "<h4>".$lang['cop']." ".$lang['licenses'].":</h4> <textarea readonly id='cop_lic' name='cop_lic' cols='70' rows='5'>".$row["cop_licenses"]."</textarea>";												
										}									
									?>
								</div>
								<div class="col-md-4" style="padding-left:300px;">
									<?php
										if ($_SESSION['user_level'] >= 2)
										{
											echo "<h4>".$lang['cop']." ".$lang['gear'].":</h4> <textarea id='cop_gear' name='cop_gear' cols='70' rows='5'>".$row["cop_gear"]."</textarea>";
										}
										else 
										{
											echo "<h4>".$lang['cop']." ".$lang['gear'].":</h4> <textarea readonly id='cop_gear' name='cop_gear' cols='70' rows='5'>".$row["cop_gear"]."</textarea>";
										}									
									?>
								</div>
							</div>
						</div>
						<div class='panel panel-default'>
							<div class='panel-heading'>
								<h3 class='panel-title'><i class='fa fa-child fa-fw'></i><?php echo " ". $lang['civil'];?></h3>
							</div>
							<div class="panel-body">
								<div class="col-md-4" style="padding-left:250px;">
									<?php
										if ($_SESSION['user_level'] >= 2)
										{
											echo "<h4>".$lang['civ']." ".$lang['licenses'].":</h4> <textarea id='civ_lic' name='civ_lic' cols='70' rows='5'>".$row["civ_licenses"]."</textarea>";
										}
										else 
										{
											echo "<h4>".$lang['civ']." ".$lang['licenses'].":</h4> <textarea readonly id='civ_lic' name='civ_lic' cols='70' rows='5'>".$row["civ_licenses"]."</textarea>";
										}									
									?>
								</div>
								<div class="col-md-4" style="padding-left:300px;">
									<?php
										if ($_SESSION['user_level'] >= 2)
										{
											echo "<h4>".$lang['civ']." ".$lang['gear'].":</h4> <textarea id='civ_gear' name='civ_gear' cols='70' rows='5'>".$row["civ_gear"]."</textarea>";
										}
										else 
										{
											echo "<h4>".$lang['civ']." ".$lang['gear'].":</h4> <textarea readonly id='civ_gear' name='civ_gear' cols='70' rows='5'>".$row["civ_gear"]."</textarea>";
										}									
									?>
								</div>
							</div>
						</div>

						<div class='panel panel-default'>
							<div class='panel-heading'>
								<h3 class='panel-title'><i class='fa fa-ambulance fa-fw'></i><?php echo " ". $lang['medic'];?></h3>
							</div>
							<div class="panel-body">
								<div class="col-md-4" style="padding-left:250px;">
									<?php
										if ($_SESSION['user_level'] >= 2)
										{
											echo "<h4>".$lang['medic']." ".$lang['licenses'].":</h4> <textarea id='med_lic' name='med_lic' cols='70' rows='5'>".$row["med_licenses"]."</textarea>";
										}
										else 
										{
											echo "<h4>".$lang['medic']." ".$lang['licenses'].":</h4> <textarea readonly id='med_lic' name='med_lic' cols='70' rows='5'>".$row["med_licenses"]."</textarea>";
										}									
									?>
								</div>
								<div class="col-md-4" style="padding-left:300px;">
									<?php
										if ($_SESSION['user_level'] >= 2)
										{
											echo "<h4>".$lang['medic']." ".$lang['gear'].":</h4> <textarea id='med_gear' name='med_gear' cols='70' rows='5'>".$row["med_gear"]."</textarea>";
										}
										else 
										{
											echo "<h4>".$lang['medic']." ".$lang['gear'].":</h4> <textarea readonly id='med_gear' name='med_gear' cols='70' rows='5'>".$row["med_gear"]."</textarea>";
										}									
									?>
								</div>
							</div>
						</div>
						<?php
							if (sql_smartPhone == TRUE && $_SESSION['user_level'] >= 2)
							{
								include("views/modules/sqlSmartPhone/module.php");
							}
						?>
						
						
					</div>
					<div class="col-md-4"></div>					
					<div class="col-md-4">
								<center>
									<?php
										echo "<input id='playerId' type='hidden' name='playerId' value='".$playersID."'>";
										echo "<input class='btn btn-lg btn-primary'  type='submit'  name='edit' value='Submit Changes'>";
									?>
									<br/>
								</center>
					</div>
									<?php
												};
											}
											else 
											{
												echo "<center><h1 style='color:red'>ERROR NO RESULTS</h1></center>";
											}
										
										} 
										else 
										{
											$this->errors[] = "Database connection problem.";
										}
									?>  
								</form>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>
