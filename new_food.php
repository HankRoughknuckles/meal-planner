<?php
// TODO: implement esha food database functionality.  nutritionix is not so great.
require_once "/inc/paths.php";
require_once LOGIN_PATH;


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																		   %
//%								functions 								   %	
//%																		   %
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//empty for now...



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
			// if no errors, proceed to the next step, passing GET status=find
			header( "Location: " . BASE_URL . "new_food.php?status=find&name=" . $_POST["name"] );
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
if( sizeof($_GET) == 0 )
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
else if( isset($_GET["status"]) AND $_GET["status"] == "find" ) 
{
	// require_once( NUTRITIONIX_PATH );
	require_once( UNITS_TABLE_PATH );


	// %%%%%%% TEST %%%%%%%
	$search_result = json_decode( file_get_contents( "http://api.esha.com/foods?apikey=" . ESHA_API_KEY . "&query=" . urlencode( $_GET["name"] ) . '&spell=true' ) ); //TODO: the fact that you're searching with a GET variable could be a security hole.  Find a way to sanitize the query
	$search_result = $search_result->items;
	var_dump( $search_result );
	// %%%%%%% END TEST %%%%%%%

	// $ch = curl_init( "http://api.esha.com/food-units?apikey=" . ESHA_API_KEY );//DEBUG
	// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );//DEBUG
	// $response = curl_exec( $ch );//DEBUG
	// var_dump( json_decode( $response ) ); //DEBUG


	//search through each result and try to match according to what they chose
	echo '<table>';
	foreach( $search_result as $food ) {
		echo '<tr>';
		echo '<td>' . htmlspecialchars( $food->description ) . '</td>';
		foreach( $food->units as $unit )
		{
			echo '<td><a href="' . BASE_URL . 'new_food.php?status=food_selected&name=' . $_GET["name"] . '&id=' . $food->id . '&unit=' . $unit . '">' . $units[ $unit ] . '</a></td>';//TODO: the fact that you're searching with a GET variable could be a security hole.  Find a way to sanitize the query
		}
		echo '</tr>';
	}
	echo '</table>';

	// $nutr = new Nutritionix( NUTRITIONIX_APP_ID, NUTRITIONIX_APP_KEY );
	// try
	// {
	// 	// $search_result = $nutr->search( $_GET["name"], 0, 10, NULL, NULL, "*", NULL );
	// 	// $search_result = $search_result["hits"];

	// 	echo 'Please choose from one of the selections below';

	// 	echo "<table>";

	// 	//search through each result and try to match according to what they chose
	// 	foreach( $search_result as $food ) {
	// 		echo "<tr>";
	// 		echo '<td>' . $food["fields"]["item_name"] . '</td>';
	// 		echo '<td> <a href="' . BASE_URL . 'new_food.php?status=food_selected&name=' . $_GET["name"] . '&id=' . $food["fields"]["item_id"] . '">Select</a>';
	// 	}

	// 	echo "</table>";
	// } 
	// catch (Exception $e)
	// {
	// 	die('Nutritionix API Error: '.$e);	
	// }
}


// ==================================================================
//
// Step 3:	Specifying cost per serving for the food
//
// ------------------------------------------------------------------
else if( isset($_GET["status"]) AND $_GET["status"] == "food_selected" )
{
	// require_once( NUTRITIONIX_PATH );

	// %%%%%%%% test this out !! %%%%%%%%%%%

	// use cURL to fetch the detailed information about the selected food from ESHA
	$header = array(
		"Accept: application/json",
		"Content-Type: application/json"
	);

	$data = json_encode( 
		array(
			'items' => array(
				'id' => $_GET["id"],  //TODO: this could potentially be a security hole, find a way to get this data through without using GET
				'quantity' => 0.5, //TODO: change this later
				'unit' => "urn:uuid:dfad1d25-17ff-4201-bba0-0711e8b88c65" //TODO: change this later
			)
		)
	);

	$ch = curl_init( "http://api.esha.com/analysis?apikey=" . ESHA_API_KEY ); 	//initialize cURL with the ESHA URL
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

	// Fetch the nutrients array from ESHA
	$ch = curl_init( "http://api.esha.com/food-units?apikey=" . ESHA_API_KEY );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	$response = curl_exec( $ch );
	echo json_encode( $response ); //DEBUG

	// %%%%%%%% /test this out !! %%%%%%%%%%%

	// $nutr = new Nutritionix( NUTRITIONIX_APP_ID, NUTRITIONIX_APP_KEY );
	// try
	// {
	// 	$food = $nutr->getItem( $_GET["id"] );
	// 	$name = ucwords( $_GET["name"] );

		// // %%%%%%% 	START DEBUG 	%%%%%
		// echo "<pre> food = "; //DEBUG
		// var_dump($food); //DEBUG
		// echo "</pre>"; //DEBUG
		// // %%%%%%% 	END DEBUG 	%%%%%
		
		//TODO: put in the jquery nutrition label from here: https://github.com/nutritionix/nutrition-label into the page
		$name = "FOOD_NAME"; //DEBUG
		echo '<h2>Food: ' . htmlspecialchars( $name ) . '</h2>';
		echo '<form name="input" action="' . BASE_URL . 'new_food.php' . '" method="post">';
		echo '<label for="cost">Cost per</label>';

		//TODO: do form validation for this text input to make sure that it's all numbers input
		echo '<input type = "text" name="serving_size" value="1">';

		echo '<select name="serving_units">';
		echo '<option value="pound">pound</option>';
		echo '<option value="piece">piece</option>';
		echo '<option value="cup">cup</option>';
		echo '<option value="liter">liter</option>';
		echo '<option value="milliliter">milliliter</option>';
		echo '<option value="fluid_oz">fluid ounce</option>';
		echo '<option value="dry_oz">dry ounce</option>';
		echo '<option value="gram">gram</option>';
		echo '<option value="kilogram">kilogram</option>';
		echo '<option value="none">(no units)</option>';
		echo '</select>';
		echo ':   ';

		echo '<input type="text" name="cost" id="cost" value="">';

		echo '<select name="currency">';
		//TODO find a way to store these currencies in an array or as json somewhere to make it easily extensible and portable
		echo '<option value="USD" selected>USD</option>';
		echo '<option value="KRW">KRW</option>';
		echo '<option value="EUR">EUR</option>';
		echo '<option value="GBP">GBP</option>';
		echo '<option value="RON">RON</option>';
		echo '</select>';

		// hidden inputs
		echo '<input type="hidden" name="name" value="' . htmlspecialchars( $name ) . '">';
		echo '<input type="hidden" name="id" value="' . htmlspecialchars( $_GET["id"] ) . '">';
		echo '<input type="hidden" name="status" value="save_food">'; //since there are multiple posts on this page, this field tells the site that the first stage, the food name submission stage is complete

		echo '<input type="submit" value="Save that Food!">';
	// }
	// catch (Exception $e)
	// {
	// 	die('Nutritionix API Error: ' . $e);
	// }
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
