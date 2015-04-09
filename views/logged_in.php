<?php

// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$enale = enable_game_query;

// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}

if (enable_game_query == TRUE) {
    require __DIR__ . '/SourceQuery/SourceQuery.class.php';

    // Edit this ->
    define('SQ_TIMEOUT', 1);
    define('SQ_ENGINE', SourceQuery :: SOURCE);
    // Edit this <-

    $Timer = MicroTime(true);

    $Query = new SourceQuery();

    $Info = Array();
    $Rules = Array();
    $Players = Array();

    try {
        $Query->Connect(SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_TIMEOUT, SQ_ENGINE);

        $Info = $Query->GetInfo();
        $Players = $Query->GetPlayers();
        $Rules = $Query->GetRules();
    } catch (Exception $e) {
        $Exception = $e;
    }

    $Query->Disconnect();

    $Timer = Number_Format(MicroTime(true) - $Timer, 4, '.', '');
}

?>

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $lang['navDashboard']; ?>
            <small><?php echo " " . $lang['statOver']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i><?php echo " " . $lang['navDashboard']; ?>
            </li>
        </ol>
    </div>
</div>

<div class="alert alert-info alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fa fa-info-circle"></i> <strong><?php echo " " . $lang['welcome']; ?></strong> To Life
    Control <?php echo $_SESSION['user_name']; ?>.
</div>
<?php
if ($_SESSION['user_level'] >= 2) {
    if (enable_game_query == TRUE) {
        ?>
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <center>
                                <div id="bigfella" style="width:200px; height:120px"></div>
                            </center>
                        </div>
                    </div>
                    <a href="curPlayers.php">
                        <div class="panel-footer">
                            <span class="pull-left"><?php echo $lang['viewAll'];?></span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    <?php
    }
}
?>
<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i
                        class="fa fa-taxi fa-fw"></i><?php echo $lang['police'] . " " . $lang['overview']; ?></h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th><?php echo $lang['name']; ?></th>
                            <th><?php echo $lang['playerID']; ?></th>
                            <th><?php echo $lang['rank']; ?></th>
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
                <div class="text-right">
                    <a href="police.php"><?php echo $lang['viewAll'] . " "; ?> <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
    <?php if ($_SESSION['user_level'] >= 2) { ?>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>Top Ten Richest Players</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                            <tr>
                                <th><?php echo $lang['name']; ?></th>
                                <th><?php echo $lang['playerID']; ?></th>
                                <th><?php echo $lang['cash']; ?></th>
                                <th><?php echo $lang['bank']; ?></th>
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
                    <div class="text-right">
                        <br/>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-ambulance fa-fw"></i>Medic Overview</h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th><?php echo $lang['name']; ?></th>
                            <th><?php echo $lang['playerID']; ?></th>
                            <th><?php echo $lang['rank']; ?></th>
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
                <div class="text-right">
                    <a href="medic.php"><?php echo $lang['viewAll'] . " "; ?><i
                            class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->