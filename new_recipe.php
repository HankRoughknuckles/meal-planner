<?php
require_once("/inc/config.php");
require_once( LOGIN_PATH );

session_start();

//Display the header
$pageTitle = "New Recipe";
include( HEADER_PATH );

// Define constants
define( 'DEFAULT_FIELD_AMOUNT', 	10 ); //the number of ingredient fields to be displayed by default on page load-up.

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%							        	%
//% 			   POST handling				%
//%									%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if( $_SERVER["REQUEST_METHOD"] == "POST")
{
    //After the user has submitted the information for the recipe
    if( $_POST['save_unregistered_foods'] == 'on' AND $_POST['new_foods_present'] == 'true' )
    {
        echo "saving unregistered foods";
        //TODO: display menu for saving unregistered foods -- do the autocomplete for new_foods.php before doing this
    }

    else //if all the foods in the recipe are already registered
    {
        echo "posting food calorie and cost information";

        $body_html = '<table>';
        $body_html .=   '<tr>';
        $body_html .=       '<th>Amount</th>';
        $body_html .=       '<th>Food</th>';
        $body_html .=       '<th>Calories</th>';
        $body_html .=       '<th>Cost</th>';
        $body_html .=   '</tr>';
        $body_html = '</table>';

        echo $body_html;
    }
    var_dump($_POST);
}

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%							        	%
//% 			   non-POST handling				%
//%									%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
else
{
    require_once( UNITS_TABLE_PATH );

    //TODO: put this query method into another file as a function to keep the code DRY
    //using PDO prepared statements for SQL query
    $conn = new PDO( 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, SQL_USERNM, SQL_PSWD );

    $sql = 'SELECT * FROM t_foods WHERE user_id = ?';

    //the param to go into the ? in the $sql variable
    $params = array( $_SESSION[ 'user_id' ] );

    //prepare the sql statement
    $query = $conn->prepare( $sql ); 
    if( !$query )
    {
	    echo 'Query preparation failed! - (' . $query->errno . ') ' . $query->error;
    }

    //crank the parameters into the statement and execute
    $result = $query->execute( $params ); 
    if( !$result )
    {
	    echo 'Query execution failed! - (' . $result->errno . ') ' . $result->error;
    }

    $_SESSION['saved_foods'] = $query->fetchAll( PDO::FETCH_ASSOC ); //this will be used in food_recommendation.php to reduce the number of SQL queries
    // var_dump($_SESSION['saved_foods']); //DEBUG
    $conn = null; //close the connection by setting it to null


    $body_html = '<h2><label for="recipe_name">Recipe Name</h2>';
    $body_html .= '<form name="input" action="' . BASE_URL . 'new_recipe.php' . '" method="post">'; //concatenate this to $body_html
    $body_html .= '<input type="text" name="recipe_name" id="recipe_name" size="70">';
    $body_html .= '<h2>Ingredients</h2>';
    
    $body_html .= '<input type="hidden" id="ingredient_list" name="ingredient_list" value="">'; //the JSON array to be submitted to the server via POST
    $body_html .= '<input type="hidden" id="new_foods_present" name="new_foods_present" value="false">'; //the JSON array to be submitted to the server via POST
    $body_html .= '<table id="ingredient_list">';
    $body_html .= '<tr>	';
    $body_html .= '<th>Ingredient Name</th>';
    $body_html .= '<th>Amount</th>';
    $body_html .= '<th>Unit</th>';
    $body_html .= '</tr>';

    if( !isset( $field_offset ) )
    { 
        $field_offset = 0; //determines how many ingredient rows should be displayed
    }
    ?>

    <script>
    // Save the current number of ingredient fields present on the screen in case we need to add more in the javascript later
    var numIngredients =  <?php echo json_encode( DEFAULT_FIELD_AMOUNT + $field_offset ) ?>;
    </script>

    <?php
    for( $i = 0; $i < DEFAULT_FIELD_AMOUNT + $field_offset; $i++ )
    {
	    $body_html .= '<tr id="ingredient_row_' . $i . '">';
	    $body_html .= '<td><input type="text" class="recommendation jsonify" name="' . $i . '_ing_name" id="ing_' . $i . '_name"></td>';
	    $body_html .= '<td><input type="text" class="jsonify" name="' . $i . '_ing_amt" id="ing_' . $i . '_amt"></td>';
	    $body_html .= '<td>';
            $dropdown_attr = array(
                'class'     => 'jsonify',
                'name'      => $i . '_ing_unit'
            );
            $body_html .=       create_serving_units_dropdown( $dropdown_attr, $common_units );
            $body_html .= '</td>';
	    $body_html .= '</tr>';
    }
    $body_html .= '</table>';
    // $body_html .= '</div>'; //END ingredient_list div


    //Button to display more ingredients for the user to enter

    $body_html .= '<a href=# onclick="moreIngredients()">Add more ingredients</a>';
    // $body_html .= '<input type="submit" name="more_ingredients_button" value="Add more ingredients">';


    $body_html .= '<h2><label for="instructions">Recipe Instructions</h2>';

    $body_html .= '<textarea rows="9" cols="65" name="instructions" id="instructions"></textarea>'; 
    $body_html .= '<br />';

    $body_html .= '<p>Recipe yields <input type="text" name="meal_yield"> portions.</p>';
    $body_html .= '<input type="submit" id="submit_btn" value="Save Recipe">';
    $body_html .= '<input type="checkbox" name="save_unregistered_foods" checked>Store all new ingredients in My Pantry'; //TODO: if this is unchecked and there are new ingredients entered, make an alert message pop up asking them if they're sure they want to proceed without saving the foods.
    $body_html .= '</form>';

    echo $body_html;
    ?>

    <script>
    /**
    *	moreIngredients()
    *	=================
    *
    *	Function that adds more ingredient fields to the ingredients table on the page.
    *	The number added is stored in the variable extraRowAmount;
    *
    */
    //TODO: incorporate this with the units_table.php->create_units_dropdown() function to keep the code DRY
    function moreIngredients()
    {
	var extraRowAmount = 10; //The number of rows to increase the ingredients table by
	var lastRow = $( "#ingredient_row_" + (numIngredients - 1) ); //select the last row in the ingredient list

	//insert {extraRowAmount} of rows after the last row in the table
	lastRow.after( function() {
	    ingredientRows = "";
	    var rowNum;
            var unitList = <?php echo json_encode( $common_units ); ?>;
	    for( var i = 0; i < extraRowAmount; i++ )
	    {
		rowNum = numIngredients + i;
		ingredientRows = ingredientRows + '<tr id="ingredient_row_' + rowNum + '">';
		ingredientRows = ingredientRows + '<td><input type="text" class="recommendation jsonify ui-autocomplete-input" type="text" name="' + rowNum + '_ing_name" id="ing_' + rowNum + '_name" autocomplete="off"></td>';
		ingredientRows = ingredientRows + '<td><input class="jsonify" type="text" name="' + rowNum + '_ing_amt" id="ing_' + rowNum + '_amt"></td>';
		ingredientRows = ingredientRows + '<td><select class="jsonify" name="' + rowNum + '_ing_unit" id="ing_' + rowNum + '_unit">';

                $.each( unitList, function( index, value ){
                    if( value ) 
                    {
                        ingredientRows = ingredientRows +  '<option value="' + value + '">' + value + '(s)</option>';
                    }
                    else
                    {
                        ingredientRows = ingredientRows +  '<option value="' + value + '">' + value + '</option>'; //dont display the (s) if the field is blank
                    }
                });
                
                ingredientRows = ingredientRows + '</td>';
		ingredientRows = ingredientRows + '</tr>';
	    }

	    return ingredientRows;
	});

        refreshJQuery();
	numIngredients += extraRowAmount;
    }
    </script>


    <script>
    var ingredients = new Array(); //will store the ingredients list for this recipe
    /**
       refreshJQuery()
    *   =====================
    *
    *   Takes all of the elements in the ingredients sections and refreshes the 
    *   jquery on them. This is used for when the user clicks "Add more ingredients".  
    *   This makes sure that the new ingredient boxes work as properly (i.e. have 
    *   autocorrect functionality, they convert their values to json, etc.)
    *
     */
    function refreshJQuery()
    {

    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
    //%								        	%
    //% 			   Autocomplete					%
    //%										%
    //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
        //set up the category autocomplete widget
        $.widget( "custom.catcomplete", $.ui.autocomplete, {
	    _renderMenu: function( ul, items ) {
	        var that = this,
	        currentCategory = "";
	        $.each( items, function( index, item ) {
		    if ( item.category != currentCategory ) {
		        ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
		        currentCategory = item.category;
		    }
		    that._renderItemData( ul, item );
	        });
	    }
        });
        
        //attach the autocomplete to items that have class "recommendation"
        //TODO: make the autocomplete show  the matched characters in bold or underline
        $(".recommendation").catcomplete({
	    
	    //define callback to format results
	    source: function(request, response){
	        // console.log("request = %o", request);

	        $.ajax({
		        url: "<?php echo INCLUDE_PATH_BASE; ?>food_recommendation.php",
		        method: "GET",
		        dataType: "json",
		        data: {
			        user_input: request.term
		        },
		        success: function( data ){
                            // console.log("Response = %o", data); //DEBUG
                            displayData = new Array; //TODO: build the array to display and also the hidden one to store the food id

                            $.each( data, function( index, value ){
                                //take the category and label values from the ajax returned data, and put them into displayData
                                displayData.push({ 
                                    'category'  : value['category'],
                                    'label'     : value['label']
                                });
                            });
                            // console.log( "displayData = %o", displayData ); //DEBUG
			    response( displayData );
		        }
	        });
	    }//,
	    
	    
	    //TODO: eventually make this have the functionality to display a box around the text in the ingredient field if it was selected.  clicking that box will delete the food in the entry
	    //define select handler
	    // select:
	    //     function(e, ui) {
	    // 	//create formatted friend
	    // 	var 	food = ui.item.value;
	    // 	var	span = $("<span>").text(food);
	    // 	var 	a = $("<a>").addClass("remove").attr({
	    // 				href: "javascript:",
	    // 				title: "Remove " + food
	    // 			}).text("x").appendTo(span);

	    // 	//add food into the text box
	    // 	span.insertBefore(this);
	    //     },

	    // //define select handler
	    // change:
	    //     function(){
	    // 	//prevent 'recommendation' field from being updated. Also, correct the position
	    // 	$(".recommendation").val("").css("top", 2);
	    //     }
        }); //END autocomplete


        /**
        * jsonify stuff
        * =============
        */
        
        // JSONify the ingredient list
        $(".jsonify").blur(function(){
            var input = $(this).attr('name'); //this will have the format [num]_ing_[name, amt, unit]
            var num = input.substr(0, input.indexOf("_"));    //which number is assigned to the ingredient field
            // console.log("num = " + num ); //DEBUG

            input = input.substr( input.indexOf("_") + 1); //get rid of everything before the first underscore (the number)
            var type = input.substr( input.indexOf("_") + 1); //get rid of everything before the next underscore (a string containing "ing"). type tells you whether it's an ingredient name, unit, or amount
            
            // console.log("type  = " + type ); //DEBUG
            if( !ingredients[num] )
            {
                ingredients[num] = {
                    'name'      : null,
                    'food_id'   : null,
                    'amt'       : null,
                    'unit'      : null
                }
            }

            //put the value of the field into the ingredients variable
            if( $(this).val() === "" )
            {
                ingredients[num][type] = null; //put as null if it was left blank
            }
            else
            {
                ingredients[num][type] = $(this).val();
            }

            // TODO: this may be a little inefficient. find a faster way of doing this
            //look through all the foods in $_SESSION['saved_foods'] to find which name matches the one created
            $.each( <?php echo json_encode($_SESSION['saved_foods']); ?>, function( i, savedFood ){
                //if the currently checked element in saved_foods matches the one that was just selected by the user
                if( savedFood['user_def_food_name'] == ingredients[num]['name'] )
                {
                    ingredients[num]['food_id'] = savedFood['id']; //save the food's id number
                }
            });

            $("#ingredient_list").val( JSON.stringify(ingredients) );
            // console.log( ingredients );
        });
    }

    refreshJQuery();
    </script>

    <script>
    $("#submit_btn").click( function(){
        
        $.each( ingredients, function( ingredientIndex, ingredient ){
            if( ingredient['food_id'] == null )
            {
                $("#new_foods_present").val("true");
            }
        });
    });
    </script>


    <?php
}

include( FOOTER_PATH ); 

