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
            <?php echo $lang['staff']; ?>
            <small><?php echo " " . $lang['overview']; ?></small>
        </h1>
</div>
<!-- /.row -->
<div class="col-md-12">
	<div class="content-panel">
		<table class="table table-striped table-advance table-hover">
			<h4>
				<i class="fa fa-cogs fa-fw"></i>
				<?php echo " " . $lang['staff']; ?>
				<div class="col-lg-4 pull-right">
					<form style="float:right;" method='post' action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
						  name='searchPlayer'>
						<input id='searchText' type='text' name='searchText'>
						<input class='btn btn-sm btn-primary' type='submit' name='edit'
							   value='<?php echo " " . $lang['search']; ?>'>
					</form>
				</div>
			</h4>
			<hr>
			<thead>
				<tr>
					<th><i class="fa fa-user"><?php echo  " " . $lang['staffName']; ?></th>
					<th><i class="fa fa-user"><?php echo  " " . $lang['emailAdd']; ?></th>
					<th><i class="fa fa-user"><?php echo  " " . $lang['rank']; ?></th>
					<th><i class="fa fa-eye"><?php echo  " " . $lang['playerID']; ?></th>
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
					$sql = "SELECT * FROM `users` WHERE `user_name` LIKE '%" . $searchText . "%' " . $max . " ;";
				} else {
					$sql = "SELECT * FROM `users` " . $max . ";";
				}

				$result_of_query = $db_connection->query($sql);
				while ($row = mysqli_fetch_assoc($result_of_query)) {
					$userID = $row["user_id"];
					echo "<tr>";
					echo "<td>" . $row["user_name"] . "</td>";
					echo "<td>" . $row["user_email"] . "</td>";
					echo "<td>" . $row["user_level"] . "</td>";
					echo "<td>" . $row["playerid"] . "</td>";
                    echo "<td><a class='btn btn-primary btn-xs' href='editStaff.php?ID=".$row["user_id"]."'>";
                    echo "<i class='fa fa-pencil'></i></a></td>";
					echo "</tr>";
				};
				echo "</tbody></table>";

				$sql = "SELECT * FROM `users`;";
				$result_of_query = $db_connection->query($sql);
				$total_records  = mysqli_num_rows($result_of_query); 
				$total_pages = ceil($total_records / $page_rows);
				echo "<center><a class='btn btn-primary' href='staff.php?page=1'>" .'First Page'."</a> ";
?>
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
						<?php echo $lang['page'] . " " ?><span class="caret"></span>
					</button>
					<ul class="dropdown-menu scrollable-menu" role="menu">
					<?php 
						for ($i=1; $i<=$total_pages; $i++) {
					?>
							<li><?php echo "<a href='staff.php?page=".$i."'>".$i."</a> "; ?></li>
				  <?php }; ?>
					</ul>
				</div>
				
				<?php
				echo "<a class='btn btn-primary' href='staff.php?page=$total_pages'>" .'Last Page'."</a></center>";
			} else {
				$this->errors[] = "Database connection problem.";
			}
			?>
			</tbody>
			<br>
		</table>
	</div>
</div>