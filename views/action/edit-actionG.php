<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["gID"]))
	{
		$gID   = $_POST["gID"];
		$gname = $_POST["gname"];
		$gowner = $_POST["gowner"];
		$gMM = $_POST["gMM"];
		$gbank = $_POST["gbank"];
		$gAct = $_POST["gAct"];
		$gMem = $_POST["gMem"];
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
			$sql = "DELETE FROM `gangs` WHERE `gangs`.`id` = '".$gID."'";
		} 
		else 
		{
			$sql = "UPDATE `gangs` SET `owner`='".$gowner."',`name`='".$gname."',`members`='".$gMem."',`maxmembers`='".$gMM."',`bank`='".$gbank."',`active`='".$gAct."' WHERE `gangs`.`id` = '".$gID."'";
		}
	
		$result_of_query = $db_connection->query($sql);


	}
	else 
	{
		$this->errors[] = "Database connection problem.";
	}	
	
	header('Location: index.php');
?>