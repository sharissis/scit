<?php


/////////////////////////////////////// Default Sidebars ///////////////////////////////////////
	
register_sidebar(array(
	'name' => __('Standard Left Sidebar', 'gp_lang'),
	'id'=> 'gp-default-left',
	'description' => 'Displayed on posts, pages and post categories.',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>')
);
 
register_sidebar(array(
	'name' => __('Standard Right Sidebar', 'gp_lang'),
	'id'=> 'gp-default-right',
	'description' => 'Displayed on posts, pages and post categories.',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>')
);
    
register_sidebar(array('name' => __('Footer 1', 'gp_lang'),
	'id' => 'gp-footer-1',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));        

register_sidebar(array('name' => __('Footer 2', 'gp_lang'), 
	'id' => 'gp-footer-2',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));   
	
register_sidebar(array('name' => __('Footer 3', 'gp_lang'),
	'id' => 'gp-footer-3',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));   
	
register_sidebar(array('name' => __('Footer 4', 'gp_lang'),
	'id' => 'gp-footer-4',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));   
	
register_sidebar(array('name' => __('Footer 5', 'gp_lang'),
	'id' => 'gp-footer-5',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2 class="widgettitle">',
	'after_title' => '</h2>'));   
		 
?>