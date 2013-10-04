<?php
require_once("/inc/config.php");
require_once DB_PATH;
require_once LIB_PATH.'javascript.php';
require_once LIB_PATH.'accordion.php';
require_once HELPERS_PATH;

display_page_header("Foods");

//=====================================================================
//                          FUNCTIONS
//=====================================================================
/*
 * populate_food_list()
 * ====================
 *
 * This creates the food list to be sent to the make_accordion_menu() in 
 * inc/libs/accordion.php
 *
 * @param   - $foods     - array of Food objects
 *
 * @returns - $food_list - a multi-dimensional array of the form:
 *                           array(
 *                               'food_name_a' => array(
 *                                   'cost'      => '<cost table html>'
 *                                   'calories'  => '<calorie table html>'
 *                               )
 *
 *                               'food_name_b' => array(
 *                                   'cost'      => '<cost table html>'
 *                                   'calories'  => '<calorie table html>'
 *                               )
 *                               ...
 *                           )
 */
function populate_food_list( $foods )
{
    $food_list = array();

    foreach( $foods as $food )
    {
        $name = $food['name'];
        $food_list[$name] = array();

        $food_list[$name]['cost'] = array( print_cost_table($food) );
        $food_list[$name]['calories'] = 
            array ( print_calorie_table($food) );
    }

    return $food_list;
}


/*
 * get_printable_unit()
 * ====================
 */
function print_cost_sentence( $food )
{
//TODO: eventually put this into the Food class
    $output = 'default output';
    $amt = $food['serving_size'];
    $unit = $food['serving_units'];
    $name = strtolower($food['name']);
    $cost = round($food['cost'], 2);

    // $amt = 2;
    // $unit = 'cup';
    // $name = 'Cucumber';


    if ( strtolower($unit) == 'each' )
    {
        if( $amt != 1 )
        {
            $output = $amt.' '.$name.'s'.' cost $'.$cost;
        }
        else
        {
            $output = $amt.' '.$name.' costs $'.$cost;
        }
    }
    else
    {
        if ( $amt != 1 ) 
        {
            $output = $amt.' '.$unit.'s of '.$name.'s'.' cost $'.$cost;
        }
        else
        {
            $output = $amt.' '.$unit.' of '.$name.'s'.' costs $'.$cost;
        }
    }

    return $output;
}


//=====================================================================
//                          MAIN CODE
//=====================================================================

$body_html = '';
$db = new Database_handler();

//get the foods and put them into the accordion menu
$foods = $db->get_foods();
$food_list = populate_food_list( $foods );
$body_html .= make_accordion_menu( 'accordion', $food_list );

$body_html .= '<script src="'.BASE_URL.'view_foods.js"></script>';
echo $body_html;


include( FOOTER_PATH ); 

