<?php

// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}
$userPid = "";
$curpassHash = "";
?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-4">
    </div>
    <div class="col-lg-8">
        <h1 class="page-header">
            <?php echo $lang['navProfile']; ?>
            <small><?php echo " " . $lang['overview']; ?></small>
        </h1>
    </div>
</div>
<!-- /.row -->
<div class="col-lg-4">
</div>
<div class="col-lg-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['user_name']; ?> </h3>
        </div>
        <div class="panel-body">
            <?php
            if (!$db_connection->connect_errno) {

                if (!empty($_POST)) {
                    $email = $_POST['email'];
                    $user_pic = $_POST['user_pic'];
                    $_SESSION['user_profile'] = $user_pic;

                    $update = "UPDATE `users` SET `user_email`= '" . $email . "', `user_profile`= '" . $user_pic . "'WHERE `user_name` = '" . $_SESSION['user_name'] . "' ";
                    $result_of_query = $db_connection->query($update);
                    $sql = "SELECT * FROM `users` WHERE `user_name` ='" . $_SESSION['user_name'] . "' ;";
                } else {
                    $sql = "SELECT * FROM `users` WHERE `user_name` ='" . $_SESSION['user_name'] . "' ;";
                }
                $sql = "SELECT * FROM `users` WHERE `user_name` ='" . $_SESSION['user_name'] . "' ;";
                $result_of_query = $db_connection->query($sql);
                while ($row = mysqli_fetch_assoc($result_of_query)) {
                    ?>
                    <form method='post' action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>' name='profileEdit'>
                    <?php
                    $userPid = $row["playerid"];
                    echo "<center>";
                    echo "<h4>" . $lang['emailAdd'] . ": <input style='min-width:300px;text-align:center;'id='email' type='text' name='email' value='" . $row["user_email"] . "'></h4>";
                    echo "<h4>" . $lang['rank'] . ": " . $row["user_level"] . "</h4>";
                    echo "<h4>" . $lang['picture'] . ": ";

                    echo "<select id='user_pic' name='user_pic'>";
                    for ($icon = 1; $icon <= 6; $icon = $icon + 1) {
                        echo '<option value="' . $icon . '" ' . select($icon, $row['user_profile']) . '>' . iconName($icon) . '</option>';
                    }
                    echo "</select>";

                    echo "<h4>" . $lang['playerID'] . ": " . $row["playerid"]. "</h4>";
                    echo "<input class='btn btn-sm btn-primary' type='submit'  name='edit' value='" . $lang['subChange'] . "'> ";
                    echo "<a data-toggle='modal' href='#password'><button type='button' class='btn btn-sm btn-primary'>".$lang['changePass']."</button></a>";
                    echo "</center>";
                }
            ;
                ?>
                <div aria-hidden="true" aria-labelledby="Passchange" role="dialog" tabindex="-1" id="password" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><?php echo $lang['enterPass']; ?></h4>
                            </div>
                            <form method="post" action="profile.php">
                                <div class="modal-body">
                                    <p class="centered">
                                        <input type="password" id="input_password" class="form-control" placeholder="<?php echo $lang['password'];?>" name="user_password" autocorrect="off" autocapitalize="off" required> <br>
                                        <input type="password" id="input_password_again" class="form-control" placeholder="<?php echo $lang['password'];?>" name="user_password_again" autocorrect="off" autocapitalize="off" required>
                                </div>
                                <div class="modal-footer centered">
                                    <button data-dismiss="modal" class="btn btn-theme04" type="button"><?php echo $lang['cancel'];?></button>
                                    <button class="btn btn-theme03" href="profile.php" type="submit" name="save"><?php echo $lang['login']; ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                </form>
            <?php
            } else {
                $this->errors[] = "Database connection problem.";
            }
            ?>
        </div>
    </div>
</div>
<!-- /.Profile -->