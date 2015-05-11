<?php
/* Bones Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/bones/
*/


// let's create the function for the custom type

//	Custom Loop to easily add multiple Custom Post Types
function custom_posts_loop() {
	$post_types = array(
						//array("database_value", "Name", "Singular Name")	//	"Name" will be used as the Slug and put to lowercase.  Database Value should be unique to Theme/Purpose to avoid collisions with basic WP or other Plugin functionality.
						//array("database_value", "Name", "Singular Name", "Custom Cat", "Custom Tag")
						array("scit_performer", "Performers", "Performer", 1, 1),	//	1 = True, 0 = False
						array("scit_team", "Teams", "Team", 1, 1),
						array("scit_course", "Curriculum", "Course", 1, 1)
						//,array("scit_show", "Shows", "Show")
						//,array("scit_staff", "Staff", "Staff Member")
						//,array("scit_course", "Courses", "Course")
					   );

	foreach ($post_types as $post_type) {
			// creating (registering) the custom type 
			register_post_type( $post_type[0], /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
			 	// let's now add all the options for this post type
				array('labels' => array(
					'name' => __($post_type[1], 'bonestheme'), /* This is the Title of the Group */
					'singular_name' => __($post_type[2], 'bonestheme'), /* This is the individual type */
					'all_items' => __('All ' . $post_type[1], 'bonestheme'), /* the all items menu item */
					'add_new' => __('Add New', 'bonestheme'), /* The add new menu item */
					'add_new_item' => __('Add New ' . $post_type[2], 'bonestheme'), /* Add New Display Title */
					'edit' => __( 'Edit', 'bonestheme' ), /* Edit Dialog */
					'edit_item' => __('Edit Post ' . $post_type[2], 'bonestheme'), /* Edit Display Title */
					'new_item' => __('New', 'bonestheme'), /* New Display Title */
					'view_item' => __('View', 'bonestheme'), /* View Display Title */
					'search_items' => __('Search ' . $post_type[1], 'bonestheme'), /* Search Custom Type Title */ 
					'not_found' =>  __('Nothing found in the Database.', 'bonestheme'), /* This displays if there are no entries yet */ 
					'not_found_in_trash' => __('Nothing found in Trash', 'bonestheme'), /* This displays if there is nothing in the trash */
					'parent_item_colon' => ''
					), /* end of arrays */
					'description' => __( 'Section for ' . $post_type[1], 'bonestheme' ), /* Custom Type Description */
					'public' => true,
					'publicly_queryable' => true,
					'exclude_from_search' => false,
					'show_ui' => true,
					'query_var' => true,
					'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */ 
					'menu_icon' => get_stylesheet_directory_uri() . '/library/images/custom-post-icon.png', /* the icon for the custom post type menu */
					'rewrite'	=> array( 'slug' => strtolower($post_type[1]), 'with_front' => false ), /* you can specify its url slug */
					'has_archive' => strtolower($post_type[1]), /* you can rename the slug here */
					'capability_type' => 'post',
					'hierarchical' => false,
					/* the next one is important, it tells what's enabled in the post editor */
					'supports' => array( 'title', 'editor', 'author', 'thumbnail')
			 	) /* end of options */
			); /* end of register post type */

			/* this adds your post categories to your custom post type */
			//register_taxonomy_for_object_type('category', $post_type[0]);
			/* this adds your post tags to your custom post type */
			//register_taxonomy_for_object_type('post_tag', $post_type[0]);

			//////////
			/*
			for more information on taxonomies, go here:
			http://codex.wordpress.org/Function_Reference/register_taxonomy
			*/

			// now let's add custom categories (these act like categories)
		    register_taxonomy( $post_type[0].'-category', 
		    	array($post_type[0]), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		    	array('hierarchical' => true,     /* if this is true, it acts like categories */             
		    		'labels' => array(
		    			'name' => __( $post_type[2].' Categories', 'bonestheme' ), /* name of the custom taxonomy */
		    			'singular_name' => __( $post_type[2].'Category', 'bonestheme' ), /* single taxonomy name */
		    			'search_items' =>  __( 'Search '.$post_type[2].' Categories', 'bonestheme' ), /* search title for taxomony */
		    			'all_items' => __( 'All '.$post_type[2].' Categories', 'bonestheme' ), /* all title for taxonomies */
		    			'parent_item' => __( 'Parent '.$post_type[2].' Category', 'bonestheme' ), /* parent title for taxonomy */
		    			'parent_item_colon' => __( 'Parent '.$post_type[2].' Category:', 'bonestheme' ), /* parent taxonomy title */
		    			'edit_item' => __( 'Edit '.$post_type[2].' Category', 'bonestheme' ), /* edit custom taxonomy title */
		    			'update_item' => __( 'Update '.$post_type[2].' Category', 'bonestheme' ), /* update title for taxonomy */
		    			'add_new_item' => __( 'Add New '.$post_type[2].' Category', 'bonestheme' ), /* add new title for taxonomy */
		    			'new_item_name' => __( 'New '.$post_type[2].' Category Name', 'bonestheme' ) /* name title for taxonomy */
		    		),
		    		'show_ui' => true,
		    		'query_var' => true,
		    		//'query_var' => true,
		    		//'rewrite' => array( 'slug' => strtolower($post_type[1]) ),
		    		//'rewrite' => array( 'slug' => $post_type[0].'-category'),
		    		//
		    		'rewrite' => array( 'slug' => strtolower($post_type[1]).'-category' ),
		    	)
		    );


			// now let's add custom tags (these act like categories)
		    register_taxonomy( $post_type[0].'-tag', 
		    	array($post_type[0]), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
		    	array('hierarchical' => false,    /* if this is false, it acts like tags */                
		    		'labels' => array(
		    			'name' => __( $post_type[2].' Tags', 'bonestheme' ), /* name of the custom taxonomy */
		    			'singular_name' => __( $post_type[2].' Tag', 'bonestheme' ), /* single taxonomy name */
		    			'search_items' =>  __( 'Search '.$post_type[2].' Tags', 'bonestheme' ), /* search title for taxomony */
		    			'all_items' => __( 'All '.$post_type[2].' Tags', 'bonestheme' ), /* all title for taxonomies */
		    			'parent_item' => __( 'Parent '.$post_type[2].' Tag', 'bonestheme' ), /* parent title for taxonomy */
		    			'parent_item_colon' => __( 'Parent '.$post_type[2].' Tag:', 'bonestheme' ), /* parent taxonomy title */
		    			'edit_item' => __( 'Edit '.$post_type[2].' Tag', 'bonestheme' ), /* edit custom taxonomy title */
		    			'update_item' => __( 'Update '.$post_type[2].' Tag', 'bonestheme' ), /* update title for taxonomy */
		    			'add_new_item' => __( 'Add New '.$post_type[2].' Tag', 'bonestheme' ), /* add new title for taxonomy */
		    			'new_item_name' => __( 'New '.$post_type[2].' Tag Name', 'bonestheme' ) /* name title for taxonomy */
		    		),
		    		'show_ui' => true,
		    		'query_var' => true,
		    	)
		    );   

		} 		

	} 

	// adding the function to the Wordpress init
	add_action( 'init', 'custom_posts_loop');

 
    

    
    /*
    	looking for custom meta boxes?
    	check out this fantastic tool:
    	https://github.com/jaredatch/Custom-Metaboxes-and-Fields-for-WordPress
    */


?>