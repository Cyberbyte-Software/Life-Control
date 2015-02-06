<?php
	// create a database connection, using the constants from config/db.php (which we loaded in index.php)
	$db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	if (isset($_POST["staffName"]))
	{
		$staffName = $_POST['staffName'];
		$staffEmail = $_POST['staffEmail'];
		$staffPID = $_POST['staffPID'];
		$staffRank = $_POST['staffRank'];
		$uId = $_POST['user_id'];
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
		$sql = "UPDATE `users` SET `user_name`='".$staffName."',`user_email`='".$staffEmail."',`playerid`='".$staffPID."',`user_level`='".$staffRank."' WHERE `user_id` ='".$uId."';";											
		$result_of_query = $db_connection->query($sql);
	}
	else 
	{
		$this->errors[] = "Database connection problem.";
	}

	header('Location: index.php');
?>