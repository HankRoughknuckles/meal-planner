<?php
require_once "/inc/config.php";
require_once DB_PATH;
require_once LIB_PATH.'PasswordHash.php';
require_once LIB_PATH.'validator.php';
require_once HELPERS_PATH;

//Display the header
display_page_header("Register");

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
 * validate_registration_input()
 * =============================
 *
 * Checks user input from registration form to make sure that all entered 
 * information meets standards
 */
function validate_registration_input()
{
  extract($_POST);
  $_SESSION['validator']->load_post($_POST);
  $_SESSION['validator']->validate_email_syntax('email');
  $_SESSION['validator']->validate_email_uniqueness('email');
  $_SESSION['validator']->validate_password_syntax('password');
  $_SESSION['validator']->validate_password_match(
                            'password', 'password_conf');
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

  if( !$_SESSION['validator']->errors_present() )
  {
    //TODO: make validation where the site will send an email link that 
    //the user has to click on

    $password_hasher = new PasswordHash(8, false);
    $digest = $password_hasher->HashPassword( $_POST['password'] );

    save_user( $_POST['email'], $digest );
    $_SESSION['user_id'] = get_user_id( $_POST['email'] );
    $_SESSION['username'] = $_POST['email'];
    header( "Location: " . BASE_URL . "index.php" );
  }
  else
  {
    $body_html .= $_SESSION['validator']->display_errors();
    $body_html .= make_registration_form( $error_msgs, $_POST );
  }

  echo $body_html;
}


include( FOOTER_PATH ); 
