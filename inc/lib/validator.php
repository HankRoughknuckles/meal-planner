<?php
//This library is responsible for holding the functions related to form 
//validation

//TODO: allow an option to use this with bootstrap or not. If so, then 
//this will make inputs using the bootstrap classes

require_once DB_PATH;
require_once LIB_PATH.'html_tags.php';

class Validator{
  //$_post is identical to the $_POST variable that comes in when a POST 
  //http request is sent in. Index = variable name, value = variable value
  protected $_post; 
  protected $_form_errors;

  /**
   * load_post()
   * ===========
   * load the POST variable into Validator to allow for form validation 
   * checking.  Note: this function should be called before any validation 
   * functions should be called.  If there is no POST variable loaded, 
   * the validation functions will break.
   *
   * @param   - $input  - the $_POST variable to be loaded.
   */
  function load_post( $input )
  {
    $this->_post = $input;
  }


  /**
   *
   *
   *
   *
   */
  function post_loaded()
  {
    if( $this->get_post() )
    {
      return TRUE;
    }
    else
    {
      return FALSE;
    }
  }


  /**
   * is_error_present()
   * ==================
   *
   * returns TRUE if the passed name is present as an index of 
   * $this->_form_errors.
   */
  function is_error_present( $name )
  {
    if( isset($this->_form_errors[$name]) ) 
    { 
      return TRUE;
    }

    return FALSE;
  }


  //Display the errors contained in the $errors array on screen
  function display_errors()
  {
    $error_html = '';
    foreach( $this->_form_errors as $error )
    {
      $error_html .= '<p class="text-error">'.$error.'</p>';
    }

    return $error_html;
  }


  /**
   * clear_errors()
   * ==============
   * Clears out the errors in the _form_errors variable.
   */
  function clear_errors()
  {
    $this->_form_errors = array();
  }


  function errors_present()
  {
    if( count($this->_form_errors) == 0 ) 
    {
      return false;
    }
    else
    {
      return true;
    }
  }


  /**
   * validate_email_syntax()
   * =======================
   * validates that the email has the proper form 
   * (i.e. - xxxxxxx@xxxx.com, etc.)
   */
  function validate_email_syntax( $name )
  {
    if( $this->post_loaded() && isset($this->_post[$name]) )
    {
      if( !filter_var( $this->_post[$name], FILTER_VALIDATE_EMAIL ) )
      {
        $this->_form_errors[$name] = 'Your email address is not 
          valid, please enter a valid email address';
      }
    }
    else
    {
      //error
      echo "post variable is not loaded or $name is not an index in post. 
        make sure you called load_post() before you called this function";
    }
  }


  /**
   * validate_email_uniqueness()
   * ===========================
   * validates that no other email address exists that shares the one 
   * passed
   */
  function validate_email_uniqueness( $email )
  {
    $db = new Database_handler();

    $matches = $db->query_table('SELECT email FROM t_users WHERE email 
      = "'.$email.'"');

    if( $matches )
    {
      $this->_form_errors['email_uniqueness'] = 'An email already exists 
        with that name, please check that you have not already 
        registered.';
    }
  }

  
  /**
   * validate_password_syntax()
   * ==========================
   * validates that the password matches the syntax required by the 
   * website (i.e., number of characters, etc.)
   */
  function validate_password_syntax( $password )
  {
    if( strlen( $password ) < 5 )
    {
      $this->_form_errors['password_syntax'] = 'Please choose a password 
        that is greater than 5 characters long.';
    }
  }


  /**
   * validate_password_match()
   * =========================
   * validates that the two passed passwords match eachother
   */
  function validate_password_match( $pass1, $pass2 )
  {
    if( $pass1 != $pass2 )
    {
      $this->_form_errors['password_match'] = 'Passwords do not match, 
        please enter and confirm your password again.';
    }
  }


  /**
   * make_text_input()
   * ================
   * Makes a text input with label for a form.  Includes ability to display 
   * if the input has an error that needs to be corrected by the user.  The 
   * input will have the falue passed in $old_input
   *
   * @param - $name       - the variable name that the form will post to
   * @param - $label      - the label for the input
   * @param - $value      - the value that the input will display (useful if 
   *                        the user previously information incorrectly and 
   *                        you want to restore the old input they had 
   *                        before)
   *                        Default value = NULL
   */
  function make_text_input($name, $value=NULL)
  {?>
    <?php if( $this->is_error_present($name) ) { ?>
    <div class="control-group error">
    <?php } else { ?>
    <div class="control-group">
    <?php } ?>

      <div class="controls">
        <?php $this->make_base_input( array(
        'type'    => "text",
        'name'    => $name,
        'id'      => $name,
        'value'   => $value)
        ); ?>
      </div>
    </div>
  <?php }

  /**
   * make_password_input()
   * =====================
   *
   * creates an label and an input for a password, 
   *
   * @param - $name       - the variable name that the form will post to
   * @param - $label      - the label for the input
   * @param - $value      - the value that the input will display (useful if 
   *                        the user previously information incorrectly and 
   *                        you want to restore the old input they had 
   *                        before)
   * @param - $has_error  - if == TRUE - input will have red outline
   */
  function make_password_input($name, $value=NULL)
  {?>
    <?php if( $this->is_error_present($name) ) { ?>
    <div class="control-group error">
    <?php } else { ?>
    <div class="control-group">
    <?php } ?>

      <div class="controls">
        <?php $this->make_base_input( array(
        'type'    => "password",
        'name'    => $name,
        'id'      => $name,
        'value'   => $value)
        ); ?>
      </div>
    </div>
  <?php }


  /**
   * make_label()
   */
  function make_label( $for, $value, $options=array() )
  {
    $options['tag'] = 'label';
    $options['class'] = 'control-label';
    $options['for'] = $for;
    $required_options = array('for');
    $tag = make_html_tag( $options, $required_options );
    $tag .= $value;
    $tag .= make_html_tag( array( "tag" => "/label"), array() );
    echo $tag;
  }


  /**
   * make_base_input()
   * =================
   * makes an input with the types specified in the input $options 
   * associative array
   */
  function make_base_input( $options )
  {
    $required_options = array( 'type', 'name' );
    $options['tag'] = 'input';
    echo  make_html_tag( $options, $required_options );
  }


  //getters and setters
  public function get_post() 
  { 
      return $this->_post;
  }
}
