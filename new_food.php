<?php
//TODO: make the links for the food query results also store the available 
//units for the foods.  Store those units in the db as well.

//TODO: make individual folders for URLs. (i.e. - instead of having 
// /new_food.php, have /newFood/, or something)

//TODO: make the program inform the user if there is already a food saved of 
//the same type as what they are entering

//TODO: parse the esha query results into a class that you can standardize and 
//work with

//TODO: implement error handling in case the user inputs a letter where only 
//numbers should be.
require_once "/inc/config.php";
require_once LOGIN_PATH;
require_once ESHA_PATH;
require_once DB_PATH;
require_once UNITS_TABLE_PATH;

session_start();

$_SESSION['page_title'] = "New Food";


//TODO: implement user accounts since THIS -1 VALUE IS JUST FOR TESTING UNTIL 
//WE IMPLEMENT USER ACCOUNTS
$_SESSION['user_id'] = "-1"; 

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%								        	%
//%     			   Functions                                    %
//%										%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
/**
*	display_page_header()
*	=====================
*
*	Takes in a string and sets the title of the page and the headline
*	to it
*
*	@param 	-	$inTitle 	-	the title to be displayed
*
*	@return -	NULL
*/
function display_page_header( $inTitle )
{
	$pageTitle = $inTitle;
	include HEADER_PATH;
}


/**
*   make_pantry_save_form()
*   =========================
*   
*   Creates a form in HTML that has the layout for saving a food in the user's
*   pantry. This form has information for the user to input like food name,
*   serving size, serving units, Cost per serving size, and the currency that
*   cost is denominated in.
*   
*   @param  -   $default_food_name  -   The name of the food that will show up
*   					in the "food name" field when the page
*   					first loads up.
*   
*   @param  -   $unit_list  -   an array containing the desired serving
*   			        units to be displayed
*   
*   @return -   $html_text  -   The html string that will build the save form
*
*/
function make_pantry_save_form( $default_food_name, $unit_list )
{
    //TODO: make this return a string that contains all the html code instead 
    //of directly outputting it through echo.
    
    //TODO: do form validation for this text input to make sure all the inputs 
    //are in number fomat
    $html_text = '<form name="input" action="' . 
        BASE_URL . 'new_food.php' . '" method="post">';
    $html_text .= '<table>';
    $html_text .= '<tr>';
    $html_text .= '<th><label for="user_def_food_name">Name:</label></th>';
    $html_text .= 	    
        '<td>' . 
            '<input type="text" '.
            'name="user_def_food_name" ' . 
            'id="user_def_food_name" ' . 
            'value="' .  $default_food_name .  '" ' . 
            'size="' . (strlen($default_food_name) + 5) .  '">' . 
        '</td>';
    $html_text .= '</tr>';
    $html_text .= '</table>';
    $html_text .= '<p>How much is it?</p>';
    $html_text .= '<table>';
    $html_text .= '<tr>';
    $html_text .= '<th>Amount</th>';
    $html_text .= '<th>Units</th>';
    $html_text .= '</tr>';
    $html_text .= '<tr>';
    $html_text .= '<td>';
    $html_text .= 
        '<input type="text" name="serving_size" id="serving_size" value="1">';
    $html_text .= '</td>'; 
    $html_text .= '<td>';

    $html_text .=
        create_serving_units_dropdown( 
            array('name' => 'serving_units') , $unit_list 
        );
    $html_text .= '</td>';
    $html_text .= '</tr>';
    $html_text .= '</table>';

    $html_text .= '<p>Costs</p>';

    $html_text .= '<table>';
    $html_text .= '<tr>';
    $html_text .= '<td>';
    $html_text .= '<input type="text" name="cost" value="">';
    $html_text .= '</td>';
    // $html_text .= '<td>';
    // $html_text .= create_currency_dropdown();
    // $html_text .=' </td>';
    $html_text .=' <td>';
    $html_text .= '<input type="hidden" name="status" value="save_food">'; 
    $html_text .= '<input type="submit" value="Save that food!">';
    $html_text .= '</td>';
    $html_text .= '</tr>';
    $html_text .= '</table>';
    $html_text .= '</form>';

    return $html_text;
}


/**
*    create_currency_dropdown()
*    ==========================
*    
*    creates and returns an html string for a dropdown menu for 
*    currencies based on the passed arguments. If the 
*    $default_currency argument is not an element in the 
*    $currencies array, then there will be no default element in the 
*    dropdown menu and the function will return false.
*    
*    @param $currencies	-	A one dimensional array containing 
*                               the currencies that will be in the dropdown 
*                               menu
*                               Ex: $units = array("USD", "EUR", "JPY");
*    
*    @param $default_currency -	a string containing the currency that 
*                               will be selected as the default for the
*                               dropdown menu
*    
*  
*    @return $output -	        the corresponding html string for the dropdown menu
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
    $output = '<select name="currency">';
    foreach( $currencies as $currency )
    {
	    if( $currency == $default_currency )
	    {
		$output .= 
                    '<option value="' . $currency . '" selected>' . 
                    $currency . '</option>';
	    }
	else
	{
		$output .= 
                    '<option value="' . $currency . '">' . 
                    $currency . '</option>';
	    }
    }
    $output .= '</select>';


    return $output;
}


/**
*	my_var_dump()
*	=============
*
*	displays the name of the variable to be displayed in var_dump() 
*	and then calls var_dump() after
*
*	@param 	-	 $var_name 	-   the name to be displayed 
*	                                    before var_dump
*
*	@param 	-	 $variable 	-   the variable to be fed into 
*                                           var_dump
*
*
*	@return -	null
*/
function my_var_dump( $var_name, $variable )
{
	echo " VAR_DUMP OF $var_name";
	echo "<pre>";
	var_dump( $variable );
	echo "</pre>";
}


/**
 * prepare_nutrition_lookup_data()
 * ===============================
 *
 * This function prepares the data necessary to let the user view the nutrition 
 * info for the food he/she wants to store.  
 * In particular, this function:
 *      -finds the ESHA code for the user-specified serving units
 *      -stores the user-specified serving size in $_SESSION
 *
 *  @param  -   null
 *  @retun  -   null
 */
function prepare_nutrition_lookup_data()
{
    $_SESSION['lookup_serving_size'] = $_POST['serving_size'];

    //since $code_to_unit_table is structured as $id => $unit_name, search 
    //through the table to find which id matches the POSTed unit
    foreach( $code_to_unit_table as $id => $table_unit )
    {
	if( $table_unit == $_POST['serving_units'] )
	{
	    $_SESSION['lookup_serving_units_id'] = $id;
	}
    }
}


/*
 * save_food_in_pantry()
 * ==================
 *
 * This function is called when the user has specified all the data necessary 
 * to save the new food in their pantry. This function performs form 
 * validation, and then saves the food in the SQL database
 *
 * @param   -   null
 * @return  -   null
 */
function save_food_in_pantry()
{
    include UNITS_TABLE_PATH;

    $save_food_vars = import_save_food_vars();
    extract( $save_food_vars );
    $save_food_vars['error_array'] = save_food_form_validation( $save_food_vars );

    // Set up and insert data into the database if there are no errors
    if( count( $save_food_vars['error_array'] ) == 0 ){

	$params = array(
	    'user_def_food_name'    => $user_def_food_name,
	    'serving_size'          => $serving_size,
	    'serving_units_esha'    => $serving_units_esha,
	    'cost'                  => $cost,
	    /* 'currency'              => $currency, */
	    'json_esha'             => $json_esha,
	    'esha_food_id'          => $esha_food_id,
	    'user_id'               => $user_id,
            'calories'              => $calories
	);

        $db = new Database_handler;
        $db->insert_row( 't_foods', $params ); 

        return null;
    }
    else
    {
        return $save_food_vars['error_array'];
    }
}

/**
 * import_save_food_vars()
 * =======================
 *
 * imports from _POST and _SESSION the variables needed to store the selected 
 * food in the sql database
 * 
 * user_id               = id of the user currently logged in
 * user_def_food_name    = name the user saved the food as
 * serving_size          = cost per serving size specified in $serving_size
 * serving_units_esha    = esha code for the serving units (i.e. cups, etc.)
 * cost                  = money cost per serving
 * currency              = currency the cost is denominated in
 * json_esha             = the json encoded esha information about the food
 * esha_food_id          = the food id as found in the esha database
*/
function import_save_food_vars()
{
    include UNITS_TABLE_PATH;

    $vars = array();

    $vars['user_id'] =
        trim( $_SESSION['user_id'] ); 

    $vars['user_def_food_name'] = 
        trim( $_POST['user_def_food_name'] ); 

    $vars['serving_size'] = 
        $_POST['serving_size'];

    $vars['serving_units_esha'] = 
        $unit_to_code_table[ trim( $_POST['serving_units'] ) ];

    $vars['cost'] = 
        $_POST['cost']; 

    // $vars['currency'] = 
    //     trim( $_POST['currency'] );

    $vars['json_esha'] = 
        addslashes( json_encode( $_SESSION['selected_food'] ) ); 

    $vars['esha_food_id'] = 
        trim( $_SESSION['selected_food']->id ); 


    $vars['calories'] = 
        fetch_food_details( 
            $vars['esha_food_id'],
            $vars['serving_size'],
            $vars['serving_units_esha'],
            ESHA_API_KEY 
        )[0]->value;

    //TODO: this is just a temporary fix to make sure that no random bugs occur 
    //if the food has 0 calories.  A more robust method should be implemented 
    //for dealing with this problem
    if( $vars['calories'] == 0 )
    {
        $vars['calories'] = 0.001;
    }


    // replace any blank fields with NULL instead
    if( $vars['user_def_food_name'] == "" ){
	$vars['user_def_food_name'] = NULL;
    }
    if( $vars['serving_size'] == "" ){
	$vars['serving_size'] = NULL;
    }
    if( $vars['serving_units_esha'] == "" ){
	$vars['serving_units_esha'] = NULL;
    }
    if( $vars['cost'] == "" ){
	$vars['cost'] = NULL;
    }
    // if( $vars['currency'] == "" ){
	$vars['currency'] = NULL;
    // }


    return $vars;
}



/*
 * save_food_form_validation()
 * ===========================
 *
 * This function checks the POST inputs from the forms when a user sends food 
 * data to be saved.  If there are any errors or blank entries, this will mark 
 * them in $error_array
 *
 * @param   -   $save_food_vars     -   the POST entries to be checked
 *
 * @return  -   $error_array        -   an array containing the errors in the 
 *                                      forms
 */
function save_food_form_validation( $save_food_vars )
{
    extract( $save_food_vars );

    //TODO: do any error checking / form validation here
    $error_array = array();
    return $error_array;
}


/**
 * display_init_page()
 * ===================
 *
 * Makes the initial page that prompts the user to enter a food name to search 
 * for.  It includes a form with a text input for the user to enter a food name 
 * along with a search button. 
 *
 * @param   -   null
 *
 * @return  -   null
 */
function display_init_page()
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


/*
 * fetch_query_results()
 * =====================
 *
 * queries the ESHA database for any foods matching the passed string.  returns 
 * the ESHA formatted object that ESHA returns.
 *
 * @param   -   query_str   -   the name of the food to be searched for
 *
 * @return  -   search_result   -   the ESHA formatted object with the query 
*                                   results
 */
function fetch_query_results( $query_str )
{
    //get the list of foods that match the user-defined query
    $search_result = 
        json_decode( 
            file_get_contents( 
                "http://api.esha.com/foods?apikey=" .  ESHA_API_KEY . "&query=" 
                . urlencode( $query_str ) . '&spell=true' ) 
    ); 

    $search_result = $search_result->items;
    $_SESSION['matched_foods'] = $search_result;

    return $search_result;
}


/*
 * make_results_table()
 * ====================
 *
 * Displays the results of an ESHA foods query in a table. Returns the html 
 * code for the table. 
 * 
 * @param   -   $search_result  -   the query results from the ESHA search
 *
 * @return  -   $html           -   the html code for the table containing all 
 *                                  the results
 */
function make_results_table( $search_result )
{
    $html =  '<table>';
    $i = 0;

    foreach( $search_result as $food ) 
    {
	$html .= '<tr>';
	$html .= '<td>' . htmlspecialchars( $food->description ) . '</td>';

	//make links that correspond to each returned food match. idx in the 
	//GET corresponds to the index of the selected food in 
	//the $_SESSION['matched_foods'] array
	$html .= '<td><a href="' . BASE_URL . 
            'new_food.php?status=food_selected&idx=' . $i . 
            '">Select</a></td>';
	$i++;
	$html .= '</tr>';
    }
    $html .= '</table>';

    return $html;
}



//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%								        	%
//%     			   Main code    				%
//%										%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

//POST HANDLING
if( $_SERVER["REQUEST_METHOD"] == "POST")
{
    $error_array = array();

    // ------------------------------------------------------------------
    // 1st step - After the user has searched for a food name
    // ------------------------------------------------------------------
    if( $_POST['status'] == "name_selected" )
    {
        //store the food name in session variable and go to the page 
        //displaying the search results
        if( isset($_POST['name']) )
        {
	    $_SESSION['food_name_query'] = htmlspecialchars( $_POST['name'] );
	    header( "location: " . BASE_URL . "new_food.php?status=find" );
        }
        else
        {
	    $error_array["name"] = true;
	    // header( "location: " . BASE_URL . "new_food.php" );
        }
    }
    
    // ------------------------------------------------------------------
    //	Searching for nutrition facts
    // ------------------------------------------------------------------
    else if( $_POST['status'] == 'nutrition_facts' )
    {
        prepare_nutrition_lookup_data();
        header( "Location: " . BASE_URL . "new_food.php?status=nutrition_facts" );
    }
    
    // ------------------------------------------------------------------
    //	The last step - saving the user's choices to the database
    //	(Note: the steps in between are below - in the non-POST section)
    // ------------------------------------------------------------------
    else if( $_POST['status'] == "save_food" )
    {
        $db_errors = save_food_in_pantry();
        if( ! $db_errors )
        {
            echo '<p>Food Saved!</p>';
        }
    }
} //end if request method == POST


// ------------------------------------------------------------------
// ------------------------------------------------------------------

//non-POST Handling

// ------------------------------------------------------------------
// Step 1 - Searching by food name
// ------------------------------------------------------------------
if( !isset( $_GET['status'] ) )
{
    display_init_page();
}

// ------------------------------------------------------------------
// Step 2 - Choosing a food from the returned database possibilities
// ------------------------------------------------------------------
else if( isset($_GET['status']) AND $_GET['status'] == "find" ) 
{
    //display the page title
    display_page_header( 
        htmlspecialchars( 
            $_SESSION['page_title']. ' - Search Results for "' . 
            $_SESSION['food_name_query'] 
        ) . '"'
    );

    $search_result = fetch_query_results( $_SESSION['food_name_query'] );
    $_SESSION['esha_matches'] = $search_result;

    $table_html = make_results_table( $search_result );
    echo $table_html;
}

// ------------------------------------------------------------------
// Step 3:	Specifying cost per serving for the food
// ------------------------------------------------------------------
else if( isset($_GET["status"]) AND $_GET["status"] == "food_selected" )
{
    //TODO: use AJAX (eventually) to show nutrition facts as the user changes 
    //the serving size on this page

    $_SESSION['selected_food'] = $_SESSION['matched_foods'][ $_GET['idx'] ];
    $selected_food = $_SESSION['selected_food'];
    var_dump($selected_food); //DEBUG
    $food_name = $selected_food->description;

    display_page_header( $_SESSION['page_title'] . ' - ' . $food_name );

    $units = create_units_array( $_SESSION['selected_food'] );

    //TODO: Hopefully this will look prettier with some CSS 
    //give the user the option to search for the food's nutrition facts... 
    $html_text = '<hr>';
    $html_text .= '<h3>Save the food in your pantry</h3>';
    $html_text .= make_pantry_save_form( $selected_food->description, $units );	

    echo $html_text;
}


// // ==================================================================
// //
// // Step 3.5 - Look at food nutrition facts
// //
// // ------------------------------------------------------------------
// else if( isset($_GET['status']) AND $_GET['status'] == 'nutrition_facts' )
// {
//     //require( units_table_path );
//     require_once( NUTRIENTS_TABLE_PATH );
// 
//     display_page_header( "nutrition facts - " . $_session['selected_food']->description );
//     $nutrition_facts = fetch_food_details( 
// 	$_session['selected_food']->id, 
// 	$_session['lookup_serving_size'], 
// 	$_session['lookup_serving_units_id'],  
// 	esha_api_key
//     );
// 
//     //show the serving size and units
//     echo '<table>';
//     echo 	'<tr>';
//     echo 		'<th>serving size:</th>';
// 
//     //put the units in plural if the serving is != 1
//     //todo: implement inch'es' instead of 'inchs'.  make the units correctly either have 's' or 'es' at the end, depending on the word
//     if(	$_session['lookup_serving_size'] == 1 )
//     {
// 	echo 	'<td>' . $_session['lookup_serving_size'] . ' ' . $code_to_unit_table[ $_session['lookup_serving_units_id'] ];
//     }
//     else
//     {
// 	echo 	'<td>' . $_session['lookup_serving_size'] . ' ' . $code_to_unit_table[ $_session['lookup_serving_units_id'] ] . 's';
//     }
//     echo 	'</tr>';
// 
//     //show each of the nutrients in it
//     foreach ($nutrition_facts as $fact) 
//     {
// 	echo '<tr>';
// 
// 	$nutrient = $nutrients_lookup_table[ $fact->nutrient ]['description'];
// 	$nutrient_unit = $nutrients_lookup_table[ $fact->nutrient ]['unit']; 
// 
// 	echo '<th>' . $nutrient . ':</th>';
// 	echo '<td>' . $fact->value . ' ' . $nutrient_unit . '</td>';
// 
// 	echo '</tr>';
//     }
//     echo '</table>';
// 
//     echo '<hr>';
//     echo '<p>' . htmlspecialchars('if you want to save this food in your pantry, please specify how much it costs:') . '</p>';
// 
//     $units = create_units_array( $_session['selected_food'] );
//     make_pantry_save_form( $_session['selected_food']->description, $units );
// }


// ------------------------------------------------------------------
// Step 4 - Food saved successfully
// ------------------------------------------------------------------
else if( isset($_GET["status"]) AND $_GET["status"] == "submitted" )
{
    display_page_header( "Save Successful" );

    echo "<p>Food saved!</p>";
    echo '<a href="' . BASE_URL . 'new_food.php">Enter a new food</a>';
    exit();
}
?>

<?php 

include( FOOTER_PATH );
