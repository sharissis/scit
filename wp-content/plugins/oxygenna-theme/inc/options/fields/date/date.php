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
class OxyDate extends OxyOption {

    /**
     * Creates option
     *
     * @return void
     * @since 1.0
     **/
    function __construct( $field, $value, $attr ) {
        parent::__construct( $field, $value, $attr );
        $this->set_attr( 'type', 'text' );
        $this->set_attr( 'class', 'oxy-date-field' );
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
        // load styles
        wp_enqueue_style( 'jquery-oxygenna-ui-theme' );
        // load scripts
        wp_enqueue_script( 'date-field', ADMIN_OPTIONS_URI . 'fields/date/date.js', array( 'jquery-ui-datepicker' ) );
    }
}