<?php

/**
 * A simple, clean and secure PHP Login Script / MINIMAL VERSION
 * For more versions (one-file, advanced, framework-like) visit http://www.php-login.net
 *
 * Uses PHP SESSIONS, modern password-hashing and salting and gives the basic functions a proper login system needs.
 *
 * @author Panique
 * @link https://github.com/panique/php-login-minimal/
 * @license http://opensource.org/licenses/MIT MIT License
 */

// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once("config/config.php");

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();
// includes page in template
$page = "views/dashboard.php";

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    include("views/template.php");

} else {
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $result = mysqli_query($link,"SHOW TABLES LIKE 'users'");
    $table_query = mysqli_num_rows($result);
    mysqli_close($link);

    if (!$table_query) {
        include("firstTime.php");
    } else {
        $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $result = mysqli_query($link, "SHOW COLUMNS FROM `users` LIKE 'user_profile';");
        $table_query = mysqli_num_rows($result);
        mysqli_close($link);
        if (!$table_query) {
            include("update.php");
        } else {
			if (playerView)
			{
				include("views/modules/playerView/playerView.php");
			}
			else 
			{
				include("views/login.php");
			}
        }
    }
}
