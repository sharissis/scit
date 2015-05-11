<?php
function camera_add_menu()
{
	global	$pix_pluginname,
			$pix_plugindir;
		
	global $current_user;
	
	
		if (function_exists('add_options_page')) {
			add_menu_page($pix_pluginname, $pix_pluginname, camera_select_role(camera_get_option('camera_perm_panel')), 'camera_general', 'camera_init', $pix_plugindir . 'css/images/blank.gif');
			add_submenu_page('camera_general', 'Settings', 'Settings', camera_select_role(camera_get_option('camera_perm_panel')), 'camera_settings','camera_init');
			add_submenu_page('camera_general', 'Documentation', 'Documentation', camera_select_role(camera_get_option('camera_perm_panel')), 'camera_documentation','camera_init');
			add_submenu_page('camera_general', 'Add/remove slideshows', 'Add/remove slideshows', camera_select_role(camera_get_option('camera_perm_panel')), 'camera_addremove','camera_init');
			add_submenu_page('camera_general', 'Manage your slideshows', 'Manage your slideshows', camera_select_role(camera_get_option('camera_perm_panel')), 'camera_manage','camera_init');
			add_submenu_page('camera_general', 'Dynamic slideshows', 'Dynamic slideshows', camera_select_role(camera_get_option('camera_perm_panel')), 'camera_dynamic','camera_init');
		}
}

add_action('admin_menu', 'camera_add_menu');



add_action( 'admin_head', 'camera_menu_style' );
function camera_menu_style() {
    ?>
    <style type="text/css" media="screen">
        #toplevel_page_camera_general ul, #toplevel_page_camera_general .wp-menu-toggle, #toplevel_page_camera_general .wp-submenu, #toplevel_page_camera_general.wp-not-current-submenu .wp-menu-arrow {
            display: none!important;
        }
        #toplevel_page_camera_general .wp-menu-image {
            background: url(<?php global $pix_plugindir; echo $pix_plugindir; ?>css/images/menu_icon.png) no-repeat 0 0 !important;
        }
		#toplevel_page_camera_general:hover .wp-menu-image, #toplevel_page_camera_general.current .wp-menu-image {
            background-position: 0 0!important;
        }
    </style>
<?php }
?>