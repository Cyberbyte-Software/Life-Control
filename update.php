<?php
require_once("config/config.php");
$json = file_get_contents('http://cyberbyte.org.uk/version.json');
$obj = json_decode($json);
$version = include 'config/version.php';

if (isset($_POST['upgrade'])) {
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    for ($run = $version['DBversion'] + 1; $run <= $obj->DBversion; $run++){
        include_once("/libraries/updater/".$run.".php");
        $version['DBversion']= $run;
        file_put_contents('config/version.php', '<?php return ' . var_export($version, true) . ';');
        $version = include 'config/version.php';
    }
    header("Location: index.php?setup=2");
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
    <!--header start-->
    <header class="header black-bg">
        <!--logo start-->
        <a href="index.php" class="logo"><b>Life Control</b></a>
        <!--logo end-->
    </header>
    <!--header end-->
    <!--sidebar end-->
    <section id="main-content">
        <section class="wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <center>Upgrade system
                            </center>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">

                    <form method="post" action="update.php" name="upgradeform">
                        <div class="form-group">
                            Your version is currently <?php echo $version['version']; echo '<br>';
                            if ($version['DBversion'] < $obj->DBversion)
                                echo 'There is a database update<br>
                                <input class="btn btn-lg btn-primary" style="float:right;" type="submit" name="upgrade"
                                   value="Upgrade"><br>';
                            if (floatval($version['version']) < floatval($obj->version))
                                echo 'There is a new version available on our website or </a><a href="' . $obj->git . '" target="_blank">GitHub</a>.';
                            ?>


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
            title: '<?php if(isset($obj->title)) echo $obj->title; else echo 'Welcome to Life Control!'?>',
            // (string | mandatory) the text inside the notification
            text: '<?php if(isset($obj->text)) echo $obj->text; else echo 'Report any bugs to Cyberbyte Studios'?>',
            // (string | optional) the image to display on the left
            image: 'assets/img/profile/<?php if(isset($obj->image)) echo $obj->image; else echo '2'?>.jpg',
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
