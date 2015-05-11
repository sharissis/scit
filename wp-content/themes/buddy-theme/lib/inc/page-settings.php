<?php require(gp_inc . 'options.php'); global $gp_settings, $dirname;


// iOS Conditionals

$gp_settings['iphone'] = (stripos($_SERVER['HTTP_USER_AGENT'],"iPhone") !== false);
$gp_settings['ipad'] = (stripos($_SERVER['HTTP_USER_AGENT'],"iPad") !== false);


// Preload Effect

if(get_option($dirname.'_preload') == '0') {
	$gp_settings['preload'] = 'preload';
} else {
	$gp_settings['preload'] = '';
}

			
/////////////////////////////////////// Homepage ///////////////////////////////////////


if(is_home()) {

	$gp_settings['layout'] = "fullwidth";
	$gp_settings['title'] = "Show";
	
			
/////////////////////////////////////// BuddyPress ///////////////////////////////////////


} elseif(function_exists('bp_is_active') && !bp_is_blog_page()) {

	// Left Sidebar
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_left', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_left', true) != 'Default') {
		$gp_settings['sidebar_left'] = get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_left', true);
	} else {
		$gp_settings['sidebar_left'] = get_option($dirname.'_bp_sidebar_left');
	}

	// Right Sidebar
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_right', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_right', true) != 'Default') {
		$gp_settings['sidebar_right'] = get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_right', true);
	} else {
		$gp_settings['sidebar_right'] = get_option($dirname.'_bp_sidebar_right');
	}
			
	// Layout
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_layout', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_layout', true) != "Default") {
		$gp_settings['layout'] = get_post_meta(get_the_ID(), '_'.$dirname.'_layout', true);
	} else {
		$gp_settings['layout'] = get_option($dirname.'_bp_layout');
	}

	// Title
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_title', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_title', true) != "Default") {
		$gp_settings['title'] = get_post_meta(get_the_ID(), '_'.$dirname.'_title', true);
	} else {
		$gp_settings['title'] = get_option($dirname.'_bp_title');
	} 
		

/////////////////////////////////////// bbPress ///////////////////////////////////////


} elseif(function_exists('is_bbpress') && is_bbpress()) {

	$gp_settings['sidebar_left'] = get_option($dirname.'_bbp_sidebar_left');
	$gp_settings['sidebar_right'] = get_option($dirname.'_bbp_sidebar_right');
	$gp_settings['layout'] = get_option($dirname.'_bbp_layout');
	$gp_settings['title'] = get_option($dirname.'_bbp_title'); 
				
			
/////////////////////////////////////// Categories, Archives etc. ///////////////////////////////////////


} elseif((is_archive() OR is_search()) OR ((is_archive() OR is_search()) && function_exists('woocommerce_content') && !is_shop())) {

	$gp_settings['thumbnail_width'] = get_option($dirname.'_cat_thumbnail_width');
	$gp_settings['thumbnail_height'] = get_option($dirname.'_cat_thumbnail_height');
	$gp_settings['image_wrap'] = get_option($dirname.'_cat_image_wrap');	
	$gp_settings['hard_crop'] = get_option($dirname.'_cat_hard_crop');
	$gp_settings['sidebar_left'] = get_option($dirname.'_cat_sidebar_left');	
	$gp_settings['sidebar_right'] = get_option($dirname.'_cat_sidebar_right');	
	$gp_settings['layout'] = get_option($dirname.'_cat_layout');	
	$gp_settings['title'] = get_option($dirname.'_cat_title');
	$gp_settings['content_display'] = get_option($dirname.'_cat_content_display');
	$gp_settings['excerpt_length'] = get_option($dirname.'_cat_excerpt_length');
	$gp_settings['read_more'] = get_option($dirname.'_cat_read_more');
	$gp_settings['meta_date'] = get_option($dirname.'_cat_date');
	$gp_settings['meta_author'] = get_option($dirname.'_cat_author');
	$gp_settings['meta_cats'] = get_option($dirname.'_cat_cats');
	$gp_settings['meta_tags'] = get_option($dirname.'_cat_tags');
	$gp_settings['meta_comments'] = get_option($dirname.'_cat_comments');
		
						
/////////////////////////////////////// Posts ///////////////////////////////////////


} elseif(is_singular('post')) {

	// Show Image
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_show_image', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_show_image', true) != 'Default') {
		$gp_settings['show_image'] = get_post_meta(get_the_ID(), '_'.$dirname.'_show_image', true);
	} else {
		$gp_settings['show_image'] = get_option($dirname.'_show_post_image');
	}
	
	// Image Dimensions
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_image_width', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_image_width', true) != "") {
		$gp_settings['image_width'] = get_post_meta(get_the_ID(), '_'.$dirname.'_image_width', true);
	} else {
		$gp_settings['image_width'] = get_option($dirname.'_post_image_width');
	}
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_image_height', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_image_height', true) != "") {
		$gp_settings['image_height'] = get_post_meta(get_the_ID(), '_'.$dirname.'_image_height', true);
	} else {
		$gp_settings['image_height'] = get_option($dirname.'_post_image_height');
	}

	// Image Wrap
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_image_wrap', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_image_wrap', true) != "Default") {
		$gp_settings['image_wrap'] = get_post_meta(get_the_ID(), '_'.$dirname.'_image_wrap', true);
	} else {
		$gp_settings['image_wrap'] = get_option($dirname.'_post_image_wrap');
	}

	// Hard Crop
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_hard_crop', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_hard_crop', true) != "Default") {
		$gp_settings['hard_crop'] = get_post_meta(get_the_ID(), '_'.$dirname.'_hard_crop', true);
	} else {
		$gp_settings['hard_crop'] = get_option($dirname.'_post_hard_crop');
	}
					
	// Left Sidebar
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_left', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_left', true) != 'Default') {
		$gp_settings['sidebar_left'] = get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_left', true);
	} else {
		$gp_settings['sidebar_left'] = get_option($dirname.'_post_sidebar_left');
	}

	// Right Sidebar
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_right', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_right', true) != 'Default') {
		$gp_settings['sidebar_right'] = get_post_meta(get_the_ID(), '_'.$dirname.'_sidebar_right', true);
	} else {
		$gp_settings['sidebar_right'] = get_option($dirname.'_post_sidebar_right');
	}

	// Layout
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_layout', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_layout', true) != "Default") {
		$gp_settings['layout'] = get_post_meta(get_the_ID(), '_'.$dirname.'_layout', true);
	} else {
		$gp_settings['layout'] = get_option($dirname.'_post_layout');
	}
	
	// Title
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_title', true) && get_post_meta(get_the_ID(), '_'.$dirname.'_title', true) != 'Default') {
		$gp_settings['title'] = get_post_meta(get_the_ID(), '_'.$dirname.'_title', true);
	} else {
		$gp_settings['title'] = get_option($dirname.'_post_title');
	}
	
	// Post Meta						
	$gp_settings['meta_date'] = get_option($dirname.'_post_date');
	$gp_settings['meta_author'] = get_option($dirname.'_post_author');
	$gp_settings['meta_cats'] = get_option($dirname.'_post_cats');
	$gp_settings['meta_tags'] = get_option($dirname.'_post_tags');
	$gp_settings['meta_comments'] = get_option($dirname.'_post_comments');
	
	// Author Info Panel
	$gp_settings['author_info'] = get_option($dirname.'_post_author_info');
						
	// Related Items
	$gp_settings['related_items'] = get_option($dirname.'_post_related_items');			
	$gp_settings['related_image_width'] = get_option($dirname.'_post_related_image_width');
	$gp_settings['related_image_height'] = get_option($dirname.'_post_related_image_height');
	

/////////////////////////////////////// Pages, Attachments, 404 etc. ///////////////////////////////////////


} else {

	if(function_exists('woocommerce_content') && is_shop()) {
		$post_id = get_option('woocommerce_shop_page_id'); 
	} else {
		$post_id = $post->ID; 
	}
	
	// Show Image
	if(get_post_meta(get_the_ID(), '_'.$dirname.'_show_image', true) && get_post_meta($post_id, '_'.$dirname.'_show_image', true) != 'Default') {
		$gp_settings['show_image'] = get_post_meta($post_id, '_'.$dirname.'_show_image', true);
	} else {
		$gp_settings['show_image'] = get_option($dirname.'_show_page_image');
	}
	
	// Image Dimensions
	if(get_post_meta($post_id, '_'.$dirname.'_image_width', true) && get_post_meta($post_id, '_'.$dirname.'_image_width', true) != "") {
		$gp_settings['image_width'] = get_post_meta($post_id, '_'.$dirname.'_image_width', true);
	} else {
		$gp_settings['image_width'] = get_option($dirname.'_page_image_width');
	}
	if(get_post_meta($post_id, '_'.$dirname.'_image_height', true) && get_post_meta($post_id, '_'.$dirname.'_image_height', true) != "") {
		$gp_settings['image_height'] = get_post_meta($post_id, '_'.$dirname.'_image_height', true);
	} else {
		$gp_settings['image_height'] = get_option($dirname.'_page_image_height');
	}

	// Image Wrap
	if(get_post_meta($post_id, '_'.$dirname.'_image_wrap', true) && get_post_meta($post_id, '_'.$dirname.'_image_wrap', true) != "Default") {
		$gp_settings['image_wrap'] = get_post_meta($post_id, '_'.$dirname.'_image_wrap', true);
	} else {
		$gp_settings['image_wrap'] = get_option($dirname.'_page_image_wrap');
	}

	// Hard Crop
	if(get_post_meta($post_id, '_'.$dirname.'_hard_crop', true) && get_post_meta($post_id, '_'.$dirname.'_hard_crop', true) != "Default") {
		$gp_settings['hard_crop'] = get_post_meta($post_id, '_'.$dirname.'_hard_crop', true);
	} else {
		$gp_settings['hard_crop'] = get_option($dirname.'_page_hard_crop');
	}
			
	// Left Sidebar
	if(get_post_meta($post_id, '_'.$dirname.'_sidebar_left', true) && get_post_meta($post_id, '_'.$dirname.'_sidebar_left', true) != 'Default') {
		$gp_settings['sidebar_left'] = get_post_meta($post_id, '_'.$dirname.'_sidebar_left', true);
	} else {
		$gp_settings['sidebar_left'] = get_option($dirname.'_page_sidebar_left');
	}

	// Right Sidebar
	if(get_post_meta($post_id, '_'.$dirname.'_sidebar_right', true) && get_post_meta($post_id, '_'.$dirname.'_sidebar_right', true) != 'Default') {
		$gp_settings['sidebar_right'] = get_post_meta($post_id, '_'.$dirname.'_sidebar_right', true);
	} else {
		$gp_settings['sidebar_right'] = get_option($dirname.'_page_sidebar_right');
	}

	// Layout
	if(get_post_meta($post_id, '_'.$dirname.'_layout', true) && get_post_meta($post_id, '_'.$dirname.'_layout', true) != "Default") {
		$gp_settings['layout'] = get_post_meta($post_id, '_'.$dirname.'_layout', true);
	} else {
		$gp_settings['layout'] = get_option($dirname.'_page_layout');
	}
		// Title
	if(get_post_meta($post_id, '_'.$dirname.'_title', true) && get_post_meta($post_id, '_'.$dirname.'_title', true) != 'Default') {
		$gp_settings['title'] = get_post_meta($post_id, '_'.$dirname.'_title', true);
	} else {
		$gp_settings['title'] = get_option($dirname.'_page_title');
	} 	
		
	// Post Meta						
	$gp_settings['meta_date'] = get_option($dirname.'_page_date');
	$gp_settings['meta_author'] = get_option($dirname.'_page_author');
	$gp_settings['meta_cats'] = '1';
	$gp_settings['meta_tags'] = '1';
	$gp_settings['meta_comments'] = get_option($dirname.'_page_comments');
	
	// Author Info Panel
	$gp_settings['author_info'] = get_option($dirname.'_page_author_info');
						
}

?>