<?php
include("config/lang/module.php");

function carType($car,$lang){
	switch ($car)
	{
		case 'Car':
			return $lang['car'];
			break;
		case 'Air':
			return $lang['air'];
			break;
		case 'Ship':
			return $lang['ship'];
			break;
	}
}

function yesNo($input,$lang){
    if($input == 1) return $lang['yes'];
    else if ($input == 0) return $lang['no'];
    else return $lang['error'];
}

function select($val,$row){
    if($row == $val) return 'selected';
}

function iconName($icon){
    if ($icon == 2) return icon2;
    elseif ($icon == 3) return icon3;
    elseif ($icon == 4) return icon4;
    elseif ($icon == 5) return icon5;
    elseif ($icon == 6) return icon6;
    else return icon1;
}

function nameID($pID){
    $db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$db_connection->set_charset("utf8")) {
        $db_connection->errors[] = $db_connection->error;
    }

    $update = "SELECT * FROM `players` WHERE `playerid` = '" . $pID . "' ";
    $result_of_query = $db_connection->query($update);

    while ($row = mysqli_fetch_assoc($result_of_query)) {
        return $row['name'];
    }
}
?>