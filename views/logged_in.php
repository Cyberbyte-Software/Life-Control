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
    </div>
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
		<div class="content-panel">
			<table class="table table-striped table-advance table-hover">
				<h4>
					<i class="fa fa-taxi fa-fw"></i>
					<?php echo $lang['police'] . " " . $lang['overview']; ?>
					<div class="col-lg-3 pull-right">
						<a href="police.php"><?php echo $lang['viewAll'] . " "; ?> <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</h4>
				<hr>
				<thead>
					<tr>
						<th><i class="fa fa-user"></i><?php echo " " .$lang['name']; ?></th>
						<th><i class="fa fa-eye"></i><?php echo " " .$lang['playerID']; ?></th>
						<th><i class="fa fa-user"></i><?php echo " " .$lang['rank']; ?></th>
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
	
    <?php if ($_SESSION['user_level'] >= 2) { ?>
        <div class="col-lg-4">
			<div class="content-panel">
				<table class="table table-striped table-advance table-hover">
					<h4>
						<i class="fa fa-money fa-fw"></i> Top Ten Richest Players
					</h4>
					<hr>
					<thead>
						<tr>
							<th><i class="fa fa-user"></i><?php echo " " .$lang['name']; ?></th>
							<th><i class="fa fa-eye"></i><?php echo " " .$lang['playerID']; ?></th>
							<th><i class="fa fa-money"></i><?php echo " " .$lang['cash']; ?></th>
							<th><i class="fa fa-bank"></i><?php echo " " .$lang['bank']; ?></th>
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
    <?php } ?>
	
    <div class="col-lg-4">
        <div class="content-panel">
			<table class="table table-striped table-advance table-hover">
				<h4>
					<i class="fa fa-ambulance fa-fw"></i> Medic Overview
					<div class="col-lg-3 pull-right">
						<a href="medic.php"><?php echo $lang['viewAll'] . " "; ?> <i class="fa fa-arrow-circle-right"></i></a>
					</div>
				</h4>
				<hr>
				<thead>
						<tr>
							<th><i class="fa fa-user"></i><?php echo " " .$lang['name']; ?></th>
							<th><i class="fa fa-eye"></i><?php echo " " .$lang['playerID']; ?></th>
							<th><i class="fa fa-user"></i><?php echo " " .$lang['rank']; ?></th>
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