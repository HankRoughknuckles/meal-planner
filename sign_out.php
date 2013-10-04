<?php
require_once("/inc/config.php");
require_once HELPERS_PATH;

display_page_header("Sign Out");

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%
//% 			                    MAIN CODE
//%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if( !isset($_GET['status']) )
{
  $body_html = '';
  $body_html .= '<p>Are you sure you want to log out?</p>';
  $body_html .= '<a href="'.SIGN_OUT_PATH.'?status=signed-out">Sign 
    out for real!</a><br />';
  $body_html .= '<a href="'.BASE_URL.'">Go back</a>';
  echo $body_html;
}


else
{
  $_SESSION['user_id'] = NOT_LOGGED_IN;
  header( "Location: " . BASE_URL . "index.php" );
}

include( FOOTER_PATH ); 
