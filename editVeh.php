<?php

require_once("config/db.php");
require_once("classes/Login.php");

$login = new Login();

if ($login->isUserLoggedIn() == true) {
    if($_SESSION['user_level'] < P_EDIT_VEHICLES) $page = "views/errors/noPerm.php"; else $page = "views/editVeh.php";
    include("views/template.php");
} else {
    include("views/not_logged_in.php");
}
