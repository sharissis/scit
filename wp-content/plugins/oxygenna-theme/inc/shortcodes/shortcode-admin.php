<?php
/**
 * Sets up the shortcode editor actions
 *
 * @package **THEME**
 * @subpackage Core
 * @since 1.0
 *
 * @copyright **COPYRIGHT**
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version **VERSION**
 */

class ShortcodeAdmin
{
    private $theme;

    function __construct( $theme ) {
        $this->theme = $theme;

        // Don't bother doing this stuff if the current user lacks permissions
        if( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
            return;
        }

        // Add only in Rich Editor mode
        if( get_user_option('rich_editing') == 'true') {
            add_filter( 'mce_external_plugins', array( $this, 'oxy_add_mce_shortcode_plugin') );
            add_filter( 'mce_buttons', array( &$this, 'oxy_add_mce_shortcode_button') );
        }

        // enqueue scripts & styles
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
        // add tinyMCE shortcode plugin
        add_action( 'admin_init', array( &$this, 'oxy_add_mce_shortcode') );
        // add action for loading shortcode page
        add_action( 'wp_ajax_oxy_shortcodes', array( &$this, 'oxy_load_mce_shortcode_page' ) );
        // add action for loading shortcode page
        add_action( 'wp_ajax_oxy_shortcode_preview', array( &$this, 'oxy_load_mce_shortcode_preview' ) );
        // add action for loading menu data
        add_action( 'wp_ajax_oxy_shortcodes_menu', array( &$this, 'oxy_load_mce_shortcode_menu' ) );

        // remove wordpress 3.6 action that is undocumented and throws notices.
        if( has_action('admin_enqueue_scripts', 'wp_auth_check_load')){
            remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );
        }
    }

    function admin_enqueue_scripts() {
        global $pagenow;
        if( 'post-new.php' == $pagenow || 'post.php' == $pagenow ) {
            wp_enqueue_style( 'oxy-shortcodes-html-menu', OXY_FRAMEWORK_URI . 'css/shortcodes/shortcode-html-menu.css' );
            wp_enqueue_script( 'oxy-shortcodes-html-menu', OXY_FRAMEWORK_URI . 'javascripts/shortcodes/html-menu.js' );
        }
    }

    function oxy_load_mce_shortcode_page() {
        // check for rights
        if ( !current_user_can('edit_pages') && !current_user_can('edit_posts') )
            die(__('You are not allowed to be here', 'PLUGIN_TD'));

        // load shortcodes js
        wp_enqueue_script( 'oxy-shortcodes', OXY_FRAMEWORK_URI . 'javascripts/shortcodes/shortcodes.js', array( 'jquery' ) );
        wp_enqueue_script( 'oxy-shortcode-options', OXY_FRAMEWORK_URI . 'javascripts/shortcodes/shortcode-options.js', array( 'jquery', 'jquery-ui-accordion' ) );
        wp_enqueue_style( 'oxy-shortcodes', OXY_FRAMEWORK_URI . 'css/shortcodes/shortcode-popup.css', array( 'jquery-oxygenna-ui-theme' ) );
        //wp_enqueue_style( 'oxy-shortcodes', ADMIN_CSS_URI . 'shortcodes/shortcode-popup.css' );

        include_once OXY_FRAMEWORK_DIR . 'shortcodes/shortcode-editor.php';

        die();
    }

    function oxy_load_mce_shortcode_preview() {
        // check for rights
        if ( !current_user_can('edit_pages') && !current_user_can('edit_posts') )
            die(__('You are not allowed to be here', 'PLUGIN_TD'));

        check_ajax_referer( 'oxy-preview-nonce' );

        // load an extra css for for the preview view only
        wp_enqueue_style( 'shortcode-preview', OXY_FRAMEWORK_URI . 'css/shortcodes/shortcode-preview.css', array( 'style', 'responsive' ) );

        //$this->theme->load_javascripts();
        // $this->theme->fix_shortcodes_autop();
        // $this->theme->load_stylesheets();
        // $this->theme->load_options( 'shortcodes' );
        //$this->theme->load_shortcodes();

        include_once OXY_FRAMEWORK_DIR . 'shortcodes/preview.php';

        die();
    }

    function oxy_load_mce_shortcode_menu() {
        // check for rights
        if ( !current_user_can('edit_pages') && !current_user_can('edit_posts') )
            die(__('You are not allowed to be here', 'PLUGIN_TD'));

        $menu = $this->add_shortcode_options( $this->theme->options['shortcodes'] );

        echo json_encode( $menu );

        die();
    }

    function add_shortcode_options( $options ) {
        if( is_array( $options ) ) {
            if( isset( $options['members'] ) ) {
                $members = array();
                foreach( $options['members'] as $member ) {
                    $members[] = $this->add_shortcode_options( $member );
                }
                $new_tree = array(
                    'title' => $options['title'],
                    'members' => $members
                );
            }
            else {
                // modified in order to parse all the shortcode options arrays
                foreach ($options as $option) {
                    $new_tree[] =  $this->add_shortcode_options( $option );
                }
            }
        }
        else {
            if( isset( $this->theme->shortcode_options[$options] ) ) {
                $new_tree = $this->theme->shortcode_options[$options];
            }
            else {
                $new_tree = 'No options for ' . $options;
            }
        }
        return $new_tree;
    }

    function oxy_add_mce_shortcode_button( $buttons ) {
        array_push( $buttons, 'shortcodes' );
        return $buttons;
    }

    function oxy_add_mce_shortcode_plugin( $plugin_array ) {
        $plugin_array['shortcodes'] = OXY_FRAMEWORK_URI . 'javascripts/shortcodes/editor_plugin.js';
        return $plugin_array;
    }
}