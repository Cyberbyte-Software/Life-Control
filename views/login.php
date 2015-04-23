<?php
include("config/lang/module.php");

// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            $message = $error;
        }
    }
}

if (isset($_GET['setup'])) {
    if ($_GET['setup'] == 1) {
        $message = $lang['setup'];
    } elseif ($_GET['setup'] == 2) {
        $message = $lang['upgrade'];
    } else $message = $_GET['setup'];
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
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet"/>
    <!--Animation CSS-->
    <link rel="stylesheet" href="assets/css/animate.css">

    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body onload="getTime()">


<div class="container">

    <div class="col-lg-4 col-lg-offset-4">
        <div class="lock-screen">
            <?php if (isset($message)) echo '<div style="margin-top: 200px;" class="alert alert-info animated infinite bounce" role="alert">' . $message . '</div>'; else echo '<div style="margin-top: 270px;"></div>' ?>
            <div id="showtime"></div>
            <h2><a data-toggle="modal" href="#login"><i class="fa fa-lock"></i></a></h2>
            <h3>LOGIN</h3>

            <!-- Modal -->
            <div aria-hidden="true" aria-labelledby="login" role="dialog" tabindex="-1" id="login"
                 class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Please Login</h4>
                        </div>
                        <form method="post" action="index.php">
                            <div class="modal-body">
                                <p class="centered"><img class="img-circle" width="80" src="assets/img/profile/2.jpg">
                                </p>

                                <div class="login-wrap">
                                    <input type="text" id="login_input_username" class="form-control"
                                           placeholder="Username" name="user_name" required autofocus>
                                    <br>
                                    <input type="password" id="login_input_password" class="form-control"
                                           placeholder="Password" name="user_password" required>
                                    <br>
                                    <select id='lang' name='lang' class="form-control login_input">
                                        <option value="en" selected>English</option>
                                        <option value="de">Deutsch</option>
                                        <option value="ne">Nederlands</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer centered">
                                <button data-dismiss="modal" class="btn btn-theme04"
                                        type="button"><?php echo $lang['cancel']; ?></button>
                                <button class="btn btn-theme03" href="index.php" type="submit"
                                        name="login"><?php echo $lang['login']; ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modal -->


        </div>
    </div>
    <!-- /col-lg-4 -->

</div>
<!-- /container -->

<!-- js placed at the end of the document so the pages load faster -->
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!--BACKSTRETCH-->
<!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
<script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
<script>
    $.backstretch([
        "assets/img/bg/1.jpg",
        "assets/img/bg/2.jpg",
        "assets/img/bg/3.jpg",
        "assets/img/bg/4.jpg",
        "assets/img/bg/5.jpg"
    ], {duration: 10000, fade: 900});
</script>

<script>
    function getTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        // add a zero in front of numbers<10
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('showtime').innerHTML = h + ":" + m + ":" + s;
        t = setTimeout(function () {
            getTime()
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
</script>

</body>
</html>

