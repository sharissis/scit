<?php
/*
Plugin Name: GhostPool: "Buddy" Theme Add-Ons
Plugin URI: http://themeforest.net/item/buddy-multipurpose-wordpress-buddypress-theme/3506362?ref=GhostPool
Description: Accompanies the "Buddy" theme you purchased from ThemeForest. It includes a number of features that you can still use if you switch to another theme.
Version: 1.0.1
Author: GhostPool
Author URI: http://themeforest.net/user/GhostPool/portfolio?ref=GhostPool
License: You should have purchased a license from ThemeForest.net
*/

if(!class_exists('GhostPool')) {

	class GhostPool {

		public function __construct() {
		
			if(!post_type_exists('slide')) {
				require_once(sprintf("%s/slide-post-type/slide-post-type.php", dirname(__FILE__)));
				$GP_Slide_Post = new GP_Slide_Post();
			}
						
			if(!class_exists('CustomSidebars')) {
				require_once(sprintf("%s/custom-sidebars/custom-sidebars.php", dirname(__FILE__)));
			}
						
			if(!class_exists('Widget_Importer_Exporter')) {
				require_once(sprintf("%s/widget-importer-exporter/widget-importer-exporter.php", dirname(__FILE__)));
			}
						
			if(!class_exists('Envato_WP_Toolkit')) {
				require_once(sprintf("%s/envato-wordpress-toolkit-master/index.php", dirname(__FILE__)));
			}
						
		} 
		
		public static function activate() {} 		
		public static function deactivate() {}
		
	}
	
}

if(class_exists('GhostPool')) {

	register_activation_hook(__FILE__, array('GhostPool', 'activate'));
	register_deactivation_hook(__FILE__, array('GhostPool', 'deactivate'));

	$ghostpool = new GhostPool();

}

?>