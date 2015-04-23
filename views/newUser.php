<?php
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo "<div class='row'>";
            echo "<div class='col-lg-12'>";
            echo "<div class='alert alert-danger alert-dismissable animated infinite bounce' style ='padding-top: 25px;'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<i class='fa fa-info-circle'></i> " . $error;
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo "<div class='row'>";
            echo "<div class='col-lg-12'>";
            echo "<div class='alert alert-info alert-dismissable animated infinite bounce' style ='padding-top: 25px;'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<i class='fa fa-info-circle'></i> " . $message;
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
}
?>

<div id="login-page">
    <div class="col-lg-1 container">
        <h4> <?php echo icon1 ?>: </h4>
        <img src="assets/img/profile/1.jpg">
        <h4> <?php echo icon2 ?>: </h4>
        <img src="assets/img/profile/2.jpg">
        <h4> <?php echo icon3 ?>: </h4>
        <img src="assets/img/profile/3.jpg">
    </div>

    <div class="col-lg-10 container">
        <form class="" method="post" action="newUser.php" name="registerform">
            <h2 class="form-login-heading">New User</h2>

            <div class="login-wrap">
                <p><?php echo $lang['username']?>:</p>
                <input id="login_input_username" type="text" class="form-control" autofocus
                       pattern="[a-zA-Z0-9]{2,64}" name="user_name" required>
                <br>

                <p><?php echo $lang['playerID']?>:</p>
                <input id="player_id" class="form-control" type="text" name="player_id"
                       required/>
                <br>

                <p><?php echo $lang['emailAdd']?>:</p>
                <input id="login_input_email" class=" form-control" type="email"
                       name="user_email" required/>
                <br>

                <p><?php echo $lang['password']?>:</p>
                <input id="login_input_password_new"
                       class=" form-control login_input" type="password"
                       name="user_password_new" pattern=".{6,}" required autocomplete="off"/>
                <br>

                <p><?php echo $lang['repeat'] .' '. $lang['password']?>:</p>
                <input id="login_input_password_repeat" class=" form-control login_input" type="password"
                       name="user_password_repeat" pattern=".{6,}" required autocomplete="off"/>
                <br>

                <p><?php echo $lang['picture']?>:</p>
                <select class=" form-control" name="profile_pic">
                    <?php for ($icon = 1; $icon <= 6; $icon++) {
                    echo '<option value="' . $icon . '" >' . iconName($icon) . '</option>';
                    } ?>
                </select>
                <br>

                <p><?php echo $lang['rank']?>:</p>
                <select class="form-control" name="user_lvl">
                    <?php for ($rank = 1; $rank <= staff_levels; $rank++) {
                        echo '<option value="' . $rank . '" >' . $rank . '</option>';
                    } ?>
                </select>
                <br>
                <input type="submit" class="btn btn-theme btn-block" name="register" value="Add New User"/>
            </div>
        </form>
    </div>
    <div class="col-lg-1 container">
        <h4> <?php echo icon4 ?>: </h4>
        <img src="assets/img/profile/4.jpg">
        <h4> <?php echo icon5 ?>: </h4>
        <img src="assets/img/profile/5.jpg">
        <h4> <?php echo icon6 ?>: </h4>
        <img src="assets/img/profile/6.jpg">
    </div>
</div>
