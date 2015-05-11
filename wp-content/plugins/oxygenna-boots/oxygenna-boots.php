<?php
/*
Plugin Name: Oxygenna Bootstrap Plugin
Version: 1.1
Plugin URI: https://github.com/oxygenna/oxygenna-boots
Description: Bootstrap Shortcodes for Oxygenna themes
Author: Oxygenna.com
Author URI: http://www.oxygenna.com
License: http://wiki.envato.com/support/legal-terms/licensing-terms/
*/

define( 'OXY_BSPLUGIN_DIR', plugin_dir_path( __FILE__ ) . 'inc/' );
define( 'OXY_BSPLUGIN_URI', plugin_dir_url( __FILE__ ) . 'inc/' );

require_once OXY_BSPLUGIN_DIR . 'OxyBootstrap.php';

global $oxy_bootstrap;
$oxy_bootstrap = new OxyBootstrap();

// load plugin updater if we are admin
if( is_admin() ) {
    require_once OXY_BSPLUGIN_DIR . 'plugin-updater/updater.php';

    $config = array(
        'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
        'proper_folder_name' => 'oxygenna-boots', // this is the name of the folder your plugin lives in
        'api_url' => 'https://api.github.com/repos/oxygenna/oxygenna-boots', // the github API url of your github repo
        'raw_url' => 'https://raw.github.com/oxygenna/oxygenna-boots/master', // the github raw url of your github repo
        'github_url' => 'https://github.com/oxygenna/oxygenna-boots', // the github url of your github repo
        'zip_url' => 'https://github.com/oxygenna/oxygenna-boots/zipball/master', // the zip url of the github repo
        'sslverify' => false, // wether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
        'requires' => '3.4', // which version of WordPress does your plugin require?
        'tested' => '3.5.2', // which version of WordPress is your plugin tested up to?
        'readme' => 'README.md', // which file to use as the readme for the version number
        'access_token' => '', // Access private repositories by authorizing under Appearance > Github Updates when this example plugin is installed
    );

    $updater = new WP_GitHub_Updater($config);
}