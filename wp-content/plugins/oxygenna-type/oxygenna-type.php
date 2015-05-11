<?php
/*
Plugin Name: Oxygenna Typography Plugin
Version: 1.0.3
Plugin URI: https://github.com/oxygenna/oxygenna-type
Description: Adds extra typography options to oxygenna themes
Author: Oxygenna.com
Author URI: http://www.oxygenna.com
License: http://wiki.envato.com/support/legal-terms/licensing-terms/
*/

define( 'OXY_TYPE_DIR', plugin_dir_path( __FILE__ ) . 'inc/' );
define( 'OXY_TYPE_URI', plugin_dir_url( __FILE__ ) . 'inc/' );

require_once OXY_TYPE_DIR . 'OxyTypography.php';

global $oxy_typography;
$oxy_typography = new OxyTypography();

// load plugin updater if we are admin
if( is_admin() ) {
    require_once OXY_TYPE_DIR . 'plugin-updater/updater.php';

    $config = array(
        'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
        'proper_folder_name' => 'oxygenna-type', // this is the name of the folder your plugin lives in
        'api_url' => 'https://api.github.com/repos/oxygenna/oxygenna-type', // the github API url of your github repo
        'raw_url' => 'https://raw.github.com/oxygenna/oxygenna-type/master', // the github raw url of your github repo
        'github_url' => 'https://github.com/oxygenna/oxygenna-type', // the github url of your github repo
        'zip_url' => 'https://github.com/oxygenna/oxygenna-type/zipball/master', // the zip url of the github repo
        'sslverify' => false, // wether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
        'requires' => '3.4', // which version of WordPress does your plugin require?
        'tested' => '3.5.2', // which version of WordPress is your plugin tested up to?
        'readme' => 'README.md', // which file to use as the readme for the version number
        'access_token' => '30f88c66eed99766a0e26d5147c8895bca2bd9ae', // Access private repositories by authorizing under Appearance > Github Updates when this example plugin is installed
    );

    $updater = new WP_GitHub_Updater($config);
}