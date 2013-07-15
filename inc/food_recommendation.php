<?php
/*
*	This page is responsible for taking in a get request containing a 
*	food name, searching for any matching foods that are saved in the
*	user's pantry, and returning those results.
*/

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . "/inc/config.php";
require_once LOGIN_PATH;

//echo json_encode( array('message' => $_GET['user_input'] . 'from php' ) ); //DEBUG

//return a result if >=2 characters have been entered
if( $_GET['user_input'] )
{
	$user_input = $_GET['user_input'];
	$saved_foods = $_SESSION['saved_foods'];

	$matched_results = array(); //the saved foods that match the name typed by the user
	

	foreach( $saved_foods as $saved_food )
	{
		if( stristr( $saved_food['user_def_food_name'], $user_input ) )
		{
			$matched_results[] = array( 'label' => $saved_food['user_def_food_name'], 'category' => 'Your Saved Foods:' );
		}
	}
	echo json_encode( $matched_results );
}
?>
