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
            <?php echo $lang['houses']; ?>
            <small><?php echo " " . $lang['overview']; ?></small>
        </h1>
    </div>
</div>
<!-- /.row -->

<div class="col-md-12">
	<div class="content-panel">
		<table class="table table-striped table-advance table-hover">
			<h4>
				<i class="fa fa-home fa-fw"></i>
				<?php echo " " . $lang['houses']; ?>
				<div class="col-lg-4 pull-right">
					<form style="float:right;" method='post' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
						  name='searchPlayer'>
						<input id='searchText' type='text' name='searchText'>
						<input class='btn btn-sm btn-primary' type='submit' name='pid'
							   value='<?php echo $lang['search'] . " " . $lang['PID']; ?>'>
						<input class='btn btn-sm btn-primary' type='submit' name='pos'
							   value='<?php echo $lang['search'] . " " . $lang['position']; ?>'>
					</form>
				</div>
			</h4>
			<hr>
			<thead>
				<tr>
					<th><i class="fa fa-eye"><?php echo " " .$lang['owner'] ?></th>
					<th><i class="fa fa-user"><?php echo " " .$lang['position']; ?></th>
					<th><i class="fa fa-user"><?php echo " " .$lang['owned']; ?></th>
					<th><i class="fa fa-pencil"><?php echo " " .$lang['edit']; ?></th>
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

					if (isset($_POST['pos'])) {
						$sql = "SELECT * FROM `houses` WHERE `pos` LIKE '%" . $searchText . "%' " . $max . " ;";
					} else {
						$sql = "SELECT * FROM `houses` WHERE `pid` LIKE '%" . $searchText . "%' " . $max . " ;";
					}
				} else {
					$sql = "SELECT * FROM `houses` " . $max . " ;";
				}
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) {
					$hID = $row["id"];
					echo "<tr>";
					echo "<td>" . nameID($row["pid"]) . "</td>";
					echo "<td>" . $row["pos"] . "</td>";
					echo "<td>" . yesNo($row["owned"],$lang) . "</td>";
                    echo "<td><a class='btn btn-primary btn-xs' href='editHouse.php?ID=".$row["id"]."'>";
                    echo "<i class='fa fa-pencil'></i></a></td>";
					echo "</tr>";
				};
				echo "</tbody></table>";

				$sql = "SELECT * FROM `houses`";
				$result_of_query = $db_connection->query($sql);
				$total_records  = mysqli_num_rows($result_of_query); 
				$total_pages = ceil($total_records / $page_rows);
				echo "<center><a class='btn btn-primary' href='houses.php?page=1'>".$lang['first']."</a> ";

				for ($i=1; $i<=$total_pages; $i++) {
					echo "<a class='btn btn-primary' href='houses.php?page=".$i."'>".$i."</a> ";
				};

				echo "<a class='btn btn-primary' href='houses.php?page=$total_pages'>".$lang['last']."</a></center>";
										
			} else {
				$this->errors[] = "Database connection problem.";
			}
			?>
			</tbody>
			<br>
		</table>
	</div>
</div>
