<html>
<head>
	<?php
	//set the page title
	if( $pageTitle == "Index" ) 
	{
		$pageTitle = "Home";
	}

	echo "<title>Calorie Calculator - " . $pageTitle . "</title>";
	?>
</head>
<body>
	<h1><?php echo $pageTitle ?></h1>