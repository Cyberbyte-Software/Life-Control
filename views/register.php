<?php

// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}
?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Add
            <small>New User</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-user"></i> New user
            </li>
        </ol>
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
    </div>
    <div class="col-sm-4">
        <form method="post" action="register.php" name="registerform">
            <div class="form-group">
                <!-- the user name input field uses a HTML5 pattern check -->
                <label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>
                <input id="login_input_username" class=" form-control login_input" type="text"
                       pattern="[a-zA-Z0-9]{2,64}" name="user_name" required/>

                <label for="player_id">PlayerID</label>
                <input id="player_id" class=" form-control login_input" type="text" name="player_id" required/>

                <!-- the email input field uses a HTML5 email type check -->
                <label for="login_input_email">User's email</label>
                <input id="login_input_email" class=" form-control login_input" type="email" name="user_email"
                       required/>

                <label for="login_input_password_new">Password (min. 6 characters)</label>
                <input id="login_input_password_new" class=" form-control login_input" type="password"
                       name="user_password_new" pattern=".{6,}" required autocomplete="off"/>

                <label for="login_input_password_repeat">Repeat password</label>
                <input id="login_input_password_repeat" class=" form-control login_input" type="password"
                       name="user_password_repeat" pattern=".{6,}" required autocomplete="off"/>
                <br/>
                <input type="submit" class="btn btn-lg btn-primary" name="register" value="Add New User"/>
            </div>
        </form>
    </div>
</div>
