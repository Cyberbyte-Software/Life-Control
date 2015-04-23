<?php //include("config/lang/module.php");

	if(isset($_SESSION['steamid']))
	{
		include("views/modules/playerView/dashboard.php");
	}
	else
	{
		include("views/modules/playerView/login.php");
	}
?>
