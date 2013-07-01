<?php
require_once("/inc/config.php");

$pageTitle = "New Recipe";
include( HEADER_PATH );

define( 'DEFAULT_FIELD_AMOUNT', 	10 ); //the number of ingredient fields to be displayed by default on page load-up.



//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																			%
//%								POST handling								%
//%																			%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if( $_SERVER["REQUEST_METHOD"] == "POST")
{

}

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																			%
//%							non-POST handling								%
//%																			%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
else
{
	$body_html = '<h2><label for="recipe_name">Recipe Name</h2>';
	$body_html = $body_html . '<form name="input" action="' . BASE_URL . 'new_recipe.php' . '" method="post">';
	$body_html = $body_html . '<input type="text" name="recipe_name" id="recipe_name" size="70">';
	$body_html = $body_html . '<h2>Ingredients</h2>';

	$body_html = $body_html . '<table>';
	$body_html = $body_html . '<tr>	';
	$body_html = $body_html . '<th>Amount</th>';
	$body_html = $body_html . '<th>Unit</th>';
	$body_html = $body_html . '<th>Ingredient Name</th>';
	$body_html = $body_html . '</tr>';

	if( !isset( $field_offset) ){ $field_offset = 0; }

	//TODO: use AJAX to suggest saved foods based on what the user types
	for( $i = 1; $i <= DEFAULT_FIELD_AMOUNT; $i++ )
	{
		$body_html = $body_html . '<tr>';
		$body_html = $body_html . '<td><input type="text" name="ing_' . $i . '_amt"></td>';
		$body_html = $body_html . '<td><input type="text" name="ing_' . $i . '_unit"></td>';
		$body_html = $body_html . '<td><input type="text" name="ing_' . $i . '_name"></td>';
		$body_html = $body_html . '</tr>';
	}
	$body_html = $body_html . '</table>';
	

	$body_html = $body_html . '<input type="submit" value="Add more ingredients">';


	$body_html = $body_html . '<h2><label for="instructions">Recipe Instructions</h2>';

	$body_html = $body_html . '<textarea rows="9" cols="65" name="instructions" id="instructions"></textarea>'; //TODO: double check that the information entered in here will show up in the _POST variable
	$body_html = $body_html . '<br />';

	$body_html = $body_html . '<input type="submit" value="Save Recipe">';
	$body_html = $body_html . '<input type="checkbox" name="save_unregistered_foods">Store all ingredients in My Pantry';
	$body_html = $body_html . '</form>';

	echo $body_html;

}

include( FOOTER_PATH ); 

