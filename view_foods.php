<?php
require_once("/inc/config.php");
$pageTitle = "Foods";

include( HEADER_PATH );
require_once DB_PATH;
require_once LIB_PATH.'javascript.php';
require_once LIB_PATH.'accordion.php';

$db = new Database_handler();


//=====================================================================
//                          FUNCTIONS
//=====================================================================
//TODO: FINISH THIS
function populate_food_list( $foods )
{
    $food_list = array();

    foreach( $foods as $food )
    {
        $name = $food['name'];
        $food_list[$name] = array();

        $food_list[$name]['cost'] = print_cost_table($food);
        $food_list[$name]['calories'] = print_calorie_table($food);
    }

    return $food_list;
}


/**
 * print_cost_table()
 * ==================
 *
 * Makes the html for a food giving the amount of the food and how much it 
 * costs
 */
function print_cost_table( $food )
{
    //TODO: eventually merge this into one single method with 
    //print_calorie_table to have one flexible function that can print any 
    //type of table
    $amt = round( $food['serving_size'], 2 );
    $unit = $food['serving_units'];
    $cost = round($food['cost'], 2);

    if( $amt != 1 )
    {
        $unit .= 's';
    }

    if( strtolower($unit) == "each" OR strtolower($unit) == "eachs" )
    {
        $unit = '';
    }

    $table_html = '<table border="1">';
    $table_html .= '<tr><th>Amount</th><th>Cost</th></tr>';
    $table_html .= '<td>'.$amt.' '.$unit.'</td>';
    $table_html .= 
        '<td>$'.number_format( (float)$cost, 2, '.', '').'</td>';
    $table_html .= '</table>';

    return $table_html;
}



/**
 * print_calorie_table()
 * =====================
 *
 * Makes the html for a food giving the amount of the food and how many 
 * calories it has
 */
function print_calorie_table( $food )
{
    //TODO: eventually merge this into one single method with 
    //print_cost_table to have one flexible function that can print any 
    //type of table
    $amt = round( $food['serving_size'], 2 );
    $unit = $food['serving_units'];
    $calories = round($food['calories'], 2);

    if( $amt != 1 )
    {
        $unit .= 's';
    }

    if( strtolower($unit) == "each" OR strtolower($unit) == "eachs" )
    {
        $unit = '';
    }

    $table_html = '<table border="1">';
    $table_html .= '<tr><th>Amount</th><th>Calories</th></tr>';
    $table_html .= '<td>'.$amt.' '.$unit.'</td>';
    $table_html .= '<td>'.$calories.'</td>';
    $table_html .= '</table>';

    return $table_html;
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

$foods = $db->get_foods();
$food_list = populate_food_list( $foods );
$body_html .= make_accordion_menu( 'accordion', $food_list );
// echo '<pre>'; var_dump($body_html); echo '</pre>'; die();
$body_html .= create_js_variables( array( 'foods' => $foods ) );

$body_html .= '<script src="'.BASE_URL.'view_foods.js"></script>';
echo $body_html;


include( FOOTER_PATH ); 

