<?php include("config/lang/module.php") ?>
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
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
            <a class="navbar-brand" href="../index.php">Life Control</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                        class="fa fa-user"></i>  <?php echo $_SESSION['user_name']; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="../profile.php"><i class="fa fa-fw fa-user"></i><?php echo " " . $lang['navProfile']; ?>
                        </a>
                    </li>
                    <?php
                    if ($_SESSION['user_level'] >= 3) {
                        ?>
                        <li class='divider'></li>
                        <li>
                            <a href='../admin.php'><i class='fa fa-fw fa-cog'></i><?php echo " " . $lang['navAdmin'];?></a>
                        </li>

                        <li class='divider'></li>
                        <li>
                            <a href='../register.php'><i
                                    class='fa fa-fw fa-cog'></i><?php echo " " . $lang['navNewUser'];?></a>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="divider"></li>
                    <li>
                        <a href="../index.php?logout"><i
                                class="fa fa-fw fa-power-off"></i><?php echo " " . $lang['navLogOut']; ?></a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a href="../index.php"><i class="fa fa-fw fa-dashboard"></i><?php echo " " . $lang['navDashboard']; ?>
                    </a>
                </li>
                <li>
                    <a href="../players.php"><i class="fa fa-fw fa-child "></i><?php echo " " . $lang['players']; ?></a>
                </li>
                <?php
                if ($_SESSION['user_level'] >= 2) {
                    ?>
                    <li>
                        <a href="../vehicles.php"><i class="fa fa-fw fa-car"></i><?php echo " " . $lang['vehicles'];?></a>
                    </li>
                    <li>
                        <a href="../houses.php"><i class="fa fa-fw fa-home"></i><?php echo " " . $lang['houses'];?></a>
                    </li>
                    <li>
                        <a href="../gangs.php"><i class="fa fa-fw fa-sitemap"></i><?php echo " " . $lang['gangs'];?></a>
                    </li>
                    <?php
                    if (alits_life_4 == TRUE) {
                        ?>
                        <li>
                            <a href="../wanted.php"><i class="fa fa-fw fa-list-ul"></i><?php echo " " . $lang['wanted'];?>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                <?php
                }
                ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">
            <?php include($page) ?>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="../js/plugins/morris/raphael.min.js"></script>
<script src="../js/plugins/morris/morris.min.js"></script>
<script src="../js/plugins/morris/morris-data.js"></script>

</body>

</html>
