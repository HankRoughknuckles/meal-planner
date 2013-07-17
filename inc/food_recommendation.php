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
        //TESTING
	//using PDO prepared statements for SQL query
	//$conn = new PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, SQL_USERNM, SQL_PSWD );
//
	//$sql = 'SELECT * FROM t_foods WHERE user_id = ?';
//
	////the param to go into the ? in the $sql variable
	//$params = array( $_SESSION[ 'user_id' ] );
//
	////prepare the sql statement
	//$query = $conn->prepare( $sql ); 
	//if( !$query )
	//{
		//echo 'Query preparation failed! - (' . $query->errno . ') ' . $query->error;
	//}
//
	////crank the parameters into the statement and execute
	//$result = $query->execute( $params ); 
	//if( !$result )
	//{
		//echo 'Query execution failed! - (' . $result->errno . ') ' . $result->error;
	//}
//
	//$_SESSION['saved_foods'] = $query->fetchAll( PDO::FETCH_ASSOC ); //this will be used in food_recommendation.php to reduce the number of SQL queries
	//$conn = null; //close the connection by setting it to null
        //END TEST
        
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

	echo json_encode( $matched_results );
}
?>
