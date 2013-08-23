<?php
$pageTitle = "Recipes";

require_once "/inc/config.php";
require_once DB_PATH;

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
        $name = $recipe->get_name();

        $recipe_list[$name] = array(
            'cost'          => print_cost_table( $recipe ),
            'calories'      => print_calorie_table( $recipe ),
            'ingredients'   => $recipe->get_ingredients(),
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
