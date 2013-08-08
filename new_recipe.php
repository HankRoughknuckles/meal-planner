<?php
//TODO: URGENT! make the first screen have drop down menus that only display 
//the units that are stored for each food in ESHA (ie if cheese can only be 
//measured in cups in ESHA, only display cups
//TODO: implement form checking on ingredients to make sure they are not blank 
//and also have the right format

require_once("/inc/config.php");
require_once( LOGIN_PATH );

session_start();

//Display the header
$pageTitle = "New Recipe";
include( HEADER_PATH );

// Define constants

//the number of ingredient fields to be displayed by default on page load-up.
define( 'DEFAULT_FIELD_AMOUNT', 	10 ); 


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%							        	%
//% 			        FUNCTIONS                               %
//%									%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%

/**
 * TODO: make doc
 * @return $table_html  -   the string containing the html code for the table
 */
function make_cost_table()
{
    //TODO: finish this
    require_once UNITS_TABLE_PATH;
    global $unit_to_code_table;

    $ingredient_list = json_decode($_POST['ingredient_list']);
    $saved_foods = $_SESSION['saved_foods'];

    $table_html = '<table id="recipe_tabulation">';
    $table_html .=   '<tr>';
    $table_html .=       '<th>Amount</th>';
    $table_html .=       '<th>Food</th>';
    $table_html .=       '<th>Calories</th>';
    $table_html .=       '<th>Cost</th>';
    $table_html .=   '</tr>';

    //get nutrition information about each ingredient
    foreach( $ingredient_list as $ingredient ){
        var_dump( $ingredient ); //DEBUG
        // var_dump( $_SESSION['saved_foods'] ); //DEBUG
        
        $matching_saved_food = $saved_foods[$ingredient->food_id];

        //Get calories of the entered ingredient
        var_dump( $unit_to_code_table[ $ingredient->unit ] ); // DEBUG

        $ingredient_calories = fetch_food_details(
            $matching_saved_food['esha_food_id'],
            $ingredient->amt,
            $unit_to_code_table[ $ingredient->unit ],
            ESHA_API_KEY
        );
        $ingredient_calories = $ingredient_calories[0]->value;
        echo 'esha successfully polled, calories are ' . $ingredient_calories;

        // Find calorie ratio between saved food amount and entered 
        // ingredient amount. Use this ratio to determine cost of using 
        // the ingredient.
        echo floatval($matching_saved_food['calories']);
        $ratio = floatval($matching_saved_food['calories']) / $ingredient_calories;
        echo $ratio;
        
        // $ingredient_cost = 
        
        $table_html .=       '<tr>';
        $table_html .=       '<td>';
        if( $ingredient->unit == 1 )
        {
            $table_html .=           $ingredient->name . ':  ' . $ingredient->amt . ' ' . strtolower($ingredient->unit);
        }
        else
        {
            $table_html .=           $ingredient->name . ':  ' . $ingredient->amt . ' ' . strtolower($ingredient->unit) . 's';
        }
        $table_html .=       '</td>';
        $table_html .=       '</tr>';
    }
    $table_html .= '</table>';

    return $table_html;
}


/*
 * This function will handle saving unregistered foods that were entered in the 
 * recipe
 */
function save_unregistered_foods()
{
    return null;
}


/*
 * get_user_pantry_foods()
 * =======================
 *
 * takes the foods that were saved in the user's pantry and returns them in an 
 * array of the form:
 *      array(
 *          'esha_food_id_code' => {food object}
 *          ...
 *      )
 *
 * @param   - null
 * @return  - saved_foods   - the associative array containing all the food 
 *                              objects stored in the user's pantry
 */
function get_user_pantry_foods()
{
    $saved_foods = array();
    $queried_foods = db_fetch_saved_foods();


    foreach( $queried_foods as $food )
    {
        $food_id = $food['id'];
        $saved_foods[$food_id] = $food;
    }

    // var_dump($saved_foods); //DEBUG

    return $saved_foods;
}


/*
 * Queries the SQL database to find the foods saved in the user's pantry
 * Returns the saved foods from the db if they exist.  
 *
 * @param   - null
 *
 * @return  - $queried foods    - the user's foods stored in the format of the 
 *                                  database
 * @return  - false             - if an error occurred while polling the database
 * @return  - null              - if the user has no stored foods
 */
function db_fetch_saved_foods()
{
    //TODO: put this query method into another file as a function to keep 
    //the code DRY
    
    $conn = new PDO( 
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, 
        SQL_USERNM, 
        SQL_PSWD );

    $sql = 'SELECT * FROM t_foods WHERE user_id = ?';
    $query = $conn->prepare( $sql ); 
    $query_error = query_has_error( $query );

    if( $query_error ) 
    {
        return false;
    }

    $params = array( $_SESSION[ 'user_id' ] );

    $result = $query->execute( $params ); 
    $query_error = query_has_error( $result );

    if( $query_error ) 
    {
        return false;
    }
    
    //close the connection by setting it to null
    $conn = null; 

    return $queried_foods = $query->fetchAll( PDO::FETCH_ASSOC ); 
}

/*
 * query_has_error()
 * ===================
 *
 * sees if there is an error with the statement returned after querying the SQL 
 * db
 */
function query_has_error( $statement )
{
    if( !$statement )
    {
	echo 'Query preparation failed! - (' . $statement->errno . ') ' . 
            $statement->error;
        return true;
    }

    return false;
}


/**
 * create_recipe_input()
 * =====================
 * 
 * Makes the html code for the entire input form for the recipe page
 *
 * @return  - $form_html    - the html for the input form
 */
function create_recipe_input()
{
    //it should be noted that for all these inputs, the one that will 
    //ultimately be most important is the input "ingredient_list".  It will 
    //contain the JSON for all the information submitted to the server

    //Recipe name
    $form_html = '<h2><label for="recipe_name">Recipe Name</h2>';
    $form_html .= '<form name="input" action="' . BASE_URL . 'new_recipe.php' . 
        '" method="post">'; 
    $form_html .= '<input type="text" name="recipe_name" id="recipe_name" 
        size="70">';

    //The ingredients list
    $form_html .= '<h2>Ingredients</h2>';
    $form_html .= '<input type="hidden" id="ingredient_list" 
        name="ingredient_list" value="">';     
    $form_html .= '<input type="hidden" id="new_foods_present" 
        name="new_foods_present" value="false">'; 
    $form_html .= create_ingredients_table();

    //Button to display more ingredients for the user to enter
    $form_html .= '<a href=# id="more_ingredients">Add more 
        ingredients</a>';

    //Recipe instructions
    $form_html .= '<h2><label for="instructions">Recipe Instructions</h2>';
    $form_html .= '<textarea rows="9" cols="65" name="instructions" 
        id="instructions"></textarea>'; 
    $form_html .= '<br />';

    //Recipe yield
    $form_html .= '<p>Recipe yields <input type="text" name="meal_yield"> 
        portions.</p>';

    //Form submission
    $form_html .= '<input type="submit" id="submit_btn" value="Save Recipe">';
    $form_html .= '<input type="checkbox" name="save_unregistered_foods" 
        checked>Store all new ingredients in My Pantry'; //TODO: if this is 
        // unchecked and there are new ingredients entered, make an alert 
        // message pop up asking them if they're sure they want to proceed 
        // without saving the foods.

    $form_html .= '</form>';

    return $form_html; 
}


/*
 * create_ingredients_table()
 * ==========================
 *
 * Makes the html for displaying the table containing all the ingredient 
 * entries
 *
 * @param   - null
 * @return  - $table_html   - the html code for the ingredients table
 */
function create_ingredients_table()
{
    global $common_units;
    $table_html = '<table id="ingredient_list">';

    //the table headers
    $table_html .= '<tr>';
    $table_html .= '<th>Ingredient Name</th>';
    $table_html .= '<th>Amount</th>';
    $table_html .= '<th>Unit</th>';
    $table_html .= '</tr>';

?>


    <?php
    for( $i = 0; $i < DEFAULT_FIELD_AMOUNT; $i++ )
    {
	$table_html .= '<tr id="ingredient_row_' . $i . '">';
	$table_html .= '<td><input type="text" class="recommendation jsonify" 
            name="' . $i . '_ing_name" id="ing_' . $i . '_name"></td>';
	$table_html .= '<td><input type="text" class="jsonify" name="' . $i . 
            '_ing_amt" id="ing_' . $i . '_amt"></td>';
	$table_html .= '<td>';
        $dropdown_attr = array(
            'class'     => 'jsonify',
            'name'      => $i . '_ing_unit',
            'id'        => $i . '_ing_unit'
        );
        $table_html .=       create_serving_units_dropdown( $dropdown_attr, 
            $common_units );
        $table_html .= '</td>';
	$table_html .= '</tr>';
    }
    $table_html .= '</table>';

    return $table_html;
}


/**
 * create_ingredient_js()
 * ================
 *
 * puts the javascript for the ingredient form on screen
 */
function create_ingredient_js()
{
    global $common_units;
    global $code_to_unit_table;
    $js = '<script>';

    //add the units available to esha straight into the 'saved_foods' session 
    //variable.  They are stored in an array called $available_units in the 
    //form <esha_unit_code> => <unit name>
    foreach( $_SESSION['saved_foods'] as & $saved_food )
    {
        $food_esha_info = json_decode(stripslashes($saved_food['json_esha']) );
        $coded_available_units = $food_esha_info->units;
        $available_units = array();
        foreach( $coded_available_units as $unit_code )
        {
            $available_units[$unit_code] = $code_to_unit_table[$unit_code];
        }
        $saved_food['available_units'] = $available_units;
    }
    
    // numIngredients           = the number of ingredients displayed
    // unitList                 = array containing the list of common 
    //                              measurement units
    // savedFoods               = list of the foods saved in the user's pantry
    // foodRecommendationPath   = path to the file for ajax to call to get food 
    //                              recommendations
    $js .= 'var numIngredients =  '.json_encode( DEFAULT_FIELD_AMOUNT ).';';
    $js .= 'var unitList = '.json_encode( $common_units ).';';
    $js .= 'var savedFoods ='. json_encode($_SESSION['saved_foods']).';';
    $js .= 'var foodRecommendationPath = "'.
        INCLUDE_PATH_BASE .'food_recommendation.php";';

    $js .= '</script>';

    $js .= '<script src=' . RECIPE_PATH . 'recipe.js></script>';

    return $js;
}


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%							        	%
//% 			   POST handling				%
//%									%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if( $_SERVER["REQUEST_METHOD"] == "POST")
{
    require_once INCLUDE_PATH . 'esha.php';

    //After the user has submitted the information for the recipe
    if( $_POST['save_unregistered_foods'] == 'on' AND 
        $_POST['new_foods_present'] == 'true' )
    {
        save_unregistered_foods();
        echo "saving unregistered foods";
        //TODO: display menu for saving unregistered foods -- do the 
        //autocomplete for new_foods.php before doing this
    }

    else //if all the foods in the recipe are already registered
    {
        $table_html = make_cost_table();
        echo $table_html;
    }
}

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%							        	%
//% 			   non-POST handling				%
//%									%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
else
{
    require_once( UNITS_TABLE_PATH );

    $saved_foods = get_user_pantry_foods();
    $_SESSION['saved_foods'] = $saved_foods;

    $body_html = create_recipe_input();
    echo $body_html;

    echo create_ingredient_js();
}

include( FOOTER_PATH ); 

