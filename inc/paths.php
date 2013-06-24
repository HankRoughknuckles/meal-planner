<?php

define("BASE_URL",		"/");
define("ROOT_PATH",		$_SERVER["DOCUMENT_ROOT"] . "/");

//the path to the file that contains the header that goes at the top of every file
define("HEADER_PATH", 	BASE_URL . "inc/header.php");


//the path to the file that contains the footer that goes at the bottom of every file
define("FOOTER_PATH", 	BASE_URL . "inc/footer.php");


//the path to the file that contains sensitive login information and api keys
define("LOGIN_PATH",	BASE_URL . "inc/sensitive/login.php"); 


//file that contains nutritionix database functionality
define("NUTRITIONIX_PATH", 	BASE_URL . "inc/nutritionix.php");

