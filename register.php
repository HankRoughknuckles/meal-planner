<?php
require_once "/inc/config.php";
require_once DB_PATH;
require_once LIB_PATH.'PasswordHash.php';
require_once LIB_PATH.'validator.php';
require_once LIB_PATH.'html_forms.php';

//Display the header
$pageTitle = "Register";
include( HEADER_PATH );
session_start();

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%		                                              					        	%
//% 			                FUNCTIONS                                     %
//%							                                                     		%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
/**
 * make_registration_form()
 * ========================
 * Returns the html for a web form for the user to register on the 
 * website. This function will also display in the form any errors as 
 * mentioned in the $errors argument
 */
function make_registration_form( $errors = null, $old_input = null )
{ ?>
  <form name="input" class="form-horizontal" action="<?php echo REGISTER_PATH; ?>" 
  method="post"> 
    <!-- TODO: the html formatting on this table is messed up.  Look at the 
    html source from the webpage. -->
    <?php 
    $needles = array('email_syntax', 'email_uniqueness');
    make_text_input('email', "Email Address", $old_input['email'], 
      $needles, $errors);  

    $needles = array('password_syntax', 'password_match');
    make_password_input('password', 'Password', $old_input['password'], 
      $needles, $errors);

    $needles = array('password_syntax', 'password_match');
    make_password_input('password_conf', 'Confirm Password', 
      $old_input['password_conf'], $needles, $errors);
    ?>

    <div class="controls">
      <input type="submit" value="Register">
    </div>
  </form>
<?php }


/**
 * display_form_error()
 * ====================
 * Searches through the $haystack variable (which should be an array).  If 
 * any of the elements in $needles matches the index of any of the 
 * elements in $haystack, then this will return ' class="form-error"' to 
 * show that there is an error in that field
 *
 * @param   - $tag        -the html tag to add the error class to (if 
 *                          errors are indeed present)
 * @param   - $needles    -an array of error message names to match
 * @param   - $haystack   -an array of error messages to check for matches
 *
 *
 * @return -  $tag        -the original passed $tag variable.  it will 
 *                          have ' class="form-error"' included in the 
 *                          tage if any of the errors mentioned in 
 *                          $needles is present in $haystack
 */
function display_form_error( $tag, $needles, $haystack )
{
  $error_is_present = false;

  foreach( $needles as $needle )
  {
    if( isset($haystack[$needle]) ) { 
      $error_is_present = true;
    }
  }

  if( $error_is_present == true )
  {
    $tag = trim( $tag );
    $tag = substr( $tag, 0, -1 );
    $tag .= ' class="form-error">';
  }

  return $tag;
}


/**
 * is_error_present()
 * ==================
 *
 * returns TRUE if any of the items in $needles is an index in 
 * $error_list_haystack
 */
function is_error_present( $needles, $error_list_haystack )
{
  $error_is_present = false;

  foreach( $needles as $needle )
  {
    if( isset($error_list_haystack[$needle]) ) 
    { 
      return TRUE;
    }
  }

  return FALSE;
}

/**
 * validate_registration_input()
 * =============================
 *
 * Checks user input from registration form to make sure that all entered 
 * information meets standards
 *
 * @param   - $vars   - an array of 
 */
function validate_registration_input()
{
  extract($_POST);
  $error_msgs = array();
  $error_msgs = validate_email_syntax( $email, $error_msgs );
  $error_msgs = validate_email_uniqueness( $email, $error_msgs );
  $error_msgs = validate_password_syntax( $password, $error_msgs );
  $error_msgs = validate_password_match( $password, $password_conf, 
    $error_msgs );

  return $error_msgs;
}


//validates that the email has the proper form (i.e. - xxxxxxx@xxxx.com, 
//etc.)
function validate_email_syntax( $email, $error_msgs )
{
  if( !filter_var( $email, FILTER_VALIDATE_EMAIL ) )
  {
    $error_msgs['email_syntax'] = 'Your email address is not valid, please 
      enter a valid email address';
  }

  return $error_msgs;
}


//makes sure that no other email address exists that shares the one passed
function validate_email_uniqueness( $email, $error_msgs )
{
  $db = new Database_handler();

  $matches = $db->query_table('SELECT email FROM t_users WHERE email 
    = "'.$email.'"');

  if( $matches )
  {
    $error_msgs['email_uniqueness'] = 'An email already exists with that 
      name, please check that you have not already registered.';
  }


  return $error_msgs;
}


//makes sure that the password matches the syntax required by the website 
//(i.e., number of characters, etc.)
function validate_password_syntax( $password, $error_msgs )
{
  if( strlen( $password ) < 5 )
  {
    $error_msgs['password_syntax'] = 'Please choose a password that is 
      greater than 5 characters long.';
  }
  return $error_msgs;
}


//makes sure that the two passed passwords match eachother
function validate_password_match( $pass1, $pass2, $error_msgs )
{
  if( $pass1 != $pass2 )
  {
    $error_msgs['password_match'] = 'Passwords do not match, please enter 
      and confirm your password again.';
  }

  return $error_msgs;
}


/**
 * save_user()
 * ===========
 *
 * Save the user and their password into the database
 *
 * @param   - email     - the email address of the user 
 * @param   - $password - the hashed password of the user
 *
 * @return -  $result   - true if saved successfully
 *                      - false if not saved
 */
function save_user( $email, $password )
{
  $db = new Database_handler();

  $params = array(
    'email'     => $email,
    'password'  => $password
  );
    
  $result = $db->insert_row( 't_users', $params );

  if( $result == SUCCESS )
  {
    return true;
  }
  else
  {
    return false;
  }
}



/**
 * get_user_id()
 * =============
 *
 * query the db for the name that matches the passed email. return the 
 * database id that results from the query
 *
 * @param   - $email  - the email address of the user
 *
 * @returns   - the user id if successful
 */
function get_user_id( $email )
{
  $db = new Database_handler();
  $command = 'SELECT id FROM t_users WHERE email = "'.$email.'"';
  $results = $db->query_table( $command );

  return $results[0]['id'];
}


//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%		                                              					        	%
//% 			                    MAIN CODE                                 %
//%							                                                     		%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if( $_SERVER['REQUEST_METHOD'] == 'GET' )
{
  if( !isset($_GET['status']) )
  {
    $body_html = make_registration_form();
    echo $body_html;
  }
}

else if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
  $body_html = '';
  $error_msgs = validate_registration_input();

  if( sizeof($error_msgs) == 0 )
  {
    //TODO: make validation where the site will send an email link that 
    //the user has to click on

    $password_hasher = new PasswordHash(8, false);
    $digest = $password_hasher->HashPassword( $_POST['password'] );

    save_user( $_POST['email'], $digest );
    $_SESSION['user_id'] = get_user_id( $_POST['email'] );
    header( "Location: " . BASE_URL . "index.php" );
  }
  else
  {
    $body_html .= display_errors( $error_msgs );
    $body_html .= make_registration_form( $error_msgs, $_POST );
  }

  echo $body_html;
}


include( FOOTER_PATH ); 
