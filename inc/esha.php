<?php
/*
 *	This file contians functionality for communicating with the ESHA server.
*/

require_once "/inc/config.php";
require_once LOGIN_PATH;
require_once UNITS_TABLE_PATH;

/**
*	fetch_food_details()
*	=====================
*
*	sends an HTTP POST request to the ESHA servers to retrieve 
*	the nutrient information about the food selected.
*
*	@param 	-	$food_id 	-	the ESHA food ID code. (This value can 
*								usually be retrieved by a GET request to 
*								http://api.esha.com/foods?apikey=[YOUR API KEY]&query=[FOOD TO BE SEARCHED FOR]
*								)
*
*	@param 	-	$qty 		-	the serving size to be searched for.
*
*	@param 	-	$unit 		-	the ESHA id code for the units that $qty will be denominated 
*								in (e.g. urn:uuid:dfad1d25-17ff-4201-bba0-0711e8b88c65 = cups).
*
*
*	@param 	-	$api_key 	-	your ESHA api key
*/
function fetch_food_details( $food_id, $qty, $unit, $api_key)
{
    // use cURL to fetch from ESHA
    $header = array(
	    "Accept: application/json",
	    "Content-Type: application/json"
	    );

    $data = json_encode(
	    array(
		    'items' => array(
			    'id' => $food_id,  
			    'quantity' => $qty, 
			    'unit' => $unit 
		    )
	    )
    );

    $ch = curl_init( "http://api.esha.com/analysis?apikey=" . $api_key ); 	//initialize cURL with the ESHA URL
    curl_setopt($ch, CURLOPT_POST,				1); 		//specify that it will be a POST request
    curl_setopt($ch, CURLOPT_HTTPHEADER,		$header);	//insert the proper header defined above	
    curl_setopt($ch, CURLOPT_POSTFIELDS,		$data); 	//the data to be sent
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,	0); 		//do not go to any LOCATION: header that the server sends back
    curl_setopt($ch, CURLOPT_HEADER,			1);  		// make the response return http headers
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,	1);  		// make the response return the contents of the call
    curl_setopt($ch, CURLOPT_VERBOSE,	1);  				// make the response verbose.  FOR DEBUGGING PURPOSES

    $response = curl_exec( $ch );

    //if the database didn't return anything properly, give a fatal error
    //the conditional has the strpos() > 25 to prevent the response body from containing "200 OK" and potentially allowing the program to continue
    if ( strpos( $response, "200 OK" ) == false 	OR 		strpos( $response, "200 OK" ) > 25 )
    {
	echo 'Query response = ';
	die("Query Error: Food not found."); //TODO: handle this more gracefully.  have some kind of error handling
    }

    //knock off the html headers and start at the beginning of the actual query results (note: they're in JSON so we have to decode them)
    $foods = substr( $response, strpos($response, '{"items":') );
    $foods = json_decode( $foods );

    return $foods->results;
}


/**
*	create_units_array()
*	====================
*
*	takes in an ESHA returned food object and makes an 
*	array of all possible units it has available. It 
*	creates this units array from the $food->units array
*	inside of it.  However, since the $food->units array 
*	is full of ESHA id numbers, this takes the 
*	$food->units array and converts to human-readable form.
*
*	@param $food 	-	an object returned from an ESHA query
*
*	@return $units 	-	a non-associative array containing 
*			        the human readable forms of the ESHA 
*		        	units that $food can be measured in
*/
function create_units_array ( $food )
{
    include UNITS_TABLE_PATH;

    $units = array();
    foreach( $food->units as $unit_code )
    {
	$units[] = $code_to_unit_table[ $unit_code ];
    }

    return $units;
}


/**
 * 	get_common_units()
 *  ==================  
 *
 *  fetches all "common" unit types and returns a 1-dimensional, non-associative array of them.
 *  The 
*/
function get_common_units()
{
	return common_units;
}
