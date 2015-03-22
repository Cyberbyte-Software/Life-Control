<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$page_rows = results_per_page;
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
                            Vehicles <small>Overview</small>
                        </h1>
						<div class="col-lg-4" style="top:3px;float:right;">
							<form style="float:right;" method='post' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" name='searchPlayer'>
								<input id='searchText' type='text' name='searchText'>
								<input class='btn btn-sm btn-primary'  type='submit'  name='pid' value='Search PID'>
								<input class='btn btn-sm btn-primary'  type='submit'  name='class' value='Search Class'>
							</form>
						</div>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-car"></i> Vehicles
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-car fa-fw"></i> Vehicles
                            </div>
                            <div class="panel-body">
                                <?php
                                    if($_SESSION['user_level'] >= '2') { ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Owners Player ID</th>
                                                        <th>Class</th>
                                                        <th>Type</th>
                                                        <th>Plate</th>
                                                        <th>Alive</th>
                                                        <th>Edit</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    if (!$db_connection->connect_errno) 
                                                    {

                                                        if (!(isset($_POST['pagenum']))) 
                                                        { 
                                                            $pagenum = 1; 
                                                        }
                                                        else
                                                        {
                                                            $pagenum = $_POST['pagenum'];
                                                        }

                                                        $sql = "SELECT * FROM `vehicles`;";

                                                        $result_of_query = $db_connection->query($sql);
                                                        $rows = mysqli_num_rows($result_of_query); 

                                                        $last = ceil($rows/$page_rows); 

                                                        if ($pagenum < 1) 
                                                        { 
                                                            $pagenum = 1; 
                                                        } 
                                                        elseif ($pagenum > $last) 
                                                        { 
                                                            $pagenum = $last; 
                                                        } 

                                                        $max = 'limit ' .($pagenum - 1) * $page_rows .',' .$page_rows;

                                                        if (isset($_POST['searchText']))
                                                        {
                                                            $searchText = $_POST['searchText'];

                                                            if (isset($_POST['pid'])) 
                                                            {
                                                                $sql = "SELECT * FROM `vehicles` WHERE `classname` LIKE '%".$searchText."%' ".$max." ;";
                                                            } 
                                                            else 
                                                            {
                                                                $sql = "SELECT * FROM `vehicles` WHERE `pid` LIKE '%".$searchText."%' ".$max." ;";
                                                            }												
                                                        }
                                                        else
                                                        {
                                                            $sql = "SELECT * FROM `vehicles` ".$max." ;";
                                                        }
                                                        $result_of_query = $db_connection->query($sql);
                                                        while($row = mysqli_fetch_assoc($result_of_query)) 
                                                        {
                                                            $vehID = $row["id"];
                                                            echo "<tr>";
                                                                echo "<td>".$row["pid"]."</td>";
                                                                echo "<td>".$row["classname"]."</td>";
                                                                echo "<td>".$row["type"]."</td>";
                                                                echo "<td>".$row["plate"]."</td>";
                                                                echo "<td>".$row["alive"]."</td>";
                                                                echo "<td><form method='post' action='editVeh.php' name='PlayerEdit'>";
                                                                echo "<input id='vehID' type='hidden' name='vehID' value='".$vehID."'>";
                                                                echo "<input class='btn btn-sm btn-primary'  type='submit'  name='edit' value='Edit Vehicle'>";
                                                                echo "</form></td>";
                                                            echo "</tr>";
                                                        };
                                                        echo "</tbody></table>";
                                                        echo "<table><thead>";
                                                        echo "<br>";
                                                        if ($pagenum == 1){} 
                                                        else 
                                                        {
                                                            echo "<th><form method='post' action='".$_SERVER['PHP_SELF']."' name='pagenum'>";
                                                            echo "<input id='pagenum' type='hidden' name='pagenum' value='1'>";
                                                            echo "<input type='submit' value=' <<-First  '>";
                                                            echo "</form></th>";
                                                            $previous = $pagenum-1;
                                                            echo "<th><form style='float:right;' method='post' action='".$_SERVER['PHP_SELF']."' name='pagenum'>";
                                                            echo "<input id='pagenum' type='hidden' name='pagenum' value='".$previous."'>";
                                                            echo "<input type='submit' value=' <-Previous  '>";
                                                            echo "</form></th>";
                                                        } 
                                                        //This does the same as above, only checking if we are on the last page, and then generating the Next and Last links
                                                        if ($pagenum == $last) {} 
                                                        else 
                                                        {
                                                            $next = $pagenum+1;
                                                            echo "<th><form method='post' action='".$_SERVER['PHP_SELF']."' name='pagenum'>";
                                                            echo "<input id='pagenum' type='hidden' name='pagenum' value='".$next."'>";
                                                            echo "<input type='submit' value=' Next ->  '>";
                                                            echo "</form></th>";
                                                            echo " ";
                                                            echo "<th><form method='post' action='".$_SERVER['PHP_SELF']."' name='pagenum'>";
                                                            echo "<input id='pagenum' type='hidden' name='pagenum' value='".$last."'>";
                                                            echo "<input type='submit' value=' Last ->>  '>";
                                                            echo "</form></th>";
                                                        } 
                                                        echo "</thead></table>";
                                                    }  
                                                    else 
                                                    {
                                                        $this->errors[] = "Database connection problem.";
                                                    }
                                                ?>  
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php } else {
                                           echo "Your permission level is insufficient to see this.";
                                    };
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

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
