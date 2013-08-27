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



/**
 * creates a string filled with script tags giving the references to other 
 * javascript documents to be included in the file.
 *
 * @param   - $filenames    -   an array of the following form:
 *                              array( 
 *                                  "javascript_filename_1.js"
 *                                  "javascript_filename_2.js"
 *                                  "javascript_filename_3.js"
 *                                  ...
 *                              )
 *                              note, these filenames will appear with the 
 *                              same scope as the document calling this 
 *                              function, so it may be safest to specify 
 *                              the absolute file path for each file.
 *
 * @returns - $js           -   a string containing the <script src=".."> 
 *                              tags for each filename given
 */
function create_js_references( $filenames )
{
    $js = '';

    foreach ($filenames as $filename) 
    {
        $js .= '<script src="'.$filename.'"></script>';
    }

    return $js;
}
