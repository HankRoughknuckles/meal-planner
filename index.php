<?php
require_once("/inc/paths.php");

$pageTitle = "Meal Calculator - Index";
include("/inc/header.php");
?>

	<ul>
		<li><a href="<?php echo BASE_URL ?>new_recipe.php">New Recipe</a></li>
		<li><a href="<?php echo BASE_URL ?>new_food.php">New Food</a></li>
		<li><a href="<?php echo BASE_URL ?>foods.php">View Foods</a></li>
		<li><a href="<?php echo BASE_URL ?>recipes.php">View Recipes</a></li>
	</ul>
	
<?php include( ROOT_PATH . "inc/footer.php"); 
