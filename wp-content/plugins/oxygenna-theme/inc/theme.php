<?php
/**
 * Main theme class file
 *
 * @package **THEME**
 * @subpackage Core
 * @since 1.0
 *
 * @copyright **COPYRIGHT**
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version **VERSION**
 */

/**
 * Main theme bootstrap class.
 *
 * @since 1.0
 */
class OxyTheme
{
    /**
     * Holds array of all theme options
     *
     * @since 1.0
     * @access public
     * @var array
     */
    public $options;

    public $shortcode_options = array();

    public $option_pages = array();

    public $metaboxes = array();

    /**
     * Constructior, this should be called from functions.php in a theme or child theme
     *
     * @since 1.0
     * @param array $theme array of all theme options to use in construction this theme
     */
    function __construct( $options ) {
        // store theme options
        $this->options = $options;

        // load textdomains for admin / front
        if( is_admin() ) {
            load_theme_textdomain( $this->options['admin_text_domain'], get_template_directory().'/inc/languages');
        }
        else {
            load_theme_textdomain( $this->options['text_domain'], get_template_directory().'/languages');
        }

        add_action( 'widgets_init', array( &$this, 'load_widgets' ) );

        // load admin class if we are admin
        if( is_admin() ) {
            include OXY_FRAMEWORK_DIR . 'themeadmin.php';
            $admin = new OxyThemeAdmin( $this );
        }

        // load theme options
        global $oxy_theme_options;
        $oxy_theme_options = get_option( THEME_SHORT . '-options' );

        // add sidebars
        $this->load_sidebars();

        // load admin bar
        add_action( 'admin_bar_menu', array( &$this, 'admin_bar_menu' ), 81 );
        add_action( 'after_setup_theme', array( &$this, 'load_option_pages' )  );
    }

    function register_shortcode_options( $shortcode_options ) {
        foreach( $shortcode_options as $shortcode => $options ) {
            $this->shortcode_options[$shortcode] = $options;
        }
    }

    function register_option_page( $option_page ) {
        $this->option_pages[] = $option_page;
    }

    function load_sidebars() {
        foreach( $this->options['sidebars'] as $id => $info ) {
            $this->register_sidebar( $info[0], $info[1], '', $id );
        }
    }

    function register_sidebar( $name , $desc='' , $class='', $id=null ) {
        if( $class == 'widget_tag_cloud' ) {
            $class = 'tags-widget';
        }
        $options = array(
            'name' => $name,
            'description'=> $desc,
            'before_widget' => '<div id="%1$s" class="sidebar-widget ' . $class  . ' %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h3 class="sidebar-header">',
            'after_title' => '</h3>',
        );
        if( null !== $id ) {
            $options['id'] = $id;
        }
        register_sidebar( $options );
    }

    function register_metabox( $metabox ) {
        $this->metaboxes[] = $metabox;
    }

    function load_widgets() {
        if( isset( $this->options['widgets'] ) ) {
            foreach( $this->options['widgets'] as $class => $file ) {
                require_once OXY_THEME_DIR . 'inc/options/widgets/' . $file;
                register_widget( $class );
            }
        }
    }

    /**
    * Loads option pages. Must be done on init.
    *
    */
    function load_option_pages() {
        if( is_admin() || is_admin_bar_showing() ) {
            include OXY_THEME_DIR . 'inc/option-pages.php';
        }
    }

    /**
     * Adds theme options to admin bar
     *
     * @since 1.0
     */
    function admin_bar_menu( $wp_admin_bar ) {
        if( !is_super_admin() || !is_admin_bar_showing() || !current_user_can( 'manage_options' ) ) {
            return;
        }
        global $wp_admin_bar;

        // create base main menu
        foreach( $this->option_pages as $option_page ) {
            if( $option_page['main_menu'] == true ) {
                $wp_admin_bar->add_node( array( 'id' => THEME_SHORT , 'title' => THEME_NAME . ' ' . __('Theme', 'PLUGIN_TD') , 'href' => admin_url( 'admin.php?page=' . $option_page['slug'] ) ) );
                break;
            }
        }
        // get dashboard menu and add all submenus to the admin bar using admin-menu as a parent menu
        foreach( $this->option_pages as $option_page ) {
            $wp_admin_bar->add_node( array( 'id' => $option_page['slug'], 'title' => $option_page['menu_title'], 'href' => admin_url( 'admin.php?page=' . $option_page['slug'] ), 'parent' => THEME_SHORT ) );
        }
    }
}