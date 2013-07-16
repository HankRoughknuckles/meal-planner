README
-------

This app take in user information about food and recipes and calculates the cost of the food, the amount of calories (and other nutrients) in it, and the cost per calorie.  Eventually, I'll try to implement a meal planning system with functionality to allow users to create custom profiles with quotas of nutrients to meet on a weekly or daily basis.  This app will allow them to both keep track of the nutrients they consume as well as help them keep a budget for buying food.


NOTE:
This program requires a mySQL database connection along with a connection to the ESHA food nutrition database (found at: http://developer.esha.com/page ).

Please note that you must apply for an api key at the esha website noted above.

For this program to work properly, you must add a folder /inc/sensitive with a file /inc/sensitive/login.php. Inside login.php, add the following code:


	<?php
		/*
			The purpose of this file is to store the login information for 
			interfaces required by the application.  This file should be
			included in .gitignore.
		*/
	define('SQL_USERNM', 	"YOUR MY_SQL USERNAME");
	define('SQL_PSWD',	 	"YOUR MY_SQL PASSWORD");

	define('ESHA_API_KEY', 	"YOUR ESHA API KEY");


To protect your own privacy, please insert the following line into your .gitignore file if it is not already there:
`inc/sensitive/*`