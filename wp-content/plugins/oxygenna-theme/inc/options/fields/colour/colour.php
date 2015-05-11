<?php
/**
 * Date Option
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
 * Creates a date picker option
 */
class OxyColour extends OxyOption {

    /**
     * Creates option
     *
     * @return void
     * @since 1.0
     **/
    function __construct( $field, $value, $attr ) {
        parent::__construct( $field, $value, $attr );
        $this->set_attr( 'type', 'text' );
        $this->set_attr( 'class', 'colour-option' );
        $this->set_attr( 'value', $value );
    }

    /**
     * Overrides super class render function
     *
     * @return string HTML for option
     * @since 1.0
     **/
    public function render( $echo = true ) {
        echo '<input ' . $this->create_attributes() . ' />';
    }

    public function enqueue() {
        parent::enqueue();
        // load wordpress bundled colorpicker
        wp_enqueue_style( 'wp-color-picker' );
        // load script
        wp_enqueue_script( 'colour-field', OXY_FRAMEWORK_URI . 'options/fields/colour/colour.js', array( 'wp-color-picker' ) );
    }
}