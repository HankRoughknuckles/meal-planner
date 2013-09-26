<?php
if( $_GET['ajax_output'] )
{
  //TODO: Fix this... and well... complete it too.
  require_once ESHA_PATH;
  
  // $esha_matches = fetch_query_results( $_GET['ajax_output'] );
	$matched_results = array();

  // foreach ($esha_matches as $esha_match) 
  // {
	  $matched_results[] = array( 
		  'category'  => 'Search Results:',
		  'label'     => 'asdf'
	  );
  // }

  echo json_encode($matched_results);
}

?>
