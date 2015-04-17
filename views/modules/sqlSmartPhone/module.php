<?php
	if ($_SESSION['user_level'] >= 2)
	{
?>
	<div class='panel panel-default'>
		<div class='panel-heading'>
			<h3 class='panel-title'><i class='fa fa-envelope-o fa-fw'></i><?php echo " ".$lang['message'];?></h3>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th><?php echo $lang['from'];?></th>
							<th><?php echo $lang['to'];?></th>
							<th><?php echo $lang['message'];?></th>
							<th><?php echo $lang['time'];?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = 'SELECT * FROM `messages` WHERE `fromID` = "'.$pID.'" OR `toID` = "'.$pID.'" ORDER BY `time` DESC LIMIT 10';
						$result_of_query = $db_connection->query($sql);
						while($row = mysqli_fetch_assoc($result_of_query)) 
						{
							echo "<tr>";
							echo "<td>".$row["fromName"]."</td>";
							echo "<td>".$row["toName"]."</td>";							
							echo "<td>".$row["message"]."</td>";
							echo "<td>".$row["time"]."</td>";
							echo "</tr>";
						};
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php
	}
?>