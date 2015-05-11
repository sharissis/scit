<?php 
/*
Plugin Name: Camera slideshow
Plugin URI: http://www.pixedelic.com/plugins/camera/wp.php
Description: An adpative jQuery slideshow, mobile ready
Version: 1.4.0.1
Author: Manuel Masia | Pixedelic.com
Author URI: http://www.pixedelic.com
License: GPL2
*/

		$pix_pluginname = "Camera";
		$pix_plugindir = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
		$pix_pluginpath = dirname( __FILE__ );
		
function camera_Install() {
	global $wpdb;

	if (function_exists('is_multisite') && is_multisite()) {
		$old_blog = $wpdb->blogid;
		$blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
		foreach ($blogids as $blog_id) {
			switch_to_blog($blog_id);
			_camera_Install();
		}
		switch_to_blog($old_blog);
		return;
	} else {
		_camera_Install();
		return;
	}
}
	
function _camera_Install() {
	global $wpdb;
	
	$table_name = $wpdb->prefix . "camera";
	$table_hack = $wpdb->prefix . "camera_hack";
	
	$charset_collate = '';
	$ver = mysqli_get_server_info( $wpdb->dbh );
	if ( version_compare($ver, '4.1.0', '>=') ) {
		if ( ! empty($wpdb->charset) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$charset_collate .= " COLLATE $wpdb->collate";
	}
	
	if( !$wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_name ) ) ) {
	  
		$sql = "CREATE TABLE ".$table_name." (
		name VARCHAR(255) NOT NULL,
		value LONGTEXT
		) $charset_collate;";
	
	   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	   dbDelta($sql);
	} else {
		if( !$wpdb->get_var( $wpdb->prepare( "SHOW TABLES LIKE %s", $table_hack ) ) ) {
			$wpdb->query("CREATE TABLE ".$table_name."_hack as
				SELECT * FROM $table_name WHERE 1 GROUP BY name;");
		}
			
		$wpdb->query("DROP TABLE $table_name;");

		$wpdb->query("CREATE TABLE $table_name as
			SELECT * FROM ".$table_name."_hack WHERE 1 GROUP BY name;");
			
		$wpdb->query("DROP TABLE ".$table_name."_hack;");

	}
}
register_activation_hook( __FILE__, 'camera_Install' );

add_action( 'wpmu_new_blog', 'camera_Install' );

		require_once $pix_pluginpath . '/lib/camera_functions.php';
		require_once $pix_pluginpath . '/lib/camera_admin.php';
		require_once $pix_pluginpath . '/lib/camera_menu.php';
		require_once $pix_pluginpath . '/lib/admin/camera_general.php';
		require_once $pix_pluginpath . '/lib/admin/camera_documentation.php';
		require_once $pix_pluginpath . '/lib/admin/camera_settings.php';
		require_once $pix_pluginpath . '/lib/admin/camera_addremove.php';
		require_once $pix_pluginpath . '/lib/admin/camera_manageslideshow.php';
		require_once $pix_pluginpath . '/lib/admin/camera_dynamicslideshows.php';
	

		
		

function cameraUninstall() {

        global $wpdb;
        $table_name = $wpdb->prefix . "camera";

	if (camera_get_option('camera_delete_table')=='true'){
		$wpdb->query("DROP TABLE IF EXISTS $table_name");
	}
}

register_uninstall_hook( __FILE__, 'cameraUninstall' );


add_action( 'wpmu_new_blog', 'camera_newBlog', 10, 6); 		
 
function camera_newBlog($blog_id, $user_id, $domain, $path, $site_id, $meta ) {
	global $wpdb;
 
	if (is_plugin_active_for_network('camera-slideshow/index.php')) {
		$old_blog = $wpdb->blogid;
		switch_to_blog($blog_id);
		_camera_Install();
		switch_to_blog($old_blog);
	}
}