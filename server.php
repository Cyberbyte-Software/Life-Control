<?php

require_once("config/db.php");
require_once("classes/Login.php");

$login = new Login();

if ($login->isUserLoggedIn() == true) {
    if($_SESSION['user_level'] < 2) $page = "views/errors/noPerm.php"; else $page = "views/server.php";
    include("views/template.php");
} else {
    include("views/login.php");
}