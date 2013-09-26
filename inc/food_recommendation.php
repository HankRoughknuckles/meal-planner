<?php
/*
 *	This page is responsible for taking in a get request containing a 
 *	food name, searching for any matching foods that are saved in the
 *	user's pantry, and returning those results.
 */

session_start();
if( $_GET['ajax_output'] )
{
	$ajax_output = $_GET['ajax_output'];
	$saved_foods = $_SESSION['saved_foods'];

  //$matched_results is the list of saved foods that match the name typed 
  //by the user
	$matched_results = array(); 


	foreach( $saved_foods as $saved_food )
	{
	  if (stristr( $saved_food['user_def_food_name'], $ajax_output ) )
	  {
		  $matched_results[] = array( 
		    'category'  => 'Your Saved Foods:',
		    'label'     => $saved_food['user_def_food_name'],
		    'food_id'   => $saved_food['id']
		    //'units' => /*TODO: Add units based on what food it is*/
		  );
	  }
	}
  
	echo json_encode( $matched_results );
}
?>
