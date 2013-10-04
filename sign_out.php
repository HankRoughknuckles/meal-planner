<?php
require_once("/inc/config.php");
require_once HELPERS_PATH;

display_page_header("Sign Out");

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%
//% 			                    MAIN CODE
//%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
$_SESSION['user_id'] = NOT_LOGGED_IN;
$_SESSION['username'] = "";
header( "Location: " . BASE_URL . "index.php" );

