/**
*	moreIngredients()
*	=================
*
*	Function that adds more ingredient fields to the ingredients table on the page.
*	The number added is stored in the variable extraRowAmount;
*
*/
//TODO: incorporate this with the units_table.php->create_units_dropdown() function to keep the code DRY
$("#more_ingredients").click( function() {

    //extraRowAmount = The number of rows to increase the ingredients table by
    //lastRow = the jquery object for the last row in the ingredient list
    var extraRowAmount = 10; 
    var lastRow = $( "#ingredient_row_" + (numIngredients - 1) ); 

    //insert {extraRowAmount} of rows after the last row in the table
    lastRow.after( function() {
	ingredientRows = "";
	var rowNum;
	for( var i = 0; i < extraRowAmount; i++ )
	{
	    rowNum = numIngredients + i;
	    ingredientRows = ingredientRows + 
                '<tr id="ingredient_row_' + rowNum + '">';
	    ingredientRows = ingredientRows + 
                '<td><input type="text" ' + 
                'class="recommendation jsonify ui-autocomplete-input" ' +  
                'type="text" name="' + rowNum + '_ing_name" id="ing_' + 
                rowNum + '_name" autocomplete="off"></td>';
	    ingredientRows = ingredientRows + 
                '<td><input class="jsonify" type="text" ' + 
                'name="' + rowNum + '_ing_amt" id="ing_' + rowNum + '_amt">' + 
                '</td>';
	    ingredientRows = ingredientRows + 
                '<td><select class="jsonify" name="' + rowNum + '_ing_unit" ' +
                'id="ing_' + rowNum + '_unit">';

            $.each( unitList, function( index, unit ){
                if( unit ) 
                {
                    ingredientRows = ingredientRows +  
                        '<option value="' + unit + '">' + unit +
                        '(s)</option>';
                }
                else
                {
                    //dont display the (s) if the field is blank
                    ingredientRows = ingredientRows +  
                        '<option value="' + unit + '">' + unit + 
                        '</option>'; 
                }
            });
            
            ingredientRows = ingredientRows + '</td>';
	    ingredientRows = ingredientRows + '</tr>';
	}

	return ingredientRows;
    });

    refreshJQuery();
    numIngredients += extraRowAmount;
});


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

    //----------------------------------------------------------------------------
    //                              Autocomplete
    //----------------------------------------------------------------------------
    //set up the category autocomplete widget
    $.widget( "custom.catcomplete", $.ui.autocomplete, {
	_renderMenu: function( ul, items ) {
	    var that = this,
	    currentCategory = "";
	    $.each( items, function( index, item ) {
		if ( item.category != currentCategory ) {
		    ul.append( "<li class='ui-autocomplete-category'>" + 
                        item.category + "</li>" );
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
		    url: foodRecommendationPath,
		    method: "GET",
		    dataType: "json",
		    data: {
			    user_input: request.term
		    },
		    success: function( data ){
                displayData = new Array; 
                //TODO: build the array to display and also the hidden
                //one to store the food id


                //take the category and label values from the ajax
                //returned data, and put them into displayData
                $.each( data, function( index, value ){
                    displayData.push({ 
                        'category'  : value['category'],
                        'label'     : value['label']
                    });
                });
			    response( displayData );
		    }
	    });
	},
	
	
	//TODO: eventually make this have the functionality to display a box
    //around the text in the ingredient field if it was selected.
    //clicking that box will delete the food in the entry
	select:
	    function(e, ui) {
		    var nameOfSelectedFood = ui.item.value;
            var currentIngredientIndex =
                $(this).attr("name").substring(0,1);
            var matchedFood;
            var unitsDropdownMenu = $( "#"+ currentIngredientIndex + "_ing_unit" );

            //TODO: find a faster way to do this
            //find the food from the db that matches the selection
            $.each( savedFoods, function( i, savedFood ){
                if( savedFood['user_def_food_name'] === nameOfSelectedFood ){
                    matchedFood = savedFood;
                }
            });

            console.log( "matchedFood = %o", matchedFood );

            //remove all existing unit options and replace them with the
            //ones that esha offers for this particular food.
            unitsDropdownMenu.children().remove();
            populateUnitsMenu(unitsDropdownMenu, matchedFood);
	    }//,

    // change:
    //     function(){
    // 	//prevent 'recommendation' field from being updated. Also,
    // 	//correct the position
    // 	$(".recommendation").val("").css("top", 2);
    //     }
    }); //END autocomplete


    refreshJSONify();
}



function populateUnitsMenu( menu, food )
{
    menu.append("<option value></option>");
    $.each( food.available_units, function( code, unit )
        {
            if( unit.toLowerCase() === "each" )
            {
                menu.append('<option value="' +
                    unit + '">' + unit + "</option>");
            }
            else
            {
                menu.append('<option value="' +
                    unit + '">' + unit + '(s)</option>');
            }
    });
}

/**
 * refreshJSONify()
 * ================
 *
 * reapplies the ability to convert the ingredients to json on all fields in
 * the ingredients list.
 *
 * This is used when the "add more ingredients" button in pressed, which would
 * make them not have the jsonify feature on them.  This makes sure that
 * jsonify gets applied to them as well.
 */
function refreshJSONify()
{
    //TODO: make all of this happen when the submit button is pressed instead
    //of when blurred
    //TODO: implement form validation.  If any field is blank while others in
    //its row are not, make an error
    
    // JSONify the ingredient list when one of the ingredient fields loses focus
    $(".jsonify").blur(function(){
        if( $(this).val() === "" )
        {
            return;
        }

        //build the name for the input field
        var input = $(this).attr('name'); 
        var num = input.substr(0, input.indexOf("_"));    
        input = input.substr( input.indexOf("_") + 1); 
        var type = input.substr( input.indexOf("_") + 1);
        
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
        
        //look through all the foods in $_SESSION['saved_foods'] to find which
        //name matches the one created. If an element is found that matches the
        //one that was just selected by the user, save that foods' id number in
        //the ingredients array
        $.each( savedFoods, function( i, savedFood ){
            if( savedFood['user_def_food_name'] == ingredients[num]['name'] )
            {
                ingredients[num]['food_id'] = savedFood['id']; 
            }
        });

        $("#ingredient_list").val( JSON.stringify(ingredients) );
        // console.log( ingredients );
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

    // console.log( ingredients );
});

