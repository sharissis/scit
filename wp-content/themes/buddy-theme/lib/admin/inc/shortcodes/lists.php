<?php

//////////////////////////////////////// Lists ////////////////////////////////////////

function gp_list($atts, $content = null, $code) {
    extract(shortcode_atts(array(
		'type' => 'icon-caret-right'
    ), $atts));
    
    $out = "";
    	
    if($code=="list") {
		$out .= '<ul class="sc-list">'.do_shortcode($content).'</ul>';
	} elseif($code=="li") {
		$out .= '<li><i class='.$type.'></i>'.do_shortcode($content).'</li>';
	}
	
   return $out;
   
}
add_shortcode("list", "gp_list");
add_shortcode("li", "gp_list");

?>