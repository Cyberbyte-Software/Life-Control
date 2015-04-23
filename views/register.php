<?php
include("config/lang/module.php");

// create a database connection, using the constants from config/config.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}
?>

<?php
if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo "<div class='row'>";
            echo "<div class='col-lg-12'>";
            echo "<div class='alert alert-danger alert-dismissable'>";
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
            echo "<div class='alert alert-danger alert-dismissable'>";
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
        <h4> Dave: </h4>
        <img src="assets/img/profile/1.jpg">
        <h4> Joe: </h4>
        <img src="assets/img/profile/2.jpg">
        <h4> Sam: </h4>
        <img src="assets/img/profile/3.jpg">
    </div>

    <div class="col-lg-10 container">
        <form class="" method="post" action="register.php" name="registerform">
            <h2 class="form-login-heading">New User</h2>

            <div class="login-wrap">
                <p>Username:</p>
                <input id="login_input_username" type="text" class="form-control"
                       placeholder="Username (only letters and numbers, 2 to 64 characters)" autofocus
                       pattern="[a-zA-Z0-9]{2,64}" name="user_name" required>
                <br>

                <p>Player ID:</p>
                <input id="player_id" class="form-control" placeholder="PlayerID" type="text" name="player_id"
                       required/>
                <br>

                <p>Email Address:</p>
                <input id="login_input_email" placeholder="User's email" class=" form-control" type="email"
                       name="user_email" required/>
                <br>

                <p>Password:</p>
                <input id="login_input_password_new" placeholder="Password (min. 6 characters)"
                       class=" form-control login_input" type="password"
                       name="user_password_new" pattern=".{6,}" required autocomplete="off"/>
                <br>

                <p>Repeat password:</p>
                <input id="login_input_password_repeat" placeholder="Repeat password" class=" form-control login_input"
                       type="password"
                       name="user_password_repeat" pattern=".{6,}" required autocomplete="off"/>
                <br>

                <p>Profile Picture:</p>
                <select class=" form-control" name="profile_pic">
                    <?php for ($icon = 1; $icon <= lvlmed; $icon = $icon + 1) {
                    echo '<option value="' . $icon . '" >' . iconName($icon) . '</option>';
                    } ?>
                </select>
                <br>

                <p>Rank:</p>
                <select class="form-control" name="user_lvl">
                    <option value="1">Support</option>
                    <option value="2">Moderator</option>
                    <option value="3">Administrator</option>
                </select>
                <br>
                <input type="submit" class="btn btn-theme btn-block" name="register" value="Add New User"/>
                <hr>
            </div>
        </form>
    </div>
    <div class="col-lg-1 container">
        <h4> Kerry: </h4>
        <img src="assets/img/profile/4.jpg">
        <h4> Jess: </h4>
        <img src="assets/img/profile/5.jpg">
        <h4> Connie: </h4>
        <img src="assets/img/profile/6.jpg">
    </div>
</div>
