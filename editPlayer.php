<?php

require_once("config/config.php");
require_once("classes/Login.php");

$login = new Login();
$page = "views/editPlayer.php";

if ($login->isUserLoggedIn() == true) {
    if($_SESSION['user_level'] < P_EDIT_PLAYER) $page = "views/Errors/noPerm.php"; else $page = "views/editPlayer.php";
    include("views/template.php");
} else {
    include("views/login.php");
}
