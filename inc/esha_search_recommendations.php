<?php
if( $_GET['ajax_output'] )
{
  //TODO: Fix this... and well... complete it too.
	$matched_results[] = array( 
		'category'  => 'Search Results:',
		'label'     => $_GET['ajax_output'],
	);
  echo $matched_results
}
?>
