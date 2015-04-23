<?php
require_once("config/db.php");
require_once("classes/Login.php");

$login = new Login();
$page = "views/curPlayers.php";

if ($login->isUserLoggedIn() == true) {
    include("views/template.php");

} else {
    include("views/not_logged_in.php");
}
