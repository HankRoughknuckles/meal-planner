<?php

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																			%
//%									PATHS									%
//%																			%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
define("BASE_URL",		"/");

define("ROOT_PATH",		$_SERVER["DOCUMENT_ROOT"] . "/");

//the path of the folder that contains all the include files
define("INCLUDE_PATH", 	BASE_URL . "inc/");


//the path to the file that contains the header that goes at the top of every file
define("HEADER_PATH", 	INCLUDE_PATH . "header.php");


//the path to the file that contains the footer that goes at the bottom of every file
define("FOOTER_PATH", 	INCLUDE_PATH . "footer.php");


//the path to the file that contains sensitive login information and api keys
define("LOGIN_PATH",	INCLUDE_PATH . "sensitive/login.php"); 


//file that contains nutritionix database functionality
define("NUTRITIONIX_PATH", 	INCLUDE_PATH . "nutritionix.php");


//path to the file that holds the nutrients lookup table for esha nutrient ID's
define("NUTRIENTS_TABLE_PATH", 	INCLUDE_PATH . "nutrients_table.php");


//path to the file that holds the units lookup table for esha unit ID's
define("UNITS_TABLE_PATH", 	INCLUDE_PATH . "units_table.php");



//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																			%
//%							DATABASE INFORMATION							%
//%																			%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

//the name of the mySQL database
define("DB_NAME", 	"meal_planner");

define("DB_HOST",	"localhost");
