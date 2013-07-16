<?php
//This file is responsible for handling database queries and commands

require_once "/inc/config.php";
require_once LOGIN_PATH; 

//Define the error codes
define( 'SUCCESS'	, 	0 );
define( 'PREP_FAIL'	, 	1 );
define( 'EXEC_FAIL'	, 	2 );

/**
 *	open_connection()
 *	================
 *
 *	this function opens the connection using the database host, 
 *	name, and sql username and password specified in LOGIN_PATH
 */
function open_connection(){
	$conn = new PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, SQL_USERNM, SQL_PSWD );
}


/**
 *	insert_row()
 *	================
 *
 * inserts a row into the specified table with data 
 * according to the $params input
 *
 * @param 	-	$table 		-	a string specifying the table name
 *
 * @param 	-	$params 	-	an associative array with keys equal to 
 * 								the column name and values equal to the 
 * 								row value.
 * 								Ex: array( 'serving_size' => 10 )
 *
 * @return 	- SUCCESS 	-	If the command executed successfully
 *
 * 			- PREP_FAIL	-	If the command preparation failed
 *
 * 			- EXEC_FAIL -	If the command execution failed
 */
//TODO: fix this up.  look at the PDO documentation about how to crank in arguments formatted as arrays
function insert_row( $table, $params )
{
	$sql = 'INSERT INTO $table (user_def_food_name, serving_size, serving_units_esha, cost, currency, json_esha, esha_food_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
	
	//the params to go into the ?'s in the $sql variable
	$params = array(
		$user_def_food_name,
		$serving_size,
		$serving_units_esha,
		$cost,
		$currency,
		$json_esha,
		$esha_food_id,
		$user_id
	);
	
	//prepare the sql statement
	$query = $conn->prepare( $sql ); 
	if( !$query )
	{
		echo 'Query preparation failed! - (' . $query->errno . ') ' . $query->error;
	}
	
	//crank the parameters into the statement and execute
	$query = $query->execute( $params ); 
	if( !$query )
	{
		echo 'Query execution failed! - (' . $query->errno . ') ' . $query->error;
	}
}



/**
 *	open_connection()
 *	================
 *
 *	this function opens the connection using the database host, 
 *	name, and sql username and password specified in LOGIN_PATH
 */
function close_connection(){
	$conn = null; //close the connection by setting it to null
}
