<?php

//TODO: eventually make it to where the input ingredients should be ingredients objects (child objects of food objects).  Make constructor automatically calculate calories and cost.

class Recipe 
{
    protected $name;
    protected $ingredients;
    protected $instructions;
    protected $calories;
    protected $cost;

    public function __construct( $name, $ingredients, $instructions, $calories, $cost )
    {
        $this->name = $name;

        if( is_string( $ingredients ) )
        {
            $this->ingredients = json_decode( $ingredients );
        }
        else
        {
            $this->ingredients = $ingredients;
        }

        $this->instructions = $instructions;
        $this->calories = $calories;
        $this->cost = $cost;
    }


    public function get_name()
    {
        return $this->name;
    }


    public function set_name( $new_name )
    {
        $this->name = $new_name;
    }


    public function get_ingredients()
    {
        return $this->ingredients;
    }


    public function set_ingredients( $new_ingredients )
    {
        $this->ingredients = $new_ingredients;
    }


    public function get_instructions()
    {
        return $this->instructions;
    }


    public function set_instructions( $new_instructions )
    {
        $this->instructions = $new_instructions;
    }


    public function get_calories()
    {
        return $this->calories;
    }


    public function set_calories( $new_calories )
    {
        $this->calories = $new_calories;
    }


    public function get_cost()
    {
        return $this->cost;
    }


    public function set_cost( $new_cost )
    {
        $this->cost = $new_cost;
    }
}
