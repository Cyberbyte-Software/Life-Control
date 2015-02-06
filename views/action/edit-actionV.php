<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["vehID"]))
	{
		//vehOwner vehClass vehSide vehType vehPlate vehAlive vehAct vehCol vehInv
		$vehID   = $_POST["vehID"];
		$vehOwner = $_POST["vehOwner"];
		$vehClass = $_POST["vehClass"];
		$vehSide = $_POST["vehSide"];
		$vehType = $_POST["vehType"];
		$vehPlate = $_POST["vehPlate"];
		$vehAlive = $_POST["vehAlive"];
		$vehAct = $_POST["vehAct"];
		$vehCol = $_POST["vehCol"];
		$vehInv = $_POST["vehInv"];
	}
	else
	{
		echo "<center><h1 style='color:red'>PLAYERID NOT SET</h1></center>";
	}
	
	// change character set to utf8 and check it
	if (!$db_connection->set_charset("utf8")) {
		$db_connection->errors[] = $db_connection->error;
	}
	
	if (!$db_connection->connect_errno) 
	{
		if (isset($_POST['drop'])) 
		{
			$sql = "DELETE FROM `vehicles` WHERE `vehicles`.`id` = '".$vehID."'";
		} 
		else 
		{
			$sql = "UPDATE `vehicles` SET `side`='".$vehSide."',`classname`='".$vehClass."',`type`='".$vehType."',`alive`='".$vehAlive."',`active`='".$vehAct."',`plate`='".$vehPlate."',`color`='".$vehCol."',`inventory`='".$vehInv."' WHERE `vehicles`.`id` = '".$vehID."'";
		}		

		$result_of_query = $db_connection->query($sql);
	}
	else 
	{
		$this->errors[] = "Database connection problem.";
	}

	header('Location: index.php');
?>
