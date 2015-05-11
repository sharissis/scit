<?php


// Custom BuddyPress/bbPress Body Classes

add_filter('body_class', 'gp_bp_class');
function gp_bp_class($classes) {
	if((function_exists('bp_is_active') && !bp_is_blog_page()) OR (function_exists('is_bbpress') && is_bbpress()) OR is_page_template('activity/index.php')) {
		if(is_rtl()) {
			$classes[] = 'rtl bp-wrapper';
		} else {
			$classes[] = 'bp-wrapper';
		}
	}
	return $classes;
}


if(function_exists('bp_is_active')) {


	// Load BuddyPress Ajax

	require_once(BP_PLUGIN_DIR . '/bp-themes/bp-default/_inc/ajax.php');


	// Avatar Dimensions

	if(!defined('BP_AVATAR_THUMB_WIDTH'))
		define('BP_AVATAR_THUMB_WIDTH', 80);

	if(!defined('BP_AVATAR_THUMB_HEIGHT'))
		define('BP_AVATAR_THUMB_HEIGHT', 80);

	if(!defined('BP_AVATAR_FULL_WIDTH'))
		define('BP_AVATAR_FULL_WIDTH', 128);

	if(!defined('BP_AVATAR_FULL_HEIGHT'))
		define('BP_AVATAR_FULL_HEIGHT', 128);


	// JS Words For Translation

	if(!function_exists('bp_dtheme_enqueue_scripts')) {

		function bp_dtheme_enqueue_scripts() {
	
			wp_enqueue_style('gp-buddypress', get_template_directory_uri().'/buddypress/bp.css');

			wp_enqueue_script('dtheme-ajax-js', BP_PLUGIN_URL.'bp-themes/bp-default/_inc/global.js', array('jquery'), '', true);

			wp_enqueue_script('gp-bp-js', get_template_directory_uri().'/buddypress/bp.js', array('jquery'), '', true);
			
			$params = array(
				'my_favs'           => __('My Favorites', 'gp_lang'),
				'accepted'          => __('Accepted', 'gp_lang'),
				'rejected'          => __('Rejected', 'gp_lang'),
				'show_all_comments' => __('Show all comments for this thread', 'gp_lang'),
				'show_x_comments'   => __('Show all %d comments', 'gp_lang'),
				'show_all'          => __('Show all', 'gp_lang'),
				'comments'          => __('comments', 'gp_lang'),
				'close'             => __('Close', 'gp_lang'),
				'view'              => __('View', 'gp_lang'),
				'mark_as_fav'	    => __('Favorite', 'gp_lang'),
				'remove_fav'	    => __('Remove Favorite', 'gp_lang'),
				'unsaved_changes'   => __('Your profile has unsaved changes. If you leave the page, the changes will be lost.', 'gp_lang'),
			);	
			wp_localize_script('dtheme-ajax-js', 'BP_DTheme', $params);
		
		}
	
		add_action('wp_enqueue_scripts', 'bp_dtheme_enqueue_scripts');
	}


	// Buttons

	if(!is_admin() OR (defined('DOING_AJAX') && DOING_AJAX)) {

		// Friends button
		if(bp_is_active('friends'))
			add_action('bp_member_header_actions', 'bp_add_friend_button', 5);

		// Activity button
		if(bp_is_active('activity'))
			add_action('bp_member_header_actions', 'bp_send_public_message_button', 20);

		// Messages button
		if (bp_is_active('messages'))
			add_action('bp_member_header_actions', 'bp_send_private_message_button', 20);

		// Group buttons
		if(bp_is_active('groups')) {
			add_action('bp_group_header_actions', 'bp_group_join_button', 5);
			add_action('bp_group_header_actions', 'bp_group_new_topic_button', 20);
			add_action('bp_directory_groups_actions', 'bp_group_join_button');
		}

		// Blog button
		if(bp_is_active('blogs'))
			add_action( 'bp_directory_blogs_actions', 'bp_blogs_visit_blog_button');

	}


}

?>