<?php
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

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Life Control</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>  <?php echo $_SESSION['user_name']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
						<?php
								if ($_SESSION['user_level'] >= 3)
								{

									echo"<li class='divider'></li>";
									echo"<li>";
									echo"<a href='admin.php'><i class='fa fa-fw fa-cog'></i> Admin</a>";
									echo"</li>";

									echo"<li class='divider'></li>";
									echo"<li>";
									echo"<a href='register.php'><i class='fa fa-fw fa-cog'></i> Add New User</a>";
									echo"</li>";
								}
						
						?>
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="players.php"><i class="fa fa-fw fa-child "></i> Players</a>
                    </li>
                    <li>
                        <a href="vehicles.php"><i class="fa fa-fw fa-car"></i> Vehicles</a>
                    </li>
                    <li>
                        <a href="houses.php"><i class="fa fa-fw fa-home"></i> Houses</a>
                    </li>
                   <li>
                        <a href="gangs.php"><i class="fa fa-fw fa-sitemap"></i> Gangs</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Add <small>New User</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-user"></i> New user
                            </li>
                        </ol>
						<?php
						
								if (isset($registration)) 
								{
									if ($registration->errors) 
									{
										foreach ($registration->errors as $error) 
										{
											echo"<div class='row'>"; 
												echo"<div class='col-lg-12'>";
													echo"<div class='alert alert-danger alert-dismissable'>";
														echo"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"; 
														echo "<i class='fa fa-info-circle'></i> ".$error;
													echo "</div>"; 
												echo"</div>";
											echo"</div>";
										}
									}
									if ($registration->messages) 
									{
										foreach ($registration->messages as $message) 
										{
											echo"<div class='row'>"; 
												echo"<div class='col-lg-12'>";
													echo"<div class='alert alert-danger alert-dismissable'>";
														echo"<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"; 
														echo "<i class='fa fa-info-circle'></i> ".$message;
													echo "</div>"; 
												echo"</div>";
											echo"</div>";
										}
									}
								}

						?>
                    </div>
					<div class="col-sm-4">
						<form method="post" action="register.php" name="registerform">                         
						   <div class="form-group">
								<!-- the user name input field uses a HTML5 pattern check -->
								<label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>
								<input id="login_input_username" class=" form-control login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />

								<label for="player_id">PlayerID</label>
								<input id="player_id" class=" form-control login_input" type="text" name="player_id" required />

								<!-- the email input field uses a HTML5 email type check -->
								<label for="login_input_email">User's email</label>
								<input id="login_input_email" class=" form-control login_input" type="email" name="user_email" required />

								<label for="login_input_password_new">Password (min. 6 characters)</label>
								<input id="login_input_password_new" class=" form-control login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

								<label for="login_input_password_repeat">Repeat password</label>
								<input id="login_input_password_repeat" class=" form-control login_input" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
								<br/>
								<input type="submit" class="btn btn-lg btn-primary" name="register" value="Add New User" />
							</div>
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