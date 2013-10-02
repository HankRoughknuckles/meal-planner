<?php
/**
 * make_html_tag()
 * ===============
 * makes an html tag with the passed options.  Will return FALSE if any 
 * options with the names present in $required_options are not present.  
 * Will also return FALSE if $options does not have a 'tag' entry.
 */
function make_html_tag( $options, $required_options = array() )
{
  //send error if required options are not present
  foreach( $required_options as $req_option )
  {
    if( !isset($options[$req_option]) )
    {
      return "FALSE";
    }
  }
  if( !isset($options['tag']) )
  {
    return "FALSE";
  }

  //build the tag
  $tag = '<'.$options['tag'];
  unset($options['tag']);
  foreach( $options as $key => $option )
  {
    if( $option )
    {
      $tag .= " $key=\"$option\"";
    }
  }

  $tag .= '>';

  return $tag;
}
