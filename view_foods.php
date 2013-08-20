<?php
require_once("/inc/config.php");
$pageTitle = "Foods";

include( HEADER_PATH );
require_once DB_PATH;
require_once UNITS_TABLE_PATH;

$db = new Database_handler();


//=====================================================================
//                          FUNCTIONS
//=====================================================================
/**
 * get_foods()
 * ===========
 * Retrieve all foods from the db. Return them all in array format
 *
 * @param   - $db       - a Database_handler object
 *
 * @returns - $foods    - the array of saved foods.  Each element has the 
 *                          following structure:
 *                          array(
 *                              'id',
 *                              'esha_food_id',
 *                              'name'
 *                              'serving_size'
 *                              'serving_units'
 *                              'cost'
 *                              'calories'
 *                              'esha_info'
 *                          )
 */
function get_foods( $db )
{
    global $db;
    global $code_to_unit_table;
    $foods = array();

    $command = "SELECT * FROM t_foods";
    $results = $db->query_table( $command );

    foreach( $results as $result )
    {
        $foods[$result['id']] = array(
            'id'            => $result['id'],
            'esha_food_id'  => $result['esha_food_id'],
            'name'          => $result['user_def_food_name'],
            'serving_size'  => $result['serving_size'],
            'serving_units' => 
                $code_to_unit_table[$result['serving_units_esha']],
            'cost'          => $result['cost'],
            'calories'      => $result['calories'],
            'esha_info'     => json_decode(stripslashes($result['json_esha']))
        );
    }

    return $foods;
}



/**
* make_food_list()
* ================
 */
function make_food_list( $food_list )
{
    foreach( $food_list as $food )
    {

    }
}


//=====================================================================
//                          MAIN CODE
//=====================================================================

$foods = get_foods( $db );
make_food_list( $foods );

include( FOOTER_PATH ); 

