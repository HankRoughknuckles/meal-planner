<?php
require_once("/inc/config.php");
require_once( KEYS_PATH );
session_start();

//set the page title
if( $pageTitle == "Index" ) 
{
	$pageTitle = "Home";
}


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%
//%     			                    FUNCTIONS
//%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
function makeNavbar()
{ 
  // TODO: finish this
?>
<div class="navbar navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container-fluid">
        <a class="brand" href="#">Meal Planner</a>  
      <ul class="nav pull-right">  
      <?php if ($_SESSION['user_id'] == NOT_LOGGED_IN){ ?>
        <li><a href="#">*THE_USERNAME_HERE*</a></li>  
        <li><a href="#">Sign out</a></li>  
      <?php } else { ?>
      <li><a href="<?php echo REGISTER_PATH;?>">Register</a></li>  
        <li><a href="#">Log in</a></li>  
      <?php } ?>
      </ul>
    </div>
    <!-- <a class="navbar_brand" href="#">Meal Planner</a> -->
  </div>
  <!-- <div class="navbar-collapse collapse"> -->
  </div>
</div>
<?php } 


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%
//%     			                     MAIN CODE
//%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
?>
<html>
<head>
  <title>
    Meal Planner - "<?php echo $pageTitle; ?>"
  </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <link rel="stylesheet" type="text/css" href="<?php echo STYLE_PATH; ?>">
  <link rel="stylesheet" href="<?php echo JQUERY_UI_STYLE_PATH; ?>">
  <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
  <script src="<?php echo JQUERY_UI_PATH; ?>"></script>
  <script src="js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
<?php makeNavbar(); ?>
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
	  <h1><a href="<?php echo BASE_URL; ?>">Meal Planner</a></h1>
