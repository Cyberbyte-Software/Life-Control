<?php

require_once("config/config.php");
require_once("classes/Login.php");

$login = new Login();

if ($login->isUserLoggedIn() == true) {
    include("views/action/editSAction.php");
} else {
    include("views/login.php");
}
