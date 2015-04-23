<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["wantedID"]))
	{
		//vehOwner vehClass vehSide vehType vehPlate vehAlive vehAct vehCol vehInv
		$wantedID   = $_POST["wantedID"];
		$wantedName = $_POST["wantedName"];
		$wantedCrimes = $_POST["wantedCrimes"];
		$wantedBounty = $_POST["wantedBounty"];
		$active = $_POST["active"];
	}
	else
	{
		echo "<center><h1 style='color:red'>wantedID NOT SET</h1></center>";
	}
	
	// change character set to utf8 and check it
	if (!$db_connection->set_charset("utf8")) {
		$db_connection->errors[] = $db_connection->error;
	}
	
	if (!$db_connection->connect_errno) 
	{
		if (isset($_POST['drop'])) 
		{
			$sql = "DELETE FROM `wanted` WHERE `wanted`.`wantedID` = '".$wantedID."'";
		} 
		else 
		{
			$sql = "UPDATE `wanted` SET `active` = '".$active."', `wantedName` = '".$wantedName."', `wantedBounty` = '".$wantedBounty."', `wantedCrimes` = '".$wantedCrimes."' WHERE `wanted`.`wantedID` = '".$wantedID."'";
		}		

		$result_of_query = $db_connection->query($sql);
	}
	else 
	{
		$this->errors[] = "Database connection problem.";
	}

	header('Location: index.php');
?>
