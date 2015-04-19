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
            <?php echo $lang['police']; ?>
            <small><?php echo " " . $lang['overview']; ?></small>
        </h1>
    </div>
</div>
<!-- /.row -->

<div class="col-md-12">
	<div class="content-panel">
		<table class="table table-striped table-advance table-hover">
			<h4>
				<i class="fa fa-taxi fa-fw"></i>
				<?php echo " " . $lang['police']; ?>
			</h4>
			<hr>
			<thead>
				<tr>
					<th><i class="fa fa-user"></i><?php echo " ". $lang['name']; ?></th>
					<th><i class="fa fa-eye"></i><?php echo " ". $lang['playerID']; ?></th>
					<th><i class="fa fa-user"></i><?php echo " ". $lang['rank']; ?></th>
					<th><i class="fa fa-pencil"></i><?php echo " ". $lang['edit']; ?></th>
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

				$sql = "SELECT `name`,`coplevel`,`playerid` FROM `players` WHERE `coplevel` >= '1' ORDER BY `coplevel` " . $max . " ;";
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) {
					echo "<tr>";
					echo "<td>" . $row["name"] . "</td>";
					echo "<td>" . $row["playerid"] . "</td>";
					echo "<td>" . $row["coplevel"] . "</td>";
                    echo "<td><a class='btn btn-primary btn-xs' href='editPlayer.php?ID=" . $row["playerid"] . "'>";
                    echo "<i class='fa fa-pencil'></i></a></td>";
					echo "</tr>";
				};
				echo "</tbody></table>";

				$sql = "SELECT * FROM `players` WHERE `coplevel` >= '1';";
				$result_of_query = $db_connection->query($sql);
				$total_records  = mysqli_num_rows($result_of_query);
				$total_pages = ceil($total_records / $page_rows);
				echo "<center><a class='btn btn-primary' href='police.php?page=1'>".'First Page'."</a> ";
?>
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						<?php echo $lang['page'] . " " ?><span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
					<?php 
						for ($i=1; $i<=$total_pages; $i++) {
					?>
							<li><?php echo "<a href='police.php?page=".$i."'>".$i."</a> "; ?></li>
				  <?php }; ?>
					</ul>
				</div>
				
				<?phpecho "<a class='btn btn-primary' href='police.php?page=$total_pages'>".'Last Page'."</a></center>";

			} else {
				$this->errors[] = "Database connection problem.";
			}
			?>
			<br>
			</tbody>
		</table>
	</div>
</div>
