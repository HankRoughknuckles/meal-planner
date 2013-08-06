<?php 
//This contains the footer that will be included in almost all the pages 
$html_code = "";

//include javascript files
if( isset($js_source_paths) )
{
    foreach( $js_source_paths as $js_source_path )
    {
        $html_code .= '<script src='.$js_source_path.'></script>';
    }
}


$html_code .= '</body>';
$html_code .= '</html>';

echo $html_code;
