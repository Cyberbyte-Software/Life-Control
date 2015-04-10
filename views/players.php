<?php

// create a database connection, using the constants from config/db.php (which we loaded in index.php)
$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$page_rows = results_per_page;
// change character set to utf8 and check it
if (!$db_connection->set_charset("utf8")) {
    $db_connection->errors[] = $db_connection->error;
}
?>


<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?php echo $lang['players']; ?>
            <small><?php echo " " . $lang['overview']; ?></small>
        </h1>
        <div class="col-lg-4" style="top:3px;float:right;">
            <form style="float:right;" method='post' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
                  name='searchPlayer'>
                <input id='searchText' type='text' name='searchText'>
                <input class='btn btn-sm btn-primary' type='submit' name='pid'
                       value='<?php echo $lang['search'] . " " . $lang['PID']; ?>'>
                <input class='btn btn-sm btn-primary' type='submit' name='name'
                       value='<?php echo $lang['search'] . " " . $lang['name']; ?>'>
            </form>
        </div>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-child"></i><?php echo " " . $lang['players']; ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-child fa-fw"></i><?php echo " " . $lang['players']; ?>
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
                        <th><?php echo $lang['cop']; ?></th>
                        <th><?php echo $lang['medic']; ?></th>
                        <th><?php echo $lang['admin']; ?></th>
                        <th><?php echo $lang['edit']; ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (!$db_connection->connect_errno) {
						if (isset($_GET["page"])) {
							$page = $_GET["page"];
						}else {
							$page=1;
						}
						
						$start_from = ($page-1) * $page_rows;
						$max = 'LIMIT ' . $start_from . ',' . $page_rows;
							
						if (isset($_POST['searchText'])) {
							$searchText = $_POST['searchText'];
							if (isset($_POST['pid'])) {
								$sql = "SELECT * FROM `players` WHERE `playerid` LIKE '%" . $searchText . "%' " . $max . " ;";
							} else {
								$sql = "SELECT * FROM `players` WHERE `name` LIKE '%" . $searchText . "%' " . $max . " ;";
							}
						} else {
							$sql = "SELECT * FROM `players` " . $max . " ;";
						}

						$result_of_query = $db_connection->query($sql);
						while ($row = mysqli_fetch_assoc($result_of_query)) {
							$playersID = $row["playerid"];
							echo "<tr>";
							echo "<td>" . $row["name"] . "</td>";
							echo "<td>" . $playersID . "</td>";
							echo "<td>" . $row["cash"] . "</td>";
							echo "<td>" . $row["bankacc"] . "</td>";
							echo "<td>" . $row["coplevel"] . "</td>";
							echo "<td>" . $row["mediclevel"] . "</td>";
							echo "<td>" . $row["adminlevel"] . "</td>";
							echo "<td><form method='post' action='editPlayer.php' name='PlayerEdit'>";
							echo "<input id='playerId' type='hidden' name='playerId' value='" . $playersID . "'>";
							echo "<input class='btn btn-sm btn-primary'  type='submit'  name='edit' value='" . $lang['edit'] . "'>";
							echo "</form></td>";
							echo "</tr>";

						};
						echo "</tbody></table>";
						
						$sql = "SELECT * FROM `players`";
						$result_of_query = $db_connection->query($sql);
						$total_records  = mysqli_num_rows($result_of_query); 
						$total_pages = ceil($total_records / $page_rows);
						echo "<center><a class='btn btn-primary' href='players.php?page=1'>".'First Page'."</a> ";
						
						for ($i=1; $i<=$total_pages; $i++) {
							echo "<a class='btn btn-primary' href='players.php?page=".$i."'>".$i."</a> ";
						};

						echo "<a class='btn btn-primary' href='players.php?page=$total_pages'>".'Last Page'."</a></center>";
						
                    } else {
                        $this->errors[] = "Database connection problem.";
                    }
                    ?>
            </div>
        </div>
    </div>
</div>
