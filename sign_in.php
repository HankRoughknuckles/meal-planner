<?php
require_once("/inc/config.php");
require_once LIB_PATH.'validator.php';

//Display the header
$pageTitle = "Sign in";
include( HEADER_PATH );

echo 'This is sign_in.php!  it will take care of both signing in a user and signing out a user (if he or she is already signed in at the time)';

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%
//% 		      	                FUNCTIONS
//%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
/**
 * make_sign_in_form()
 * ===================
 *
 * Returns the html for the form where the user will enter his or her 
 * login information in order to sign in
 */
function make_sign_in_form()
{
  $form_html = '<form name = "input" action="'.SIGN_IN_PATH.'" 
    method="post">';
  $form_html .= '<table>';

  //Email address
  $form_html .= '<tr>';
  $form_html .= '<td><th><label for="email">Email Address:</th></td>';
  $form_html .= '<td><input type="text" name="email" id="email" 
    size="50"';
  $form_html .= '</tr>';

  //Password
  $form_html .= '<tr>';
  $form_html .= '<td><th><label for="password">Password:</th></td>';
  $form_html .= '<td><input type="password" name="password" id="password" 
    size="50"';
  $form_html .= '</tr>';
  $form_html .= '</table>';
  $form_html .= '<input type="submit" value="Register">';

  return $form_html;
}
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%
//% 			                    MAIN CODE
//%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if( $_SERVER['REQUEST_METHOD'] == 'GET' )
{
  $body_html = '';

  if( $_SESSION['user_id'] ==  NOT_LOGGED_IN )
  {
    $body_html .= make_sign_in_form();
    echo $body_html;
  }
  else
  {
    //TODO: make something that says "are you sure you want to log out?" 
    //with a button that says confirm, or something
  }
}

include( FOOTER_PATH ); 
