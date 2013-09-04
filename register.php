<?php
require_once "/inc/config.php";
require_once DB_PATH;

//Display the header
$pageTitle = "Register";
include( HEADER_PATH );
session_start();

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%		                                              					        	%
//% 			                FUNCTIONS                                     %
//%							                                                     		%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
function make_registration_form()
{
  $form_html = "";
  $form_html .= '<form name = "input" action="'.BASE_URL.'register.php" 
    method="post">';
  $form_html .= '<table>';

  //Email Address
  $form_html .= '<tr>';
  $form_html .= '<td><th><label for="email">Email Address:</th></td>';
  $form_html .= '<td><input type="text" name="email" id="email" 
    size="50"></td>';
  $form_html .= '</tr>';

  //Password
  $form_html .= '<tr>';
  $form_html .= '<td><th><label for="password">Password:</th></td>';
  $form_html .= '<td><input type="text" name="password" id="password" 
    size="50"></td>';
  $form_html .= '</tr>';

  //Password Confirmation
  $form_html .= '<tr>';
  $form_html .= '<td><th><label for="password">Confirm 
    Password:</th></td>';
  $form_html .= '<td><input type="text" name="password_conf" 
    id="password_conf" size="50"></td>';
  $form_html .= '</tr>';

  $form_html .= '</table>';
  $form_html .= '<input type="submit" value="Register">';
  $form_html .= '</form>';


  return $form_html;
}


//validates that the email has the proper form (i.e. - xxxxxxx@xxxx.com, 
//etc.)
function validate_email_syntax( $email, $error_msgs )
{
  if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) )
  {
    $error_msgs['email_syntax'] = 'Your email address is not valid, please 
      enter a valid email address';
  }

  return $error_msgs;
}


//makes sure that no other email address exists that shares the one passed
function validate_email_uniqueness( $email, $error_msgs )
{
  $db = new Database_handler();

  $matches = $db->query_table('SELECT name FROM t_users WHERE name 
    = "'.$email.'"');

  if( $matches )
  {
    $error_msgs['email_uniqueness'] = 'An email already exists with that 
      name, please check that you have not already registered.';
  }


  return $error_msgs;
}


//makes sure that the password matches the syntax required by the website 
//(i.e., number of characters, etc.)
function validate_password_syntax( $password, $error_msgs )
{
  if( strlen( $password ) < 5 )
  {
    $error_msgs['password_syntax'] = 'Please choose a password that is 
      greater than 5 characters';
  }
  return $error_msgs;
}


//makes sure that the two passed passwords match eachother
function validate_password_match( $pass1, $pass2, $error_msgs )
{
  if( $pass1 != $pass2 )
  {
    $error_msgs['password_match'] = 'Passwords do not match, please enter 
      and confirm your password again.';
  }

  return $error_msgs;
}


//save the user and their password into the database
function save_user( $email, $password )
{

}
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%		                                              					        	%
//% 			                    MAIN CODE                                 %
//%							                                                     		%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if( $_SERVER['REQUEST_METHOD'] == 'GET' )
{
  if( !isset($_GET['status']) )
  {
    $body_html = make_registration_form();
    echo $body_html;
  }
}

else if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
  extract($_POST);
  $error_msgs = array();
  $error_msgs = validate_email_syntax( $email, $error_msgs );
  $error_msgs = validate_email_uniqueness( $email, $error_msgs );
  $error_msgs = validate_password_syntax( $password, $error_msgs );
  $error_msgs = validate_password_match( $password, $password_conf, 
    $error_msgs );

  echo '<pre>'; var_dump($error_msgs); echo '</pre>'; die(); //DEBUG

  if( sizeof($error_msgs) == 0 )
  {
    //TODO: make the password safe
    save_user( $email, $password );
  }
}


include( FOOTER_PATH ); 
