<?php
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%
//%			         PATHS
//%				
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
define("BASE_URL",		"/");


define("ROOT_PATH",		$_SERVER["DOCUMENT_ROOT"]."/");


//the path of the folder that contains all the include files
define("INCLUDE_PATH", 	ROOT_PATH."inc/");
define("INCLUDE_PATH_BASE", 	BASE_URL."inc/");


//LIB_PATH          =   base directory where libraries are stored
//DB_PATH           =   database function library
//ESHA_PATH         =   esha query library
//UNITS_TABLE_PATH  =   esha units conversion library
define("LIB_PATH", 	        INCLUDE_PATH_BASE."lib/");
define("DB_PATH", 	        LIB_PATH."database.php");
define("ESHA_PATH", 	    LIB_PATH."esha.php"); 
define("UNITS_TABLE_PATH", 	LIB_PATH."units_table.php");


//the path to the file that contains the header that goes at the top of 
//every file
define("HEADER_PATH", 	INCLUDE_PATH."header.php");


//the path to the file that contains the footer that goes at the bottom of 
//every file
define("FOOTER_PATH", 	INCLUDE_PATH."footer.php");


//the path to the file that contains sensitive login information and api 
//keys
define("LOGIN_PATH",	INCLUDE_PATH."sensitive/login.php"); 



//path to the file that holds the nutrients lookup table for esha nutrient 
//ID's
define("NUTRIENTS_TABLE_PATH", 	INCLUDE_PATH."nutrients_table.php"); 

//path to the default style sheet
define("STYLE_PATH", 	BASE_URL."css/style.css");


//path to the jQuery UI source code
define("JQUERY_UI_PATH", 	BASE_URL."js/jquery-ui-1.10.3.custom.min.js");


//path to the jQuery UI style sheet
define("JQUERY_UI_STYLE_PATH", 	BASE_URL . 
    "css/smoothness/jquery-ui-1.10.3.custom.css");


//path to Recipe stuff
define("RECIPE_PATH", 	BASE_URL );



//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%									
//%				DATABASE INFORMATION
//%					
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

//the name of the mySQL database
define("DB_NAME", 	"meal_planner");

define("DB_HOST",	"localhost");



//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%									
//%				ERROR CODES
//%					
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

define("ERR_NAME_EXISTS",	"5");
