<?php

/**
* make_accordion_menu()
* ================
* Makes the html for the accordion menu for the list of items passed.  The 
* menu will be of type div and have an id equal to $accordion_id.
*
* Note: this only works if the input $menu_array has 2 levels or less
*
* @param    -   $accordion_id   -   the desired id for the accordion div
* @param    -   $menu_array     -   an array of Food objects
*
* @returns  -   $html           -   the html for the accordion list
 */
function make_accordion_menu( $accordion_id, $menu_array )
{
    ksort($menu_array);
    $html = '<div id="'.$accordion_id.'">';


    //display each accordion item
    foreach( $menu_array as $heading => $contents )
    {
        //the menu button text
        $html .= '<h3>'.ucfirst($heading).'</h3>';


        //the contents of each menu item
        $html .= '<div>';
        $html .= '<ul>';
        $html .=    '<li><h3>'.ucfirst($heading).'</h3>';
        $html .=        '<ul>';

        //display each sub heading (with contents) inside each accordion 
        //item
        foreach ($contents as $sub_heading => $sub_contents) 
        {
            $html .=        '<li><h4>'.ucfirst($sub_heading).'</h4>';
            $html .=            '<ul>';
            $html .=                '<li>'.$sub_contents.'</li>';
            $html .=            '</ul>';
            $html .=        '</li>';
        }
        $html .=        '</ul>';
        $html .=    '</li>';
        $html .= '</ul>';
        $html .= '</div>'; //END accordion element div
    }


    $html .= '</div>'; //END accordion div

    return $html;
}



