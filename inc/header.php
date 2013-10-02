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

	<h1><a href="<?php echo BASE_URL; ?>">Meal Planner</a></h1>
	<h2><?php echo $pageTitle ?></h2>
