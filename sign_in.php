<?php
require_once("/inc/config.php");

//Display the header
$pageTitle = "Sign in";
include( HEADER_PATH );

echo 'This is sign_in.php!  it will take care of both signing in a user and signing out a user (if he or she is already signed in at the time)';
include( FOOTER_PATH ); 
