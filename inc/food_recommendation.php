<?php
/*
*	This page is responsible for taking in a get request containing a 
*	food name, searching for any matching foods that are saved in the
*	user's pantry, and returning those results.
*/

//TODO: make this always query the SQL database for matched foods

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
		if( 1 == 1 ) //stristr( $saved_food['user_def_food_name'], $user_input ) )
		{
			$matched_results[] = array( 
					'category' => 'Your Saved Foods:',
					'food_name' => $saved_food['user_def_food_name']
					//'units' => /*TODO: Add units based on what food it is*/
			);
		}
	}

	echo json_encode( $matched_results );
}
?>
