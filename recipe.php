<?php

//TODO: eventually make it to where the input ingredients should be ingredients 
//objects (child objects of food objects).  
//TODO: Make constructor automatically calculate calories and cost.

class Recipe 
{
    protected $name;
    protected $db_id;
    protected $ingredients;
    protected $instructions;
    protected $calories;
    protected $cost;

    public function __construct( $input )
    {
        if( is_string( $input['ingredients'] ) )
        {
            $this->set_ingredients( json_decode($input['ingredients']) );
        }
        else
        {
            $this->set_ingredients( $input['ingredients'] );
        }

        $this->set_name( $input['name'] );
        $this->set_db_id( $input['db_id'] );
        $this->set_instructions( $input['instructions'] );
        $this->set_calories( $input['calories'] );
        $this->set_cost( $input['cost'] );
    }

    //getter and setter functions
    //calories
    public function get_calories() { return $this->calories; }
    public function set_calories( $new_calories )
    { $this->calories = $new_calories; }


    //cost
    public function get_cost() { return $this->cost; }

    public function set_cost( $new_cost )
    { $this->cost = $new_cost; }

    
    //db_id
    public function get_db_id() { return $this->db_id; }

    public function set_db_id( $new_db_id ) 
    { 
        $this->db_id = $new_db_id; 

        foreach ($this->ingredients as $ingredient) {
            $ingredient->set_recipe_db_id( $this->get_db_id() );
        }
    }

    //name
    public function get_name() { return $this->name; }

    public function set_name( $new_name ) 
    { 
        $this->name = $new_name; 

        foreach ( $this->ingredients as $ingredient ) {
            $ingredient->set_recipe_name( $this->get_name() );
        }
    }


    //ingredients
    public function get_ingredients() { return $this->ingredients; }

    public function set_ingredients( $new_ingredients )
    { 
        $this->ingredients = $new_ingredients;

        foreach ( $this->ingredients as $ingredient ) {
            $ingredient->set_recipe_name( $this->get_name() );
            $ingredient->set_recipe_db_id( $this->get_db_id() );
        }
    }


    //instructions
    public function get_instructions() { return $this->instructions; }

    public function set_instructions( $new_instructions )
    { $this->instructions = $new_instructions; } 

}
