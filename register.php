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
/**
 * make_registration_form()
 * ========================
 * Makes a web form for the user to register on the website.
 * This function will also display any errors as mentioned in the $errors 
 * argument
 */
function make_registration_form( $errors = null, $entered_info = null )
{
  $form_html = "";
  $form_html .= '<form name = "input" action="'.BASE_URL.'register.php" 
    method="post">';
  $form_html .= '<table>';

  //Email Address
  $form_html .= display_form_error( '<tr>', array('email_syntax', 
    'email_uniqueness'), $errors );
  $form_html .= '<td><th><label for="email">Email Address:</th></td>';
  $form_html .= '<td><input type="text" name="email" id="email" 
    size="50"';

  if( isset($entered_info['email']) )
  {
    $form_html .= ' value="'.$entered_info['email'].'"';
  }
  $form_html .= '>';
  $form_html .= '</td>';
  $form_html .= '</tr>';



  //Password
  $form_html .= display_form_error( '<tr>', array('password_syntax', 
    'password_match'), $errors );
  $form_html .= '<td><th><label for="password">Password:</th></td>';
  $form_html .= '<td><input type="text" name="password" id="password" 
    size="50"';

  if( isset($entered_info['password']) )
  {
    $form_html .= ' value="'.$entered_info['password'].'"';
  }
  $form_html .= '>';
  $form_html .= '</td>';
  $form_html .= '</tr>';



  //Password Confirmation
  $form_html .= display_form_error( '<tr>', array('password_syntax', 
    'password_match'), $errors );
  $form_html .= '<td><th><label for="password">Confirm 
    Password:</th></td>';
  $form_html .= '<td><input type="text" name="password_conf" 
    id="password_conf" size="50"';

  if( isset($entered_info['password_conf']) )
  {
    $form_html .= 'value="'.$entered_info['password_conf'].'"';
  }
  $form_html .= '>';
  $form_html .= '</td>';
  $form_html .= '</tr>';



  $form_html .= '</table>';
  $form_html .= '<input type="submit" value="Register">';
  $form_html .= '</form>';

  return $form_html;
}


/**
 * display_form_error()
 * ====================
 * Searches through the $haystack variable (which should be an array).  If 
 * any of the elements in $needles matches the index of any of the 
 * elements in $haystack, then this will return ' class="form-error"' to 
 * show that there is an error in that field
 *
 * @param   - $tag        -the html tag to add the error class too (if 
 *                          errors are indeed present)
 * @param   - $needles    -an array of error message names to match
 * @param   - $haystack   -an array of error messages to check for matches
 *
 *
 * @return -  $tag        -the original passed $tag variable.  it will 
 *                          have ' class="form-error"' included in the 
 *                          tage if any of the errors mentioned in 
 *                          $needles is present in $haystack
 */
function display_form_error( $tag, $needles, $haystack )
{
  $error_is_present = false;

  foreach( $needles as $needle )
  {
    if( isset($haystack[$needle]) ) { 
      $error_is_present = true;
    }
  }

  if( $error_is_present == true )
  {
    $tag = trim( $tag );
    $tag = substr( $tag, 0, -1 );
    $tag .= ' class="form-error">';
  }

  return $tag;
}


/**
 * validate_registration_input()
 * =============================
 *
 * Checks user input from registration form to make sure that all entered 
 * information meets standards
 *
 * @param   - $vars   - an array of 
 */
function validate_registration_input()
{
  extract($_POST);
  $error_msgs = array();
  $error_msgs = validate_email_syntax( $email, $error_msgs );
  $error_msgs = validate_email_uniqueness( $email, $error_msgs );
  $error_msgs = validate_password_syntax( $password, $error_msgs );
  $error_msgs = validate_password_match( $password, $password_conf, 
    $error_msgs );

  return $error_msgs;
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
      greater than 5 characters long.';
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


//Display the errors contained in $errors on screen
function display_errors( $errors )
{
  $error_html = '';
  foreach( $errors as $error )
  {
    $error_html .= '<p class="error_message">'.$error.'</p>';
  }

  return $error_html;
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
  $error_msgs = validate_registration_input();

  if( sizeof($error_msgs) == 0 )
  {
    //TODO: make the password safe
    save_user( $email, $password );
    //TODO: finish this
  }
  else
  {
    $body_html = display_errors( $error_msgs );
    $body_html .= make_registration_form( $error_msgs, $_POST );
  }

  echo $body_html;
}


include( FOOTER_PATH ); 
