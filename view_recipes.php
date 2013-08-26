<?php
$pageTitle = "Recipes";

require_once "/inc/config.php";
require_once DB_PATH;
require_once LIB_PATH.'accordion.php';

include HEADER_PATH;

session_start();
//=====================================================================
//                          FUNCTIONS
//=====================================================================
/*
 * populate_recipe_list()
 * ==========================
 *
 * This creates the ingredient list to be sent to the 
 * make_accordion_menu() in inc/libs/accordion.php
 *
 * @param   - $recipes     - array of Ingredient objects
 *
 * @returns - $recipe_list - a multi-dimensional array of the form:
 *                           array(
 *                               'recipe_name_a' => array(
 *                                   'cost'      => '<cost table html>'
 *                                   'calories'  => '<calorie table html>'
 *                               )
 *
 *                               'recipe_name_b' => array(
 *                                   'cost'      => '<cost table html>'
 *                                   'calories'  => '<calorie table html>'
 *                               )
 *                               ...
 *                           )
 */
function populate_recipe_list( $recipes )
{
    $recipe_list = array();

    foreach ( $recipes as $recipe ) 
    {
        $ing_list = '';
        $ing_strings = $recipe->get_ingredient_strings();
        $name = $recipe->get_name();

        foreach ($ing_strings as $ing_string) 
        {
            $ing_list .= '<p>'.$ing_string.'</p>';
        }

        $recipe_list[$name] = array(
            'cost'          => '$'.$recipe->get_cost(),
            'calories'      => $recipe->get_calories().' kCal', //TODO: FIX THIS
            'ingredients'   => $ing_list,
            'instructions'  => $recipe->get_instructions(),
            'yield'         => $recipe->get_yield()
        );

    }

    return $recipe_list;
}


//=====================================================================
//                          MAIN CODE
//=====================================================================
$body_html = '';
$db = new Database_handler();

//get the ingredients and put them into the accordion menu
$recipes = $db->get_recipes( USER_ID );
$recipe_list = populate_recipe_list( $recipes );
$body_html .= make_accordion_menu( 'accordion', $recipe_list );


$body_html .= '<script src="'.BASE_URL.'view_recipes.js"></script>';


echo $body_html;

include( FOOTER_PATH ); 
