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
            'esha_info'     => json_decode(
                                stripslashes($result['json_esha']))
        );
    }

    return $foods;
}



/**
 * create_js_variables()
 * =====================
 *
 * creates the <script> tags for javascript which will export the passed 
 * php variables to the javascript in the page
 *
 * @param       - $php_vars         - an array of the following form:
 *                                      array(
 *                                          array('var_name' => php_var),
 *                                          ...
 *                                      )
 *
 * @return      - $js           -a string with <script> tags containing 
 *                                  the variables in json form
 */
function create_js_variables( $php_vars )
{
    $js = '<script>';
    foreach ($php_vars as $name => $php_var) {
        $js .= 'var '.$name.' = '.json_encode($php_var).';';
    }
    $js .= '</script>';

    return $js;
}



/**
* make_food_list()
* ================
 */
function make_food_list( $food_list )
{
    $html = '<div id="accordion">';
        
    foreach( $food_list as $food )
    {
        $html .= '<h3>'.$food['name'].'</h3>';
        $html .= '<div>'.$food['name'].'</div>';
    }

    $html .= '</div>';

    return $html;
}


//=====================================================================
//                          MAIN CODE
//=====================================================================

$body_html = '';

$foods = get_foods( $db );
$body_html .= make_food_list( $foods );
$body_html .= create_js_variables( array( 'foods' => $foods ) );

$body_html .= '<script src="'.BASE_URL.'view_foods.js"></script>';
echo $body_html;


include( FOOTER_PATH ); 

