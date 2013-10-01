<?php
//This library is responsible for holding the functions related to form 
//validation

//TODO: consider making this an object that will hold the error messages 
//and will contain all the functions for validating forms

//Display the errors contained in the $errors array on screen
function display_errors( $errors )
{
  $error_html = '';
  foreach( $errors as $error )
  {
    $error_html .= '<p class="text-error">'.$error.'</p>';
  }

  return $error_html;
}


