<?php

//TODO: make an interface called Edible which contains all the things like 
//cost, calories, name, etc. and make this implement it
class Ingredient //extends Food
{
    //note: TODO: the lines that say "port this to food" mean to make them the 
    //fields in the food class, and then have Ingredient inherit them
    
    private $recipe_name; 
    private $recipe_db_id;  //the database id for the recipe this 
                            //ingredient belongs to
    private $preparation;   //the manner in which the ingredient should be 
                            // prepared, e.g.-chopped, or boiled, etc.

    private $name; //port this to food
    private $food_id;//port this to Food
    private $calories; //port this to food
    private $amt; //port this to food
    private $unit; //port this to food
    private $cost; //port this to food


    public function __construct( $input_array )
    {
        //set all the variables
        $this->recipe_name  = $input_array['recipe_name'];
        $this->recipe_db_id = $input_array['recipe_db_id'];
        $this->name         = $input_array['name'];
        $this->food_id      = $input_array['food_id'];
        $this->calories     = $input_array['calories'];
        $this->amt          = $input_array['amt'];
        $this->unit         = $input_array['unit'];
        $this->cost         = $input_array['cost'];

        //TODO: add constructor for preparation field
    }



    /*
     * to_string()
     * ===========
     *
     * Outputs the amount, unit, and name of the ingredient in the 
     * following form:
     *      2 chopped onions
     *
     *      or
     *
     *      1 cup of uncooked rice
     */
    public function to_string()
    {
        //TODO: finish this
        return $this->get_amt().' '.$this->get_unit().
            ' of '.$this->get_name();
    }



    //getter and setter functions
    //amount
    function get_amt(){
        return $this->amt;
    }
    function set_amt( $val ){
        $this->amt = $val;
    }

    //calories
    function get_calories(){
        return $this->calories;
    }
    function set_calories( $val ){
        $this->calories = $val;
    }

    //cost
    function get_cost(){
        return $this->cost;
    }
    function set_cost( $val ){
        $this->cost = $val;
    }

    //food_id
    function get_food_id(){
        return $this->food_id;
    }
    function set_food_id( $val ){
        $this->food_id = $val;
    }
    
    //name
    function get_name(){
        return $this->name;
    }
    function set_name( $val ){
        $this->name = $val;
    }
    
    //preparation
    function get_preparation(){
        return $this->preparation;
    }
    function set_preparation( $val ){
        $this->preparation = $val;
    }

    //recipe_db_id
    function get_recipe_db_id(){
        return $this->recipe_db_id;
    }
    function set_recipe_db_id( $val ){
        $this->recipe_db_id = $val;
    }

    //recipe_name
    function get_recipe_name(){
        return $this->recipe_name;
    }
    function set_recipe_name( $val ){
        $this->recipe_name = $val;
    }

    //unit
    function get_unit(){
        return $this->unit;
    }
    function set_unit( $val ){
        $this->unit = $val;
    }
}
