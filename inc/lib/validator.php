<?php
//This library is responsible for holding the functions related to form 
//validation

//TODO: allow an option to use this with bootstrap or not. If so, then 
//this will make inputs using the bootstrap classes

require_once DB_PATH;
require_once LIB_PATH.'html_tags.php';

class Validator{
  // $_form_errors has the following form:
  // {
  //  field_name1 = {
  //    error_msg_a,
  //    error_msg_b,
  //  },
  //  field_name2 = {
  //    error_msg_c
  //  }
  //}
  protected $_form_errors;

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
    foreach( $this->_form_errors as $field )
    {
      foreach( $field as $error_msg )
      {?>
        <p class="text-error"><?php echo $error_msg; ?></p>
      <?php
      }
    }
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
   * make_error()
   * ============
   * registers an error in the _form_errors array to allow the Validator 
   * class to see which fileds have errors in them.
   * 
   * @param - $field_name   - the name of the field as it appears in the 
   *                          html
   * @param - $error_msg    - the error message to register for the field
   */
  function make_error( $field_name, $error_msg )
  {
    $this->_form_errors[$field_name][] = $error_msg;
  }

  /**
   * validate_email_syntax()
   * =======================
   * validates that the email has the proper form 
   * (i.e. - xxxxxxx@xxxx.com, etc.)
   */
  function validate_email_syntax( $field_name, $value )
  {
    if( !filter_var( $value, FILTER_VALIDATE_EMAIL ) )
    {
      $this->make_error( $field_name, 'Your email address is not valid, 
        please enter a valid email address');
    }
  }


  /**
   * validate_email_uniqueness()
   * ===========================
   * validates that no other email address exists that shares the one 
   * passed
   */
  function validate_email_uniqueness( $field_name, $value )
  {
    $db = new Database_handler();

    $matches = $db->query_table('SELECT email FROM t_users WHERE email 
      = "'.$value.'"');

    if( $matches )
    {
      $this->make_error( $field_name, 'An email already exists with that 
        name, please check that you have not already registered.' );
    }
  }

  
  /**
   * validate_password_syntax()
   * ==========================
   * validates that the password matches the syntax required by the 
   * website (i.e., number of characters, etc.)
   */
  function validate_password_syntax( $field_name, $value )
  {
    if( strlen( $value ) < 5 )
    {
      $this->make_error( $field_name, 'Please choose a password that is 
        greater than 5 characters long.');
    }
  }


  /**
   * validate_password_match()
   * =========================
   * validates that the two passed passwords match eachother
   */
  function validate_password_match( 
    $field_name_1, $value_1, $field_name_2, $value_2 )
  {
    if( $value_1 != $value_2 )
    {
      $this->make_error( $field_name_2, 'Passwords do not match, please 
        enter and confirm your password again.');
    }
  }


  /**
   * make_text_input()
   * ================
   * Makes a text input with label for a form.  Includes ability to 
   * display if the input has an error that needs to be corrected by the 
   * user.  The input will have the falue passed in $value
   *
   * @param - $name       - the variable name that the form will post to
   * @param - $label      - the label for the input
   * @param - $value      - the value that the input will display (useful 
   *                        if the user previously information incorrectly 
   *                        and you want to restore the old input they had 
   *                        before)
   *                        Default value = NULL
   */
  function make_text_input($name, $value=NULL)
  {
    $this->make_base_input( array(
      'type'    => "text",
      'name'    => $name,
      'id'      => $name,
      'value'   => $value)
    );
  }

  /**
   * make_password_input()
   * =====================
   *
   * creates an label and an input for a password, 
   *
   * @param - $name       - the variable name that the form will post to
   * @param - $label      - the label for the input
   * @param - $value      - the value that the input will display (useful 
   *                        if the user previously information incorrectly 
   *                        and you want to restore the old input they had 
   *                        before)
   * @param - $has_error  - if == TRUE - input will have red outline
   */
  function make_password_input($name, $value=NULL)
  {
    $this->make_base_input( array(
      'type'    => "password",
      'name'    => $name,
      'id'      => $name,
      'value'   => $value)
    );
  }


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
  {?>
    <?php if( $this->is_error_present($options['name']) ) { ?>
    <div class="control-group error">
    <?php } else { ?>
    <div class="control-group">
    <?php }?>
      <div class="controls">
    <?php
      $required_options = array( 'type', 'name' );
      $options['tag'] = 'input';
      echo  make_html_tag( $options, $required_options ); 
    ?>
      </div> <!-- /div "controls" -->
    </div> <!-- /div "control-group" or "control-group error" -->
<?php 
  }
}
