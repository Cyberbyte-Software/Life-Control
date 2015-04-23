<?php
require_once("config/config.php");

function iconName($icon){
    if ($icon == 2) return icon2;
    elseif ($icon == 3) return icon3;
    elseif ($icon == 4) return icon4;
    elseif ($icon == 5) return icon5;
    elseif ($icon == 6) return icon6;
    else return icon1;
}

if (isset($_POST['user_name']) && isset($_POST['user_email']) && isset($_POST['user_password']) && isset($_POST['playerid'])) {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    $playerid = $_POST['playerid'];
    $user_pic = $_POST['user_pic'];

    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

    mysqli_query($link, "CREATE TABLE IF NOT EXISTS `users` (
    `user_id` INT(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
    `user_name` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
    `user_password_hash` VARCHAR(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s password in salted and hashed format',
    `user_email` VARCHAR(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
    `playerid` VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
    `user_level` ENUM('0','1','2','3') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
    `user_profile` SMALLINT NOT NULL
    ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';") or die(mysqli_error($link));

    mysqli_query($link, "INSERT INTO `users` (`user_id`, `user_name`, `user_password_hash`, `user_email`, `playerid`, `user_level`, `user_profile`) VALUES
    (1, '" . $user_name . "', '" . $user_password_hash . "', '" . $user_email . "', '" . $playerid . "', 3, ".$user_pic.");") or die(mysqli_error($link));

    mysqli_query($link, "ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`), ADD UNIQUE KEY `user_name` (`user_name`), ADD UNIQUE KEY `user_email` (`user_email`);") or die(mysqli_error($link));

    mysqli_query($link, "ALTER TABLE `users`
    MODIFY `user_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index',AUTO_INCREMENT=5;") or die(mysqli_error($link));

	mysqli_query($link, "CREATE TABLE IF NOT EXISTS `notes` (
	  `note_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing note_id of each user, unique index',
	  `uid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	  `staff_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	  `note_text` varchar(255) NOT NULL,
	  `note_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`note_id`),
	  UNIQUE KEY `note_id` (`note_id`)
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");

    mysqli_close($link);
    header("Location: index.php?setup=1");
} else {
    $message = '<div class="alert alert-danger" role="alert">Enter all values</div>';
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
        <!--logo start-->
        <a href="index.php" class="logo"><b>Life Control</b></a>
        <!--logo end-->
    </header>
    <!--header end-->

    <!-- **********************************************************************************************************************************************************
    MAIN SIDEBAR MENU
    *********************************************************************************************************************************************************** -->
    <!--sidebar end-->
    <section id="main-content">
        <section class="wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <center>SQL Setup</center>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">

                    <form method="post" action="index.php" name="setupform">
                        <div class="form-group">
                            Username: <input placeholder="Username" id="login_input_username"
                                             class=" form-control login_input" type="text" name="user_name" required>
                            Email: <input placeholder="Email" id="login_input_email" class="form-control login_input"
                                          type="email" name="user_email" autocomplete="off" required>
                            Password: <input placeholder="Password" id="login_input_password"
                                             class="form-control login_input" type="password" name="user_password"
                                             autocomplete="off" required>
                            Player ID: <input placeholder="Player ID" id="login_input_playerid"
                                              class=" form-control login_input" type="number" name="playerid">
                            Picture: <select id='user_pic' name='user_pic' class=" form-control login_input">
                            <?php
                            for ($icon = 1; $icon <= lvlmed; $icon = $icon + 1) {
                                echo '<option value="' . $icon . '">' . iconName($icon) . '</option>';
                            }?>
                            </select>
                            <br>
                            <input class="btn btn-lg btn-primary" style="float:right;" type="submit" name="setup"
                                   value="Setup">
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.container-fluid -->

        </section>
    </section>

</section>

<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/jquery-1.8.3.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="jquery.scrollTo.min.js"></script>
<script src="jquery.nicescroll.js" type="text/javascript"></script>
<script src="assets/js/jquery.sparkline.js"></script>


<!--common script for all pages-->
<script src="assets/js/common-scripts.js"></script>

<script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="assets/js/gritter-conf.js"></script>

<!--script for this page-->
<script src="assets/js/sparkline-chart.js"></script>
<script src="assets/js/zabuto_calendar.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var unique_id = $.gritter.add({
            // (string | mandatory) the heading of the notification
            title: 'SQL Setup',
            // (string | mandatory) the text inside the notification
            text: 'This program should automatically create the SQL tables',
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
</body>
</html>
