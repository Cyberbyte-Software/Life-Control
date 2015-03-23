<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	$uId = "";
	
	if (isset($_POST["userId"]))
	{
		$uId = $_POST["userId"];
	}
	else
	{
		echo "<center><h1 style='color:red'>USERID NOT SET</h1></center>";
	}

	// change character set to utf8 and check it
	if (!$db_connection->set_charset("utf8")) {
		$db_connection->errors[] = $db_connection->error;
	}	
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
                            Staff <small>Editor
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-wrench"></i> Staff Editor
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
					<div class="col-md-4"></div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-users fa-fw"></i> Staff Member</h3>
                            </div>
                            <div class="panel-body">
								<form method="post" action="editStaffAction.php" name="editform">
									<?php
										if (!$db_connection->connect_errno) 
										{
											$sql = 'SELECT * FROM `users` WHERE `user_id` ="'.$uId.'";';
											$result_of_query = $db_connection->query($sql);
											if ($result_of_query->num_rows > 0)
											{
												while($row = mysqli_fetch_assoc($result_of_query)) 
												{
													$playersID = $row["playerid"];
													echo "<center>";
														echo "<h4>Name:  <input id='staffName' name='staffName' type='text' value='".$row["user_name"]."'></h4>";
														echo "<h4>Email: <input id='staffEmail' style='min-width:300px;'name='staffEmail' type='text' value='".$row["user_email"]."'></h4>";
														echo "<h4>Rank: ";
														echo "<select id='staffRank' name='staffRank'>";
															echo '<option value="1"';
																if($row['user_level']==1){echo ' selected';}
															echo '>1</option>';	
															echo '<option value="2"';
																if($row['user_level']==2){echo ' selected';}
															echo '>2</option>';
															echo '<option value="3"';
																if($row['user_level']==3){echo ' selected';}
															echo '>3</option>';
														echo "</select></h4>";
														echo "<h4>Player ID:  <input id='staffPID' name='staffPID' type='text' value='".$row["playerid"]."'></h4>";
													echo "</center>";
										
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
											echo "<input id='user_id' type='hidden' name='user_id' value='".$uId."'>";
											echo "<center><input class='btn btn-lg btn-primary'  type='submit'  name='edit' value='Submit Changes'></center>";
								
									?>
								</form>
							</div>		
						</div>
					</div>
								
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
