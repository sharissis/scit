<?php


/////////////////////////////////////// Custom Styling ///////////////////////////////////////


// Convert hex codes to rgb

function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);	
	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		$rgb = array($r, $g, $b);
		return implode(",", $rgb);
	} elseif(strlen($hex) > 3) {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
		$rgb = array($r, $g, $b);
		return implode(",", $rgb);
	} else {}
}


// Custom CSS

global $dirname;
$custom_css = "";

	
// Primary

if(get_option($dirname.'_primary_font')) {		
	$custom_css .= 'body, input, textarea, select, #sidebar .menu li .menu-subtitle {font-family: "'.get_option($dirname.'_primary_font').'";}';
}

if(get_option($dirname.'_primary_size')) {
	$custom_css .= 'body, input, textarea, select, #sidebar .menu li .menu-subtitle {font-size: '.get_option($dirname.'_primary_size').'px;}';
}

if(get_option($dirname.'_primary_text_color')) {
	$custom_css .= 'body, input, textarea, select, #sidebar .menu li .menu-subtitle {color: '.get_option($dirname.'_primary_text_color').';}';
}
	
if(get_option($dirname.'_primary_link_color')) {
	$custom_css .= 'a, .ui-tabs .ui-tabs-nav li.ui-tabs-active a, .ui-tabs .ui-tabs-nav li.ui-state-disabled a, .ui-tabs .ui-tabs-nav li.ui-state-processing a, .ui-tabs .ui-tabs-nav li.ui-state-hover a {color: '.get_option($dirname.'_primary_link_color').';}';
}

if(get_option($dirname.'_primary_link_hover_color')) {
	$custom_css .= 'a:hover {color: '.get_option($dirname.'_primary_link_hover_color').';}';
}

if(get_option($dirname.'_primary_bg_color')) {
	$custom_css .= '.padder, .widget, #footer, body.activity-permalink .activity-list {background-color: '.get_option($dirname.'_primary_bg_color').';}';
}	

if(get_option($dirname.'_primary_border_color')) {
	$custom_css .= '.widget .widgettitle, .sc-divider, .author-info, .separate > div, .joint > div {border-color:'.get_option($dirname.'_primary_border_color').';}';
}	

// Secondary

if(get_option($dirname.'_secondary_bg_color')) {
	$custom_css .= 'input, textarea, input[type="password"], .ui-tabs .ui-tabs-nav li.ui-tabs-active, .sc-tab-panel, #content .widget[class*="widget_bp_"] h3 {background-color: '.get_option($dirname.'_secondary_bg_color').'; border-color: '.get_option($dirname.'_secondary_bg_color').';}';
}

if(get_option($dirname.'_secondary_bg_hover_color')) {
	$custom_css .= 'input:focus, textarea:focus, input[type="password"]:focus {background-color: '.get_option($dirname.'_secondary_bg_hover_color').'; border-color: '.get_option($dirname.'_secondary_bg_hover_color').';}';
}	


// Headings

if(get_option($dirname.'_heading_font')) {		
	$custom_css .= 'h1, h2, h3, h4, h5, h6, .widget .widgettitle {font-family: "'.get_option($dirname.'_heading_font').'";}';
}

if(get_option($dirname.'_heading_text_color')) {
	$custom_css .= 'h1, h2, h3, h4, h5, h6, .widget .widgettitle {color: '.get_option($dirname.'_heading_text_color').';}';
}	

if(get_option($dirname.'_heading1_size')) {
	$custom_css .= 'h1 {font-size: '.get_option($dirname.'_heading1_size').'px;}';
}	

if(get_option($dirname.'_heading2_size')) {
	$custom_css .= 'h2 {font-size: '.get_option($dirname.'_heading2_size').'px;}';
}
	
if(get_option($dirname.'_heading3_size')) {
	$custom_css .= 'h3 {font-size: '.get_option($dirname.'_heading3_size').'px;}';
}
	
if(get_option($dirname.'_heading_link_color')) {				
	$custom_css .= 'h1 a, h2 a, h3 a, h4 a, h5 a, h6 a, #sidebar .menu li a {color: '.get_option($dirname.'_heading_link_color').';}';
}

if(get_option($dirname.'_heading_link_hover_color')) {
	$custom_css .= 'h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover, #sidebar .menu li a:hover {color: '.get_option($dirname.'_heading_link_hover_color').';}';
}	


// Header

if(get_option($dirname.'_header_bg_color')) {
	$custom_css .= '#header {background-color: '.get_option($dirname.'_header_bg_color').';}';
	$custom_css .= '#nav .menu li a:hover, #nav .menu .sub-menu, #nav .menu li:hover > a {background-color: '.get_option($dirname.'_header_bg_color').';}';
}	

if(get_option($dirname.'_header_link_color')) {
	$custom_css .= '#nav .menu li a, #nav .menu li a:hover, #nav .menu li:hover > a {color: '.get_option($dirname.'_header_link_color').';}';
	$custom_css .= '#nav .menu .sub-menu li a {color: rgb('.hex2rgb(get_option($dirname.'_header_link_color')).'); color: rgba('.hex2rgb(get_option($dirname.'_header_link_color')).',0.8);}';
	$custom_css .= '#nav .menu .sub-menu li a:hover {color: rgb('.hex2rgb(get_option($dirname.'_header_link_color')).'); color: rgba('.hex2rgb(get_option($dirname.'_header_link_color')).',1);}'; 
}


// Primary Buttons
	
if(get_option($dirname.'_primary_button_text_color')) {
	$custom_css .= 'input[type="button"], input[type="submit"], input[type="reset"], button, .button {color: '.get_option($dirname.'_primary_button_text_color').';}';
}	
		
if(get_option($dirname.'_primary_button_bg_color')) {		
	$custom_css .= 'input[type="button"], input[type="submit"], input[type="reset"], button, .button {background-color: '.get_option($dirname.'_primary_button_bg_color').'; border-color: '.get_option($dirname.'_primary_button_bg_color').';}';
}	

if(get_option($dirname.'_primary_button_bg_hover_color')) {
	$custom_css .= 'input[type="button"]:hover, input[type="submit"]:hover, input[type="reset"]:hover, button:hover, .button:hover {background-color: '.get_option($dirname.'_primary_button_bg_hover_color').'; border-color: '.get_option($dirname.'_primary_button_bg_hover_color').'; color: '.get_option($dirname.'_primary_button_text_color').';}';
}	


// Secondary Buttons
	
if(get_option($dirname.'_secondary_button_text_color')) {
	$custom_css .= '.login-button, .bp-wrapper .generic-button a,.bp-wrapper ul.button-nav li a,.bp-wrapper .item-list a.button,.bp-wrapper .item-list .activity-meta a,.bp-wrapper .item-list .acomment-options a,.bp-wrapper .activity-meta a:hover span,.widget .item-options a,.widget .swa-wrap ul#activity-filter-links a,.widget .swa-activity-list li.mini div.swa-activity-meta a,.widget .swa-activity-list div.swa-activity-meta a.acomment-reply,.widget .swa-activity-list div.swa-activity-meta a,.widget .swa-activity-list div.acomment-options a {color: '.get_option($dirname.'_secondary_button_text_color').';}';
}	
		
if(get_option($dirname.'_secondary_button_bg_color')) {		
	$custom_css .= '.login-button, .bp-wrapper .generic-button a,.bp-wrapper ul.button-nav li a,.bp-wrapper .item-list a.button,.bp-wrapper .item-list .activity-meta a,.bp-wrapper .item-list .acomment-options a,.bp-wrapper .activity-meta a:hover span,.widget .item-options a,.widget .swa-wrap ul#activity-filter-links a,.widget .swa-activity-list li.mini div.swa-activity-meta a,.widget .swa-activity-list div.swa-activity-meta a.acomment-reply,.widget .swa-activity-list div.swa-activity-meta a,.widget .swa-activity-list div.acomment-options a {background-color: '.get_option($dirname.'_secondary_button_bg_color').'; border-color: '.get_option($dirname.'_secondary_button_bg_color').';}';
}	

if(get_option($dirname.'_secondary_button_bg_hover_color')) {
	$custom_css .= '.login-button:hover, .bp-wrapper .generic-button a:hover,.bp-wrapper ul.button-nav li a:hover,.bp-wrapper .item-list a.button:hover,.bp-wrapper .item-list .activity-meta a:hover,.bp-wrapper .item-list .acomment-options a:hover,.bp-wrapper .acomment-options a:hover,.bp-wrapper .activity-meta a span,.widget .item-options a:hover,.widget .item-options a.selected,.widget .swa-wrap ul#activity-filter-links a:hover,.widget .swa-activity-list div.swa-activity-meta a.acomment-reply:hover,.widget .swa-activity-list div.swa-activity-meta a:hover,.widget .swa-activity-list div.acomment-options a:hover {background-color: '.get_option($dirname.'_secondary_button_bg_hover_color').'; border-color: '.get_option($dirname.'_secondary_button_bg_hover_color').'; color: '.get_option($dirname.'_secondary_button_text_color').';}';
}	

	
// Icons

if(get_option($dirname.'_icon_color')) {
	$custom_css .= '[class^="icon-"]::before, [class*=" icon-"]::before {color: '.get_option($dirname.'_icon_color').';}';
}	

if(get_option($dirname.'_icon_hover_color')) {
	$custom_css .= '[class^="icon-"]:hover::before, [class*=" icon-"]:hover::before {color: '.get_option($dirname.'_icon_hover_color').' !important;}';
}
	

// Custom Styling

if(get_option($dirname.'_custom_css')) {
	$custom_css .= stripslashes(get_option($dirname.'_custom_css'));
}

if(!empty($custom_css)) { echo '<style>'.$custom_css.'</style>'; }

?>