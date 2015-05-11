<?php
/*
Plugin Name: SCIT: Main Functions
Description: Explicit Functions required to be kept outside of Theme
Author:	Fitzgerald, Jerome
*/
/* Add your functions below this line */

global $blog_id;

///	CUSTOMIZATIONS ... Maybe move this to a child theme or something so it doesn't get overwritten...

//////////////////////////////////////////////////////////////////////
/////	I fucking overwrote all my functions.php alterations. :X
// Use your own external URL logo link
function wpc_url_login(){
	//return "http://steelcityimprov.com/"; // your URL here
	 return get_bloginfo('url');; // your URL Here
}
add_filter('login_headerurl', 'wpc_url_login');

// Custom WordPress Login Logo
function login_css() {
	wp_enqueue_style( 'login_css', get_template_directory_uri() . '/lib/css/login.css' );
}
add_action('login_head', 'login_css');

// Custom WordPress Footer
function remove_footer_admin () {
	echo 'Copyright (c) 2010-2013 Steel City Improv Theater, LLC. All Rights Reserved';
}
add_filter('admin_footer_text', 'remove_footer_admin');

//	add_theme_support( 'post-thumbnails' ); 



// remove version number from head & feeds
function disable_version() { return ''; }
add_filter('the_generator','disable_version');
remove_action('wp_head', 'wp_generator');
//remove WooCommere generator tag
 function remove_woocommerce_tag() {
 remove_action('wp_head',array($GLOBALS['woocommerce'], 'generator'));
 }
 add_action('get_header','remove_woocommerce_tag');

//Making jQuery Google API
function modify_jquery() {
	if (!is_admin()) {
		// comment out the next two lines to load the local copy of jQuery
		wp_deregister_script('jquery');
		//wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', false, '1.9.1');\
		wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js', false, '1.8.3');
		//wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', false, '1.7.2');
		//
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'modify_jquery');

//	Swap Demo Store Notification with new Class to have it show on BOTTOM
if (!function_exists('woocommerce_demo_store')) {
  function woocommerce_demo_store() {
    if (get_option('woocommerce_demo_store')=='no') return;
    $message = '<p class="demo_stor3">'.__('We are making some changes that might impact ordering.  When this message is gone, you can safely place your order.', 'woocommerce').'</p>';
    echo apply_filters('woocommerce_demo_store', $message );
  }
}

/* Disable the Admin Bar.
	Why?
	Because it adds 28PX to the CSS... I guess we could position: absolute it, but for now. GET RID OF THIS!
 */
add_filter( 'show_admin_bar', '__return_false' );

/* Remove the Admin Bar preference in user profile */
remove_action( 'personal_options', '_admin_bar_preferences' );


// Alter Events Calendar from IMPROT to SUBSCRIBE
	// if ( function_exists( 'tribe_get_ical_link' ) ) { 
	// 	$calurl = tribe_get_ical_link();
	// 	$icalurl = preg_replace('(https?://)', 'webcal://', $calurl );
	// 	$gcalurl = 'https://www.google.com/calendar/render?cid=' . $calurl ;
	// }

remove_action( 'tribe_get_ical_link', '' );


//	Exclude Members
// to exclude only defined roles in the Buddypress Members LOOP

function exclude_by_role($exclude_roles) {

$memberArray = array();

if (bp_has_members()) :
	while (bp_members()) : bp_the_member();
		$user = new WP_User( bp_get_member_user_id() );
		$user_role = $user->roles[0];
		foreach ($exclude_roles as $exclude_role) {
			if ($exclude_role==$user_role) {
				array_push($memberArray, $user->ID);
				break;
			}
		}
	endwhile;
endif;

$theExcludeString=implode(",",$memberArray);

return $theExcludeString;
}
/////

/// Custom Out of Stock
add_filter('woocommerce_get_availability','custom_get_availability');

function custom_get_availability($availability){
	// Out of Stock
	//$availability['availability'] = str_ireplace('Out of stock', 'Coming Soon...', $availability['availability']);
	$availability['availability'] = str_ireplace('Out of stock', 'Sold Out!', $availability['availability']);
	//$availability['availability'] = str_ireplace('Out of stock', 'Call for Price', $availability['availability']);

	// In Stock
	$availability['availability'] = str_ireplace('In stock', '', $availability['availability']);

	// Only
	$availability['availability'] = str_ireplace('Only', 'Only', $availability['availability']);

	// Left
	$availability['availability'] = str_ireplace('left', 'left', $availability['availability']);

return $availability;
}

/////////	Virtual Items set to COMPLETE IMMEDIATELY
add_filter( 'woocommerce_payment_complete_order_status', 'virtual_order_payment_complete_order_status', 10, 2 );

function virtual_order_payment_complete_order_status( $order_status, $order_id ) {
  $order = new WC_Order( $order_id );
  
  if ( $order_status == 'processing' && 
       ( $order->status == 'on-hold' || $order->status == 'pending' || $order->status == 'failed' ) ) {
    $virtual_order = true;
    
    if ( count( $order->get_items() ) > 0 ) {
      foreach( $order->get_items() as $item ) {
      
        if ( $item['id'] > 0 ) {
          
          $_product = $order->get_product_from_item( $item );
          
          if ( ! $_product->is_virtual() ) {
            $virtual_order = false;
            break;
          }
          
        }
      }
    }
    
    // virtual order, mark as completed
    if ( $virtual_order ) {
      return 'completed';
    }
  }
  
  // non-virtual order, return original status
  return $order_status;
}

//	Specific Functions for MAIN Site Only.
if( $blog_id == '1' ) { 
/////
/*	Ported from Bones, but highly modified to use multiple arrays.
2. library/custom-post-type.php
    - an example custom post type
    - example custom taxonomy (like categories)
    - example custom taxonomy (like tags)
*/
require_once('lib/custom-post-type.php'); 

////	POST TO POST
///////////////////////////////
//	Posts 2 Posts
/*
Text
Textarea
WYSIWYG
Select
Radio
Checkbox
*/

function my_connection_types() {
    // Make sure the Posts 2 Posts plugin is active.
    if ( !function_exists( 'p2p_register_connection_type' ) )
        return;
	/////////////
	//	Wordpress User to performer
	p2p_register_connection_type( array(
		'name' => 'scit_user_matrix',
		'from' => 'scit_performer',
		'to' => 'user'
		, 'title' => array(
		    'from' => __( 'Connected Users (Wordpress)', 'my-textdomain' ),
		    'to' => __( 'Connected Users (Performer)', 'my-textdomain' )
		  )
		, sortable => 'any'
		)
	);
	////////////
	//	performers to Teams
	p2p_register_connection_type(
	array(
		'name' => 'scit_performers_to_teams',
		'from' => 'scit_performer',
		'to' => 'scit_team',
		'title' => array(
		    'from' => __( 'Connected Team(s)', 'my-textdomain' ),
		    'to' => __( 'Connected Performer(s)', 'my-textdomain' )
		  )
		, sortable => 'any'
		, 'fields' => array(
			"scit_performerTeam_roleType"	=> array(
				"name"			=> "scit_performerTeam_roleType",
				"title"			=> "Role",
				"description"	=> "",
				"type"			=>	"select",
				"value"			=> array ("Performer", "Technical", "Producer", "Director")
				)
			// , "scit_performerTeam_active"	=>	array(
			// 	"name"			=> "scit_performerTeam_active",
			// 	"title"			=> "Active",
			// 	"description"	=> "",
			// 	"type"			=>	"checkbox"
			// 	)
			// , "scit_performerTeam_captain"	=>	array(
			// 	"name"			=> "scit_performerTeam_captain",
			// 	"title"			=> "Captain",
			// 	"description"	=> "",
			// 	"type"			=>	"checkbox"
			// 	)
			)
			, 'context' => 'advanced'
			, 'prevent_duplicates' => false
			,'reciprocal' => true
			,'admin_column' => 'any'
			,'cardinality' => 'many-to-many'
			,'post_status' => 'inherit'
		)
	);
	//	End 01.
	/////////////
	//	Teams to EVENTS
	p2p_register_connection_type(
	array(
		'name' => 'scit_teams_to_events',
		'from' => 'scit_team',
		'to' => 'tribe_events',
		'title' => array(
		    'from' => __( 'Connected Event (Headlining)', 'my-textdomain' ),
		    'to' => __( 'Connected Team (Headlining)', 'my-textdomain' )
		  )
		, sortable => 'any'
		,
		)
	);
	//	End
	/////////////
	//	Performer to EVENTS
	// p2p_register_connection_type(
	// array(
	// 	'name' => 'scit_performers_to_events',
	// 	'from' => 'scit_performer',
	// 	'to' => 'tribe_events',
	// 	'title' => array(
	// 	    'from' => __( 'Connected Event (Headlining)', 'my-textdomain' ),
	// 	    'to' => __( 'Connected Performer (Headlining)', 'my-textdomain' )
	// 	  ),
	// 	)
	// );
	//	End
	//
	//	Products to Performers
	p2p_register_connection_type(
	array(
		'name' => 'scit_products_to_performers',
		'from' => 'product',
		'to' => 'scit_performer',
		'title' => array(
		    'from' => __( 'Connected User (Instructor)', 'my-textdomain' ),
		    'to' => __( 'Connected Product (Course)', 'my-textdomain' )
		  )
		, sortable => 'any'
		,
		)
	);
	//	End Products to Performers
	/////////////
	//	Performers to Curriculum
	//  Note: this might be better
	p2p_register_connection_type(
	array(
		'name' => 'scit_curriculum_to_performers',
		'from' => 'scit_course',
		'to' => 'scit_performer',
		'title' => array(
		    'from' => __( 'Connected User (Instructor)', 'my-textdomain' ),
		    'to' => __( 'Connected Product (Course)', 'my-textdomain' )
		  )
		, sortable => 'any'
		,
		)
	);
	//	End Curriculum to performer
	/////////////
	//	Featured Teams/ Performers (Users)
	// 	01 of 02: Featured Performer(s)
	p2p_register_connection_type(
	array(
		'name' => 'scit_events_to_performers_Featured',
		'from' => 'tribe_events',
		//'to' => 'user'
		'to' => 'scit_performer',
		'title' => array(
		    'from' => __( 'Connected Performer (Featured)', 'my-textdomain' ),
		    'to' => __( 'Connected Event (Featured)', 'my-textdomain' )
		  )
		, sortable => 'any'
		,
		//,'reciprocal' => true
		////,'admin_column' => 'any'
		//,'cardinality' => 'many-to-many'
		//,'post_status' => 'inherit'
		
		)
	);
	//
	// 	02 of 02: Featured Team(s)
	p2p_register_connection_type(
	array(
		'name' => 'scit_teams_to_events_Featured',
		'from' => 'scit_team',
		'to' => 'tribe_events',
		'title' => array(
		    'from' => __( 'Connected Event (Featured)', 'my-textdomain' ),
		    'to' => __( 'Connected Team (Featured)', 'my-textdomain' )
		  )
		, sortable => 'any'
		,
		)
	);
	//	End
	//	
	//	
	//	
	/////////////
	//	Products to Courses
	p2p_register_connection_type(
	array(
		'name' => 'scit_products_to_courses',
		'from' => 'product',
		'to' => 'scit_course',
		'title' => array(
		    'from' => __( 'Connected Course(s)', 'my-textdomain' ),
		    'to' => __( 'Connected Product(s)', 'my-textdomain' )
		  )
		, sortable => 'any'
		,
		)
	);
}

add_action( 'p2p_init', 'my_connection_types' );




//add_rewrite_rule('^performers/([^/]*)/([^/]*)/?$' ,'index.php?performer=$matches[2]','top');	
//add_rewrite_rule('^teams/([^/]*)/([^/]*)/?$' ,'index.php?team=$matches[2]','top');	
//////////////////////////////////////////////////////////////////////


/**
 * Fix compatibility issues with The Event Calendar and Posts 2 Posts WordPress Plugins
 * Issue arrises with how nested select queries function when P2P expects a single column.
 */

function tribe_to_p2p_pre_get_posts( $query ){
    if(isset($query->_p2p_capture) && $query->_p2p_capture) {
        add_filter( 'posts_fields', 'tribe_to_p2p_setupFields', 20);    
    } else {
        remove_filter( 'posts_fields', 'tribe_to_p2p_setupFields', 20); 
    }
    return $query;
}
function tribe_to_p2p_setupFields( $fields ){
    global $wpdb;
    $fields = "{$wpdb->posts}.ID";
    return $fields;
}
add_action( 'pre_get_posts', 'tribe_to_p2p_pre_get_posts');







// add_filter('posts_orderby', 'date_asc' );
// function date_asc( $orderby )
// {
//   global $teamEventQuery;

//   if(is_singular('performer')) {
//      return "start_date ASC";
//   }

//   return $orderby;
// }


// Hook in
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

// Our hooked in function - $fields is passed via the filter!
function custom_override_checkout_fields( $fields ) {
     $fields['order']['order_comments']['placeholder'] = 'Please provide Name / E-Mail / Phone if applicable.';
     $fields['order']['order_comments']['label'] = 'If you are purchasing this for someone else, please put their details here.<br/> Or if you have some notes you\'d wish to share:';
     return $fields;
}


/////////////////////////////////////////////////////////////////////////////////////////
/* Remove Woocommerce User Fields */
add_filter( 'woocommerce_billing_fields' , 'custom_override_billing_fields' );
add_filter( 'woocommerce_shipping_fields' , 'custom_override_shipping_fields' );


function custom_override_billing_fields( $fields ) {
  // unset($fields['billing_first_name']);
  // unset($fields['billing_last_name']);
  // unset($fields['billing_phone']);
  // unset($fields['billing_email']);
  //
  unset($fields['billing_state']);
  unset($fields['billing_country']);
  unset($fields['billing_company']);
  unset($fields['billing_address_1']);
  unset($fields['billing_address_2']);
  unset($fields['billing_postcode']);
  unset($fields['billing_city']);
  return $fields;
}
function custom_override_shipping_fields( $fields ) {
  unset($fields['shipping_first_name']);
  unset($fields['shipping_last_name']);
  unset($fields['shipping_phone']);
  unset($fields['shipping_email']);
  //
  unset($fields['shipping_state']);
  unset($fields['shipping_country']);
  unset($fields['shipping_company']);
  unset($fields['shipping_address_1']);
  unset($fields['shipping_address_2']);
  unset($fields['shipping_postcode']);
  unset($fields['shipping_city']);
  return $fields;
}
/* End - Remove Woocommerce User Fields */

/*

		Service Agreement to Course Enrollment Policy.
		We will need separate agreements for other Products down the line.

		This is separate from Terms & Conditions, but for now we should comment it out.

 */
/*
//	ADMIN
	add_action( 'woocommerce_settings_page_options', 'service_agreement' );
	add_action( 'woocommerce_update_options_pages', 'save_service_agreement' );

	function service_agreement() {

		woocommerce_admin_fields( array(
			array(  
				'name' 		=> __( 'Service Agreement Page ID', 'woocommerce' ),
				'desc' 		=> __( 'If you define a \'Service Agreement\' page the customer will be asked if they agree to it when checking out.', 'woocommerce' ),
				'tip' 		=> '',
				'id' 		=> 'woocommerce_service_agreement_page_id',
				'std' 		=> '',
				'class'		=> 'chosen_select_nostd',
				'css' 		=> 'min-width:300px;',
				'type' 		=> 'single_select_page',
				'desc_tip'	=>  true,
			),
		
		));
	
	}
	
	function save_service_agreement() {
		
		if ( isset($_POST['woocommerce_service_agreement_page_id']) ) :
            update_option( 'woocommerce_service_agreement_page_id', woocommerce_clean( $_POST['woocommerce_service_agreement_page_id']) );
		else :
			delete_option('woocommerce_service_agreement_page_id');
		endif;
	}

	//	FRONTEND
	

	add_action( 'woocommerce_review_order_after_submit' , 'add_service_agreement_checkbox' );
	add_action( 'woocommerce_checkout_process' , 'check_service_agreement' );
	
	function add_service_agreement_checkbox() {
		
		global $woocommerce;
		if (woocommerce_get_page_id('service_agreement')>0) : ?>
			<p class="form-row service_agreement">
				<label for="service_agreement" class="checkbox"><?php _e('I agree to the', 'woocommerce'); ?> <a href="<?php echo esc_url( get_permalink(woocommerce_get_page_id('service_agreement')) ); ?>" target="_blank"><?php _e('service agreement', 'woocommerce'); ?></a></label>
				<input type="checkbox" class="input-checkbox" name="service_agreement" <?php if (isset($_POST['service_agreement'])) echo 'checked="checked"'; ?> id="service_agreement" />
			</p>
			<?php endif;
		
	}
	
	
	function check_service_agreement() {
		
		global $woocommerce;
		if (!isset($_POST['woocommerce_checkout_update_totals']) && empty($_POST['service_agreement']) && woocommerce_get_page_id('service_agreement')>0 ) :
			
			$woocommerce->add_error( __('You must review and agree to our service agreement.', 'woocommerce') );
			
		endif;
		
	}
*/

//	Instead, adapt the "terms & conditions" to read Course Enrollment POlicy
 
 /// Custom Out of Stock
add_filter('woocommerce_get_terms','custom_get_terms');

function custom_get_terms($terms){
	// Course Enrollment Policy
	$terms['terms'] = str_ireplace('terms &amp; conditions', 'Course Enrollment Policy', $terms['terms']);

return $availability;
}

// function my_custom_bbp_stylesheet(){

//     wp_deregister_style( 'bbp-default-bbpress' );
//     wp_enqueue_style(  );

// }
// add_action( 'bbp_enqueue_scripts', 'my_custom_bbp_stylesheet' );

//
// Get Rid of the BuddyPress CSS Files for Main Site that does not display.
add_action( 'wp_print_styles', 'my_deregister_styles', 100 );

function my_deregister_styles() {
	wp_deregister_style( 'bbp-default-bbpress' );
	wp_deregister_style( 'bbp-default-bbpress-css' );
	wp_deregister_style( 'bp-legacy-css' );
	wp_deregister_style( 'swa-css' );
	//wp_deregister_script( 'jquery');
	//
	wp_deregister_script( 'bbp-default-bbpress' );
	wp_deregister_script( 'bbp-default-bbpress-js' );
	wp_deregister_script( 'bp-legacy-js' );
	wp_deregister_script( 'swa-js' );

	wp_deregister_script( 'comment-reply' );

}

//	Close IF Statement for BLOG MAIN SITE
}

//	Turn off Auto-Save
function disableAutoSave(){
    wp_deregister_script('autosave');
}
add_action( 'wp_print_scripts', 'disableAutoSave' );

//	Remove BuddyPress Items on Main Site and SCIT.TV (BP needs to eb installed across all)
if( $blog_id == '1' || $blog_id == '3' ) { 

	add_action( 'admin_menu', 'my_remove_menu_pages' );

	function my_remove_menu_pages() {
		remove_menu_page('edit.php?post_type=forum');
		remove_menu_page('edit.php?post_type=topic');	
		remove_menu_page('edit.php?post_type=reply');
		remove_menu_page('index.php?page=bbp-update')	;
	}
}


/* 	************************************************************ 	*/
/*	EMOJIS 	*/
function emoji_ob_call($buffer){ // $buffer contains entire page

/*
	Create 3 Tone Array
	ID, Find, Replace, Class



....	This is how the code _SHOULD_ work:

	01.	Identify the Folder
	02.	Cycle through the available .PNG files
	03.	Get Filename, remove .png ":filename:"
	04. Replace in Array

*/

//	Custom Aray
$emojiArray = array(
   array("0", "bowtie.png",":bowtie:")
,   array("1", "smile.png",":smile:")
,   array("2", "laughing.png",":laughing:")
,   array("3", "blush.png",":blush:")
,   array("4", "smiley.png",":smiley:")
,   array("5", "relaxed.png",":relaxed:")
,   array("6", "smirk.png",":smirk:")
,   array("7", "heart_eyes.png",":heart_eyes:")
,   array("8", "kissing_heart.png",":kissing_heart:")
,   array("9", "kissing_closed_eyes.png",":kissing_closed_eyes:")
,   array("10", "flushed.png",":flushed:")
,   array("11", "relieved.png",":relieved:")
,   array("12", "satisfied.png",":satisfied:")
,   array("13", "grin.png",":grin:")
,   array("14", "wink.png",":wink:")
,   array("15", "stuck_out_tongue_winking_eye.png",":stuck_out_tongue_winking_eye:")
,   array("16", "stuck_out_tongue_closed_eyes.png",":stuck_out_tongue_closed_eyes:")
,   array("17", "grinning.png",":grinning:")
,   array("18", "kissing.png",":kissing:")
,   array("19", "kissing_smiling_eyes.png",":kissing_smiling_eyes:")
,   array("20", "stuck_out_tongue.png",":stuck_out_tongue:")
,   array("21", "sleeping.png",":sleeping:")
,   array("22", "worried.png",":worried:")
,   array("23", "frowning.png",":frowning:")
,   array("24", "anguished.png",":anguished:")
,   array("25", "open_mouth.png",":open_mouth:")
,   array("26", "grimacing.png",":grimacing:")
,   array("27", "confused.png",":confused:")
,   array("28", "hushed.png",":hushed:")
,   array("29", "expressionless.png",":expressionless:")
,   array("30", "unamused.png",":unamused:")
,   array("31", "sweat_smile.png",":sweat_smile:")
,   array("32", "sweat.png",":sweat:")
,   array("33", "disappointed_relieved.png",":disappointed_relieved:")
,   array("34", "weary.png",":weary:")
,   array("35", "pensive.png",":pensive:")
,   array("36", "disappointed.png",":disappointed:")
,   array("37", "confounded.png",":confounded:")
,   array("38", "fearful.png",":fearful:")
,   array("39", "cold_sweat.png",":cold_sweat:")
,   array("40", "persevere.png",":persevere:")
,   array("41", "cry.png",":cry:")
,   array("42", "sob.png",":sob:")
,   array("43", "joy.png",":joy:")
,   array("44", "astonished.png",":astonished:")
,   array("45", "scream.png",":scream:")
,   array("46", "neckbeard.png",":neckbeard:")
,   array("47", "tired_face.png",":tired_face:")
,   array("48", "angry.png",":angry:")
,   array("49", "rage.png",":rage:")
,   array("50", "triumph.png",":triumph:")
,   array("51", "sleepy.png",":sleepy:")
,   array("52", "yum.png",":yum:")
,   array("53", "mask.png",":mask:")
,   array("54", "sunglasses.png",":sunglasses:")
,   array("55", "dizzy_face.png",":dizzy_face:")
,   array("56", "imp.png",":imp:")
,   array("57", "smiling_imp.png",":smiling_imp:")
,   array("58", "neutral_face.png",":neutral_face:")
,   array("59", "no_mouth.png",":no_mouth:")
,   array("60", "innocent.png",":innocent:")
,   array("61", "alien.png",":alien:")
,   array("62", "yellow_heart.png",":yellow_heart:")
,   array("63", "blue_heart.png",":blue_heart:")
,   array("64", "purple_heart.png",":purple_heart:")
,   array("65", "heart.png",":heart:")
,   array("66", "green_heart.png",":green_heart:")
,   array("67", "broken_heart.png",":broken_heart:")
,   array("68", "heartbeat.png",":heartbeat:")
,   array("69", "heartpulse.png",":heartpulse:")
,   array("70", "two_hearts.png",":two_hearts:")
,   array("71", "revolving_hearts.png",":revolving_hearts:")
,   array("72", "cupid.png",":cupid:")
,   array("73", "sparkling_heart.png",":sparkling_heart:")
,   array("74", "sparkles.png",":sparkles:")
,   array("75", "star.png",":star:")
,   array("76", "star2.png",":star2:")
,   array("77", "dizzy.png",":dizzy:")
,   array("78", "boom.png",":boom:")
,   array("79", "collision.png",":collision:")
,   array("80", "anger.png",":anger:")
,   array("81", "exclamation.png",":exclamation:")
,   array("82", "question.png",":question:")
,   array("83", "grey_exclamation.png",":grey_exclamation:")
,   array("84", "grey_question.png",":grey_question:")
,   array("85", "zzz.png",":zzz:")
,   array("86", "dash.png",":dash:")
,   array("87", "sweat_drops.png",":sweat_drops:")
,   array("88", "notes.png",":notes:")
,   array("89", "musical_note.png",":musical_note:")
,   array("90", "fire.png",":fire:")
,   array("91", "hankey.png",":hankey:")
,   array("92", "poop.png",":poop:")
,   array("93", "shit.png",":shit:")
,   array("94", "plus1.png",":+1:")
,   array("95", "thumbsup.png",":thumbsup:")
,   array("96", "-1.png",":-1:")
,   array("97", "thumbsdown.png",":thumbsdown:")
,   array("98", "ok_hand.png",":ok_hand:")
,   array("99", "punch.png",":punch:")
,   array("100", "facepunch.png",":facepunch:")
,   array("101", "fist.png",":fist:")
,   array("102", "v.png",":v:")
,   array("103", "wave.png",":wave:")
,   array("104", "hand.png",":hand:")
,   array("105", "open_hands.png",":open_hands:")
,   array("106", "point_up.png",":point_up:")
,   array("107", "point_down.png",":point_down:")
,   array("108", "point_left.png",":point_left:")
,   array("109", "point_right.png",":point_right:")
,   array("110", "raised_hands.png",":raised_hands:")
,   array("111", "pray.png",":pray:")
,   array("112", "point_up_2.png",":point_up_2:")
,   array("113", "clap.png",":clap:")
,   array("114", "muscle.png",":muscle:")
,   array("115", "metal.png",":metal:")
,   array("116", "fu.png",":fu:")
,   array("117", "walking.png",":walking:")
,   array("118", "runner.png",":runner:")
,   array("119", "running.png",":running:")
,   array("120", "couple.png",":couple:")
,   array("121", "family.png",":family:")
,   array("122", "two_men_holding_hands.png",":two_men_holding_hands:")
,   array("123", "two_women_holding_hands.png",":two_women_holding_hands:")
,   array("124", "dancer.png",":dancer:")
,   array("125", "dancers.png",":dancers:")
,   array("126", "ok_woman.png",":ok_woman:")
,   array("127", "no_good.png",":no_good:")
,   array("128", "information_desk_person.png",":information_desk_person:")
,   array("129", "raised_hand.png",":raised_hand:")
,   array("130", "bride_with_veil.png",":bride_with_veil:")
,   array("131", "person_with_pouting_face.png",":person_with_pouting_face:")
,   array("132", "person_frowning.png",":person_frowning:")
,   array("133", "bow.png",":bow:")
,   array("134", "couplekiss.png",":couplekiss:")
,   array("135", "couple_with_heart.png",":couple_with_heart:")
,   array("136", "massage.png",":massage:")
,   array("137", "haircut.png",":haircut:")
,   array("138", "nail_care.png",":nail_care:")
,   array("139", "boy.png",":boy:")
,   array("140", "girl.png",":girl:")
,   array("141", "woman.png",":woman:")
,   array("142", "man.png",":man:")
,   array("143", "baby.png",":baby:")
,   array("144", "older_woman.png",":older_woman:")
,   array("145", "older_man.png",":older_man:")
,   array("146", "person_with_blond_hair.png",":person_with_blond_hair:")
,   array("147", "man_with_gua_pi_mao.png",":man_with_gua_pi_mao:")
,   array("148", "man_with_turban.png",":man_with_turban:")
,   array("149", "construction_worker.png",":construction_worker:")
,   array("150", "cop.png",":cop:")
,   array("151", "angel.png",":angel:")
,   array("152", "princess.png",":princess:")
,   array("153", "smiley_cat.png",":smiley_cat:")
,   array("154", "smile_cat.png",":smile_cat:")
,   array("155", "heart_eyes_cat.png",":heart_eyes_cat:")
,   array("156", "kissing_cat.png",":kissing_cat:")
,   array("157", "smirk_cat.png",":smirk_cat:")
,   array("158", "scream_cat.png",":scream_cat:")
,   array("159", "crying_cat_face.png",":crying_cat_face:")
,   array("160", "joy_cat.png",":joy_cat:")
,   array("161", "pouting_cat.png",":pouting_cat:")
,   array("162", "japanese_ogre.png",":japanese_ogre:")
,   array("163", "japanese_goblin.png",":japanese_goblin:")
,   array("164", "see_no_evil.png",":see_no_evil:")
,   array("165", "hear_no_evil.png",":hear_no_evil:")
,   array("166", "speak_no_evil.png",":speak_no_evil:")
,   array("167", "guardsman.png",":guardsman:")
,   array("168", "skull.png",":skull:")
,   array("169", "feet.png",":feet:")
,   array("170", "lips.png",":lips:")
,   array("171", "kiss.png",":kiss:")
,   array("172", "droplet.png",":droplet:")
,   array("173", "ear.png",":ear:")
,   array("174", "eyes.png",":eyes:")
,   array("175", "nose.png",":nose:")
,   array("176", "tongue.png",":tongue:")
,   array("177", "love_letter.png",":love_letter:")
,   array("178", "bust_in_silhouette.png",":bust_in_silhouette:")
,   array("179", "busts_in_silhouette.png",":busts_in_silhouette:")
,   array("180", "speech_balloon.png",":speech_balloon:")
,   array("181", "thought_balloon.png",":thought_balloon:")
,   array("182", "feelsgood.png",":feelsgood:")
,   array("183", "finnadie.png",":finnadie:")
,   array("184", "goberserk.png",":goberserk:")
,   array("185", "godmode.png",":godmode:")
,   array("186", "hurtrealbad.png",":hurtrealbad:")
,   array("187", "rage1.png",":rage1:")
,   array("188", "rage2.png",":rage2:")
,   array("189", "rage3.png",":rage3:")
,   array("190", "rage4.png",":rage4:")
,   array("191", "suspect.png",":suspect:")
,   array("192", "trollface.png",":trollface:")
,   array("193", "sunny.png",":sunny:")
,   array("194", "umbrella.png",":umbrella:")
,   array("195", "cloud.png",":cloud:")
,   array("196", "snowflake.png",":snowflake:")
,   array("197", "snowman.png",":snowman:")
,   array("198", "zap.png",":zap:")
,   array("199", "cyclone.png",":cyclone:")
,   array("200", "foggy.png",":foggy:")
,   array("201", "ocean.png",":ocean:")
,   array("202", "cat.png",":cat:")
,   array("203", "dog.png",":dog:")
,   array("204", "mouse.png",":mouse:")
,   array("205", "hamster.png",":hamster:")
,   array("206", "rabbit.png",":rabbit:")
,   array("207", "wolf.png",":wolf:")
,   array("208", "frog.png",":frog:")
,   array("209", "tiger.png",":tiger:")
,   array("210", "koala.png",":koala:")
,   array("211", "bear.png",":bear:")
,   array("212", "pig.png",":pig:")
,   array("213", "pig_nose.png",":pig_nose:")
,   array("214", "cow.png",":cow:")
,   array("215", "boar.png",":boar:")
,   array("216", "monkey_face.png",":monkey_face:")
,   array("217", "monkey.png",":monkey:")
,   array("218", "horse.png",":horse:")
,   array("219", "racehorse.png",":racehorse:")
,   array("220", "camel.png",":camel:")
,   array("221", "sheep.png",":sheep:")
,   array("222", "elephant.png",":elephant:")
,   array("223", "panda_face.png",":panda_face:")
,   array("224", "snake.png",":snake:")
,   array("225", "bird.png",":bird:")
,   array("226", "baby_chick.png",":baby_chick:")
,   array("227", "hatched_chick.png",":hatched_chick:")
,   array("228", "hatching_chick.png",":hatching_chick:")
,   array("229", "chicken.png",":chicken:")
,   array("230", "penguin.png",":penguin:")
,   array("231", "turtle.png",":turtle:")
,   array("232", "bug.png",":bug:")
,   array("233", "honeybee.png",":honeybee:")
,   array("234", "ant.png",":ant:")
,   array("235", "beetle.png",":beetle:")
,   array("236", "snail.png",":snail:")
,   array("237", "octopus.png",":octopus:")
,   array("238", "tropical_fish.png",":tropical_fish:")
,   array("239", "fish.png",":fish:")
,   array("240", "whale.png",":whale:")
,   array("241", "whale2.png",":whale2:")
,   array("242", "dolphin.png",":dolphin:")
,   array("243", "cow2.png",":cow2:")
,   array("244", "ram.png",":ram:")
,   array("245", "rat.png",":rat:")
,   array("246", "water_buffalo.png",":water_buffalo:")
,   array("247", "tiger2.png",":tiger2:")
,   array("248", "rabbit2.png",":rabbit2:")
,   array("249", "dragon.png",":dragon:")
,   array("250", "goat.png",":goat:")
,   array("251", "rooster.png",":rooster:")
,   array("252", "dog2.png",":dog2:")
,   array("253", "pig2.png",":pig2:")
,   array("254", "mouse2.png",":mouse2:")
,   array("255", "ox.png",":ox:")
,   array("256", "dragon_face.png",":dragon_face:")
,   array("257", "blowfish.png",":blowfish:")
,   array("258", "crocodile.png",":crocodile:")
,   array("259", "dromedary_camel.png",":dromedary_camel:")
,   array("260", "leopard.png",":leopard:")
,   array("261", "cat2.png",":cat2:")
,   array("262", "poodle.png",":poodle:")
,   array("263", "paw_prints.png",":paw_prints:")
,   array("264", "bouquet.png",":bouquet:")
,   array("265", "cherry_blossom.png",":cherry_blossom:")
,   array("266", "tulip.png",":tulip:")
,   array("267", "four_leaf_clover.png",":four_leaf_clover:")
,   array("268", "rose.png",":rose:")
,   array("269", "sunflower.png",":sunflower:")
,   array("270", "hibiscus.png",":hibiscus:")
,   array("271", "maple_leaf.png",":maple_leaf:")
,   array("272", "leaves.png",":leaves:")
,   array("273", "fallen_leaf.png",":fallen_leaf:")
,   array("274", "herb.png",":herb:")
,   array("275", "mushroom.png",":mushroom:")
,   array("276", "cactus.png",":cactus:")
,   array("277", "palm_tree.png",":palm_tree:")
,   array("278", "evergreen_tree.png",":evergreen_tree:")
,   array("279", "deciduous_tree.png",":deciduous_tree:")
,   array("280", "chestnut.png",":chestnut:")
,   array("281", "seedling.png",":seedling:")
,   array("282", "blossom.png",":blossom:")
,   array("283", "ear_of_rice.png",":ear_of_rice:")
,   array("284", "shell.png",":shell:")
,   array("285", "globe_with_meridians.png",":globe_with_meridians:")
,   array("286", "sun_with_face.png",":sun_with_face:")
,   array("287", "full_moon_with_face.png",":full_moon_with_face:")
,   array("288", "new_moon_with_face.png",":new_moon_with_face:")
,   array("289", "new_moon.png",":new_moon:")
,   array("290", "waxing_crescent_moon.png",":waxing_crescent_moon:")
,   array("291", "first_quarter_moon.png",":first_quarter_moon:")
,   array("292", "waxing_gibbous_moon.png",":waxing_gibbous_moon:")
,   array("293", "full_moon.png",":full_moon:")
,   array("294", "waning_gibbous_moon.png",":waning_gibbous_moon:")
,   array("295", "last_quarter_moon.png",":last_quarter_moon:")
,   array("296", "waning_crescent_moon.png",":waning_crescent_moon:")
,   array("297", "last_quarter_moon_with_face.png",":last_quarter_moon_with_face:")
,   array("298", "first_quarter_moon_with_face.png",":first_quarter_moon_with_face:")
,   array("299", "moon.png",":moon:")
,   array("300", "earth_africa.png",":earth_africa:")
,   array("301", "earth_americas.png",":earth_americas:")
,   array("302", "earth_asia.png",":earth_asia:")
,   array("303", "volcano.png",":volcano:")
,   array("304", "milky_way.png",":milky_way:")
,   array("305", "partly_sunny.png",":partly_sunny:")
,   array("306", "octocat.png",":octocat:")
,   array("307", "squirrel.png",":squirrel:")
,   array("308", "bamboo.png",":bamboo:")
,   array("309", "gift_heart.png",":gift_heart:")
,   array("310", "dolls.png",":dolls:")
,   array("311", "school_satchel.png",":school_satchel:")
,   array("312", "mortar_board.png",":mortar_board:")
,   array("313", "flags.png",":flags:")
,   array("314", "fireworks.png",":fireworks:")
,   array("315", "sparkler.png",":sparkler:")
,   array("316", "wind_chime.png",":wind_chime:")
,   array("317", "rice_scene.png",":rice_scene:")
,   array("318", "jack_o_lantern.png",":jack_o_lantern:")
,   array("319", "ghost.png",":ghost:")
,   array("320", "santa.png",":santa:")
,   array("321", "christmas_tree.png",":christmas_tree:")
,   array("322", "gift.png",":gift:")
,   array("323", "bell.png",":bell:")
,   array("324", "no_bell.png",":no_bell:")
,   array("325", "tanabata_tree.png",":tanabata_tree:")
,   array("326", "tada.png",":tada:")
,   array("327", "confetti_ball.png",":confetti_ball:")
,   array("328", "balloon.png",":balloon:")
,   array("329", "crystal_ball.png",":crystal_ball:")
,   array("330", "cd.png",":cd:")
,   array("331", "dvd.png",":dvd:")
,   array("332", "floppy_disk.png",":floppy_disk:")
,   array("333", "camera.png",":camera:")
,   array("334", "video_camera.png",":video_camera:")
,   array("335", "movie_camera.png",":movie_camera:")
,   array("336", "computer.png",":computer:")
,   array("337", "tv.png",":tv:")
,   array("338", "iphone.png",":iphone:")
,   array("339", "phone.png",":phone:")
,   array("340", "telephone.png",":telephone:")
,   array("341", "telephone_receiver.png",":telephone_receiver:")
,   array("342", "pager.png",":pager:")
,   array("343", "fax.png",":fax:")
,   array("344", "minidisc.png",":minidisc:")
,   array("345", "vhs.png",":vhs:")
,   array("346", "sound.png",":sound:")
,   array("347", "speaker.png",":speaker:")
,   array("348", "mute.png",":mute:")
,   array("349", "loudspeaker.png",":loudspeaker:")
,   array("350", "mega.png",":mega:")
,   array("351", "hourglass.png",":hourglass:")
,   array("352", "hourglass_flowing_sand.png",":hourglass_flowing_sand:")
,   array("353", "alarm_clock.png",":alarm_clock:")
,   array("354", "watch.png",":watch:")
,   array("355", "radio.png",":radio:")
,   array("356", "satellite.png",":satellite:")
,   array("357", "loop.png",":loop:")
,   array("358", "mag.png",":mag:")
,   array("359", "mag_right.png",":mag_right:")
,   array("360", "unlock.png",":unlock:")
,   array("361", "lock.png",":lock:")
,   array("362", "lock_with_ink_pen.png",":lock_with_ink_pen:")
,   array("363", "closed_lock_with_key.png",":closed_lock_with_key:")
,   array("364", "key.png",":key:")
,   array("365", "bulb.png",":bulb:")
,   array("366", "flashlight.png",":flashlight:")
,   array("367", "high_brightness.png",":high_brightness:")
,   array("368", "low_brightness.png",":low_brightness:")
,   array("369", "electric_plug.png",":electric_plug:")
,   array("370", "battery.png",":battery:")
,   array("371", "calling.png",":calling:")
,   array("372", "email.png",":email:")
,   array("373", "mailbox.png",":mailbox:")
,   array("374", "postbox.png",":postbox:")
,   array("375", "bath.png",":bath:")
,   array("376", "bathtub.png",":bathtub:")
,   array("377", "shower.png",":shower:")
,   array("378", "toilet.png",":toilet:")
,   array("379", "wrench.png",":wrench:")
,   array("380", "nut_and_bolt.png",":nut_and_bolt:")
,   array("381", "hammer.png",":hammer:")
,   array("382", "seat.png",":seat:")
,   array("383", "moneybag.png",":moneybag:")
,   array("384", "yen.png",":yen:")
,   array("385", "dollar.png",":dollar:")
,   array("386", "pound.png",":pound:")
,   array("387", "euro.png",":euro:")
,   array("388", "credit_card.png",":credit_card:")
,   array("389", "money_with_wings.png",":money_with_wings:")
,   array("390", "e-mail.png",":e-mail:")
,   array("391", "inbox_tray.png",":inbox_tray:")
,   array("392", "outbox_tray.png",":outbox_tray:")
,   array("393", "envelope.png",":envelope:")
,   array("394", "incoming_envelope.png",":incoming_envelope:")
,   array("395", "postal_horn.png",":postal_horn:")
,   array("396", "mailbox_closed.png",":mailbox_closed:")
,   array("397", "mailbox_with_mail.png",":mailbox_with_mail:")
,   array("398", "mailbox_with_no_mail.png",":mailbox_with_no_mail:")
,   array("399", "door.png",":door:")
,   array("400", "smoking.png",":smoking:")
,   array("401", "bomb.png",":bomb:")
,   array("402", "gun.png",":gun:")
,   array("403", "hocho.png",":hocho:")
,   array("404", "pill.png",":pill:")
,   array("405", "syringe.png",":syringe:")
,   array("406", "page_facing_up.png",":page_facing_up:")
,   array("407", "page_with_curl.png",":page_with_curl:")
,   array("408", "bookmark_tabs.png",":bookmark_tabs:")
,   array("409", "bar_chart.png",":bar_chart:")
,   array("410", "chart_with_upwards_trend.png",":chart_with_upwards_trend:")
,   array("411", "chart_with_downwards_trend.png",":chart_with_downwards_trend:")
,   array("412", "scroll.png",":scroll:")
,   array("413", "clipboard.png",":clipboard:")
,   array("414", "calendar.png",":calendar:")
,   array("415", "date.png",":date:")
,   array("416", "card_index.png",":card_index:")
,   array("417", "file_folder.png",":file_folder:")
,   array("418", "open_file_folder.png",":open_file_folder:")
,   array("419", "scissors.png",":scissors:")
,   array("420", "pushpin.png",":pushpin:")
,   array("421", "paperclip.png",":paperclip:")
,   array("422", "black_nib.png",":black_nib:")
,   array("423", "pencil2.png",":pencil2:")
,   array("424", "straight_ruler.png",":straight_ruler:")
,   array("425", "triangular_ruler.png",":triangular_ruler:")
,   array("426", "closed_book.png",":closed_book:")
,   array("427", "green_book.png",":green_book:")
,   array("428", "blue_book.png",":blue_book:")
,   array("429", "orange_book.png",":orange_book:")
,   array("430", "notebook.png",":notebook:")
,   array("431", "notebook_with_decorative_cover.png",":notebook_with_decorative_cover:")
,   array("432", "ledger.png",":ledger:")
,   array("433", "books.png",":books:")
,   array("434", "bookmark.png",":bookmark:")
,   array("435", "name_badge.png",":name_badge:")
,   array("436", "microscope.png",":microscope:")
,   array("437", "telescope.png",":telescope:")
,   array("438", "newspaper.png",":newspaper:")
,   array("439", "football.png",":football:")
,   array("440", "basketball.png",":basketball:")
,   array("441", "soccer.png",":soccer:")
,   array("442", "baseball.png",":baseball:")
,   array("443", "tennis.png",":tennis:")
,   array("444", "8ball.png",":8ball:")
,   array("445", "rugby_football.png",":rugby_football:")
,   array("446", "bowling.png",":bowling:")
,   array("447", "golf.png",":golf:")
,   array("448", "mountain_bicyclist.png",":mountain_bicyclist:")
,   array("449", "bicyclist.png",":bicyclist:")
,   array("450", "horse_racing.png",":horse_racing:")
,   array("451", "snowboarder.png",":snowboarder:")
,   array("452", "swimmer.png",":swimmer:")
,   array("453", "surfer.png",":surfer:")
,   array("454", "ski.png",":ski:")
,   array("455", "spades.png",":spades:")
,   array("456", "hearts.png",":hearts:")
,   array("457", "clubs.png",":clubs:")
,   array("458", "diamonds.png",":diamonds:")
,   array("459", "gem.png",":gem:")
,   array("460", "ring.png",":ring:")
,   array("461", "trophy.png",":trophy:")
,   array("462", "musical_score.png",":musical_score:")
,   array("463", "musical_keyboard.png",":musical_keyboard:")
,   array("464", "violin.png",":violin:")
,   array("465", "space_invader.png",":space_invader:")
,   array("466", "video_game.png",":video_game:")
,   array("467", "black_joker.png",":black_joker:")
,   array("468", "flower_playing_cards.png",":flower_playing_cards:")
,   array("469", "game_die.png",":game_die:")
,   array("470", "dart.png",":dart:")
,   array("471", "mahjong.png",":mahjong:")
,   array("472", "clapper.png",":clapper:")
,   array("473", "memo.png",":memo:")
,   array("474", "pencil.png",":pencil:")
,   array("475", "book.png",":book:")
,   array("476", "art.png",":art:")
,   array("477", "microphone.png",":microphone:")
,   array("478", "headphones.png",":headphones:")
,   array("479", "trumpet.png",":trumpet:")
,   array("480", "saxophone.png",":saxophone:")
,   array("481", "guitar.png",":guitar:")
,   array("482", "shoe.png",":shoe:")
,   array("483", "sandal.png",":sandal:")
,   array("484", "high_heel.png",":high_heel:")
,   array("485", "lipstick.png",":lipstick:")
,   array("486", "boot.png",":boot:")
,   array("487", "shirt.png",":shirt:")
,   array("488", "tshirt.png",":tshirt:")
,   array("489", "necktie.png",":necktie:")
,   array("490", "womans_clothes.png",":womans_clothes:")
,   array("491", "dress.png",":dress:")
,   array("492", "running_shirt_with_sash.png",":running_shirt_with_sash:")
,   array("493", "jeans.png",":jeans:")
,   array("494", "kimono.png",":kimono:")
,   array("495", "bikini.png",":bikini:")
,   array("496", "ribbon.png",":ribbon:")
,   array("497", "tophat.png",":tophat:")
,   array("498", "crown.png",":crown:")
,   array("499", "womans_hat.png",":womans_hat:")
,   array("500", "mans_shoe.png",":mans_shoe:")
,   array("501", "closed_umbrella.png",":closed_umbrella:")
,   array("502", "briefcase.png",":briefcase:")
,   array("503", "handbag.png",":handbag:")
,   array("504", "pouch.png",":pouch:")
,   array("505", "purse.png",":purse:")
,   array("506", "eyeglasses.png",":eyeglasses:")
,   array("507", "fishing_pole_and_fish.png",":fishing_pole_and_fish:")
,   array("508", "coffee.png",":coffee:")
,   array("509", "tea.png",":tea:")
,   array("510", "sake.png",":sake:")
,   array("511", "baby_bottle.png",":baby_bottle:")
,   array("512", "beer.png",":beer:")
,   array("513", "beers.png",":beers:")
,   array("514", "cocktail.png",":cocktail:")
,   array("515", "tropical_drink.png",":tropical_drink:")
,   array("516", "wine_glass.png",":wine_glass:")
,   array("517", "fork_and_knife.png",":fork_and_knife:")
,   array("518", "pizza.png",":pizza:")
,   array("519", "hamburger.png",":hamburger:")
,   array("520", "fries.png",":fries:")
,   array("521", "poultry_leg.png",":poultry_leg:")
,   array("522", "meat_on_bone.png",":meat_on_bone:")
,   array("523", "spaghetti.png",":spaghetti:")
,   array("524", "curry.png",":curry:")
,   array("525", "fried_shrimp.png",":fried_shrimp:")
,   array("526", "bento.png",":bento:")
,   array("527", "sushi.png",":sushi:")
,   array("528", "fish_cake.png",":fish_cake:")
,   array("529", "rice_ball.png",":rice_ball:")
,   array("530", "rice_cracker.png",":rice_cracker:")
,   array("531", "rice.png",":rice:")
,   array("532", "ramen.png",":ramen:")
,   array("533", "stew.png",":stew:")
,   array("534", "oden.png",":oden:")
,   array("535", "dango.png",":dango:")
,   array("536", "egg.png",":egg:")
,   array("537", "bread.png",":bread:")
,   array("538", "doughnut.png",":doughnut:")
,   array("539", "custard.png",":custard:")
,   array("540", "icecream.png",":icecream:")
,   array("541", "ice_cream.png",":ice_cream:")
,   array("542", "shaved_ice.png",":shaved_ice:")
,   array("543", "birthday.png",":birthday:")
,   array("544", "cake.png",":cake:")
,   array("545", "cookie.png",":cookie:")
,   array("546", "chocolate_bar.png",":chocolate_bar:")
,   array("547", "candy.png",":candy:")
,   array("548", "lollipop.png",":lollipop:")
,   array("549", "honey_pot.png",":honey_pot:")
,   array("550", "apple.png",":apple:")
,   array("551", "green_apple.png",":green_apple:")
,   array("552", "tangerine.png",":tangerine:")
,   array("553", "lemon.png",":lemon:")
,   array("554", "cherries.png",":cherries:")
,   array("555", "grapes.png",":grapes:")
,   array("556", "watermelon.png",":watermelon:")
,   array("557", "strawberry.png",":strawberry:")
,   array("558", "peach.png",":peach:")
,   array("559", "melon.png",":melon:")
,   array("560", "banana.png",":banana:")
,   array("561", "pear.png",":pear:")
,   array("562", "pineapple.png",":pineapple:")
,   array("563", "sweet_potato.png",":sweet_potato:")
,   array("564", "eggplant.png",":eggplant:")
,   array("565", "tomato.png",":tomato:")
,   array("566", "corn.png",":corn:")
,   array("567", "house.png",":house:")
,   array("568", "house_with_garden.png",":house_with_garden:")
,   array("569", "school.png",":school:")
,   array("570", "office.png",":office:")
,   array("571", "post_office.png",":post_office:")
,   array("572", "hospital.png",":hospital:")
,   array("573", "bank.png",":bank:")
,   array("574", "convenience_store.png",":convenience_store:")
,   array("575", "love_hotel.png",":love_hotel:")
,   array("576", "hotel.png",":hotel:")
,   array("577", "wedding.png",":wedding:")
,   array("578", "church.png",":church:")
,   array("579", "department_store.png",":department_store:")
,   array("580", "european_post_office.png",":european_post_office:")
,   array("581", "city_sunrise.png",":city_sunrise:")
,   array("582", "city_sunset.png",":city_sunset:")
,   array("583", "japanese_castle.png",":japanese_castle:")
,   array("584", "european_castle.png",":european_castle:")
,   array("585", "tent.png",":tent:")
,   array("586", "factory.png",":factory:")
,   array("587", "tokyo_tower.png",":tokyo_tower:")
,   array("588", "japan.png",":japan:")
,   array("589", "mount_fuji.png",":mount_fuji:")
,   array("590", "sunrise_over_mountains.png",":sunrise_over_mountains:")
,   array("591", "sunrise.png",":sunrise:")
,   array("592", "stars.png",":stars:")
,   array("593", "statue_of_liberty.png",":statue_of_liberty:")
,   array("594", "bridge_at_night.png",":bridge_at_night:")
,   array("595", "carousel_horse.png",":carousel_horse:")
,   array("596", "rainbow.png",":rainbow:")
,   array("597", "ferris_wheel.png",":ferris_wheel:")
,   array("598", "fountain.png",":fountain:")
,   array("599", "roller_coaster.png",":roller_coaster:")
,   array("600", "ship.png",":ship:")
,   array("601", "speedboat.png",":speedboat:")
,   array("602", "boat.png",":boat:")
,   array("603", "sailboat.png",":sailboat:")
,   array("604", "rowboat.png",":rowboat:")
,   array("605", "anchor.png",":anchor:")
,   array("606", "rocket.png",":rocket:")
,   array("607", "airplane.png",":airplane:")
,   array("608", "helicopter.png",":helicopter:")
,   array("609", "steam_locomotive.png",":steam_locomotive:")
,   array("610", "tram.png",":tram:")
,   array("611", "mountain_railway.png",":mountain_railway:")
,   array("612", "bike.png",":bike:")
,   array("613", "aerial_tramway.png",":aerial_tramway:")
,   array("614", "suspension_railway.png",":suspension_railway:")
,   array("615", "mountain_cableway.png",":mountain_cableway:")
,   array("616", "tractor.png",":tractor:")
,   array("617", "blue_car.png",":blue_car:")
,   array("618", "oncoming_automobile.png",":oncoming_automobile:")
,   array("619", "car.png",":car:")
,   array("620", "red_car.png",":red_car:")
,   array("621", "taxi.png",":taxi:")
,   array("622", "oncoming_taxi.png",":oncoming_taxi:")
,   array("623", "articulated_lorry.png",":articulated_lorry:")
,   array("624", "bus.png",":bus:")
,   array("625", "oncoming_bus.png",":oncoming_bus:")
,   array("626", "rotating_light.png",":rotating_light:")
,   array("627", "police_car.png",":police_car:")
,   array("628", "oncoming_police_car.png",":oncoming_police_car:")
,   array("629", "fire_engine.png",":fire_engine:")
,   array("630", "ambulance.png",":ambulance:")
,   array("631", "minibus.png",":minibus:")
,   array("632", "truck.png",":truck:")
,   array("633", "train.png",":train:")
,   array("634", "station.png",":station:")
,   array("635", "train2.png",":train2:")
,   array("636", "bullettrain_front.png",":bullettrain_front:")
,   array("637", "bullettrain_side.png",":bullettrain_side:")
,   array("638", "light_rail.png",":light_rail:")
,   array("639", "monorail.png",":monorail:")
,   array("640", "railway_car.png",":railway_car:")
,   array("641", "trolleybus.png",":trolleybus:")
,   array("642", "ticket.png",":ticket:")
,   array("643", "fuelpump.png",":fuelpump:")
,   array("644", "vertical_traffic_light.png",":vertical_traffic_light:")
,   array("645", "traffic_light.png",":traffic_light:")
,   array("646", "warning.png",":warning:")
,   array("647", "construction.png",":construction:")
,   array("648", "beginner.png",":beginner:")
,   array("649", "atm.png",":atm:")
,   array("650", "slot_machine.png",":slot_machine:")
,   array("651", "busstop.png",":busstop:")
,   array("652", "barber.png",":barber:")
,   array("653", "hotsprings.png",":hotsprings:")
,   array("654", "checkered_flag.png",":checkered_flag:")
,   array("655", "crossed_flags.png",":crossed_flags:")
,   array("656", "izakaya_lantern.png",":izakaya_lantern:")
,   array("657", "moyai.png",":moyai:")
,   array("658", "circus_tent.png",":circus_tent:")
,   array("659", "performing_arts.png",":performing_arts:")
,   array("660", "round_pushpin.png",":round_pushpin:")
,   array("661", "triangular_flag_on_post.png",":triangular_flag_on_post:")
,   array("662", "jp.png",":jp:")
,   array("663", "kr.png",":kr:")
,   array("664", "cn.png",":cn:")
,   array("665", "us.png",":us:")
,   array("666", "fr.png",":fr:")
,   array("667", "es.png",":es:")
,   array("668", "it.png",":it:")
,   array("669", "ru.png",":ru:")
,   array("670", "gb.png",":gb:")
,   array("671", "uk.png",":uk:")
,   array("672", "de.png",":de:")
,   array("673", "one.png",":one:")
,   array("674", "two.png",":two:")
,   array("675", "three.png",":three:")
,   array("676", "four.png",":four:")
,   array("677", "five.png",":five:")
,   array("678", "six.png",":six:")
,   array("679", "seven.png",":seven:")
,   array("680", "eight.png",":eight:")
,   array("681", "nine.png",":nine:")
,   array("682", "keycap_ten.png",":keycap_ten:")
,   array("683", "1234.png",":1234:")
,   array("684", "zero.png",":zero:")
,   array("685", "hash.png",":hash:")
,   array("686", "symbols.png",":symbols:")
,   array("687", "arrow_backward.png",":arrow_backward:")
,   array("688", "arrow_down.png",":arrow_down:")
,   array("689", "arrow_forward.png",":arrow_forward:")
,   array("690", "arrow_left.png",":arrow_left:")
,   array("691", "capital_abcd.png",":capital_abcd:")
,   array("692", "abcd.png",":abcd:")
,   array("693", "abc.png",":abc:")
,   array("694", "arrow_lower_left.png",":arrow_lower_left:")
,   array("695", "arrow_lower_right.png",":arrow_lower_right:")
,   array("696", "arrow_right.png",":arrow_right:")
,   array("697", "arrow_up.png",":arrow_up:")
,   array("698", "arrow_upper_left.png",":arrow_upper_left:")
,   array("699", "arrow_upper_right.png",":arrow_upper_right:")
,   array("700", "arrow_double_down.png",":arrow_double_down:")
,   array("701", "arrow_double_up.png",":arrow_double_up:")
,   array("702", "arrow_down_small.png",":arrow_down_small:")
,   array("703", "arrow_heading_down.png",":arrow_heading_down:")
,   array("704", "arrow_heading_up.png",":arrow_heading_up:")
,   array("705", "leftwards_arrow_with_hook.png",":leftwards_arrow_with_hook:")
,   array("706", "arrow_right_hook.png",":arrow_right_hook:")
,   array("707", "left_right_arrow.png",":left_right_arrow:")
,   array("708", "arrow_up_down.png",":arrow_up_down:")
,   array("709", "arrow_up_small.png",":arrow_up_small:")
,   array("710", "arrows_clockwise.png",":arrows_clockwise:")
,   array("711", "arrows_counterclockwise.png",":arrows_counterclockwise:")
,   array("712", "rewind.png",":rewind:")
,   array("713", "fast_forward.png",":fast_forward:")
,   array("714", "information_source.png",":information_source:")
,   array("715", "ok.png",":ok:")
,   array("716", "twisted_rightwards_arrows.png",":twisted_rightwards_arrows:")
,   array("717", "repeat.png",":repeat:")
,   array("718", "repeat_one.png",":repeat_one:")
,   array("719", "new.png",":new:")
,   array("720", "top.png",":top:")
,   array("721", "up.png",":up:")
,   array("722", "cool.png",":cool:")
,   array("723", "free.png",":free:")
,   array("724", "ng.png",":ng:")
,   array("725", "cinema.png",":cinema:")
,   array("726", "koko.png",":koko:")
,   array("727", "signal_strength.png",":signal_strength:")
,   array("728", "u5272.png",":u5272:")
,   array("729", "u5408.png",":u5408:")
,   array("730", "u55b6.png",":u55b6:")
,   array("731", "u6307.png",":u6307:")
,   array("732", "u6708.png",":u6708:")
,   array("733", "u6709.png",":u6709:")
,   array("734", "u6e80.png",":u6e80:")
,   array("735", "u7121.png",":u7121:")
,   array("736", "u7533.png",":u7533:")
,   array("737", "u7a7a.png",":u7a7a:")
,   array("738", "u7981.png",":u7981:")
,   array("739", "sa.png",":sa:")
,   array("740", "restroom.png",":restroom:")
,   array("741", "mens.png",":mens:")
,   array("742", "womens.png",":womens:")
,   array("743", "baby_symbol.png",":baby_symbol:")
,   array("744", "no_smoking.png",":no_smoking:")
,   array("745", "parking.png",":parking:")
,   array("746", "wheelchair.png",":wheelchair:")
,   array("747", "metro.png",":metro:")
,   array("748", "baggage_claim.png",":baggage_claim:")
,   array("749", "accept.png",":accept:")
,   array("750", "wc.png",":wc:")
,   array("751", "potable_water.png",":potable_water:")
,   array("752", "put_litter_in_its_place.png",":put_litter_in_its_place:")
,   array("753", "secret.png",":secret:")
,   array("754", "congratulations.png",":congratulations:")
,   array("755", "m.png",":m:")
,   array("756", "passport_control.png",":passport_control:")
,   array("757", "left_luggage.png",":left_luggage:")
,   array("758", "customs.png",":customs:")
,   array("759", "ideograph_advantage.png",":ideograph_advantage:")
,   array("760", "cl.png",":cl:")
,   array("761", "sos.png",":sos:")
,   array("762", "id.png",":id:")
,   array("763", "no_entry_sign.png",":no_entry_sign:")
,   array("764", "underage.png",":underage:")
,   array("765", "no_mobile_phones.png",":no_mobile_phones:")
,   array("766", "do_not_litter.png",":do_not_litter:")
,   array("767", "non-potable_water.png",":non-potable_water:")
,   array("768", "no_bicycles.png",":no_bicycles:")
,   array("769", "no_pedestrians.png",":no_pedestrians:")
,   array("770", "children_crossing.png",":children_crossing:")
,   array("771", "no_entry.png",":no_entry:")
,   array("772", "eight_spoked_asterisk.png",":eight_spoked_asterisk:")
,   array("773", "eight_pointed_black_star.png",":eight_pointed_black_star:")
,   array("774", "heart_decoration.png",":heart_decoration:")
,   array("775", "vs.png",":vs:")
,   array("776", "vibration_mode.png",":vibration_mode:")
,   array("777", "mobile_phone_off.png",":mobile_phone_off:")
,   array("778", "chart.png",":chart:")
,   array("779", "currency_exchange.png",":currency_exchange:")
,   array("780", "aries.png",":aries:")
,   array("781", "taurus.png",":taurus:")
,   array("782", "gemini.png",":gemini:")
,   array("783", "cancer.png",":cancer:")
,   array("784", "leo.png",":leo:")
,   array("785", "virgo.png",":virgo:")
,   array("786", "libra.png",":libra:")
,   array("787", "scorpius.png",":scorpius:")
,   array("788", "sagittarius.png",":sagittarius:")
,   array("789", "capricorn.png",":capricorn:")
,   array("790", "aquarius.png",":aquarius:")
,   array("791", "pisces.png",":pisces:")
,   array("792", "ophiuchus.png",":ophiuchus:")
,   array("793", "six_pointed_star.png",":six_pointed_star:")
,   array("794", "negative_squared_cross_mark.png",":negative_squared_cross_mark:")
,   array("795", "a.png",":a:")
,   array("796", "b.png",":b:")
,   array("797", "ab.png",":ab:")
,   array("798", "o2.png",":o2:")
,   array("799", "diamond_shape_with_a_dot_inside.png",":diamond_shape_with_a_dot_inside:")
,   array("800", "recycle.png",":recycle:")
,   array("801", "end.png",":end:")
,   array("802", "on.png",":on:")
,   array("803", "soon.png",":soon:")
,   array("804", "clock1.png",":clock1:")
,   array("805", "clock130.png",":clock130:")
,   array("806", "clock10.png",":clock10:")
,   array("807", "clock1030.png",":clock1030:")
,   array("808", "clock11.png",":clock11:")
,   array("809", "clock1130.png",":clock1130:")
,   array("810", "clock12.png",":clock12:")
,   array("811", "clock1230.png",":clock1230:")
,   array("812", "clock2.png",":clock2:")
,   array("813", "clock230.png",":clock230:")
,   array("814", "clock3.png",":clock3:")
,   array("815", "clock330.png",":clock330:")
,   array("816", "clock4.png",":clock4:")
,   array("817", "clock430.png",":clock430:")
,   array("818", "clock5.png",":clock5:")
,   array("819", "clock530.png",":clock530:")
,   array("820", "clock6.png",":clock6:")
,   array("821", "clock630.png",":clock630:")
,   array("822", "clock7.png",":clock7:")
,   array("823", "clock730.png",":clock730:")
,   array("824", "clock8.png",":clock8:")
,   array("825", "clock830.png",":clock830:")
,   array("826", "clock9.png",":clock9:")
,   array("827", "clock930.png",":clock930:")
,   array("828", "heavy_dollar_sign.png",":heavy_dollar_sign:")
,   array("829", "copyright.png",":copyright:")
,   array("830", "registered.png",":registered:")
,   array("831", "tm.png",":tm:")
,   array("832", "x.png",":x:")
,   array("833", "heavy_exclamation_mark.png",":heavy_exclamation_mark:")
,   array("834", "bangbang.png",":bangbang:")
,   array("835", "interrobang.png",":interrobang:")
,   array("836", "o.png",":o:")
,   array("837", "heavy_multiplication_x.png",":heavy_multiplication_x:")
,   array("838", "heavy_plus_sign.png",":heavy_plus_sign:")
,   array("839", "heavy_minus_sign.png",":heavy_minus_sign:")
,   array("840", "heavy_division_sign.png",":heavy_division_sign:")
,   array("841", "white_flower.png",":white_flower:")
,   array("842", "100.png",":100:")
,   array("843", "heavy_check_mark.png",":heavy_check_mark:")
,   array("844", "ballot_box_with_check.png",":ballot_box_with_check:")
,   array("845", "radio_button.png",":radio_button:")
,   array("846", "link.png",":link:")
,   array("847", "curly_loop.png",":curly_loop:")
,   array("848", "wavy_dash.png",":wavy_dash:")
,   array("849", "part_alternation_mark.png",":part_alternation_mark:")
,   array("850", "trident.png",":trident:")
,   array("851", "black_square.png",":black_square:")
,   array("852", "white_square.png",":white_square:")
,   array("853", "white_check_mark.png",":white_check_mark:")
,   array("854", "black_square_button.png",":black_square_button:")
,   array("855", "white_square_button.png",":white_square_button:")
,   array("856", "black_circle.png",":black_circle:")
,   array("857", "white_circle.png",":white_circle:")
,   array("858", "red_circle.png",":red_circle:")
,   array("859", "large_blue_circle.png",":large_blue_circle:")
,   array("860", "large_blue_diamond.png",":large_blue_diamond:")
,   array("861", "large_orange_diamond.png",":large_orange_diamond:")
,   array("862", "small_blue_diamond.png",":small_blue_diamond:")
,   array("863", "small_orange_diamond.png",":small_orange_diamond:")
,   array("864", "small_red_triangle.png",":small_red_triangle:")
,   array("865", "small_red_triangle_down.png",":small_red_triangle_down:")
,   array("866", "shipit.png",":shipit:")

    );

$emojiArrayCount = count($emojiArray);

$emojiArrayI = 0;

	//$farsettings = get_option('far_plugin_settings');
	//if (is_array($farsettings['farfind'])){
		foreach ($emojiArray as $emoji){
	        $emojiId		= $emoji[0];
	        $emojiReplace	= $emoji[1];
	        $emojiFind		= $emoji[2];
	        

			//if(isset($farsettings['farregex'][$key]))
			//	$buffer = preg_replace($find, $farsettings['farreplace'][$key], $buffer);
			//else
				$buffer = str_replace($emojiFind, "<img src=\"/assets/global/emojis/".$emojiReplace."\" class=\"emoji\">", $buffer);
		}
	//}
	return $buffer;
}

function emoji_template_redirect(){
	ob_start();
	ob_start('emoji_ob_call');
}
add_action('template_redirect', 'emoji_template_redirect');

/* Add your functions above this line */
?>