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

include("views/templates/head");
?>

<body>

<section id="container" >
    <header class="header black-bg">
        <a href="index.php" class="logo"><b>Life Control</b></a>
    </header>
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

        </section>
    </section>

</section>

<?php include("views/templates/scripts.php"); ?>

<script type="text/javascript">
    $(document).ready(function () {
        var unique_id = $.gritter.add({
            title: 'SQL Setup',
            text: 'This program should automatically create the SQL tables',
            image: 'assets/img/profile/2.jpg',
            sticky: true,
            time: '',
            class_name: 'my-sticky-class'
        });

        return false;
    });
</script>
</body>
</html>
