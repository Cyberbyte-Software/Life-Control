<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["hID"]))
	{
		$hID   = $_POST["hID"];
		$hOwn = $_POST["hOwn"];
		$hPos = $_POST["hPos"];
		$hOwned = $_POST["hOwned"];
		$hCont = $_POST["hCont"];
		$hInv = $_POST["hInv"];
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
			$sql = "DELETE FROM `houses` WHERE `houses`.`id` = '".$hID."'";
		} 
		else 
		{
			$sql = "UPDATE `houses` SET `pid`='".$hOwn."',`pos`='".$hPos."',`owned`='".$hOwned."',`inventory`='".$hInv."',`containers`='".$hCont."' WHERE `houses`.`id` = '".$hID."'";
		}		

		$result_of_query = $db_connection->query($sql);

	}
	else 
	{
		$this->errors[] = "Database connection problem.";
	}
	
	header('Location: index.php');	
?>