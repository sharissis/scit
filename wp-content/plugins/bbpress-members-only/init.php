<?php
/**
 * Plugin Name: bbP Members Only
 * Plugin URI:  http://wordpress.org/extend/plugins/bbp-members-only/
 * Description: This plugin retricts bbPress to logged in/registered members.
 * Version:     1.0.1
 * Author:      Jared Atchison
 * Author URI:  http://jaredatchison.com 
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * @author     Jared Atchison
 * @version    1.0.0
 * @package    bbPMembersOnly
 * @copyright  Copyright (c) 2012, Jared Atchison
 * @link       http://jaredatchison.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class ja_bbp_members_only {

	static $instance;

	/**
	 * Initialize all the things
	 *
	 * @since 1.0.0
	 */
	function __construct() {
		
		self::$instance =& $this;
		
		// Actions
		add_action( 'admin_init',          array( $this, 'admin_settings'      ), 15     );
		add_filter( 'plugin_action_links', array( $this, 'admin_settings_link' ), 10, 2  );
		add_action( 'init',                array( $this, 'load_textdomain'     )         );
		add_action( 'template_redirect',   array( $this, 'redirect'            )         );
		// Filters
		add_filter( 'request',             array( $this, 'detect_feeds'        )         );
		add_filter( 'bbp_shortcodes',      array( $this, 'shortcode_hijack'    )         );
		
	}


	/**
	 * Add Settings link to plugins page
	 *
	 * @since 1.0.0
	 * @param array $links
	 * @param string $file
	 * @return array Links
	 */
	public function admin_settings_link( $links, $file ) {

		if ( plugin_basename( __FILE__ ) == $file ) {
			$settings_link = '<a href="' . admin_url( 'options-general.php?page=bbpress' ) . '#bbp-members-only">' . __( 'Settings', 'bbp-members-only' ) . '</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}

	/**
	 * Admin settings
	 *
	 * @since 1.0.0
	 */
	public function admin_settings() {

		// Add the section to primary bbPress options
		add_settings_section( 'ja_bbpress_members_only', __( 'Members Only', 'bbp-members-only' ), array( $this, 'admin_heading'   ), 'bbpress'                            );
		
		// Add the URL input field
		add_settings_field(   'ja_bbpress_members_only', __( 'Redirect URL', 'bbp-members-only' ), array( $this, 'admin_url_input' ), 'bbpress', 'ja_bbpress_members_only' );
		
		// Register our settings with the bbPress settings page
		register_setting( 'bbpress', 'ja_bbpress_members_only', 'esc_url_raw' );
	}

	/**
	 * Heading for the admin settings page
	 *
	 * @since 1.0.0
	 */
	public function admin_heading() {
		_e( 'Your forums are currently restricted to registered users. Redirect guest users to the following URL.', 'bbp-members-only' );
	}

	/**
	 * Input field for the redirect URL
	 *
	 * @since 1.0.0
	 */
	public function admin_url_input() {

		$url = get_option( 'ja_bbpress_members_only', home_url() );

		echo '<input name="ja_bbpress_members_only" type="text" id="bbp-members-only" class="regular-text code" value="' . $url . '" />';
	}

	/**
	 * Load the textdomain so we can support other languages
	 *
	 * @since 1.0.0
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'bbp-members-only', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Primary redirect
	 *
	 * If we are viewing a bbPress page and the current user does not have
	 * read permision then redirect them. Will redirect to URL if provided
	 * in the settings otherwise redirects to the site homepage.
	 *
	 * @since 1.0.0
	 */
	public function redirect() {

		if ( is_bbpress() && !current_user_can( 'read' ) ) {

			// Grab redirect URL provided from settings
			$url = get_option( 'ja_bbpress_members_only' );

			// If no URL is provided, default to the homepage
			if ( empty( $url ) ) {
				$url = get_bloginfo( 'url' );
			}

			// Send them to the new URL
			wp_redirect( $url );
			
			exit;	
		}
	}

	/**
	 * Detect bbPress feeds
	 *
	 * Prevent viewing bbPress feeds for users who do not have read
	 * permission. Structure of this function taken directly from 
	 * bbp_request_feed_trap().
	 *
	 * @since 1.0.0
	 * @param array $query_vars
	 * @return array
	 */
	public function detect_feeds( $query_vars = array() ) {

		// Looking at a feed
		if ( isset( $query_vars['feed'] ) && !current_user_can( 'read' ) ) {

			// Forum/Topic/Reply Feed
			if ( isset( $query_vars['post_type'] ) ) {

				// Apply to all the primary bbPress feeds
				if ( in_array( $query_vars['post_type'], array( bbp_get_forum_post_type(), bbp_get_topic_post_type(), bbp_get_reply_post_type() ) ) ) {
					_e('You do not have permission to view this feed.', 'bbp-members-only');
					die();
				}

			// Single Topic Vview
			} elseif ( isset( $query_vars['bbp_view'] ) ) {
				_e('You do not have permission to view this feed.', 'bbp-members-only');
				die();
			}

		}

		// No bbPress feed detected so continue on
		return $query_vars;
	}

	/**
	 * Hijack the bbPress shortcodes
	 *
	 * If a user is not logged in or does not have read permission, we
	 * disable all bbPress shortcodes except login, register, and reset password.
	 *
	 * @since 1.0.0
	 * @param array $shortcodes
	 * @return array
	 */
	public function shortcode_hijack( $shortcodes )  {

		if ( !current_user_can( 'read' ) ) {
			foreach( (array) array_keys( $shortcodes ) as $code ) {

				// Allow the login, register, and lost password shortcodes
				if ( !in_array( $code, array( 'bbp-login', 'bbp-register', 'bbp-lost-pass' ) ) ) {
					$shortcodes[$code] = array( $this, 'shortcode_output' );
				}

			}
		}

		return $shortcodes;
	}

	/**
	 * Outputs an message in place of default bbPress shortcodes for
	 * users who are not logged in or do not have read permission.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function shortcode_output() {

		$output  = '<div class="bbp-template-notice"><p>';
		$output .= __( 'You do not have permission to view this.', 'bbp-members-only' );
		$output .= '</p></div>';

		return $output;
	}

}
new ja_bbp_members_only();