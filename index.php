<?php
require_once("/inc/config.php");
require_once HELPERS_PATH;

display_page_header("Meal Planner");

if( $_SESSION['user_id'] == NOT_LOGGED_IN ){ ?>
  <p>Make welcome page talking about all the stuff the meal planner can 
  do.</p>
<?php } else { ?>
  <p>Display the user's profile page here.</p>
<?php } ?>

<?php include( FOOTER_PATH ); 
