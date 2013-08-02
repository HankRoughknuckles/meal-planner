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

            $.each( unitList, function( index, unit ){
                if( unit ) 
                {
                    ingredientRows = ingredientRows +  '<option value="' + unit + '">' + unit + '(s)</option>';
                }
                else
                {
                    ingredientRows = ingredientRows +  '<option value="' + unit + '">' + unit + '</option>'; //dont display the (s) if the field is blank
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
    
    //TODO: make all of this happen when the submit button is pressed instead of when blurred
    //TODO: implement form validation.  If any field is blank while others in its row are not, make an error
    // JSONify the ingredient list when one of the ingredient fields loses focus
    $(".jsonify").blur(function(){
        if( $(this).val() === "" )
        {
            return;
        }

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
        ingredients[num][type] = $(this).val();

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
        console.log( ingredients );
    });
}

refreshJQuery();

$("#submit_btn").click( function(){
    
    $.each( ingredients, function( ingredientIndex, ingredient ){
        if( ingredient['food_id'] == null )
        {
            $("#new_foods_present").val("true");
        }
    });

    console.log( ingredients );
});

