<?php
/**
 * Configuration for: Database Connection
 *
 * For more information about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 *
 * DB_HOST: database host, usually it's "127.0.0.1" or "localhost", some servers also need port info
 * DB_NAME: name of the database. please note: database and database table are not the same thing
 * DB_USER: user for your database. the user needs to have rights for SELECT, UPDATE, DELETE and INSERT.
 * DB_PASS: the password of the above user
 */
define("DB_HOST", "localhost");
define("DB_NAME", "arma3life");
define("DB_USER", "root");
define("DB_PASS", "");
define("results_per_page", 10);
define("DEV", false);

/**
 * Make altis_life_4 True to be able to access the wanted section
 */
define("alits_life_4", true);


/**
 * Modules: Here you can enable any modules for the system that have been made to
 * support people who use things like SQL Smart Phone
 * If you enable player view please edit the classes/steamauth/steamSettings.php file !
 */
define("playerView", false);
define("sql_smartPhone", true);

/**
 * Change These To Reflect The Connection Info Of Your Game Server.
 * This Allows the current players function to work.
 * !! Make sure to add +1 to the server port, ARMA 3 implementation violates Source query protocol spec. !!
 * Add your servers query details to the array like so:
 * array("Server Name","Port", "IP")
 **/
define("enable_game_query", true);
$gameServers = array(
    array("Altis Life", "3103", "37.187.154.23"),
    array("KOTH", "2503", "188.165.255.190")
);

$navigation_Items = array(
    array("Houses", "houses.php", "fa-fw fa-home","P_VIEW_HOUSES")
);

/**
 * Levels
 */
define("lvlcop", 7);
define("lvlmed", 5);
define("lvladmin", 3);
define("lvldonator", 5);

/**
 * Names add names to the profile images
 */
define("icon1", "Dave");
define("icon2", "Sam");
define("icon3", "Joe");
define("icon4", "Kerry");
define("icon5", "Connie");
define("icon6", "Jess");

/**
 * Permissions
 */
define("staff_levels", 3);

define("P_VIEW_STAFF", 3);
define("P_VIEW_UPDATE", 3);
define("P_VIEW_VEHICLES", 2);
define("P_VIEW_HOUSES", 2);
define("P_VIEW_GANGS", 2);
define("P_VIEW_WANTED", 2);
define("P_VIEW_STEAM", 2);
define("P_VIEW_PLAYER", 1);
define("P_VIEW_LICENCES", 1);

define("P_EDIT_STAFF", 3);
define("P_EDIT_VEHICLES", 3);
define("P_EDIT_HOUSES", 3);
define("P_EDIT_GANGS", 2);
define("P_EDIT_WANTED", 3);
define("P_EDIT_ADMINS", 3);
define("P_EDIT_PLAYER", 1);
define("P_EDIT_PLAYER_INV", 2);
define("P_EDIT_PLAYER_LICENCES", 2);

define("P_ADD_NOTE", 2);
define("P_VIEW_NOTE", 1);

define("P_ACCESS_SQL_PHONE", 2);