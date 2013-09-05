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
define("ESHA_PATH", 	      LIB_PATH."esha.php"); 
define("UNITS_TABLE_PATH", 	LIB_PATH."units_table.php");


//the path to the file that contains the header that goes at the top of 
//every file
define("HEADER_PATH", 	INCLUDE_PATH."header.php");


//the path to the file that contains the footer that goes at the bottom of 
//every file
define("FOOTER_PATH", 	INCLUDE_PATH."footer.php");


//the path to the file that contains sensitive login information and api 
//keys
//TODO: Change this name to something that is not so similar to 
//SIGN_IN_PATH
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

//path to sign-in page
define('SIGN_IN_PATH',  BASE_URL.'sign_in.php');

//path to account registration page
define('REGISTER_PATH',  BASE_URL.'register.php');

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%									
//%				DATABASE INFORMATION
//%					
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

//the name of the mySQL database
define("DB_NAME", 	"meal_planner");

define("DB_HOST",	"localhost");

//TODO: delete this when you implement user accounts
define("USER_ID",	        "-1");
define("NOT_LOGGED_IN", 	"-2");


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%									
//%				ERROR CODES
//%					
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

//Define the error codes
define( 'SUCCESS'	,    	     '1' );
define( 'PREP_FAIL'	,    	    '-1' );
define( 'EXEC_FAIL'	,    	    '-2' );
define( 'ERR_NAME_EXISTS',	    '-3' );
define( 'INSUFFICIENT_DATA',    '-4' );
