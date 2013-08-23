<?php
require_once("/inc/config.php");

$pageTitle = "Meal Planner - Index";
include( HEADER_PATH );

session_start();
?>
<ul>
    <li> <a href="<?php echo BASE_URL ?>new_recipe.php">New Recipe</a> </li>
    <li><a href="<?php echo BASE_URL ?>new_food.php">New Food</a></li>
    <li><a href="<?php echo BASE_URL ?>view_foods.php">View Foods</a></li>
    <li><a href="<?php echo BASE_URL ?>view_recipes.php">View Recipes</a></li>
</ul>

<?php include( FOOTER_PATH ); 
