<?php
//TODO: implement nutrition fact checking
require_once "/inc/config.php";
require_once LOGIN_PATH;

session_start();

$_SESSION['page_title'] = "New Food";
$_SESSION['user_id'] = "-1"; //THIS IS JUST FOR TESTING UNTIL WE IMPLEMENT USER ACCOUNTS

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																		   %
//%								functions 								   %	
//%																		   %
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

/**
*	display_page_header()
*	=====================
*
*	Takes in a string and sets the title of the page and the headline
*	to it
*
*	@param 	-	$inTitle 	-	the title to be displayed
*
*
*	@return -	NULL
*/
function display_page_header( $inTitle )
{
	$pageTitle = $inTitle;
	include HEADER_PATH;
}


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
	//	The last step - saving the user's choices to the database
	//	(note, the steps in between are below, in the non-POST section)
	//
	// ------------------------------------------------------------------
	else if( $_POST["status"] == "save_food" )
	{
		//import the variables from _POST and _SESSION
		$user_id				= trim( $_SESSION['user_id'] ); //the id of the user currently logged in
		$user_def_food_name 	= trim( $_POST['user_def_food_name'] ); //the name the user saved the food as
		$serving_size 			= trim( $_POST['serving_size'] );
		$serving_units_esha		= trim( $_POST['serving_units'] );
		$cost 					= trim( $_POST['cost'] ); //this is the cost per serving size specified in $serving_size
		$currency 				= trim( $_POST['currency'] );
		$json_esha				= json_encode( $_SESSION['selected_food'] ); //the json encoded esha information about the food
		$esha_food_id			= trim( $_SESSION['selected_food']->id ); //the food id as found in the esha database


		// replace any blank fields with NULL instead
		if( $user_def_food_name == "" ){
			$user_def_food_name = NULL;
		}
		if( $serving_size == "" ){
			$serving_size = NULL;
		}
		if( $serving_units_esha == "" ){
			$serving_units_esha = NULL;
		}
		if( $cost == "" ){
			$cost = NULL;
		}
		if( $currency == "" ){
			$currency = NULL;
		}

		//TODO: do any error checking / form validation here
		$error_array = array();

		//escape all double quotation marks in json_esha
		$json_esha = addslashes( $json_esha );


		// Set up and insert data into the database if there are no errors
		if( count( $error_array ) == 0 ){

			//using PDO prepared statements...
			$conn = new PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, SQL_USERNM, SQL_PSWD );

			$sql = 'INSERT INTO t_foods (user_def_food_name, serving_size, serving_units_esha, cost, currency, json_esha, esha_food_id, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

			//the params to go into the ?'s in $sql
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

			$conn = null; //close the connection by setting it to null
		}
		echo '<p>Food Saved!</p>';
	}
} //end if request method == POST


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																		   %
//%								non-POST stuff							   %	
//%																		   %
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

// ==================================================================
//
// Step 1 - Searching by food name
//
// ------------------------------------------------------------------
if( !isset( $_GET['status'] ) )
{
	//display the page title
	display_page_header( $_SESSION['page_title'] );

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
	//display the page title
	display_page_header( $_SESSION['page_title'] );

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
	// var_dump( $selected_food ); //DEBUG

	//for readability
	$food_name = $selected_food->description;

	//display the page title
	display_page_header( $_SESSION['page_title'] . ' - ' . $food_name );

	//prepare units array for create_servings_form_inputs
	$units = array();
	foreach( $selected_food->units as $unit_code )
	{
		$units[] = $units_lookup_table[ $unit_code ];
	}
	// echo("units array = "); //DEBUG
	// var_dump( $units ); //DEBUG
	?>

	<!-- //TODO: Hopefully this will look prettier with some CSS -->
	<!-- //give the user the option to search for the food's nutrition facts... -->
	<hr>
	<h3>Search for Nutrition Facts</h3>
	<form name="input" action="<?php echo BASE_URL . 'new_food.php'; ?>" method="post">
		<table>
			<tr>
				<th>Amount</th>
				<th>Units</th>
			</tr>

			<tr>
				<td><input type = "text" name="serving_size" value=""></td> <!-- //TODO: do form validation for this text input to make sure that it all numbers input the serving size input -->
				<td>
					<?php create_serving_units_dropdown( $units ); ?>
				</td>
				<td>
					<input type="hidden" name="status" value="nutrition_facts"><!--//tells the site to view the nutrition facts if this is selected -->
					<input type="submit" value="See Nutrition Facts">
				</td>
			</tr>
		</table>
	</form>


	<h2>OR</h2>


	<!-- ...or give them the option to save the food in the database -->
	<h3>Save the food in your pantry</h3>
	<form name="input" action="<?php echo BASE_URL . 'new_food.php'; ?>" method="post">
		<table>
			<tr>
				<th><label for="user_def_food_name">Name:</label></th>
				<td><input type="text" name="user_def_food_name" id="user_def_food_name" value="<?php echo $food_name;?>" size="<?php echo (strlen($food_name) + 5); ?>"></td>
			</tr>
		</table>
		<p>How much is it?</p>
		<table>
			<tr>
				<th>Amount</th>
				<th>Units</th>
			</tr>
			<tr>
				<td>
					<input type="text" name="serving_size" id="serving_size" value="1">
				</td> <!-- //TODO: do form validation for this text input to make sure that it all numbers input the serving size input -->
				<td>
					<?php create_serving_units_dropdown( $units ); ?>
				</td>
			</tr>
		</table>

		<p>Costs</p>

		<table>
			<tr>
				<td>
					<input type="text" name="cost" value="">
				</td>
				<td>
					<?php create_currency_dropdown(); ?>
				</td>
				<td>
					<input type="hidden" name="status" value="save_food"> <!--//tells the site to save the food in the database if this is selected -->
					<input type="submit" value="Save that food!">
				</td>
			</tr>
		</table>
	</form>

	<?php

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
					//display the page title
	display_page_header( "Save Successful" );

	echo "<p>Food saved!</p>";
	echo '<a href="' . BASE_URL . 'new_food.php">Enter a new food</a>';
	exit();
}
?>

<?php 
include( FOOTER_PATH );
