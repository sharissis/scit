<?php
/**
 * Icon Option
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
 * Creates a selection of icons
 */
class OxyIcons extends OxyOption {

    /**
     * Creates option
     *
     * @return void
     * @since 1.0
     **/
    function __construct( $field, $value, $attr ) {
        parent::__construct( $field, $value, $attr );
        $this->set_attr( 'type', 'hidden' );
        $this->set_attr( 'value', esc_attr( $value ) );
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     * @since 1.0
     **/
    public function render( $echo = true ) {
        if( file_exists( OXY_THEME_DIR . 'inc/options/theme-plugin-options/fontawesome.php' ) ) {
            $icons = include OXY_THEME_DIR . 'inc/options/theme-plugin-options/fontawesome.php';
        }
        else {
            // this theme has no specific options so use standard
            $icons = include OXY_FRAMEWORK_DIR . 'options/icons/fontawesome.php';
        }
        ?>
        <div class="icon-container">
            <ul>
            <?php foreach( $icons as $icon ) : ?>
                <li><i class="fa fa-<?php echo $icon; ?>" data-value="<?php echo $icon; ?>"></i></li>
            <?php endforeach; ?>
            </ul>
        </div>
        <input <?php echo $this->create_attributes(); ?> />
    <?php
    }

    public function enqueue() {
        parent::enqueue();
        // load styles
        //wp_enqueue_style( 'jquery-oxygenna-ui-theme' );
        if( file_exists( OXY_THEME_DIR . 'assets/css/font-awesome-for-admin.css' ) ) {
            wp_enqueue_style( 'font-awesome', OXY_THEME_URI . '/assets/css/font-awesome-for-admin.css', array(), false, 'all' );
        }
        else {
            wp_enqueue_style( 'font-awesome', OXY_FRAMEWORK_URI . '/css/font-awesome/font-awesome.css', array(), false, 'all' );
        }

        wp_enqueue_style( 'font-icon', OXY_FRAMEWORK_URI . 'options/fields/icons/icons.css', array( 'font-awesome' ), false, 'all' );
        // load scripts
        wp_enqueue_script( 'font-icon', OXY_FRAMEWORK_URI . 'options/fields/icons/icons.js' );
    }
}