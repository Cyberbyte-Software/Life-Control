<?php

// create a database connection, using the constants from config/config.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$enale = enable_game_query;

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (isset($_GET['setup'])) {
if ($_GET['setup'] == 1) {
    $message = $lang['setup'];
} elseif ($_GET['setup'] == 2) {
    $message = $lang['upgrade'];
} else $message = $_GET['setup']; }

if (isset($obj->DBversion)) if (floatval($version['DBversion']) < floatval($obj->DBversion) && $_SESSION['user_level'] >= P_VIEW_UPDATE && !DEV)
    $message = 'There is a database upgrade avalible, update your software and go to <a href="/update.php">update.php</a><br>Don\'t want this message set P_VIEW_UPDATE to 99'
?>
<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $lang['navDashboard']; ?>
            <small><?php echo " " . $lang['statOver']; ?></small>
        </h1>
    </div>
</div>
<?php if (isset($message)) echo '<div class="alert alert-info" role="alert">' . $message . '</div>';?>

<div class="row">
    <div class="col-lg-4">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4>
                    <i class="fa fa-taxi fa-fw"></i>
                    <?php echo $lang['police'] . " " . $lang['overview']; ?>
                    <div class="col-lg-3 pull-right">
                        <a href="police.php"><?php echo $lang['viewAll'] . " "; ?> <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </h4>
                <hr>
                <thead>
                <tr>
                    <th><i class="fa fa-user"></i><?php echo " " . $lang['name']; ?></th>
                    <th><i class="fa fa-eye"></i><?php echo " " . $lang['playerID']; ?></th>
                    <th><i class="fa fa-user"></i><?php echo " " . $lang['rank']; ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!$db_connection->connect_errno) {
                    $sql = "SELECT `name`,`coplevel`,`playerid` FROM `players` WHERE `coplevel` >= '1' ORDER BY `coplevel` DESC LIMIT 10";
                    $result_of_query = $db_connection->query($sql);
                    while ($row = mysqli_fetch_assoc($result_of_query)) {
                        $playersID = $row["playerid"];
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $playersID . "</td>";
                        echo "<td>" . $row["coplevel"] . "</td>";
                        echo "</tr>";
                    };
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4>
                    <i class="fa fa-money fa-fw"></i><?php echo $lang['topRich']; ?>
                </h4>
                <hr>
                <thead>
                <tr>
                    <th><i class="fa fa-user"></i><?php echo " " . $lang['name']; ?></th>
                    <th><i class="fa fa-eye"></i><?php echo " " . $lang['playerID']; ?></th>
                    <th><i class="fa fa-money"></i><?php echo " " . $lang['cash']; ?></th>
                    <th><i class="fa fa-bank"></i><?php echo " " . $lang['bank']; ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!$db_connection->connect_errno) {
                    $sql = "SELECT `name`, `cash`, `bankacc`, `playerid` FROM `players` ORDER BY `bankacc` DESC LIMIT 10";
                    $result_of_query = $db_connection->query($sql);
                    while ($row = mysqli_fetch_assoc($result_of_query)) {
                        $playersID = $row["playerid"];
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $playersID . "</td>";
                        echo "<td>" . $row["cash"] . "</td>";
                        echo "<td>" . $row["bankacc"] . "</td>";
                        echo "</tr>";
                    };
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-panel">
            <table class="table table-striped table-advance table-hover">
                <h4>
                    <i class="fa fa-ambulance fa-fw"></i>
                    <?php echo $lang['medic'] . " " . $lang['overview']; ?>
                    <div class="col-lg-3 pull-right">
                        <a href="medic.php"><?php echo $lang['viewAll'] . " "; ?> <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </h4>
                <hr>
                <thead>
                <tr>
                    <th><i class="fa fa-user"></i><?php echo " " . $lang['name']; ?></th>
                    <th><i class="fa fa-eye"></i><?php echo " " . $lang['playerID']; ?></th>
                    <th><i class="fa fa-user"></i><?php echo " " . $lang['rank']; ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (!$db_connection->connect_errno) {
                    $sql = "SELECT `name`,`mediclevel`,`playerid` FROM `players` WHERE `mediclevel` >= '1' ORDER BY `mediclevel` DESC LIMIT 10";
                    $result_of_query = $db_connection->query($sql);
                    while ($row = mysqli_fetch_assoc($result_of_query)) {
                        $playersID = $row["playerid"];
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $playersID . "</td>";
                        echo "<td>" . $row["mediclevel"] . "</td>";
                        echo "</tr>";
                    };
                } else {
                    $this->errors[] = "Database connection problem.";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- /.row -->