$.getScript("/inc/autocomplete.js", function(){

  /**
  *	moreIngredients()
  *	=================
  *
  *	Function that adds more ingredient fields to the ingredients table on
  *	the page.  The number added is stored in the variable extraRowAmount;
  *
  */
  //TODO: incorporate this with the
  //units_table.php->create_units_dropdown() function to keep the code DRY
  $("#more_ingredients").click( function() {

    //extraRowAmount = The number of rows to increase the ingredients
    //table by lastRow = the jquery object for the last row in the
    //ingredient list
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
          'name="'+rowNum + '_ing_amt" id="ing_' + rowNum
          + '_amt">' + '</td>';
	      ingredientRows = ingredientRows + 
          '<td><select class="jsonify" name="' + rowNum
          + '_ing_unit" ' + 'id="ing_' + rowNum + '_unit">';

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


  /**
  *   refreshJQuery()
  *   ===============
  *
  *   Takes all of the elements in the ingredients sections and refreshes
  *   the jquery on them. This is used for when the user clicks "Add more
  *   ingredients".  This makes sure that the new ingredient boxes work as
  *   properly (i.e. have autocorrect functionality, they convert their
  *   values to json, etc.)
  *
   */
  function refreshJQuery()
  {
    autocompleteFactory( 
      0, '.recommendation', savedFoodRecommendationPath 
    );
    refreshJSONify();
  }


  /**
   * refreshJSONify()
   * ================
   *
   * reapplies the ability to convert the ingredients to json on all
   * fields in the ingredients list.
   *
   * This is used when the "add more ingredients" button in pressed, which
   * would make them not have the jsonify feature on them.  This makes
   * sure that jsonify gets applied to them as well.
   */
  function refreshJSONify()
  {
    //TODO: make all of this happen when the submit button is pressed
    //instead of when blurred
    //TODO: implement form validation.  If any field is blank while
    //others in its row are not, make an error
    
    // JSONify the ingredient list when one of the ingredient fields
    // loses focus
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

      // TODO: this may be a little inefficient. find a faster way of
      // doing this
      
      //look through all the foods in $_SESSION['saved_foods'] to find
      //which name matches the one created. If an element is found
      //that matches the one that was just selected by the user, save
      //that foods' id number in the ingredients array
      $.each( savedFoods, function( i, savedFood ){
        if( savedFood['user_def_food_name'] == ingredients[num]['name'] )
        {
          ingredients[num]['food_id'] = savedFood['id']; 
        }
      });

      $("#ingredient_list").val( JSON.stringify(ingredients) );
    });
  }


  //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
  //%		                                              					        	
  //% 			                      MAIN CODE                                     
  //%							                                                     		
  //%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
  //ingredients will store the ingredients list for this recipe
  var ingredients = new Array(); 

  refreshJQuery();

  $("#submit_btn").click( function(){
    $.each( ingredients, function( ingredientIndex, ingredient ){
      if( ingredient['food_id'] == null ) {
        $("#new_foods_present").val("true");
      }
    });
  });

});
