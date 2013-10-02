<?php
// This library contains functionality to allow you to easily make html 
// input forms.  The classes that are assigned to the forms are standard 
// for twitter bootstrap

require_once LIB_PATH.'html_tags.php';

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
 * @param - $needles    - list of errors that, if present in the $errors 
 *                        variable, will cause the input to have an 
 *                        "error" theme.
 * @param - $errors     - if any entries in $needles are present as 
 *                        indices here, then the input will have an 
 *                        "error" theme to show that the user didn't enter 
 *                        information correctly
 */
function make_text_input($name, $label, $value, $needles, $errors)
{?>
  <?php if( is_error_present($needles, $errors) ) { ?>
  <div class="control-group error">
  <?php } else { ?>
  <div class="control-group">
  <?php } ?>

    <?php make_label( $label, array( 
    "for" => $name,
    "class" => "control-label") 
    ); ?>

    <div class="controls">
      <?php make_base_input( array(
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
function make_password_input($name, $label, $value, $needles, $errors)
{?>
  <?php if( is_error_present($needles, $errors) ) { ?>
  <div class="control-group error">
  <?php } else { ?>
  <div class="control-group">
  <?php } ?>

    <?php make_label( $label, array( 
      "for" => $name,
      "class" => "control-label") 
    );?>

    <div class="controls">
      <?php make_base_input( array(
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
function make_label( $value, $options )
{
  $options['tag'] = 'label';
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
