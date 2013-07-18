<?php
session_start();
/*
*	This page is responsible for taking in a get request containing a 
*	food name, searching for any matching foods that are saved in the
*	user's pantry, and returning those results.
*/
	$user_input = $_GET['user_input'];
	$saved_foods = $_SESSION['saved_foods'];

	$matched_results = array(); //the saved foods that match the name typed by the user
	

	foreach( $saved_foods as $saved_food )
	{
	    if (stristr( $saved_food['user_def_food_name'], $user_input ) )
	    {
		$matched_results[] = array( 
		    'category' => 'Your Saved Foods:',
		    'label' => $saved_food['user_def_food_name']
		    //'units' => /*TODO: Add units based on what food it is*/
		);
	    }
	}

	//echo json_encode( $matched_results );
	echo json_encode( $saved_foods ); //DEBUG
}
?>
