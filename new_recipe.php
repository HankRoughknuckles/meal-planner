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
	var_dump( $_POST );
}

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%																			%
//%							non-POST handling								%
//%																			%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
else
{
	$body_html = '<h2><label for="recipe_name">Recipe Name</h2>';
	$body_html .= '<form name="input" action="' . BASE_URL . 'new_recipe.php' . '" method="post">'; //concatenate this to $body_html
	$body_html .= '<input type="text" name="recipe_name" id="recipe_name" size="70">';
	$body_html .= '<h2>Ingredients</h2>';

	$body_html .= '<table>';
	$body_html .= '<tr>	';
	$body_html .= '<th>Amount</th>';
	$body_html .= '<th>Unit</th>';
	$body_html .= '<th>Ingredient Name</th>';
	$body_html .= '</tr>';

	if( !isset( $field_offset ) ){ $field_offset = 0; }
	?>

	<!-- Save the current number of ingredient fields present on the screen in case we need to add more -->
	<script>
		var numIngredients =  <?php echo json_encode( DEFAULT_FIELD_AMOUNT + $field_offset ) ?>;
	</script>

	<?php
	//TODO: use AJAX to suggest saved foods based on what the user types
	for( $i = 0; $i < DEFAULT_FIELD_AMOUNT + $field_offset; $i++ )
	{
		$body_html .= '<tr>';
		$body_html .= '<td><input type="text" name="ing_' . $i . '_amt" id="ing_' . $i . '_amt"></td>';
		$body_html .= '<td><input type="text" name="ing_' . $i . '_unit" id="ing_' . $i . '_unit"></td>';
		$body_html .= '<td><input type="text" name="ing_' . $i . '_name" id="ing_' . $i . '_name"></td>';
		$body_html .= '</tr>';
	}
	$body_html .= '</table>';
	

	//Button to display more ingredients for the user to enter
	$body_html .= '<a href=# onclick="moreIngredients()">Add more ingredients</a>';
	// $body_html .= '<input type="submit" name="more_ingredients_button" value="Add more ingredients">';


	$body_html .= '<h2><label for="instructions">Recipe Instructions</h2>';

	$body_html .= '<textarea rows="9" cols="65" name="instructions" id="instructions"></textarea>'; 
	$body_html .= '<br />';

	$body_html .= '<input type="submit" value="Save Recipe">';
	$body_html .= '<input type="checkbox" name="save_unregistered_foods">Store all ingredients in My Pantry';
	$body_html .= '</form>';

	echo $body_html;

	?>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script>
		function moreIngredients()
		{
			alert("you touched a button!");

			$("#ing_9_name").attr("value", "hi!"); //DEBUG
			var ingPrefix = "#ing_" + (numIngredients) + "_";
			var endIngredient = $( "#ing_" + (numIngredients - 1) + "_name" ); //select the last ingredient in the list

			endIngredient.attr("value", "second time");	 //DEBUG


			endIngredient.append( $("<p>HI!</p>") );
			// endIngredient.append( $('<td><input type="text" name="' + ingPrefix + 'name" id="' + ingPrefix + 'name"></td>'))
		}
	</script>

<?php
}

include( FOOTER_PATH ); 

