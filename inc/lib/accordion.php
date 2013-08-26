<?php

/**
* make_accordion_menu()
* ================
* Makes the html for the accordion menu for the list of items passed.  The 
* menu will be of type div and have an id equal to $accordion_id.
*
* Note: this only works if the input $menu_array has 2 levels or less
*
*
* @param    -   $accordion_id   -   the desired id for the accordion div
* @param    -   $menu_array     -   an array up to 2 levels deep  
*                                   where the key of each level will be 
*                                   the heading for that section in the 
*                                   list
*                                   Ex:
*                                   array(
*                                       'Name' => array(
*                                           'Cost'      => 5.00
*                                           'Calories'  => 100
*                                       )
*                                   )
*
*                                   Will have an accordion menu with one 
*                                   item, where 'Name' will appear on the 
*                                   button.  When the 'Name' button is 
*                                   clicked, it will open up to reveal 
*                                   a tiered list of items where Cost is 
*                                   the headline of one, with the contents 
*                                   of '5.00' and Calories is another 
*                                   headline with the contents of '100'
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

            if( is_array($sub_contents) )
            {
                foreach ($sub_contents as $sub_sub_contents) 
                {
                    $html .=            '<li>'.$sub_sub_contents.'</li>';
                }
            }
            else
            {
                $html .=            '<li>'.$sub_contents.'</li>';
            }

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



/**
 * print_cost_table()
 * ==================
 *
 * Makes the html for a food giving the amount of the food and how much it 
 * costs
 */
function print_cost_table( $edible )
{
    //TODO: eventually merge this into one single method with 
    //print_calorie_table to have one flexible function that can print any 
    //type of table
    $amt = round( $edible['serving_size'], 2 );
    $unit = $edible['serving_units'];
    $cost = round($edible['cost'], 2);

    if( $amt != 1 )
    {
        $unit .= 's';
    }

    if( strtolower($unit) == "each" OR strtolower($unit) == "eachs" )
    {
        $unit = '';
    }

    $table_html = '<table border="1">';
    $table_html .= '<tr><th>Amount</th><th>Cost</th></tr>';
    $table_html .= '<td>'.$amt.' '.$unit.'</td>';
    $table_html .= 
        '<td>$'.number_format( (float)$cost, 2, '.', '').'</td>';
    $table_html .= '</table>';

    return $table_html;
}



/**
 * print_calorie_table()
 * =====================
 *
 * Makes the html for a food giving the amount of the food and how many 
 * calories it has
 */
function print_calorie_table( $edible )
{
    //TODO: eventually merge this into one single method with 
    //print_cost_table to have one flexible function that can print any 
    //type of table
    $amt = round( $edible['serving_size'], 2 );
    $unit = $edible['serving_units'];
    $calories = round($edible['calories'], 2);

    if( $amt != 1 )
    {
        $unit .= 's';
    }

    if( strtolower($unit) == "each" OR strtolower($unit) == "eachs" )
    {
        $unit = '';
    }

    $table_html = '<table border="1">';
    $table_html .= '<tr><th>Amount</th><th>Calories</th></tr>';
    $table_html .= '<td>'.$amt.' '.$unit.'</td>';
    $table_html .= '<td>'.$calories.'</td>';
    $table_html .= '</table>';

    return $table_html;
}



