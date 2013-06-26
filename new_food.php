<?php
// TODO: use session variables for re-used variables
require_once "/inc/paths.php";
require_once LOGIN_PATH;

session_start();

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																		   %
//%								functions 								   %	
//%																		   %
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

/**
*	create_serving_units_dropdown()
*	===============================
*
*	creates a "select" input (aka dropdown menu) for a form based on the 
*	arguments passed
*
*	@param 	$units 	-	A one dimensional array containing the units that 
*						will be in the dropdown menu
*
*						Ex: $units = array("Cup", "Milliliter", "Pound")
*
*
*	@return NULL
*
*/
function create_serving_units_dropdown( $units )
{
	//TODO: modify this so that if the serving size is > 1, the units will have an 's' at the end.

	require_once( UNITS_TABLE_PATH );

	//the serving units (i.e. cups, pieces, lbs, etc.) input
	echo '<select name="serving_units">';

	//output each unit to the dropdown list
	foreach( $units as $unit )
	{
		//if the units are in small, medium, or large, make them into "small piece", "medium piece", etc.
		if ( strtolower($unit) == "small" 
			OR strtolower($unit) == "medium"
			OR strtolower($unit) == "large")
		{
			$unit = $unit . " piece";
		}
		elseif ( strtolower($unit) == "ounce-weight" )
		{
			$unit = "Dry ounce";
		}

		echo '<option value="' . $unit . '">' . $unit . '</option>';
	}

	echo '</select>';
}



/**
*	create_currency_dropdown()
*	==========================
*
*	creates a dropdown menu for currencies based on the passed arguments.
*	If the $default_currency argument is not an element in the 
*	$currencies array, then there will be no default element in the 
*	dropdown menu and the function will return false.
*
*	@param 	$currencies	-	A one dimensional array containing the currencies
*							that will be in the dropdown menu
*
*							Ex: $units = array("USD", "EUR", "JPY");
*
*	@param 	$default_currency	-	a string containing the currency that 
*									will be selected as the default for the
*									dropdown menu
*
*
*	@return $isPresent			-	true if $default_currency is present
*										in the $currencies array
*									false if $default_currency is not 
*										present in the array
*
*
*/
function create_currency_dropdown( $currencies = NULL, $default_currency = "USD" )
{
	//initialize the currencies array if nothing is passed as an argument
	if( $currencies == NULL )
	{
		$currencies = array(
			"USD",
			"KRW",
			"EUR",
			"GBP",
			"RON"
		);
	}

	//build the dropdown menu
	$isPresent = false;
	echo '<select name="currency">';
	foreach( $currencies as $currency )
	{
		if( $currency == $default_currency )
		{
			echo '<option value="' . $currency . '" selected>' . $currency . '</option>';
			$isPresent = true;
		}
		else
		{
			echo '<option value="' . $currency . '">' . $currency . '</option>';
		}
	}
	echo '</select>';


	return $isPresent;
}




/**
*
*
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
				'id' => $id,  
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

	$response = curl_exec( $ch );

	//if the database didn't return anything properly, give a fatal error
	//the conditional has the strpos() > 25 to prevent the response body from containing "200 OK" and potentially allowing the program to continue
	if ( strpos( $response, "200 OK" ) == false 	OR 		strpos( $response, "200 OK" ) > 25 )
	{
		echo 'Query response = ';
		var_dump( $response );
		die("Query Error: Food not found."); //TODO: handle this more gracefully.  have some kind of error handling
	}

	$foods = substr( $response, strpos($response, '{"items":') );
	$foods = json_decode( $foods );
	var_dump( $foods );
}



//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																		   %
//%								POST stuff 								   %	
//%																		   %
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if( $_SERVER["REQUEST_METHOD"] == "POST")
{
	$error_array = array();

	// ==================================================================
	//
	// 1st step - After the user has searched for a food name
	//
	// ------------------------------------------------------------------
	if( $_POST["status"] == "name_selected" )
	{
		//Check if the food name is blank
		if( !isset($_POST["name"]) OR trim($_POST["name"]) == "" )
		{
			//if no food name was searched, mark it in the error array and go back to the initial page
			$error_array["name"] = true;
			// header( "Location: " . BASE_URL . "new_food.php" );
		}
		else
		{
			//store entered name as session variable
			$_SESSION['food_name_query'] = htmlspecialchars( $_POST['name'] );

			// if no errors, proceed to the next step, setting $_GET['status']='find'
			header( "Location: " . BASE_URL . "new_food.php?status=find" );
		}
	}


	// ==================================================================
	//
	// When the user is ready to save the food information in the 
	// database
	//
	// ------------------------------------------------------------------
	if( $_POST["status"] == "save_food" )
	{
		require_once( NUTRITIONIX_PATH );

		$nutr = new Nutritionix( NUTRITIONIX_APP_ID, NUTRITIONIX_APP_KEY );

		//import the variables from _POST
		$q_name = trim( $_POST["name"] );
		$q_json_food = json_encode( $nutr->getItem( $_POST['id'] ) );
		$q_serving_size = trim( $_POST["serving_size"] );
		$q_serving_units = trim( $_POST["serving_units"] );
		$q_cost = trim( $_POST["cost"] );
		$q_currency = trim( $_POST["currency"] );

		//TODO: do any error checking / form validation here
		$error_array = array();

		// replace any blank fields with NULL instead
		if( $q_name == "" ) {
			$q_ = NULL;
		}
		if( $q_json_food == "" ) {
			$q_json_food = NULL;
		}
		if( $q_serving_size == "" ) {
			$q_serving_size = NULL;
		}
		if( $q_serving_units == "" ) {
			$q_serving_units = NULL;
		}
		if( $q_cost == "" ) {
			$q_cost = NULL;
		}
		if( $q_currency == "" ) {
			$q_currency = NULL;
		}

		//escape all double quotation marks in q_json_food
		$q_json_food = addslashes( $q_json_food );


		// Set up and insert data into the database if there are no errors
		if( count( $error_array ) == 0 ){
			// set up the database connection and select the calorie_counter db
			$mysqli = mysqli_connect("localhost", $SQL_USERNM, $SQL_PSWD, "calorie_calculator")or die("cannot connect to mySQL");

			mysqli_select_db( $mysqli, "calorie_calculator" )or die("cannot use the calorie_calculator db");

			// TODO secure the query against sql injection attacks.  check out the following sites:
			// 	http://stackoverflow.com/questions/60174/how-to-prevent-sql-injection-in-php
			// 	http://php.net/manual/en/mysqli.prepare.php
			// 	http://php.net/manual/en/mysqli-stmt.bind-param.php
			$query = 'INSERT INTO t_foods (name, serving_size, serving_units, cost_per_package, food_object) VALUES ("' . $q_name . '", ' . $q_serving_size . ', "' . $q_serving_units . '", ' . $q_cost . ', "' . $q_json_food . '")';

			$result = mysqli_query( $mysqli, $query );

			mysqli_close($mysqli);

			//check to make sure the insertion worked properly
			if( $result )
			{
				//reload the page as GET instead of POST
				header("Location: " . BASE_URL . "new_food.php/?status=submitted");
			} 
			else
			{
				html_echo("DATABASE ERROR!!!!");
				$error_array["insert"] = true;
				exit();
			}
		}
		echo '<p>Food Saved!</p>';
	}
} //end if request method == POST


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																		   %
//%								non-POST stuff							   %	
//%																		   %
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
$pageTitle = "New Food";
include HEADER_PATH;

// ==================================================================
//
// Step 1 - Searching by food name
//
// ------------------------------------------------------------------
if( !isset( $_GET['status'] ) )
{
	echo '<p>Search for a food to add to your pantry</p>';

	if( isset($error_array["name"]) AND $error_array["name"] == true )
	{
		echo '<p>Please enter a food name</p>';
	}

	echo '<form name="input" action="' . BASE_URL . 'new_food.php' . '" method="post">';
	echo '<input type="text" name="name" value="">';
	echo '<input type="hidden" name="status" value="name_selected">'; //since there are multiple posts on this page, this field tells the site that the first stage, the food name submission stage is complete
	echo '<input type="submit" value="Find Food">';
}


// ==================================================================
//
// Step 2 - Choosing a food from the returned database possibilities
//
// ------------------------------------------------------------------
else if( isset($_GET['status']) AND $_GET['status'] == "find" ) 
{
	// require_once( NUTRITIONIX_PATH );
	require_once( UNITS_TABLE_PATH );


	//get the list of foods that match the user-defined query
	$search_result = json_decode( file_get_contents( "http://api.esha.com/foods?apikey=" . ESHA_API_KEY . "&query=" . urlencode( $_SESSION['food_name_query'] ) . '&spell=true' ) ); 
	$search_result = $search_result->items;
	$_SESSION['matched_foods'] = $search_result;

	echo 'search result = '; // DEBUG
	var_dump( $search_result ); // DEBUG

	// $ch = curl_init( "http://api.esha.com/food-units?apikey=" . ESHA_API_KEY );//DEBUG
	// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );//DEBUG
	// $response = curl_exec( $ch );//DEBUG
	// var_dump( json_decode( $response ) ); //DEBUG


	//put a table at the bottom of the screen displaying all the results
	echo '<table>';
	$i = 0;

	foreach( $search_result as $food ) {
		echo '<tr>';
		echo '<td>' . htmlspecialchars( $food->description ) . '</td>';

		//make links that correspond to each returned food match. idx in the GET corresponds to the index of the selected food in the $_SESSION['matched_foods'] array
		echo '<td><a href="' . BASE_URL . 'new_food.php?status=food_selected&idx=' . $i . '">Select</a></td>';
		$i++;

		echo '</tr>';
	}
	echo '</table>';
}


// ==================================================================
//
// Step 3:	Specifying cost per serving for the food
//
// ------------------------------------------------------------------
else if( isset($_GET["status"]) AND $_GET["status"] == "food_selected" )
{
	//TODO: implement ability to see nutrition facts on this page based on what serving size the user chooses
	//TODO: use AJAX (eventually) to show nutrition facts as the user changes the serving size

	require_once( UNITS_TABLE_PATH );

	//retrieve the selected food from the matched_foods array dependent on what idx is in the GET variable
	$_SESSION['selected_food'] = $_SESSION['matched_foods'][ $_GET['idx'] ];
	$selected_food = $_SESSION['selected_food'];
	var_dump( $selected_food ); //DEBUG

	//for readability
	$food_name = $selected_food->description;

	//prepare units array for create_servings_form_inputs
	$units = array();
	foreach( $selected_food->units as $unit_code )
	{
		$units[] = $units_lookup_table[ $unit_code ];
	}
	echo("units array = "); //DEBUG
	var_dump( $units ); //DEBUG

	echo '<h2>Selected food: ' . htmlspecialchars( $food_name ) . '</h2>';

	//give the user the option to search for the food's nutrition facts...
	echo '<h3>Search for Nutrition Facts</h3>';
	echo '<form name="input" action="' . BASE_URL . 'new_food.php' . '" method="post">';
	echo 	'<input type = "text" name="serving_size" value="">'; //TODO: do form validation for this text input to make sure that it's all numbers input the serving size input
	create_serving_units_dropdown( $units );
	echo 	'<input type="hidden" name="status" value="nutrition_facts">'; //tells the site to view the nutrition facts if this is selected
	echo 	'<input type="submit" value="See Nutrition Facts">';


	//...or give them the option to save the food in the database
	echo '<h3>OR</h3>';
	echo '<br />';
	echo '<h3>Save the food in your pantry</h3>';
	echo '<form name="input" action="' . BASE_URL . 'new_food.php' . '" method="post">';
	echo 	'<label for="user_def_food_name">Name to save it as:</label>';
	echo 	'<input type="text" name="user_def_food_name" id="user_def_food_name" value="' . $food_name . '">';
	echo 	'<br>';
	echo 	'<label for="serving_size">Cost per</label>';
	echo 	'<input type = "text" name="serving_size" id="serving_size" value="">'; //TODO: do form validation for this text input to make sure that it's all numbers input the serving size input
	create_serving_units_dropdown( $units );
	echo 	'=';
	echo 	'<input type="text" name="cost" value="">';
	create_currency_dropdown();
	echo 	'<input type="hidden" name="food_name" value="' . $food_name . '">';
	echo 	'<input type="hidden" name="status" value="save_food">'; //tells the site to save the food in the database if this is selected
	echo 	'<input type="submit" value="Save that food!">';
	
	// //if the user hasn't already searched for the food nutrients already, fetch the data from ESHA
	// if( !isset( $_SESSION["food_details"] ) )
	// {
	// 	fetch_food_details( $_SESSION['selected_food']->id, $qty, $unit, ESHA_API_KEY );
	// }

	// // Fetch the nutrients array from ESHA
	// $ch = curl_init( "http://api.esha.com/food-units?apikey=" . ESHA_API_KEY );
	// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	// $response = curl_exec( $ch );
	// echo json_encode( $response ); //DEBUG
}


// ==================================================================
//
// Step 4 - Food saved successfully
//
// ------------------------------------------------------------------
else if( isset($_GET["status"]) AND $_GET["status"] == "submitted" )
{
	echo "<p>Food saved!</p>";
	echo '<a href="' . BASE_URL . 'new_food.php">Enter a new food</a>';
	exit();
}
?>

<?php 
include( FOOTER_PATH );
