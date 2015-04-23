<?php
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET["ID"])) {
    $uId = $_GET["ID"];
} else {
    echo "<center><h1 style='color:red'>" . $lang['idNotSet'] . "</h1></center>";
}

if (isset($_POST["staffName"])) {
    $staffName = $_POST['staffName'];
    $staffEmail = $_POST['staffEmail'];
    $staffPID = $_POST['staffPID'];
    $uId = $_POST['user_id'];
    if (isset($_POST['ban'])) $staffRank = 0; else $staffRank = $_POST['staffRank'];
    $_SESSION['user_level'] = $staffRank;

    if (!$db_connection->connect_errno) {
        $sql = "UPDATE `users` SET `user_name`='" . $staffName . "',`user_email`='" . $staffEmail . "',`playerid`='" . $staffPID . "',`user_level`='" . $staffRank . "' WHERE `user_id` ='" . $uId . "';";
        $result_of_query = $db_connection->query($sql);
    } else {
        $this->errors[] = "Database connection problem.";
    }
}
if (!$db_connection->connect_errno) {
    $sql = 'SELECT * FROM `users` WHERE `user_id` ="' . $uId . '";';
    $result_of_query = $db_connection->query($sql);
    if ($result_of_query->num_rows > 0) {
        ?>
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    <?php echo $lang['staff']; ?>
                    <small><?php echo " " . $lang['editor']; ?></small>
                </h1>
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
                    <form method="post" action="editStaff.php?ID=<?php echo $uId; ?>" name="editform">
                        <?php
                        while ($row = mysqli_fetch_assoc($result_of_query)) {
                            $playersID = $row["playerid"];
                            echo "<center>";
                            echo "<h4>" . $lang['name'] . ":  <input id='staffName' name='staffName' type='text' value='" . $row["user_name"] . "'></h4>";
                            echo "<h4>" . $lang['emailAdd'] . ": <input id='staffEmail' style='min-width:300px;'name='staffEmail' type='text' value='" . $row["user_email"] . "'></h4>";
                            echo "<h4>" . $lang['rank'] . ": ";
                            echo "<select id='staffRank' name='staffRank'>";
                            for ($lvl = 1; $lvl <= staff_levels; $lvl++) {
                                echo '<option value="' . $lvl . '"' . select($lvl, $row['user_level']) . '>' . $lvl . '</option>';
                            }
                            echo "</select></h4>";
                            echo "<h4>" . $lang['playerID'] . ":  <input id='staffPID' name='staffPID' type='text' value='" . $row["playerid"] . "'></h4>";
                            echo "</center>";

                        };

                        echo "<input id='user_id' type='hidden' name='user_id' value='" . $uId . "'>";
                        echo "<center><input class='btn btn-lg btn-primary'  type='submit'  name='edit' value='" . $lang['subChange'] . "'>";
                        if ($_SESSION['user_id'] <> $uId)
                            echo "  <input class='btn btn-lg btn-danger' type='submit'  name='ban' value='" . $lang['ban'] . "'>";
                        ?>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    <?php
    } else {
        include("views/Errors/noID.php");
    }

} else {
    $this->errors[] = "Database connection problem.";
}