<?php

/**
 * create_js_variables()
 * =====================
 *
 * creates the <script> tags for javascript which will export the passed 
 * php variables to the javascript in the page
 *
 * @param       - $php_vars         - an array of the following form:
 *                                      array(
 *                                          array('var_name' => php_var),
 *                                          ...
 *                                      )
 *
 * @return      - $js           -a string with <script> tags containing 
 *                                  the variables in json form
 */
function create_js_variables( $php_vars )
{
    $js = '<script>';
    foreach ($php_vars as $name => $php_var) {
        $js .= 'var '.$name.' = '.json_encode($php_var).';';
    }
    $js .= '</script>';

    return $js;
}



