<?php
/*
Plugin Name: TinyNav
Version: 1.4
Plugin URI: http://www.berryplasman.com/wordpress/tinynav/?utm_source=wpadmin&utm_medium=pluginpage&utm_campaign=tinynavplugin
Description: This plugin changes your WordPress menu into a menu which is better readable on mobile devices.
Author: Beee
Author URI: http://berryplasman.com
License: GPL v2

Copyright 2012-2014 Beee (email : info@berryplasman.com)

		site by Beee
		http://www.berryplasman.com
		   ___  ____ ____ ____ 
		  / _ )/ __/  __/  __/
		 / _  / _/   _/   _/ 
		/____/___/____/____/
		

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program. If not, see <http://www.gnu.org/licenses/>.

		TinyNav.js script taken from http://tinynav.viljamis.com/

2do
- check if it's possible to remove the first 2 functions
- add custom css field
- add option to choose em/px

*/

/**
 * The following 2 functions might be removed from a future version
 *
 * Removes the div from wp_nav_menu() and replace with ul
 * Script taken from Responsive theme by Emil Uzelac @ www.themeid.com
 */
function tn_remove_wp_nav_menu ($page_markup) {
    preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
        $divclass = $matches[1];
        $replace = array('<div class="'.$divclass.'">', '</div>');
        $new_markup = str_replace($replace, '', $page_markup);
        $new_markup = preg_replace('/^<ul>/i', '<ul>', $new_markup);
        return $new_markup;
        }
add_filter('wp_nav_menu', 'tn_remove_wp_nav_menu');
	
/* 
 * Removes div from wp_page_menu() and replace with ul
 */ 
function tn_remove_wp_page_menu ($page_markup) {
    preg_match('/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches);
        $divclass = $matches[1];
        $replace = array('<div class="'.$divclass.'">', '</div>');
        $new_markup = str_replace($replace, '', $page_markup);
        $new_markup = preg_replace('/^<ul>/i', '<ul>', $new_markup);
        return $new_markup;
        }
add_filter('wp_page_menu', 'tn_remove_wp_page_menu');

/**
 * Adds a page in the settings menu
 */
function tinynav_menu() {
	add_options_page( 'TinyNav Options', 'TinyNav', 'manage_options', 'tinynav-options', 'tinynav_options' );
}
add_action( 'admin_menu', 'tinynav_menu' );

/**
 * Content for the settings page
 */
function tinynav_options() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}

  // variables for the field and option names 
  $hidden_field_name 		= 'tn_submit_hidden';
	$tn_opt_name1 				= 'tn_menu_marginleft';
  $tn_data_field_name1 	= 'tn_menu_marginleft';
	$tn_opt_name2 				= 'tn_menu_marginright';
  $tn_data_field_name2 	= 'tn_menu_marginright';
	$tn_opt_name3 				= 'tn_menu_margintop';
  $tn_data_field_name3 	= 'tn_menu_margintop';
	$tn_opt_name4 				= 'tn_menu_marginbottom';
  $tn_data_field_name4 	= 'tn_menu_marginbottom';
	$tn_opt_name5 				= 'tn_menu_customclass';
  $tn_data_field_name5 	= 'tn_menu_customclass';
	$tn_opt_name6 				= 'tn_menu_customwidth';
  $tn_data_field_name6 	= 'tn_menu_customwidth';
	$tn_opt_name6c 				= 'tn_menu_customwidth2';
  $tn_data_field_name6c	= 'tn_menu_customwidth2';
	$tn_opt_name7 				= 'tn_tinynav_viewport';
  $tn_data_field_name7 	= 'tn_tinynav_viewport';
	$tn_opt_name8 				= 'tn_tinynav_footer';
  $tn_data_field_name8 	= 'tn_tinynav_footer';

  // Read in existing option value from database
  $tn_opt_val1 		= get_option( $tn_opt_name1 );
  $tn_opt_val2 		= get_option( $tn_opt_name2 );
  $tn_opt_val3 		= get_option( $tn_opt_name3 );
  $tn_opt_val4 		= get_option( $tn_opt_name4 );
  $tn_opt_val5 		= get_option( $tn_opt_name5 );
  $tn_opt_val6 		= get_option( $tn_opt_name6 );
  $tn_opt_val6c 	= get_option( $tn_opt_name6c );
  $tn_opt_val7 		= get_option( $tn_opt_name7 );
  $tn_opt_val8 		= get_option( $tn_opt_name8 );
  
  // See if the user has posted us some information
  // If they did, this hidden field will be set to 'Y'
  if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
      // Read their posted value
      $tn_opt_val1 		= $_POST[ $tn_data_field_name1 ];
      $tn_opt_val2 		= $_POST[ $tn_data_field_name2 ];
      $tn_opt_val3 		= $_POST[ $tn_data_field_name3 ];
      $tn_opt_val4 		= $_POST[ $tn_data_field_name4 ];
      $tn_opt_val5 		= $_POST[ $tn_data_field_name5 ];
      $tn_opt_val6 		= $_POST[ $tn_data_field_name6 ];
      $tn_opt_val6c 	= $_POST[ $tn_data_field_name6c ];
      $tn_opt_val7 		= $_POST[ $tn_data_field_name7 ];
      $tn_opt_val8 		= $_POST[ $tn_data_field_name8 ];

      // Save the posted value in the database
      update_option( $tn_opt_name1, $tn_opt_val1 );
      update_option( $tn_opt_name2, $tn_opt_val2 );
      update_option( $tn_opt_name3, $tn_opt_val3 );
      update_option( $tn_opt_name4, $tn_opt_val4 );      
      update_option( $tn_opt_name5, $tn_opt_val5 );
      update_option( $tn_opt_name6, $tn_opt_val6 );
      update_option( $tn_opt_name6c, $tn_opt_val6c );
      update_option( $tn_opt_name7, $tn_opt_val7 );
      update_option( $tn_opt_name8, $tn_opt_val8 );

      // Put an settings updated message on the screen
?>
<div class="updated"><p><strong><?php _e('Your settings have been saved.', 'tinynav-updated' ); ?></strong></p></div>
<?php
    }
    // Now display the settings editing screen
    echo '<div class="wrap">';
    echo '<div id="icon-options-general" class="icon32"><br /></div>';

    // header
    echo "<h2>" . __( 'TinyNav Settings', 'tinynav-header' ) . "</h2>";
    echo "<p>" . __( 'On this page you can find some helpful info about your TinyNav plugin as well as some settings.', 'tinynav-headerdescription' ) . "</p>";

    // left part
    echo '<div class="admin_left">';

    // settings form
    echo '<form method="post" action="">';

    // register settings
		settings_fields( 'tinynav_settings' ); 
		register_setting( 'tinynav_settings', 'tn_menu_marginleft' ); 
		register_setting( 'tinynav_settings', 'tn_menu_marginright' ); 
		register_setting( 'tinynav_settings', 'tn_menu_margintop' ); 
		register_setting( 'tinynav_settings', 'tn_menu_marginbottom' ); 
		register_setting( 'tinynav_settings', 'tn_menu_customclass' ); 
		register_setting( 'tinynav_settings', 'tn_menu_customwidth' ); 
		register_setting( 'tinynav_settings', 'tn_menu_customwidth2' ); 
		register_setting( 'tinynav_settings', 'tn_tinynav_viewport' ); 
		register_setting( 'tinynav_settings', 'tn_tinynav_footer' ); 
?>
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
    <h3>General info</h3>
  	<p>This plugin makes (partially) use of the Wordpress <a href="<?php echo site_url('/'); ?>wp-admin/nav-menus.php">Menus option</a>. 
<?php
    echo 'It is recommended you use this, if you haven\'t done so already. ';
    echo 'Also use \'theme locations\', if enabled.</p>';

    echo '<hr />';
    echo '<h3>Custom id/class</h3>';
    echo '<p>If your menu doesn\'t get optimized, you might have to enter the id/class manually.</p>';
    echo '<p>A WordPress menu is (mostly) an UL, often used in an element with the id \'#site-navigation\' which is the element which gets optimized out of the box.</p>';
?>
			<div class="tn_margins">
				<p>
					<span class="tn_label"><?php _e("Custom id/class ( use # and . ):", 'tinynav-customclass' ); ?></span>
					<span class="tn_input"><input type="text" name="<?php echo $tn_data_field_name5; ?>" value="<?php echo $tn_opt_val5; ?>" size="25"></span>
				</p>
			</div>
<?php
		submit_button(); 

    echo '<hr />';
    echo '<h3>Viewport</h3>';
    echo '<p>To make this plugin work correctly your template\'s header file (header.php) must have this line of code:<br />
    \'< meta name="viewport" content="width=device-width" / >\'<br />(without the spaces of course between < meta and / >).</p>';
    echo '<p>If your template doesn\'t have this line of code, you can add it by ticking this checkbox.</p>';
?>
			<div class="tn_margins">
				<p>
					<span class="tn_label"><?php _e("Add Viewport", 'tinynav-viewport' ); ?></span>
					<span class="tn_input"><input type="checkbox" name="<?php echo $tn_data_field_name7; ?>" id="<?php echo $tn_data_field_name7; ?>" value="1" <?php if ( $tn_opt_val7 ) { echo " checked"; } ?> /></span>
				</p>
			</div>
<?php
		submit_button(); 

    echo '<hr />';
    echo '<h3>Custom margins</h3>';
    echo '<p>Your normal menu might maybe move a bit to the left or right (depending on your template\'s css) and/or maybe a bit up or down. This is because the plugin strips the div container around the Wordpress generated menu. In a future version a custom css field will be entered for this option.</p>';
    echo '<p>Here you can add extra margins.</p>';
?>
			<div class="tn_margins">
				<p>
					<span class="tn_label"><?php _e("Add left margin:", 'tinynav-leftmargin' ); ?></span>
					<span class="tn_input"><input type="text" name="<?php echo $tn_data_field_name1; ?>" value="<?php echo $tn_opt_val1; ?>" size="3"> px</span>
				</p>
	
				<p>
					<span class="tn_label"><?php _e("Add right margin:", 'tinynav-rightmargin' ); ?></span>
					<span class="tn_input"><input type="text" name="<?php echo $tn_data_field_name2; ?>" value="<?php echo $tn_opt_val2; ?>" size="3"> px</span>
				</p>
	
				<p>
					<span class="tn_label"><?php _e("Add top margin:", 'tinynav-topmargin' ); ?></span>
					<span class="tn_input"><input type="text" name="<?php echo $tn_data_field_name3; ?>" value="<?php echo $tn_opt_val3; ?>" size="3"> px</span>
				</p>
	
				<p>
					<span class="tn_label"><?php _e("Add bottom margin:", 'tinynav-bottommargin' ); ?></span>
					<span class="tn_input"><input type="text" name="<?php echo $tn_data_field_name4; ?>" value="<?php echo $tn_opt_val4; ?>" size="3"> px</span>
				</p>
			</div>
			
<?php submit_button(); ?>

<?php
    echo '<hr />';
    echo '<h3>Screen size</h3>';
    echo '<p>Out of the box, the TinyNav menu kicks in when a screen is max. 650 pixels wide.</p>';

		$tn_opt_val6 = get_option( 'tn_menu_customwidth' );
		if ( !$tn_opt_val6 ) { $tn_opt_val6 = "650"; } 	
?>
			<div class="tn_margins">
				<p>
					<span class="tn_label"><?php _e("Custom screen size activation:", 'tinynav-customwidth' ); ?></span>
					<span class="tn_input">
						<select name="<?php echo $tn_data_field_name6; ?>">
							<option value="650" <?php if ( !$tn_opt_val6 ) echo "selected"; ?>>Standard (650)</option>
							<option value="1024" <?php if ( $tn_opt_val6 == "1024" ) echo "selected"; ?>>1024 - iPad 2 (landscape)</option>
							<option value="800" <?php if ( $tn_opt_val6 == "800" ) echo "selected"; ?>>800</option>
							<option value="768" <?php if ( $tn_opt_val6 == "768" ) echo "selected"; ?>>768 - iPad 2 (portrait)</option>
							<option value="650" <?php if ( $tn_opt_val6 == "650" ) echo "selected"; ?>>650 - (standard)</option>
							<option value="568" <?php if ( $tn_opt_val6 == "568" ) echo "selected"; ?>>568 - iPhone 5 (landscape)</option>
							<option value="480" <?php if ( $tn_opt_val6 == "480" ) echo "selected"; ?>>480 - iPhone 2/3/4 (landscape)</option>
							<option value="360" <?php if ( $tn_opt_val6 == "360" ) echo "selected"; ?>>360</option>
							<option value="320" <?php if ( $tn_opt_val6 == "320" ) echo "selected"; ?>>320 - iPone 2/3/4/(portrait)</option>
						</select>
					</span>
				</p>
			</div>

			<div class="tn_margins">
				<p>
					If you enter a (numeric) value here, this value will be used instead of the selected one in the dropdown. Remove it and the dropdown will be used again.
				</p>
				<p>
					<span class="tn_label"><?php _e("Enter a screen size in pixels:", 'tinynav-customwidth2' ); ?></span>
					<?php $tn_opt_val6c = get_option( 'tn_menu_customwidth2' ); ?>
					<span class="tn_input"><input type="text" name="<?php echo $tn_data_field_name6c; ?>" value="<?php echo $tn_opt_val6c; ?>" size="5"> px</span>
				</p>
			</div>

<?php submit_button(); ?>

<?php
    echo '<hr />';
    echo '<h3>Load in footer</h3>';
    echo '<p>Out of the box, the TinyNav menu is loaded in the header. If you want to load it in the footer, tick this checkbox.</p>';
?>
			<div class="tn_margins">
				<p>
					<span class="tn_label"><?php _e("Load Tinynav.js in wp_footer()", 'tinynav-viewport' ); ?></span>
					<span class="tn_input"><input type="checkbox" name="<?php echo $tn_data_field_name8; ?>" id="<?php echo $tn_data_field_name8; ?>" value="1" <?php if ( $tn_opt_val8 ) { echo " checked"; } ?> /></span>
				</p>
			</div>

<?php submit_button(); ?>

			</form>

		</div><!-- end .admin_left -->

		<div class="admin_right">
			<h3>About the plugin</h3>
			<?php echo "<p>I built this plugin because I got inspired by Emil Uzelac's <a href=\"http://themeid.com/responsive-theme/\" target=\"_blank\">Responsive Theme</a>, in which I saw TinyNav for the first time. But the function only came with the theme, so I decided to 'extract' the function and create a plugin just for this function.</p>"; ?>
			<p><a href="http://www.berryplasman.com/wordpress/tinynav/?utm_source=wpadmin&utm_medium=about_plugin&utm_campaign=tinynavplugin" target="_blank">Click here</a> for the plugin page on my site.</p>
			
			<hr />
			
			<h3>About Beee</h3>
			<?php echo "<p>If you need a Wordpress designer/coder to create a new template for your Wordpress site, I'm available for work."; ?>
			<br /><a href="http://www.berryplasman.com/portfolio/?utm_source=wpadmin&utm_medium=about_beee&utm_campaign=tinynavplugin" target="_blank">My Portfolio</a> </p>
			
			<hr />
			
			<h3>Support</h3>
			<p>If you need support for this plugin or if you have some good suggestions for improvements and/or new features, please post it on the <a href="http://wordpress.org/support/plugin/tinynav" target="_blank">WordPress forums for TinyNav</a>.</p>
			
			<hr />
			
			<h3>Spread the word</h3>
			<p>If you like this plugin, please consider the following:
			<ul>
				<li>Give it 5 stars on the <a href="http://wordpress.org/plugins/tinynav" target="_blank">plugin page</a> on WordPress.org</li>
				<li>Blog about it and link to my <a href="http://www.berryplasman.com/wordpress/tinynav/?utm_source=wpadmin&utm_medium=spread_word&utm_campaign=tinynavplugin" target="_blank">plugin page</a></li>
				<li>Tweet about it</li>
			</ul>
</p>
			<p><a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=info%40rubber%2dlab%2ecom&lc=NL&item_name=GigaTools%20plugin&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest" target="_blank"><img src="<?php echo site_url(); ?>/wp-content/plugins/tinynav/img/paypal_donate.gif" alt="" class="donateimg" /></a> If you like this plugin, buy me a coke (I don't drink alcohol) to show your appreciation so I can continue to develop it.</p>
		</div><!-- end .admin_right -->
	</div><!-- end .wrap -->

<?php } /* end tinynav_options - content for settings page */
	
/**
 * Add settings link on plugin page
 * @author c.bavota (http://bavotasan.com/2009/a-settings-link-for-your-wordpress-plugins/)
 */

function tinynav_settings_link($links) { 
	  $settings_link = '<a href="options-general.php?page=tinynav-options">Settings</a>'; 
	  array_unshift($links, $settings_link); 
	  return $links; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'tinynav_settings_link' );


/**
 * Add meta="viewport" to header
 */
function tn_add_viewport() {
	$tn_opt_val7 = get_option( 'tn_tinynav_viewport' );
	if ( $tn_opt_val7 ) {
		echo "<meta name=\"viewport\" content=\"width=device-width\" />\n\t";
	}
}
add_action( "wp_enqueue_scripts", "tn_add_viewport", 10 );

/**
 * Enqueues jQuery.min.js
 */
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
	wp_enqueue_script('jquery');
}

/**
 * Enqueues TinyNav.js script
 */
if (!is_admin()) add_action("wp_enqueue_scripts", "my_tinynav_enqueue", 11);
function my_tinynav_enqueue() {
	$tn_opt_val8 = get_option( 'tn_tinynav_footer' );
	if ( get_option( 'tn_tinynav_footer' ) == '1' ) $footer = 'true'; 
	wp_register_script('tinynav', plugins_url('/js/tinynav.min.js', __FILE__), array('jquery'), '1.0', $footer);
	wp_enqueue_script('tinynav');
}

/**
 * Adds CSS on the admin side
 */
function TinyNav_admin_addCSS(){
	echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( 'admin.css' , __FILE__ ) . '" />';
	echo "\n";
}
add_action('admin_head','TinyNav_admin_addCSS');

/**
 * Adds TinyNav <script> and css to your header
 */
function tinynav_header()
	{
	 $tn_customcss = get_option( 'tn_menu_customclass' );
	 if ( !$tn_customcss ) { $tn_customcss = "#site-navigation ul"; } 	
?>

<!-- Add TinyNav Javascript -->
<script>
	jQuery(function($) {
		$("<?php echo $tn_customcss; ?>").tinyNav({
			active: 'current-menu-item' // Set the "active" class
		});
	});
</script>
<!-- End TinyNav Javascript -->

<?php
/**
 * Adds the necessary css
 */ 
 ?>
<!-- Add TinyNav CSS -->
<style type="text/css">
	/* Remove tinynav menu untill screen size is the max selected size */
	.tinynav { display: none; }
<?php
  	$tn_opt_val1 = get_option( 'tn_menu_marginleft' );
  	$tn_opt_val2 = get_option( 'tn_menu_marginright' );
  	$tn_opt_val3 = get_option( 'tn_menu_margintop' );
  	$tn_opt_val4 = get_option( 'tn_menu_marginbottom' );
		if ($tn_opt_val1 || $tn_opt_val2 || $tn_opt_val3 || $tn_opt_val4)
		{
	 		// $tn_customcss = get_option( 'tn_menu_customclass' );
	 		if ( !$tn_customcss ) { $tn_customcss = "#site-navigation ul"; } 	
			echo "\t/* This is custom css added through TinyNav settings */\n";
			echo "\t" . $tn_customcss; echo " {\n"; 
			if ($tn_opt_val1) { echo "\t\tmargin-left: "; echo $tn_opt_val1; echo "px;\n"; }
			if ($tn_opt_val2) { echo "\t\tmargin-right: "; echo $tn_opt_val2; echo "px;\n"; }
			if ($tn_opt_val3) { echo "\t\tmargin-top: "; echo $tn_opt_val3; echo "px;\n"; }
			if ($tn_opt_val4) { echo "\t\tmargin-bottom: "; echo $tn_opt_val4; echo "px;\n"; }
			echo "\t"; 
			echo "}\n"; 
		}
		
		$tn_customwidth = get_option( 'tn_menu_customwidth' );
		$tn_customwidth2 = get_option( 'tn_menu_customwidth2' );
		if ($tn_customwidth2) {
			$tn_customwidth = $tn_customwidth2;
		} else {
			$tn_customwidth = $tn_customwidth;
		}
		if ( !$tn_customwidth ) { $tn_customwidth = "650"; } 	
?>
	@media screen and (max-width: <?php echo $tn_customwidth; ?>px) {
		/**
		 * When a screen is max <?php echo $tn_customwidth; ?> pixels, we hide the 'regular' menu because we want to show our new menu
		 */
		<?php echo $tn_customcss; ?> { display: none; }
	
		/* Here we show our new menu menu */
		.tinynav { display: block; width: 100%; }
	}
</style>
<!-- End TinyNav CSS -->
<?php
	}
add_action('wp_head','tinynav_header', '11' );