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
define("DB_USER", "arma3life");
define("DB_PASS", "1237");
define("results_per_page", 10 );

/**
	Make altis_life_4 True to be able to access the wanted section
*/
define("alits_life_4", true);

/**
	Modules: Here you can enable any modules for the system that have been made to
			 support people who use things like SQL Smart Phone
*/
define("sql_smartPhone",true);


/**
	Change These To Reflect The Connection Info Of Your Game Server.
	This Allows the current players function to work.
	!! Make sure to add +1 to the server port, ARMA 3 implementation violates Source query protocol spec. !!

**/
define( 'enable_game_query', false);
define( 'SQ_SERVER_ADDR'   , '127.0.0.1' );
define( 'SQ_SERVER_PORT'   , 3103 );