<?php
	include("config/lang/module.php");

	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	// change character set to utf8 and check it
	if (!$db_connection->set_charset("utf8")) {
		$db_connection->errors[] = $db_connection->error;
	}
	$userPid = "";
	$curpassHash = "";
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
                            <?php echo $lang['navProfile'];?><small><?php echo " ". $lang['overview'];?></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-user"></i><?php echo " ". $lang['navProfile'];?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                    <div class="col-lg-4">
						<div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['user_name']; ?> </h3>
                            </div>
                            <div class="panel-body">
										<?php
											if (!$db_connection->connect_errno) 
											{
												
												if (!empty($_POST))
												{
													$email = $_POST['email'];
													
													$update = "UPDATE `users` SET `user_email`= '".$email."' WHERE `user_name` = '".$_SESSION['user_name']."' ";
													$result_of_query = $db_connection->query($update);
													$sql = "SELECT * FROM `users` WHERE `user_name` ='".$_SESSION['user_name']."' ;";													
												}
												else
												{
													$sql = "SELECT * FROM `users` WHERE `user_name` ='".$_SESSION['user_name']."' ;";
												}
												$sql = "SELECT * FROM `users` WHERE `user_name` ='".$_SESSION['user_name']."' ;";
												$result_of_query = $db_connection->query($sql);
												while($row = mysqli_fetch_assoc($result_of_query)) 
												{
										?>
													<form method='post' action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>' name='profileEdit'>
										<?php
														$userPid = $row["playerid"];
														echo "<center>";
															echo "<h4>".$lang['emailAdd'].": <input style='min-width:300px;text-align:center;'id='email' type='text' name='email' value='".$row["user_email"]."'></h4>";
															echo "<h4>".$lang['rank'].": ".$row["user_level"]."</h4>";
															echo "<h4>".$lang['playerID'].": ".$row["playerid"]."</h4>";
															echo "<input class='btn btn-sm btn-primary'  type='submit'  name='edit' value='".$lang['subChange']."'>";
														echo "</center>";
												};	
										?>			
													</form>
										<?php
											} 
											else 
											{
												$this->errors[] = "Database connection problem.";
											}
										?>
							</div>		                       
						</div>
					</div>
					<!-- /.Profile -->               
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