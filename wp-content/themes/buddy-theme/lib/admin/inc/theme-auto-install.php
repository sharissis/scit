<?php

if(is_admin() && isset($_GET['activated']) && $pagenow == "themes.php") {

	global $dirname;

	if(get_option($dirname.'_theme_auto_install') !== '1') {
	

		/////////////////////////////////////// Delete Default Content ///////////////////////////////////////	


		// Default Posts
		$post = get_page_by_path('hello-world', OBJECT, 'post');
		if($post) { wp_delete_post($post->ID,true); }

		// Default Pages		
		$post = get_page_by_path('sample-page', OBJECT, 'page');
		if($post) { wp_delete_post($post->ID,true); }

				
		/////////////////////////////////////// Create Attachments ///////////////////////////////////////	


		require_once(ABSPATH . 'wp-admin/includes/file.php');
		require_once(ABSPATH . 'wp-admin/includes/media.php');
		require(ABSPATH . 'wp-admin/includes/image.php');		

		$filename1 = get_template_directory_uri().'/lib/images/placeholder1.png';
		$description1 = 'Image Description 1';
		media_sideload_image($filename1, 0, $description1);
		$last_attachment1 = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
		$attachment_id1 = $last_attachment1['ID'];
			
		$filename2 = get_template_directory_uri().'/lib/images/placeholder2.png';
		$description2 = 'Image Description 2';
		media_sideload_image($filename2, 0, $description2);
		$last_attachment2 = $wpdb->get_row($query = "SELECT * FROM {$wpdb->prefix}posts ORDER BY ID DESC LIMIT 1", ARRAY_A);
		$attachment_id2 = $last_attachment2['ID'];
    		

		/////////////////////////////////////// Create Pages ///////////////////////////////////////	
		

		/*************************************** Homepage ***************************************/	
		
		$new_page_title = 'Homepage';
		$new_page_content = '
[slider timeout="0" margins="0,0,15,0"]

[activity header="Latest Activity" per_page="5" comments="threaded" order="desc" pagination="true"]

[clear]

[posts image_width="100" image_height="75" meta="false" title_size="14" spacing="spacing-small" per_page="3" excerpt_length="200" header="Latest Posts"]

[clear]

[posts image_width="138" image_height="105" meta="false" title_size="12" image_wrap="false" spacing="spacing-small" per_page="4" cols="4" excerpt_length="0" header="The Features" pagination="false"]';
		$page_check = get_page_by_title($new_page_title);
		$new_page = array(
			'post_type' => 'page',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'closed'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			update_option('page_on_front', $new_page_id);
			update_option('show_on_front', 'page');
			update_post_meta($new_page_id, '_wp_page_template', 'homepage.php');			
		}
			

		/*************************************** Blog Page ***************************************/	
		
		$new_page_title = 'Blog Page';
		$new_page_content = '[posts]';
		$page_check = get_page_by_title($new_page_title);
		$new_page = array(
			'post_type' => 'page',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'closed'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);			
		}
		
			
		/*************************************** Contact Page ***************************************/	
		
		$new_page_title = 'Contact Page';
		$new_page_content = '[contact email="youraddress@email.com"]';
		$page_check = get_page_by_title($new_page_title);
		$new_page = array(
			'post_type' => 'page',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'closed'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);			
		}


		/*************************************** Login Page ***************************************/	
		
		$new_page_title = 'Login';
		$new_page_content = '';
		$page_check = get_page_by_title($new_page_title);
		$new_page = array(
			'post_type' => 'page',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'closed'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			update_post_meta($new_page_id, '_wp_page_template', 'login.php');		
		}
		
		
		/////////////////////////////////////// Create Posts ///////////////////////////////////////	


		/*************************************** Post 1 ***************************************/	
				
		$new_page_title = 'Post 1';
		$new_page_content = 'Compellingly drive goal-oriented initiatives without high-payoff internal or "organic" sources. Objectively provide access to cooperative human capital after highly efficient value. Credibly administrate multimedia based applications with cooperative niche markets. Seamlessly evolve focused models for state of the art quality vectors. Assertively harness long-term high-impact catalysts for change with.';
		$page_check = get_page_by_title($new_page_title, '', 'post');
		$new_page = array(
			'post_type' => 'post',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'open'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);			
			set_post_thumbnail($new_page_id, $attachment_id1);
		}
		
		
		/*************************************** Post 2 ***************************************/	
				
		$new_page_title = 'Post 2';
		$new_page_content = 'Proactively foster superior growth strategies and adaptive users. Conveniently deploy timely strategic theme areas vis-a-vis B2B scenarios. Progressively cultivate viral partnerships after state of the art e-commerce. Proactively synergize sticky best practices without ethical e-tailers. Quickly visualize customized data and synergistic infrastructures.';
		$page_check = get_page_by_title($new_page_title, '', 'post');
		$new_page = array(
			'post_type' => 'post',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'open'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			update_post_meta($new_page_id, '_'.$dirname.'_link_type', 'Lightbox Image');			
			set_post_thumbnail($new_page_id, $attachment_id2);			
		}


		/////////////////////////////////////// Create Slides ///////////////////////////////////////	
		

		/*************************************** Slide 1 ***************************************/	
				
		$new_page_title = 'Image Slide';
		$new_page_content = '';
		$page_check = get_page_by_title($new_page_title, '', 'slide');
		$new_page = array(
			'post_type' => 'slide',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'closed'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			update_post_meta($new_page_id, '_'.$dirname.'_slide_url', '#');
			update_post_meta($new_page_id, '_'.$dirname.'_slide_link_type', 'Page');
			update_post_meta($new_page_id, '_'.$dirname.'_slide_caption_position', 'Bottom Right Overlay');
			set_post_thumbnail($new_page_id, $attachment_id1);
		}
		
		
		/*************************************** Slide 2 ***************************************/	
				
		$new_page_title = 'Video Slide';
		$new_page_content = '';
		$page_check = get_page_by_title($new_page_title, '', 'slide');
		$new_page = array(
			'post_type' => 'slide',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'post_author' => 1,
			'comment_status' => 'closed'
		);
		if(!isset($page_check->ID)){
			$new_page_id = wp_insert_post($new_page);
			update_post_meta($new_page_id, '_'.$dirname.'_slide_video', 'http://vimeo.com/36006533');
			update_post_meta($new_page_id, '_'.$dirname.'_slide_title', true);
			set_post_thumbnail($new_page_id, $attachment_id2);
		}
		
		
		/////////////////////////////////////// Create Navigation ///////////////////////////////////////	


		/*************************************** Header Nav ***************************************/	
		
		$menu_name = 'Header';
		$menu_location = 'main-nav';
		$menu_exists = wp_get_nav_menu_object($menu_name);			
		if(!$menu_exists) {
			$menu_id = wp_create_nav_menu($menu_name);
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  'Home',
				'menu-item-classes' => 'home',
				'menu-item-url' => home_url('/'), 
				'menu-item-status' => 'publish')
			);
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' => 'Blog',
				'menu-item-object' => 'page',
				'menu-item-object-id' => get_page_by_path('blog-page')->ID,
				'menu-item-type' => 'post_type',
				'menu-item-status' => 'publish')
			);
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' => 'Contact',
				'menu-item-object' => 'page',
				'menu-item-object-id' => get_page_by_path('contact-page')->ID,			
				'menu-item-type' => 'post_type',
				'menu-item-status' => 'publish')
			);
			if(!has_nav_menu($menu_location)) {
				$locations = get_theme_mod('nav_menu_locations');
				$locations[$menu_location] = $menu_id;
				set_theme_mod('nav_menu_locations', $locations);
			}
		}
		
			
	}

	update_option($dirname.'_theme_auto_install', '1');
		
}	

?>