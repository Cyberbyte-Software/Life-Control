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
define("results_per_page", 10 );

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
	array("Altis Life","3103", "37.187.154.23"),
	array("KOTH","2503", "188.165.255.190")
);

/**
 * Levels
 */
define("lvlcop", 7);
define("lvlmed", 5);
define("lvladmin", 5);
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
define("P_VIEW_VEHICLES", 2);
define("P_VIEW_HOUSES", 2);
define("P_VIEW_GANGS", 2);
define("P_VIEW_WANTED", 2);
define("P_VIEW_PLAYER", 1);
define("P_VIEW_LICENCES", 1);

define("P_EDIT_STAFF", 3);
define("P_EDIT_VEHICLES", 3);
define("P_EDIT_HOUSES", 3);
define("P_EDIT_GANGS", 3);
define("P_EDIT_WANTED", 3);
define("P_EDIT_ADMINS", 3);
define("P_EDIT_PLAYER", 2);
define("P_EDIT_PLAYER_INV", 2);
define("P_EDIT_PLAYER_LICENCES", 2);

define("P_ACCESS_SQL_PHONE", 2);
define("P_ADD_NOTE", 2);

/**
*	DO NOT EDIT BELOW THIS LINE
*/
$playerSkins = array (
	'U_B_CombatUniform_mcam',
	'U_B_CombatUniform_mcam_tshirt',
	'U_B_CombatUniform_mcam_vest',
	'U_B_GhillieSuit',
	'U_B_HeliPilotCoveralls',
	'U_B_Wetsuit',
	'U_O_CombatUniform_ocamo',
	'U_O_GhillieSuit',
	'U_O_PilotCoveralls',
	'U_O_Wetsuit',
	'U_C_Poloshirt_blue',
	'U_C_Poloshirt_burgundy',
	'U_C_Poloshirt_stripped',
	'U_C_Poloshirt_tricolour',
	'U_C_Poloshirt_salmon',
	'U_C_Poloshirt_redwhite',
	'U_C_Commoner1_1',
	'U_C_Commoner1_2',
	'U_C_Commoner1_3',
	'U_Rangemaster',
	'U_OrestesBody',
	'U_NikosBody',
	'U_BasicBody',
	'U_B_CombatUniform_mcam_worn',
	'U_B_SpecopsUniform_sgg',
	'U_B_PilotCoveralls',
	'U_O_CombatUniform_oucamo',
	'U_O_SpecopsUniform_ocamo',
	'U_O_SpecopsUniform_blk',
	'U_O_OfficerUniform_ocamo',
	'U_I_CombatUniform',
	'U_I_CombatUniform_tshirt',
	'U_I_CombatUniform_shortsleeve',
	'U_I_pilotCoveralls',
	'U_I_HeliPilotCoveralls',
	'U_I_GhillieSuit',
	'U_I_OfficerUniform',
	'U_I_Wetsuit',
	'U_Competitor',
	'U_MillerBody',
	'U_KerryBody',
	'U_IG_Guerilla1_1',
	'U_IG_Guerilla2_1',
	'U_IG_Guerilla2_2',
	'U_IG_Guerilla2_3',
	'U_IG_Guerilla3_1',
	'U_IG_Guerilla3_2',
	'U_IG_leader',
	'U_BG_Guerilla1_1',
	'U_BG_Guerilla2_1',
	'U_BG_Guerilla2_2',
	'U_BG_Guerilla2_3',
	'U_BG_Guerilla3_1',
	'U_BG_Guerilla3_2',
	'U_BG_leader',
	'U_OG_Guerilla1_1',
	'U_OG_Guerilla2_1',
	'U_OG_Guerilla2_2',
	'U_OG_Guerilla2_3',
	'U_OG_Guerilla3_1',
	'U_OG_Guerilla3_2',
	'U_OG_leader',
	'U_C_Poor_1',
	'U_C_Poor_2',
	'U_C_WorkerCoveralls',
	'U_C_HunterBody_grn',
	'U_C_Poor_shorts_1',
	'U_C_Commoner_shorts',
	'U_C_ShirtSurfer_shorts',
	'U_C_TeeSurfer_shorts_1',
	'U_C_TeeSurfer_shorts_2',
	'U_B_CTRG_1',
	'U_B_CTRG_2',
	'U_B_CTRG_3',
	'U_B_survival_uniform',
	'U_I_G_Story_Protagonist_F',
	'U_I_G_resistanceLeader_F',
	'U_C_Journalist',
	'U_C_Scientist',
	'U_NikosAgedBody'
);

