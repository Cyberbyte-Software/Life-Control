<?php //include("config/lang/module.php");

	if(isset($_SESSION['steamid']))
	{
		include("views/modules/playerView/logged_in.php");	
	}
	else
	{
		include("views/modules/playerView/not_logged_in.php");	
	}
?>
