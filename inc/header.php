<html>
<head>
	<?php
	require_once("/inc/config.php");
	require_once( KEYS_PATH );

	//set the page title
	if( $pageTitle == "Index" ) 
	{
		$pageTitle = "Home";
	}
	?>

	<title>Meal Planner - "<?php echo $pageTitle; ?>"</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<link rel="stylesheet" type="text/css" href="<?php echo STYLE_PATH; ?>" />
	<link rel="stylesheet" href="<?php echo JQUERY_UI_STYLE_PATH; ?>" />
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="<?php echo JQUERY_UI_PATH; ?>"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>
  
  <div class="container-fluid">
	  <h1><a href="<?php echo BASE_URL; ?>">Meal Planner</a></h1>
    <!-- TODO: make a homepage for when user is logged out, and a user profile page when logged in -->
	  <h2><?php echo $pageTitle ?></h2>
    <div class="row-fluid">
      <div class="span2">
        <ul>
          <li>
            <a href="<?php echo BASE_URL ?>new_recipe.php">New Recipe</a>
          </li>
          <li>
            <a href="<?php echo BASE_URL ?>new_food.php">New Food</a>
          </li>
          <li>
            <a href="<?php echo BASE_URL ?>view_foods.php">My Foods</a>
          </li>
          <li>
            <a href="<?php echo BASE_URL ?>view_recipes.php">My Recipes</a>
          </li>
        </ul>
      </div>
      <div class="span10">
