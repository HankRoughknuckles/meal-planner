<html>
<head>
	<?php
	require_once("/inc/config.php");
	require_once( LOGIN_PATH );

	//set the page title
	if( $pageTitle == "Index" ) 
	{
		$pageTitle = "Home";
	}
	?>

	<title>Meal Planner - "<?php echo $pageTitle; ?>"</title>

	<link rel="stylesheet" href="<?php echo JQUERY_UI_STYLE_PATH; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo STYLE_PATH; ?>" />
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="<?php echo JQUERY_UI_PATH; ?>"></script>
</head>
<body>
	<h1><a href="<?php echo BASE_URL; ?>">Meal Planner</a></h1>
	<h2><?php echo $pageTitle ?></h2>
