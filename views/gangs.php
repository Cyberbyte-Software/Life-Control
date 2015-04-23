<?php
// create a database connection, using the constants from config/config.php (which we loaded in index.php)
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
            <?php echo $lang['gangs']; ?>
            <small><?php echo " " . $lang['overview']; ?></small>
        </h1>
    </div>
</div>
<!-- /.row -->

<div class="col-md-12">
	<div class="content-panel">
		<table class="table table-striped table-advance table-hover">
			<h4>
				<i class="fa fa-sitemap fa-fw"></i>
				<?php echo " " . $lang['gangs']; ?>
				<div class="col-lg-4 pull-right">
					<form style="float:right;" method='post' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
						  name='searchPlayer'>
						<input id='searchText' type='text' name='searchText'>
						<input class='btn btn-sm btn-primary' type='submit' name='pid'
							   value='<?php echo $lang['search'] . " " . $lang['PID']; ?>'>
						<input class='btn btn-sm btn-primary' type='submit' name='name'
							   value='<?php echo $lang['search'] . " " . $lang['name']; ?>'>
					</form>
				</div>
			</h4>
			<hr>
			<thead>
				<tr>
					<th><i class="fa fa-eye"><?php echo " " .$lang['id']; ?></th>
					<th><i class="fa fa-user"><?php echo " " .$lang['gang'] . " " . $lang['name']; ?></th>
					<th><i class="fa fa-user"><?php echo " " .$lang['owner']; ?></th>
					<th><i class="fa fa-bank"><?php echo " " .$lang['bank']; ?></th>
					<th><i class="fa fa-user"><?php echo " " .$lang['maxMembers']; ?></th>
					<th><i class="fa fa-user"><?php echo " " .$lang['active']; ?></th>
					<th><i class="fa fa-pencil"><?php echo " " . $lang['edit']; ?></th>
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
						$sql = "SELECT * FROM `gangs` WHERE `owner` LIKE " . $searchText . $max . " ;";
					} else {
						$sql = "SELECT * FROM `gangs` WHERE `name` LIKE " . $searchText . $max . " ;";
					}
				} else {
					$sql = "SELECT * FROM `gangs` " . $max . " ;";
				}
				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) {
					echo "<tr>";
					echo "<td>" . $row["id"] . "</td>";
					echo "<td>" . $row["name"] . "</td>";
					echo "<td>" . nameID($row["owner"]) . "</td>";
					echo "<td>" . $row["bank"] . "</td>";
					echo "<td>" . $row["maxmembers"] . "</td>";
					echo "<td>" . yesNo($row["active"],$lang) . "</td>";
					echo "<td><a class='btn btn-primary btn-xs' href='editGang.php?ID=".$row["id"]."'>";
					echo "<i class='fa fa-pencil'></i></a></td>";
					echo "</tr>";
				};
				echo "</tbody></table>";

				$sql = "SELECT * FROM `gangs`";
				$result_of_query = $db_connection->query($sql);
				$total_records  = mysqli_num_rows($result_of_query); 
				$total_pages = ceil($total_records / $page_rows);
				echo "<center><a class='btn btn-primary' href='gangs.php?page=1'>".$lang['first']."</a> ";
?>
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						<?php echo $lang['page'] . " " ?><span class="caret"></span>
					</button>
					<ul class="dropdown-menu scrollable-menu" role="menu">
					<?php 
						for ($i=1; $i<=$total_pages; $i++) {
					?>
							<li><?php echo "<a href='gangs.php?page=".$i."'>".$i."</a> "; ?></li>
				  <?php }; ?>
					</ul>
				</div>
				
				<?php			echo "<a class='btn btn-primary' href='gangs.php?page=$total_pages'>".$lang['last']."</a></center>";
			} else {
				$this->errors[] = "Database connection problem.";
			}
			?>
			</tbody>
			<br>
		</table>
	</div>
</div>
