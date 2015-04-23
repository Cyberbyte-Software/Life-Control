<?php
require_once("config/config.php");
require_once("classes/Login.php");

$login = new Login();
$page = "views/medics.php";

if ($login->isUserLoggedIn() == true) {
    include("views/template.php");
} else {
    include("views/not_logged_in.php");
}
