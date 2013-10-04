<?php 
/**
*	display_page_header()
*	=====================
*
*	Takes in a string and sets the title of the page and the headline
*	to it
*
*	@param 	-	$inTitle 	-	the title to be displayed
*
*	@return -	NULL
*/
function display_page_header( $inTitle )
{
	$pageTitle = $inTitle;
	include HEADER_PATH;
}


