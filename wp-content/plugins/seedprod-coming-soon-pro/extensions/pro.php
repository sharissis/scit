<?php


function seed_csp3_pro_email_list_providers($providers) {
	$pro_providers = array(
		'aweber' => 'Aweber',
		'campaignmonitor' => 'Campaign Monitor',
		'constantcontact' => 'Constant Contact',
		'getresponse' => 'Get Response',
		'gravityforms' => 'Gravity Forms',
		'mailchimp' => 'MailChimp',
		'wysija' => 'Wysija',
	);
 
	$providers = array_merge($providers,$pro_providers);
 
	return $providers;
}
add_filter('seed_csp3_email_list_providers', 'seed_csp3_pro_email_list_providers');

function seed_csp3_pro_fonts($fonts) {
	$google_fonts = unserialize(get_transient('seed_csp3_google_fonts'));
	if($google_fonts === false){
		$response = wp_remote_get('http://s3.amazonaws.com/static.seedprod.com/api/google-fonts.html');
		if(!is_wp_error($response)){
			foreach(unserialize($response['body']) as $v){
			 $google_fonts[$v['css-name']] = $v['font-name'];
			 $google_fonts_families[$v['css-name']] = str_replace('font-family: ', '', $v['font-family']);
			}
			update_option('seed_csp3_google_font_families',$google_fonts_families);
			asort($google_fonts);
			set_transient('seed_csp3_google_fonts',serialize($google_fonts),604800);
		}
	} 	

	

	$pro_fonts= array('Google Fonts' => $google_fonts);
 
	$fonts = array_merge($fonts,$pro_fonts);
 
	return $fonts;
}
add_filter('seed_csp3_fonts', 'seed_csp3_pro_fonts');

function seed_csp3_get_gravityforms_forms(){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(is_plugin_active('gravityforms/gravityforms.php') && class_exists('RGFormsModel')){
	  $forms = array();
	  $gforms = RGFormsModel::get_forms(null, "title");
	  foreach($gforms as $k=>$v){
	  	$forms[$v->id] = $v->title;
	  }
	}else{
	  $forms = array('-1'=> 'No Forms Found');
	}
	return $forms;
}

function seed_csp3_get_wysija_lists(){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if(is_plugin_active('wysija-newsletters/index.php')){
	  	//get the lists and ids
		global $wpdb;
		$wlists = array();
        $tablename = $wpdb->prefix . 'wysija_list';
        if( $wpdb->get_var("SHOW TABLES LIKE '$tablename'") == $tablename ){
        	$sql = "SELECT list_id,name FROM $tablename WHERE is_enabled = 1";
	    	$wlists = $wpdb->get_results($sql);
        }
		  
		$lists = array();
		
		foreach($wlists as $k=>$v){
		  	$lists[$v->list_id] = $v->name;
		}
	}else{
	  $lists = array('-1'=> 'No Lists Found');
	}
	return $lists;
}