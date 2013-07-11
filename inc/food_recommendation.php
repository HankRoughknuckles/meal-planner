<?php
/*
*	This page is responsible for taking in a get request containing a 
*	food name, searching for any matching foods that are saved in the
*	user's pantry, and returning those results.
*/

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/inc/config.php";
require_once LOGIN_PATH;

//return a result if >=2 characters have been entered
if( $_GET['user_input'] and strlen( $_GET['user_input'] ) >= 2 )
{
	$user_input = $_GET['user_input'];
	$saved_foods = $_SESSION['saved_foods'];

	$matched_results = array(); //the saved foods that match the name typed by the user


	foreach( $saved_foods as $saved_food )
	{
		if( strstr( strtolower($saved_food['user_def_food_name']), strtolower($user_input) ) )
		{
			$matched_results[] = $saved_food['user_def_food_name'];
		}
	}
	echo $_GET['callback'] . '(' . json_encode( $matched_results ) . ')';
}

