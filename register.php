<?php
require_once("/inc/config.php");

//Display the header
$pageTitle = "Register";
include( HEADER_PATH );

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


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%		                                              					        	%
//% 			                    MAIN CODE                                 %
//%							                                                     		%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if( $_SERVER['REQUEST_METHOD'] == 'GET' & !isset($_GET['status']) )
{
  $body_html = "";
  $body_html .= make_registration_form();
  echo $body_html;
}
include( FOOTER_PATH ); 
