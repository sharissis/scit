<?php
/**
 * Main theme admin class file
 *
 * @package **THEME**
 * @subpackage Core
 * @since 1.0
 *
 * @copyright **COPYRIGHT**
 * @license http://wiki.envato.com/support/legal-terms/licensing-terms/
 * @version **VERSION**
 */

include OXY_FRAMEWORK_DIR . 'options/options.php';
include OXY_FRAMEWORK_DIR . 'options/option.php';
include OXY_FRAMEWORK_DIR . 'quick-uploader.php';
include OXY_FRAMEWORK_DIR . 'metaboxes/OxyMetabox.php';

/**
 * Main theme admin bootstrap class
 *
 * @since 1.0
 */
class OxyThemeAdmin
{
    /**
     * Stores array of theme setuop options
     *
     * @since 1.0
     * @access public
     * @var array
     */
    public $theme;

    /**
     * Main theme options
     *
     * @var Object
     **/
    public $options;

    /**
     * Constructior, called if the theme is_admin by †he main Theme class
     *
     * @since 1.0
     * @param array $options array of all theme options to use in construction this theme
     */
    function __construct( $theme ) {
        $this->theme = $theme;
        // initialise admin
        add_action('admin_init', array( &$this, 'admin_init' ) );
        // enqueue option page scripts
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

        add_action('init', array(&$this, 'create_meta_boxes'));

        // create theme options
        $this->options = new OxyOptions( $this->theme );

    }



    /**
     * called on admin_init
     *
     * @since 1.0
     */
    function admin_init() {
        // register admin js & css
        $this->register_resources();
        // initialise media upload class ( for media options )
        require_once OXY_FRAMEWORK_DIR . 'media-upload.php';
        $media_upload = new OxyMediaUpload();

        require_once OXY_FRAMEWORK_DIR . 'shortcodes/shortcode-admin.php';
        $shortcode_admin = new ShortcodeAdmin( $this->theme );

    }

    function register_resources() {
        wp_register_style( 'jquery-oxygenna-ui-theme', OXY_FRAMEWORK_URI . 'css/jquery-ui/smoothness/theme.min.css' );
        wp_register_style( 'oxy-option-page', OXY_FRAMEWORK_URI . 'css/options/oxy-option-page.css' );
    }

    function check_theme_compatible() {
        $version = get_bloginfo( 'version' );
        $this->errors = array();

        if( version_compare( $version, $this->options['min_wp_ver'], '<' ) ) {
            $this->errors[] = sprintf( __('Version %s is incompatible with this theme minimum version %s', 'PLUGIN_TD'), $version, $this->options['min_wp_ver'] );
        }

        if( !empty( $this->errors ) ) {
            add_action( 'init', array( &$this, 'admin_warning' ) );
        }

    }

    function admin_enqueue_scripts( $hook ) {
    }

    function admin_warning() {
        $msg = '<div class="error">';
        foreach( $this->errors as $error ) {
            $msg .= '<p>' . $error . '</p>';
        }
        $msg .=  '</div>';
        echo $msg;
    }

    function create_meta_boxes() {
        if( !empty( $this->theme->metaboxes ) ) {
            foreach( $this->theme->metaboxes as $metabox ) {
                $new_metabox = new OxyMetabox( $metabox );
            }
        }
    }
}
