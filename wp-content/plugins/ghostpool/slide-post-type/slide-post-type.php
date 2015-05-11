<?php 

if(!class_exists('GP_Slide_Post')) {

	global $dirname; $dirname = 'buddy';	
	
	class GP_Slide_Post {

		public function __construct() {

			global $dirname;
						
			add_action('init', array(&$this, 'gp_post_type_slide'));	
			add_action('manage_posts_custom_column',  array(&$this, 'gp_slide_custom_columns'));
			if(get_option('template') == $dirname) {
				add_action('admin_menu', array(&$this, 'gp_enable_slide_sort')); 			
				add_action('admin_print_styles', array(&$this, 'gp_slides_print_styles'));
				add_action('admin_print_scripts', array(&$this, 'gp_slides_print_scripts'));
				add_action('wp_ajax_slide_sort', array(&$this, 'gp_save_slide_order'));
			}
			
		}


		public function gp_post_type_slide() {

			/////////////////////////////////////// Slide Post Type ///////////////////////////////////////
	
	
			register_post_type('slide', array(
				'labels' => array(
					'name' => __('Slides', 'gp_lang'),
					'singular_name' => __('Slide', 'gp_lang'),
					'all_items' => __('All Slides', 'gp_lang'),
					'add_new' => _x('Add New', 'slide', 'gp_lang'),
					'add_new_item' => __('Add New Slide', 'gp_lang'),
					'edit_item' => __('Edit Slide', 'gp_lang'),
					'new_item' => __('New Slide', 'gp_lang'),
					'view_item' => __('View Slide', 'gp_lang'),
					'search_items' => __('Search Slides', 'gp_lang'),
					'menu_name' => __('Slides', 'gp_lang')
				),	
				'public' => true,
				'exclude_from_search' => true,
				'show_ui' => true,
				'show_in_nav_menus' => false,
				'_builtin' => false,
				'_edit_link' => 'post.php?post=%d',
				'capability_type' => 'post',
				'hierarchical' => false,
				'rewrite' => array("slug" => "slide"),
				'menu_position' => 20,
				'with_front' => true,
				'supports' => array('title', 'thumbnail', 'editor', 'author', 'custom-fields')
			));
	
	
			/////////////////////////////////////// Slide Categories ///////////////////////////////////////
	
	
			register_taxonomy('slide_categories', 'slide', array(
				'labels' => array(
					'name' => __('Slide Categories', 'gp_lang'),
					'singular_name' => __('Slide Category', 'gp_lang'),
					'all_items' => __('All Slide Categories', 'gp_lang'),
					'add_new' => _x('Add New', 'slide', 'gp_lang'),
					'add_new_item' => __('Add New Slide Category', 'gp_lang'),
					'edit_item' => __('Edit Slide Category', 'gp_lang'),
					'new_item' => __('New Slide Category', 'gp_lang'),
					'view_item' => __('View Slide Category', 'gp_lang'),
					'search_items' => __('Search Slide Categories', 'gp_lang'),
					'menu_name' => __('Slide Categories', 'gp_lang')
				),
				'show_in_nav_menus' => false,
				'hierarchical' => true,
				'rewrite' => array('slug' => 'slide-categories')
			));


			/////////////////////////////////////// Slide Page Layout ///////////////////////////////////////
	
	
			add_filter('manage_edit-slide_columns', 'gp_slide_edit_columns');
		
			function gp_slide_edit_columns($columns) {
					$columns = array(
						"cb" => "<input type=\"checkbox\" />",
						"title" => __('Title', 'gp_lang'),
						"slide_desc" => __('Description', 'gp_lang'),	
						"slide_categories" => __('Categories', 'gp_lang'),
						"slide_image" => __('Image', 'gp_lang'),				
						"date" => __('Date', 'gp_lang')
					);
	
					return $columns;
			}

		}


		public function gp_slide_custom_columns($column) {
				
			global $dirname;
			
			switch ($column) {
				case "slide_desc":
					if(get_the_excerpt()) { echo excerpt(125); }
					break;
				case "slide_categories":
					echo get_the_term_list(get_the_id(), 'slide_categories', '', ', ', '');
					break;
				case "slide_image":
					if(has_post_thumbnail()) { the_post_thumbnail(array(100,100)); }
					break;					
				}
		}


		/////////////////////////////////////// Slide Order Menu ///////////////////////////////////////
	
	
		public function gp_enable_slide_sort() {
			add_submenu_page('edit.php?post_type=slide', __('Order Slides', 'gp_lang'), __('Order Slides', 'gp_lang'), 'edit_posts', basename(__FILE__), array(&$this, 'gp_sort_slides'));
		}
 
		public function gp_sort_slides() {
	
			$slides = new WP_Query('post_type=slide&posts_per_page=-1&orderby=menu_order&order=ASC');

		?>

			<div id="gp-theme-options" class="wrap">
	
				<div id="icon-edit" class="icon32"><br></div> <h2><?php _e('Order Slides', 'gp_lang'); ?> <img src="<?php echo site_url(); ?>/wp-admin/images/loading.gif" id="loading-animation" /></h2>
		
				<ul id="sort-list">
		
					<?php if($slides->have_posts()) : while ($slides->have_posts()) : $slides->the_post();
					$nonce = wp_create_nonce('my-nonce');
					global $dirname; ?>
			
						<li id="<?php the_ID(); ?>">
					
							<?php if(has_post_thumbnail()) { the_post_thumbnail(array(100,100)); } ?>
					
							<span>
								<h4 style="margin: 0 0 10px 0;"><?php the_title(); ?></h4>
								<a href="<?php echo site_url(); ?>/wp-admin/post.php?post=<?php the_ID(); ?>&action=edit"><?php _e('Edit', 'gp_lang'); ?></a>					
							</span>
					
							<div class="clear"></div>
				
						</li>					
				
					<?php endwhile; endif; wp_reset_query(); ?>
			
				</ul>
		
			</div>
 
		<?php
		}

		public function gp_slides_print_styles() {
			global $pagenow;
 
			$pages = array('edit.php', 'admin.php');
			if (in_array($pagenow, $pages))
				wp_enqueue_style('gp-admin', get_template_directory_uri().'/lib/admin/css/admin.css');
		}


		public function gp_slides_print_scripts() {
			global $pagenow;
 
			$pages = array('edit.php', 'admin.php');
			if (in_array($pagenow, $pages)) {
				wp_enqueue_script('jquery-ui-sortable');
				wp_enqueue_script('gp-sort-slides', get_template_directory_uri().'/lib/admin/scripts/sort-slides.js');
			}
		}

		public function gp_save_slide_order() {
			global $wpdb;
 
			$order = explode(',', $_POST['order']);
			$counter = 0;
 
			foreach ($order as $slide_id) {
				$wpdb->update($wpdb->posts, array('menu_order' => $counter), array('ID' => $slide_id));
				$counter++;
			}
			die(1);
		}

	}

}

?>