<?php

// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$uId = "";

if (isset($_POST["userId"])) {
    $uId = $_POST["userId"];
} else {
    echo "<center><h1 style='color:red'>" . $lang['idNotSet'] . "</h1></center>";
}

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}
?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $lang['staff']; ?>
            <small><?php echo " " . $lang['editor']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-wrench"></i><?php echo $lang['staff'] . " " . $lang['editor']; ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="col-md-4"></div>
<div class="col-md-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-users fa-fw"></i><?php echo " " . $lang['staff']; ?></h3>
        </div>
        <div class="panel-body">
            <form method="post" action="editStaffAction.php" name="editform">
                <?php
                if (!$db_connection->connect_errno) {
                    $sql = 'SELECT * FROM `users` WHERE `user_id` ="' . $uId . '";';
                    $result_of_query = $db_connection->query($sql);
                    if ($result_of_query->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result_of_query)) {
                            $playersID = $row["playerid"];
                            echo "<center>";
                            echo "<h4>" . $lang['name'] . ":  <input id='staffName' name='staffName' type='text' value='" . $row["user_name"] . "'></h4>";
                            echo "<h4>" . $lang['emailAdd'] . ": <input id='staffEmail' style='min-width:300px;'name='staffEmail' type='text' value='" . $row["user_email"] . "'></h4>";
                            echo "<h4>" . $lang['rank'] . ": ";
                            echo "<select id='staffRank' name='staffRank'>";
                            echo '<option value="1"';
                            if ($row['user_level'] == 1) {
                                echo ' selected';
                            }
                            echo '>' . $lang['support'] . '</option>';
                            echo '<option value="2"';
                            if ($row['user_level'] == 2) {
                                echo ' selected';
                            }
                            echo '>' . $lang['mod'] . '</option>';
                            echo '<option value="3"';
                            if ($row['user_level'] == 3) {
                                echo ' selected';
                            }
                            echo '>' . $lang['administrator'] . '</option>';
                            echo "</select></h4>";
                            echo "<h4>" . $lang['playerID'] . ":  <input id='staffPID' name='staffPID' type='text' value='" . $row["playerid"] . "'></h4>";
                            echo "</center>";

                        };
                    } else {
                        echo "<center><h1 style='color:red'>ERROR NO RESULTS</h1></center>";
                    }

                } else {
                    $this->errors[] = "Database connection problem.";
                }
                echo "<input id='user_id' type='hidden' name='user_id' value='" . $uId . "'>";
                echo "<center><input class='btn btn-lg btn-primary'  type='submit'  name='edit' value='" . $lang['subChange'] . "'></center>";

                ?>
            </form>
        </div>
    </div>
</div>
								
