<?php
require_once("/inc/config.php");
require_once HELPERS_PATH;

display_page_header("Meal Planner");

if( $_SESSION['user_id'] == NOT_LOGGED_IN ){ ?>
  <div class='login'>
    <ul>
      <li><a href="<?php echo BASE_URL ?>sign_in.php">Sign In</a></li>
      <li><a href="<?php echo BASE_URL ?>register.php">Register</a></li>
    </ul>
  </div> <!-- END login div -->

<?php } else { ?>

  <div class='login'>
    <ul>
      <li><a href="<?php echo BASE_URL ?>sign_out.php">Sign Out</a></li>
    </ul>
  </div> <!-- END login div -->

<?php } ?>

<?php include( FOOTER_PATH ); 
