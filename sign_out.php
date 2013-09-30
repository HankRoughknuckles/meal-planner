<?php
require_once("/inc/config.php");
session_start();

//Display the header
$pageTitle = "Sign Out";
include( HEADER_PATH );

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%
//% 			                    MAIN CODE
//%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if( $_SERVER['REQUEST_METHOD'] == 'GET' )
{
  
  $body_html = '';

  if( $_SESSION['user_id'] !=  NOT_LOGGED_IN )
  {
    $body_html .= '<p>Are you sure you want to log out?</p>';
    $body_html .= '<a href="'.SIGN_OUT_PATH.'?status=signed-out">Sign out 
      for real!</a><br />';
    $body_html .= '<a href="'.BASE_URL.'">Go back</a>';
    echo $body_html;
  }
}

include( FOOTER_PATH ); 
